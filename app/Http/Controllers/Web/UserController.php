<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use Log;
use DateTime;
use URL;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userlist()
    {

      $user=Auth::user();
      if(!empty($user->role)){
      if($user->role == '4'){
       $data=User::where('role',2)->get();
       $datas=User::where('role',3)->get();
        //die('==');
        return view('web.user.UserList', ['title' => 'Users', 'data'=>$data,'datas'=>$datas]);
      }else{
        return redirect('/');
      }
    }else{
       return redirect('/');
    }
    }

    public function createUser(Request $request){

   //die('======');
        if ($request->hasFile('image')) {
            $file = request()->file('image');
            $ext=$file->getClientOriginalExtension();
            $imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('admin/images/doctor', $imagename);
            $url= URL::to('/');
              $ServiceImage=$url.'/admin/images/doctor/'.$imagename;
            }else{
              $ServiceImage='';
            }

      
        $info= DB::table('users')->insert([
                'profile_image'           =>  $ServiceImage??null,
                'password'                => \Hash::make('123456'),
                'first_name'              =>  $request->f_name??null,
                'last_name'               =>  $request->l_name??null,
                'email'                   =>  $request->email??null,
                'owner_id'                =>  $request->id??null,
                'phone_number'            =>  $request->phone_number??null,
                'role'                    =>  $request->role??null,
                'created_at'              =>  new \DateTime,
                'updated_at'              =>  new \DateTime,
            ]);
        return redirect('owner/userlist')->with('error', 'User has been created successfully. ') ;
    }

    public function signin(Request $request){

         return view('web.user.Login', ['title' => 'Users']);

    }

    public function loginUser(Request $request){
         $email=$request->get('email');
         $password=$request->get('password');
            
        if (Auth::attempt(['email' => $email, 'password' => $password, 'role' =>'4','account_status'=>'active'])) {
          return redirect('/');
      }else{
        return redirect('owner/signin')->with('error', 'Login credential is not valid ') ;
      }
    }

    public function logout(){
    Auth::logout();
    return redirect('/');
  }


    

   
}
