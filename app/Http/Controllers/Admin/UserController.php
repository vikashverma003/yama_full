<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Group;
use App\Models\Chatrequest;
use App\User;
use URL;
use Hash;
use Mail;
//use Conekta\Conekta;
use DB;
class UserController extends Controller
{
    protected $groupObj;
    protected $userObj;

    public function __construct(Group $group,User $user)
    {
         $this->groupObj   =$group;
         $this->userObj    =$user;
        
    }
    

    /**
     * Login page
     */
    public function term(){
     return view('admin.admin.term', ['title' => 'Term and condition']);
    }

    public function privacy(){
     return view('admin.admin.privacy', ['title' => 'Privacy Policy']);
    }

    public function index(){
      if (Auth::check()) {
        return redirect('admin/dashboard');
      }
      Auth::logout();

  
      return view('admin.login', ['title' => 'Login Page']);
    }


    /**
     * Check user Detail
     */

    public function login(Request $request){
         
      $request->validate([
          'email' => 'required|email|exists:users,email',
          'password' => 'required|min:6',
      ]);

      if (!Auth::check()) {
        $email=$request->get('email');
        $password=$request->get('password');
  
        if (Auth::attempt(['email' => $email, 'password' => $password, 'role' =>'admin','account_status'=>'active'])) {
          return redirect('admin/dashboard');
      }else{
        return redirect('admin/login')->with('error', 'Login credential is not valid ') ;
      }
      }
  }
  
  public function logout(){
    Auth::logout();
    return redirect(\URL::previous());
  }

  public function users(Request $request){
        $user=Auth::user();
        $allUser = User::where('role',config('constants.role.USER'))->where('account_status','0')->get();
        return view('admin.admin.viewUser', ['title' => 'Users','user'=>$user, 'allUser'=>$allUser]);
     
  }
  public function group(Request $request){
        $user=Auth::user();
        $group=Group::get();
        $allUser = User::where('role',config('constants.role.USER'))->where('account_status','0')->get();
        return view('admin.admin.viewGroup', ['title' => 'Users','user'=>$user, 'group'=>$group]);   
  }

  public function addGroup(Request $request){

     $user=Auth::user();
     return view('admin.admin.addGroup', ['title' => 'Add Services','user'=>$user]);
  }

  public function editGroup(Request $request,$id){
    $user=Auth::user();
    $data=Group::where('id',$id)->first();
    return view('admin.admin.editGroup', ['title' => 'Add Services','user'=>$user,'data'=>$data]);
  }

  public function createGroup(Request $request){

    if ($request->hasFile('image')) {
            $file = request()->file('image');
            $ext=$file->getClientOriginalExtension();
            $imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('admin/images/doctor', $imagename);
            }

      $url= URL::to('/');
      $groupImage=$url.'/admin/images/doctor/'.$imagename;
      $createdUser=$this->groupObj->creategroup([
            'heading'     =>  $request->food_name??null,
            'restaurants' =>  $request->restaurants??null,
            'description' =>  $request->description??null,
            'image'       =>  $groupImage??null,
        ]);
       return redirect('admin/group')->with('status','Group has been added Successfully.');
  }

  public function updateGroup(Request $request){
       if ($request->hasFile('image')) {
            $file = request()->file('image');
            $ext=$file->getClientOriginalExtension();
            $imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('admin/images/doctor', $imagename);
            }
            if(!empty($imagename)){
              $url= URL::to('/');
              $groupImage=$url.'/admin/images/doctor/'.$imagename;
            }else{
              $reqInfo=Group::where('id',$request->id)->first();
              $groupImage=$reqInfo->image;
          }
      Group::where('id',$request->id)->update([
                'heading'     =>  $request->food_name??null,
                'restaurant_id' =>  $request->restaurants??null,
                'description' =>  $request->description??null,
                'image'       =>  $groupImage??null,
                       
            ]);
        return redirect('admin/group')->with('status','Group has been updated Successfully.');
  }

  public function viewadministrator(){

    $user=Auth::user();
    $data=User::where('role',3)->get();
    return view('admin.admin.viewadministrator', ['title' => 'View User','user'=>$user,'data'=>$data]);

  }

  public function viewcollaborators(){
    $user=Auth::user();
    $data=User::where('role',2)->get();
    return view('admin.admin.viewcollaborators', ['title' => 'View User','user'=>$user,'data'=>$data]);
  }

  public function viewowner(){
    $user=Auth::user();
    $data=User::where('role',4)->get();
    return view('admin.admin.viewowner', ['title' => 'View User','user'=>$user,'data'=>$data]);
  }

  public function add_owner(){
     $user=Auth::user();
   // $data=User::where('role',4)->get();
    return view('admin.admin.add_owner', ['title' => 'Add Owner','user'=>$user]);
  }

  public function createowner(Request $request){

    $data=User::where('email',$request->email)->first();
    if(!empty($data->id)){
    return redirect('admin/viewowner')->with('error', 'Email Already Exist.') ;
    }else{
    if ($request->hasFile('image')) {
            $file = request()->file('image');
            $ext=$file->getClientOriginalExtension();
            $imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('admin/images/doctor', $imagename);
            }

      $url= URL::to('/');
      $groupImage=$url.'/admin/images/doctor/'.$imagename;
      $createdUser=$this->userObj->createUser([
            'first_name'     =>  $request->first_name??null,
            'last_name'      =>  $request->last_name??null,
            'email'          =>  $request->email??null,
            'profile'        =>  $groupImage??null,
        ]);
       return redirect('admin/viewowner')->with('status','Owner has been added Successfully.');
}
  }

 public function block_user(Request $request){

   
      $user = User::where('id',$request->user_id)->first();
        if ($request->status == 'Unblock')
        {
            if ($user->status == 'UNBLOCK')
              return response()->json(['success' => false,'message' => 'User Already Unblocked']);
            User::where('id',$request->user_id)->update([
                'block_status' => '0',
                'updated_at' => new \DateTime
            ]);
            return response()->json(['success' => true,'message' => 'User Unblocked Successfully']);

        }else{
            if ($user->status == 'Block')
              return response()->json(['success' => false,'message' => 'User Already Blocked']);
            User::where('id',$request->user_id)->update([
                'block_status' => '1',
                'updated_at' => new \DateTime
            ]);
            // dd($user = User::where('_id',$request->user_id)->first());
            return response()->json(['success' => true,'message' => 'User Blocked Successfully']);
        }

  }


}
