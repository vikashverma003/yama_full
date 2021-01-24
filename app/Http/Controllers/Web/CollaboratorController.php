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
class CollaboratorController extends Controller
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
    }else{
        return redirect('collaborator/signin');
    }}else{
        return redirect('collaborator/signin');
    }
    }

    public function collaborator_signin()
    {
      $user=Auth::user();
      if(!empty($user->role)){
      if($user->role =='4')
       return redirect('/');
      }else{
        return view('web.collaborator.Login', ['title' => 'Collaborator']);
      }
    }

    public function loginCollaorator(Request $request){
         //dd($request->all());
         $email=$request->get('email');
         $password=$request->get('password');
            
        if (Auth::attempt(['email' => $email, 'password' => $password, 'role' =>'2'])) {
          return redirect('/collaborator');
      }else{
        return redirect('collaborator/signin')->with('error', 'Login credential is not valid ') ;
      }

    }


}
