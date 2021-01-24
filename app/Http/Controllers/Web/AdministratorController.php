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
class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
      
      $user=Auth::user();
      if(!empty($user->role)){
        if($user->role =='2'){
      return view('web.collaborator.Homepage', ['title' => 'Collaborator']);
    }else if(@$user->role =='3'){
        return view('web.administrator.Homepage', ['title' => 'Administrator']);
    }}else{
        return redirect('collaborator/signin');
    }
    }

    public function administrator_signin()
    {
      $user=Auth::user();
      if(!empty($user->role)){
      if($user->role =='4')
       return redirect('/');
      }else if(@$user->role =='3'){

        return redirect('/');
      }else{

        return view('web.administrator.Login', ['title' => 'Administrator']);
      }
      
    }

    public function loginAdministrator(Request $request){
         //dd($request->all());
         $email=$request->get('email');
         $password=$request->get('password');
            
        if (Auth::attempt(['email' => $email, 'password' => $password, 'role' =>'3'])) {
          return redirect('/administrator');
      }else{
        return redirect('administrator/signin')->with('error', 'Login credential is not valid ') ;
      }

    }


}
