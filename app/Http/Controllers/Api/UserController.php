<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Redis;
use Hash;
use App\Models\Administrator;
use App\Models\Userinfo;
use App\Models\Userimage;
use App\Models\Billing;
use App\Models\Chatrequest;
use App\Models\Recommended;
use App\Models\Trusted;
use App\Models\ChatMessage;
use App\Models\Video;
use App\Models\Rating;
use App\Models\Services;
use App\Models\Advice;
use App\Models\Permotions;
use App\Models\Patientrating;
use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Helper;
use App\Models\Presentation;
use DB;
use URL;
use Log;
use DateTime;
use Mail;
use Twilio\Rest\Client;
use App\Repositories\Interfaces\LocationRepositoryInterface;

class UserController extends Controller
{
    use \App\Traits\APIResponseManager;
    use \App\Traits\CommonUtil;

    protected $userObj;
    protected $businessObj;
    protected $trustedObj;
    protected $ratingObj;
    protected $ratingsObj;
    protected $adviceObj;

    public function __construct(User $user,Trusted $trust,Rating $rating,Patientrating $patientrating, Advice $advice)
    {
        $this->userObj=$user;
        $this->trustedObj=$trust;
        $this->ratingObj=$rating;
        $this->ratingsObj=$patientrating;
        $this->adviceObj=$advice;
    }
    
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */

    public function signup(Request $request)
    {
        
      //die('==');

        try{
        $request->validate([
            
            'name' => "required",
            'email' => 'required_without:phone_number|unique:users,email',
            'phone_code'=>'required_without:email',
            'phone_number'=>'required_without:email|unique:users,phone_number'
            
            ]);
        
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        } 
      
        try{

        DB::beginTransaction();
            $otp=rand(1000,9999);

            if(!empty($request->phone_code)){
                $number =$request->phone_code.$request->phone_number;
            }
          
           if($request->email ==''){
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_number = getenv("TWILIO_NUMBER");
            $client = new Client($account_sid, $auth_token);
            $data=$client->messages->create($number, ['from' => $twilio_number, 'body' =>  $otp]);
         }




            $createdUser=$this->userObj->createUser([
                'name'          =>  $request->name??$request->first_name,
                'email'         =>  $request->email??null,
                'role'          =>  $request->role??null,
                'phone_code'    =>  $request->phone_code??null,
                'phone_number'  =>  $request->phone_number??null,
                'device_token'  =>  $request->device_token??null,
                'time_zone'     =>  $request->time_zone??null,
                'otp'           =>  $otp,
            ]);
            
           // $createdUser =$createdUser->load(['location','business']);
            $token=$this->userObj->createPassportToken($createdUser);
            //$otp=rand(100000,999999);

            $createdUser->access_token=$token;
            //$createdUser->otp=$otp;
        DB::commit();   
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_REGISTER_SUCCESS', 'response',  $createdUser);
    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
     
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    { 

        
		 try{
        $request->validate([
            //'email' => 'required|exists:users,email',
            'password'    => 'required|string',
            'device_token'=> 'string',
            'email'       => 'required_without:phone_number',
            'phone_number'=> 'required_without:email'
         
            ]);
        
		 } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

		try{
             \Log::error($request->all());

              if(!empty($request->email)){
                if (!Auth::attempt(['email' => $request->email, 'password' => $request->password,'role'=>$request->role])) {
                    return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_PASSWORD_WRONG', 'response','');
                }
                $user=Auth::user();
                $user->device_token=$request->device_token??null;
                $user->save();
                $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                $updatedUser=$this->userObj->user_resource($user);
            }else{
                if (!Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password,'role'=>$request->role])) {
                    return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_PASSWORD_WRONG', 'response','');
                }
                $user=Auth::user();
                $user->device_token=$request->device_token??null;
                $user->save();
                $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                $updatedUser=$this->userObj->user_resource($user);
            }

          
           
            User::where('id',$updatedUser->id)->update([
                        'is_login'       => '1',
                        'time_zone'      => $request->time_zone??null,
                        'device_token'   => $request->device_token,
                       
            ]);

            
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_LOGIN_SUCCESS', 'response', $updatedUser);
    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    } 
	}

    public function verifyOtp(Request $request){ 

     try{
        $request->validate([
            'otp' => 'required',
            'userid' => 'required',
            ]);
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{
               $user = User::where(['otp'=>$request->otp,'id'=>$request->userid])->first();
               $token=$this->userObj->createPassportToken($user);
               $user->access_token=$token;
                
                //$updatedUser =$user->load(['location','business']);
                $updatedUser=$this->userObj->user_resource($user);
               if(!empty($updatedUser)){
                return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_OTP_SUCCESS', 'response', $updatedUser);
               }else{
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_OTP_FAIL');
               }
     
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }}

    public function updatePasword(Request $request){ 
        try{
        $request->validate([
            'password' => 'required',
            'userid'   => 'required',
            ]);

         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{
                   
            User::where('id',$request->userid)->update([
                        'password'       => Hash::make($request->password),
                        'updated_at'     => new \DateTime
            ]);
             User::where('id',$request->userid)->update([
                        'is_complete'       => '1',
                        'updated_at'     => new \DateTime
            ]);

            $row = User::where(['id'=>$request->userid])->first();
               if(!empty($row)){
                return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_UPDATE_PASSWORD', 'response', $row);
            }else{
                 return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_NOT_FOUND');
            }
     
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function basicInfo(Request $request){
       try{
        $request->validate([
            'userid'              =>'required',
            'gender'              =>'required',
            'born'                =>'required',
            'fathername'          =>'required',
            'address1'            =>'required',
            'exterior_house'      =>'required',
            'zipcode'             =>'required',
            'country'             =>'required',
            'chronic_illness'     =>'required',
            'consume_medicines'   =>'required',
            'allergic_medication' =>'required',
            'fractures'           =>'required',
            'supervison'          =>'required',
            'marital_status'      =>'required',
            'education_level'     =>'required'
            ]);
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{
            //dd($request->all());
            $row = User::where(['id'=>$request->userid])->first();

            if(!empty($row)){
                if($request->born=='Invalid date'){
                   $born='1995-08-19';
                }else{
                   $born=$request->born;
                }
                 // print_r($request->allergic_medication_yes);
                 // die();
                
                if(!empty($request->chronic_yes)){
                    $chronic_yes=implode(',', $request->chronic_yes);
                }else{
                    $chronic_yes='';
                }

                if(!empty($request->consume_medicines_yes)){
                    $consume_medicines_yes=implode(',', $request->consume_medicines_yes);
                }else{
                    $consume_medicines_yes='';
                }

                if(!empty($request->allergic_medication_yes)){
                     $allergic_medication_yes=implode(',', $request->allergic_medication_yes);
                   
                }else{
                    $allergic_medication_yes='';
                }

                if(!empty($request->fractures_yes)){
                    $fractures_yes=implode(',', $request->fractures_yes);
                }else{
                    $fractures_yes='';
                }

                if(!empty($request->supervison_yes)){
                   $supervison_yes=implode(',', $request->supervison_yes);
                }else{
                   $supervison_yes='';
                }

                

            $info= DB::table('usersinfo')->insert([
                'user_id'               =>  $request->userid,
                'gender'                =>  $request->gender??null,
                'born'                  =>  $born??null,
                'fathername'            =>  $request->fathername??null,
                'address1'              =>  $request->address1??null,
                'address2'              =>  $request->address2??null,
                'interior_house'        =>  $request->interior_house??null,
                'exterior_house'        =>  $request->exterior_house??null,
                'zipcode'               =>  $request->zipcode??null,
                'country'               =>  $request->country??null,
                'chronic_illness'       =>  $request->chronic_illness??null,
                'chronic_yes'           =>  $chronic_yes??null,
                'consume_medicines'     =>  $request->consume_medicines??null,
                'consume_medicines_yes' =>  $consume_medicines_yes??null,
                'allergic_medication'   =>  $request->allergic_medication??null,
                'allergic_medication_yes'=> $allergic_medication_yes??null,
                'fractures'             =>  $request->fractures??null,
                'fractures_yes'         =>  $fractures_yes??null,
                'supervison'            =>  $request->supervison??null,
                'supervison_yes'        =>  $supervison_yes??null,
                'name'                  =>  $request->name??null,
                'age'                   =>  $request->age??null,
                'marital_status'        =>  $request->marital_status??null,
                'education_level'       =>  $request->education_level??null,
            ]);
            if($info){
                User::where('id',$request->userid)->update([
                        'is_complete'       => '2',
                        'updated_at'        => new \DateTime
            ]);
            $rows = User::where(['id'=>$request->userid])->first();

            $arrayName = array('userid' => $request->userid,'is_complete'=>$rows->is_complete,'verfiy_action'=> $rows->skip );
            }
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_INFO_SUCCESS', 'response', $arrayName);
            }else{
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_NOT_FOUND'); 
            }
        } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }


    public function verifyImage(Request $request){

        try{
            $request->validate([
                'userid'              => 'required',
                'upload_id'           => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:10000',
                'selfie'              => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:10000',
                'upload_profile'      => 'required|image|mimes:jpeg,png,jpg,bmp,gif,svg|max:10000',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }
                

            try{
            $row = User::where(['id'=>$request->userid])->first();
            if(!empty($row)){
                
                if ($request->hasFile('upload_id')) {
                    $upload_id = $request->file('upload_id');
                    $uploadName=$this->uploadGalery($upload_id);
                }
                if ($request->hasFile('selfie')) {
                    $selfie_id = $request->file('selfie');
                    $selfieName=$this->uploadGalery($selfie_id);
                }
                if ($request->hasFile('upload_profile')) {
                    $upload_profile = $request->file('upload_profile');
                    $profileName=$this->uploadGalery($upload_profile);
                }



               
            $info= DB::table('usersimage')->insert([
                'user_id'                  =>  $request->userid,
                'upload_id'                =>  $uploadName,
                'selfie'                   =>  $selfieName,
                'upload_profile'           =>  $profileName,
                
            ]);
             
            if($info){

              
                User::where('id',$request->userid)->update([
                        'is_complete'       => '3',
                        'updated_at'     => new \DateTime
                ]);

                User::where('id',$request->userid)->update([
                        'profile_image'       => $profileName,
                        'updated_at'     => new \DateTime
                ]);
                $user = User::where(['id'=>$request->userid])->first();
                   $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                $updatedUser=$this->userObj->user_resource($user);
               // $arrayName = array('user_response' => $updatedUser,'is_complete'=>$user->is_complete);
            }

            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_IMAGE_UPLOAD_SUCCESS', 'response',  $updatedUser);
            }else{
             return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_NOT_FOUND'); 
            }
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function forgotPasword(Request $request){
     
      try{
            $request->validate([
                //'userid'      => 'required',
                'email'       => 'required_without:phone_number',
                'phone_code'  =>'required_without:email',
                'phone_number'=>'required_without:email'
            ]);

             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }

        try{
          if(!empty($request->email)){
          $getData = User::where(['email'=>$request->email,'role'=>'patient'])->first();
       
             if(!empty($getData)){
                $otp=rand(1000,9999);
                $request['otp']=$otp;
                User::where('id',$request->userid)->update([
                            'otp'         => $otp,
                            'updated_at'  => new \DateTime
                ]);

            $test= Mail::send('templates.forgot', ['user' => $request], function ($m) use ($request) {
            $m->from('testing@gmail.com', 'Vinku Application');
            $m->to($request->email,$getData->id)->subject('Activate User By Email');
            });

            $arrayName = array('otp' => $otp,'userid'=>$getData->id);
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_FORGOT_SUCCESS', 'response',  $arrayName);
             }else{
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_FORGOTEMAIL_SUCCESS');
             }
         }
              if(!empty($request->phone_number)){
              $getnumber = User::where(['phone_number'=>$request->phone_number,'role'=>'patient'])->first();
             if(!empty($getnumber)){
                $otp=rand(1000,9999);
                $request['otp']=$otp;
                User::where('id',$getnumber->id)->update([
                            'otp'         => $otp,
                            'updated_at'  => new \DateTime
                ]);
                $arrayName = array('otp' => $otp,'userid'=>$getnumber->id);
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_FORGOTS_SUCCESS', 'response',  $arrayName);
             }else{
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_FORGOTPHONE_SUCCESS');
             }
         }
            
              
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    
    }
    
    public function verifyforgotOtp(Request $request){
      try{
            $request->validate([
                'userid'    => 'required',
                'otp'       => 'required'
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{
              $row = User::where(['otp'=>$request->otp,'id'=>$request->userid,'role'=>'patient'])->first();
               if(!empty($row)){
                User::where('id',$request->userid)->update([
                            'otp'         => '',
                            'updated_at'  => new \DateTime
                ]);
                return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_OTP_SUCCESS', 'response', $row);
               }else{
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_OTP_FAIL');
               }
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function changePassword(Request $request){
     try{
            $request->validate([
               'password' => 'required_with:password_confirmation|same:password_confirmation',
               'password_confirmation' => 'required',
               'userid'=>'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{
             
              $result= User::where('id',$request->userid)->update([
                            'password'         => Hash::make($request->password),
                            'updated_at'       => new \DateTime
                ]);
                $arrayName = array('userid' => $request->userid);
                return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'PASSWORD_UPDATE_SUCCESS', 'response', $arrayName);
              
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function patientProfileInfo(Request $request){
     
    try{
            $request->validate([
               'userid' => 'required'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
    try{
             
       $row = User::where(['id'=>$request->userid])->with(['userinfo'])->with(['userimage'])->first();
       if(!empty($row)){
       return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_SUCCESS', 'response', $row);
       }else{
         return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_NOT_FOUND');
       }
              
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function editProfile(Request $request){

        try{

            $request->validate([
              // 'profile_image'        =>'required',
               'name'                 =>'required',
               'born'                 =>'required',
               'gender'               =>'required',
               'fathername'           =>'required',
               //'occupation'           =>'required',
               'userid'               =>'required',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

         try{
             $row = User::where(['id'=>$request->userid])->first();
             if(!empty($row)){
              
                if ($request->hasFile('profile_image')) {
                    $profile_image = $request->file('profile_image');
                    $profileName=$this->uploadGalery($profile_image);
                }
            if(!empty($profileName)){
                $p_name=$profileName;
            }else{
            $row = User::where(['id'=>$request->userid])->first();
               $p_name=$row->profile_image;
            }

            
            $user= User::where('id',$request->userid)->update([
                            'profile_image'         => $p_name,
                            'name'                  => $request->name,
                            'occupation'            => $request->occupation,
                            'updated_at'            => new \DateTime
            ]);

            $userinfo= Userinfo::where('user_id',$request->userid)->update([
                            'gender'              => $request->gender,
                            'born'                => $request->born,
                            'fathername'          => $request->fathername,
                            'updated_at'          => new \DateTime
            ]);

                $user=Auth::user();
                $user->device_token=$request->device_token??null;
                $user->save();
                $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                $updatedUser=$this->userObj->user_resource($user);
           
                       
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'PROFILE_EDIT_SUCCESS', 'response', $updatedUser);
     }else{
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_NOT_FOUND');
     }
              
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function freeChatDoctor(Request $request){
      try{
            $request->validate([
                'userid'      => 'required',
                'for_chat'    => 'required',
            ]);

             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
         }

          try{
                $row = User::where(['role'=>'doctor','free_consultation'=>'1'])->where('rating', '>=','3.7')->orderBy('rating', 'desc')->limit(10)->get();


                foreach ($row as $getdoctor) {
                     $res=Chatrequest::where(['doctor_id'=>$getdoctor->id,'is_accept'=>'1'])->first();

                     if($res ==''){
                        $rets=Chatrequest::where(['doctor_id'=>$getdoctor->id,'patient_id'=>$request->userid,'is_accept'=>'3'])->first();
                       if(!empty($rets)){
                         $create_date=$rets->created_at;
                         $date = date('Y-m-d H:i:s');
                
                        $time1 = new DateTime($create_date);
                        $time2 = new DateTime($date);
                        $timediff = $time1->diff($time2);
                        $timediff->format('%y year %m month %d days %h hour %i minute %s second')."<br/>";
                          $day    = $timediff->d."<br/>";
                          $hours  = $timediff->h."<br/>";
                          $minuts = $timediff->i."<br/>";
                       // if($day ==0 AND $hours==0 AND $minuts < 15){
                          //  $rt='1';
                       // }else{ 
                          $newdate=date('Y-m-d');
                           $rt= DB::table('chat_request')->insert(['patient_id' => $request->userid, 'doctor_id' =>$getdoctor->id,'price_status'=>'0','for_chat'=>$request->for_chat,'name'=>$request->name,'age'=>$request->age,'date'=>$newdate,'updated_at'=> new \DateTime,'created_at'=>new \DateTime]);

                          $data=User::where(['id'=>$getdoctor->id])->first();
                          $token=$data->device_token;
                          $socket_id=$data->socket_id;
                           //\Log::error($data->email);
                           \Log::error($data);
                          $ring='loving';
                          $datadd=Helper::SendPushNotificationsDoctor($token,'New Request','Please accept patient request',$ring);
                          //$redis = Redis::connection();
                          //$test=$redis->publish('channel5_'.$socket_id,'requestSend');

                          //\Log::error($datadd);
                       //}

                       }else{
                        $newdate=date('Y-m-d');
                        $rt= DB::table('chat_request')->insert(['patient_id' => $request->userid, 'doctor_id' =>$getdoctor->id,'price_status'=>'0','for_chat'=>$request->for_chat,'name'=>$request->name,'age'=>$request->age,'date'=>$newdate,'updated_at'=> new \DateTime,'created_at'=>new \DateTime]);
                        
                          $data=User::Where(['id'=>$getdoctor->id])->first();

                          $token=$data->device_token;
                          $socket_id=$data->socket_id;
                          \Log::error($data);
                          $ring='loving';
                          $datas=Helper::SendPushNotificationsDoctor($token,'New Request','Please accept patient request',$ring); 
                          \Log::error($datas);
                          // $redis = Redis::connection();
                          // $test=$redis->publish('channel5_'.$socket_id,'requestSend');
                          
                       }
                            
                 }

                  // $data=User::Where(['id'=>$getdoctor->id])->first();
                  //         $token=$data->device_token;
                  //         Helper::SendPushNotificationsDoctor($token,'New Request','Please accept patient request'); 

                }
                if(!empty($rt)){
                  
                     return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'REQUEST_SEND_SUCCESS');
                }else{
                     //return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_NOT_FOUND');
                    return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'REQUEST_SEND_SUCCESS');
                }     
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }
     
     public function signleDoctorRequest(Request $request){

        try{
            $request->validate([
                'doctor_id'      => 'required',
                'patient_id'     => 'required',
                'for_chat'       => 'required',
                'payment_id'     => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
          $result=User::where('id',$request->doctor_id)->where('role','doctor')->where('paid_consultation',0)->where('free_consultation',0)->first();
           if(!empty($result->id)){
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'OFFLINE');
            die();
           }
            $results=User::where('id',$request->doctor_id)->where('role','doctor')->where('paid_consultation','0')->where('free_consultation',1)->first();
            if(!empty($results->id)){
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'FREE');
            die();
            }

           $record=Transaction::where('id',$request->payment_id)->first();

            $info= DB::table('chat_request')->insertGetId([
                'patient_id'               => $request->patient_id,
                'doctor_id'                => $request->doctor_id,
                'for_chat'                 => $request->for_chat,
                'name'                     => $request->name,
                'age'                      => $request->age,
                'price_status'             => $record->amount,
                'date'                     => date('Y-m-d'),
                'created_at'               => new \DateTime,
                'updated_at'               => new \DateTime,
            ]);
           
            $data= Chatrequest::where('id',$info)->first();
            $doctorData=$data->doctor_id;
            $matchdata=User::where('id',$doctorData)->with('medicalchat')->first();
           
            $ring='loving';
            $datadd=Helper::SendPushNotificationsDoctor($matchdata->device_token,'New Request','Please accept patient request',$ring);
            //$matchdata['request_id']= $data->id;


            if(!empty($matchdata->profile_image)){
                     $url= URL::to('/');
                     $image=$url.'/'.$matchdata->profile_image;
                     }else{
                     $image='';
                     }
                     $matchRecord=array('id'=>$matchdata->id, 
                                     'name'=>$matchdata->name,
                                     'email'=>$matchdata->email,
                                     'role'=>$matchdata->role,
                                     'profile_image'=>$image,
                                     'disease'=>$matchdata->disease,
                                     'account_status'=>$matchdata->account_status,
                                     'email_verified_at'=>$matchdata->email_verified_at,
                                     'phone_code'=>$matchdata->phone_code,
                                     'phone_number'=>$matchdata->phone_number,
                                     'random'=>$matchdata->random,
                                     'device_token'=>$matchdata->device_token,
                                     'is_complete'=>$matchdata->is_complete,
                                     'paid_consultation'=>$matchdata->paid_consultation,
                                     'free_consultation'=>$matchdata->free_consultation,
                                     'rating'=>$matchdata->rating,
                                     'fees'=>$matchdata->fees,
                                     'block_status'=>$matchdata->block_status,
                                     'is_login'=>$matchdata->is_login,
                                     'skip'=>$matchdata->skip,
                                     'short_description'=>$matchdata->medicalchat->short_description,
                                     'experience'=>$matchdata->medicalchat->experience,
                                     'degrees'=>$matchdata->medicalchat->degrees,
                                     'created_at'=>$matchdata->created_at,
                                     'updated_at'=>$matchdata->updated_at,
                                     'request_id' => $data->id,
                                     'price'      => $data->price_status,
                                    );

             $userimage= Transaction::where('id',$request->payment_id)->update([
                                            'request_id'           => $data->id,
                                            'updated_at'           => new \DateTime
             ]);

            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $matchRecord);
            
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }



     }

    public function reciveRequest(Request $request){
     try{
            $request->validate([
                'doctorid'      => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
         try{
              $resTot=Chatrequest::where(['doctor_id'=>$request->doctorid,'is_accept'=>'0'])->first();

               if(!empty($resTot)){
                $Chatrequest[]=Chatrequest::where(['doctor_id'=>$request->doctorid,'is_accept'=>'0'])->first();
               
                $resTotal=User::where(['id'=>$Chatrequest['0']['patient_id']])->with('userinfo')->first();
                // print_r($resTotal);
                // die();
          
            $born=$resTotal->userinfo->born;
            $dateOfBirth = $born;
            //die($dateOfBirth);
            $today = date('Y-m-d');
            $diff = date_diff(date_create($dateOfBirth), date_create($today));

            $bornYear=$diff->format('%y');
             $bornMonth=$diff->format('%m');

             if($bornYear =='0'){
                $born=$bornMonth.' '.'Month';
              }else{
                 $born=$bornYear.' '.'Year';
              }
                $url= URL::to('/');
                $data=array('id'=>$resTotal->id,
                            'request_id'=>$Chatrequest['0']['id'],
                            'for_chat'=>$Chatrequest['0']['for_chat'],
                            'name'=>$resTotal->name,
                            'email'=>$resTotal->email,
                            'role'=>$resTotal->role,
                            'age'=>$born,
                            'profile_image'=> $url.'/'.$resTotal->profile_image,
                            'disease'=>$resTotal->disease,
                            'account_status'=>$resTotal->account_status,
                            'email_verified_at'=>$resTotal->email_verified_at,
                            'phone_code'=>$resTotal->phone_code,
                            'phone_number'=>$resTotal->phone_number,
                            'is_complete'=>$resTotal->is_complete,
                            'paid_consultation'=>$resTotal->paid_consultation,
                            'free_consultation'=>$resTotal->free_consultation,
                            'rating'=>$resTotal->rating,
                            'fees'=>$resTotal->fees,
                            'block_status'=>$resTotal->block_status,
                            'is_login'=>$resTotal->is_login,
                            'created_at'=>$resTotal->created_at,
                            'updated_at'=>$resTotal->updated_at,
                            'gender'=>$resTotal->userinfo->gender,
                            'born'=>$resTotal->userinfo->born,
                            'fathername'=>$resTotal->userinfo->fathername,
                            'address1'=>$resTotal->userinfo->address1,
                            'address2'=>$resTotal->userinfo->address2,
                            'interior_house'=>$resTotal->userinfo->interior_house,
                            'exterior_house'=>$resTotal->userinfo->exterior_house,
                            'zipcode'=>$resTotal->userinfo->zipcode,
                            'country'=>$resTotal->userinfo->country,
                            'chronic_illness'=>$resTotal->userinfo->chronic_illness,
                            'chronic_yes'=> explode(',',$resTotal->userinfo->chronic_yes),
                            'consume_medicines'=>$resTotal->userinfo->consume_medicines,
                            'consume_medicines_yes'=>  explode(',',$resTotal->userinfo->consume_medicines_yes),
                            'allergic_medication'=>$resTotal->userinfo->allergic_medication,
                            'allergic_medication_yes'=> explode(',',$resTotal->userinfo->allergic_medication_yes),
                            'fractures'=>$resTotal->userinfo->fractures,
                            'fractures_yes'=> explode(',',$resTotal->userinfo->fractures_yes),
                            'supervison'=>$resTotal->userinfo->supervison,
                            'supervison_yes'=>explode(',',$resTotal->userinfo->supervison_yes),
                            'marital_status'=>$resTotal->userinfo->marital_status,
                            'education_level'=>$resTotal->userinfo->education_level,
                            'name_request'=>$Chatrequest['0']['name'],
                            'age_request'=>$Chatrequest['0']['age'],
                            'price' => $resTot->price_status,
                           );

            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'REQUEST_RECIVE_SUCCESS', 'response', $data);
        }else{
            $data=array('id'=>'');
             return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'REQUEST_RECIVE_SUCCESS', 'response', $data);
        }

    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function requestStatus(Request $request){
        try{
            $request->validate([
                'id'         =>  'required',
                'status'     =>  'required',
                'patient_id' =>  'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{

             $getRecords=Chatrequest::where('id',$request->id)->first();
             if(!empty($getRecords->id)){   
            $userimage= Chatrequest::where('id',$request->id)->update([
                            'is_accept'             => $request->status,
                            'updated_at'            => new \DateTime
            ]);

            $resultData= Chatrequest::Where(['patient_id'=>$request->patient_id,'is_accept'=>'0'])->get();
            foreach ($resultData as $newVal) {
              $rest= Chatrequest::where('id', $newVal->id)->delete();
            }

            if($request->status =='1'){
                
             $userData=User::where(['id'=>$request->patient_id])->with('userinfo')->with('userimage')->first();   
            // print_r($userData->userinfo->born);
            // die();
            $born=$userData->userinfo->born;
            $dateOfBirth = $born;
            $today = date('Y-m-d H:i:s');
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            $year=$diff->format('%y');
            $month=$diff->format('%m');
            if($year =='0'){
              $born=$month.' '.'Month';
            }else{
             $born=$year.' '.'Year';
            }
            $userData['age']=$born;
            $userData['request_id']=$request->id;
            $socket_id=$userData->socket_id;
                $redis = Redis::connection();
                $test=$redis->publish('channel2_'.$socket_id,'request');
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'REQUEST_STATUS_SUCCESS', 'response', $userData);

            }else{
                if($request->status == '2'){
                    $data=User::where(['id'=>$request->patient_id])->first();
                    $token=$data->device_token;
                    $socket_id=$data->socket_id;
                    $ring='true';
              Helper::SendPushNotificationsPatient($token,'Vinku Message','Request has been reject.',$ring); 
                $redis = Redis::connection();
                $test  = $redis->publish('channel3_'.$socket_id,'request');
                // print_r($test);
                // die();

                }else if($request->status == '3'){
                    $data=User::where(['id'=>$request->patient_id])->first();
                    $token=$data->device_token;
                    $socket_id=$data->socket_id;
                    $ring='true';
              Helper::SendPushNotificationsPatient($token,'Vinku Message','Chat has been ended.',$ring);
                $redis = Redis::connection();
                $test  = $redis->publish('channel4_'.$socket_id,'request');
                
                }
                

             return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'REQUEST_REJECTED_SUCCESS'); 
            }
            }else{
             return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'NOT_LONGER'); 
            }

    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function rejectStatus(Request $request){
        try{
            $request->validate([
                'id' => 'required',
                'status'     => 'required',
            ]);
             }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{
                
            $userimage= Chatrequest::where('id',$request->id)->update([
                            'is_accept'             => $request->status,
                            'updated_at'            => new \DateTime
            ]);

            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'REJECT_STATUS_SUCCESS'); 
            
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }



    public function requestWaiting(Request $request){

        try{
            $request->validate([
                'userid'      => 'required',
                //'is_accept'  => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }

           try{
                
            $data=Chatrequest::where(['patient_id'=>$request->userid,'is_accept'=>'1'])->first();

            if(!empty($data)){
               $doctorId=$data->doctor_id;
               $id=$data->id;
            $result=User::where(['id'=>$doctorId])->with('general')->with('medicalchat')->first();

            //$rest = array('request_id' => $id);
             $record= Trusted::where('patient_id',$request->userid)->where('doctor_id',$doctorId)->where('status',1)->first();
            if(!empty($record->id)){
                $is_trusted='1';
            }else{
              $is_trusted='0';
            }
            $url= URL::to('/');
     
           $image=$url.'/'.$result->profile_image;
       
            $result['request_id']= $id;
            $result['is_trusted']= $is_trusted;
            $result['profile_image']= $image;

           return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $result);

            }else{
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_NOT_FOUND');
            } 

    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

   
   
     public function addTrusted(Request $request){
        
         try{
            $request->validate([
                'patient_id'             => 'required',
                'doctor_id'              => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           } 

           try{
         DB::beginTransaction();
         $createdUser=$this->trustedObj->createTrusted([
                'patient_id'   =>  $request->patient_id,
                'doctor_id'    =>  $request->doctor_id??null,
                'date'         =>  date('Y-m-d'),
                'status'       => '1',
            ]);

         $data=User::where('id',$request->doctor_id)->first();
         $token=$data->device_token;
         Helper::SendPushNotificationsDoctors($token,'New Trusted Patient','congratulations, you have a new trusted patient');

          DB::commit(); 
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'DOCTOR_TRUSTED_SUCCESS', 'response', $createdUser);

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

    }

    public function removeTrusted(Request $request){

        try{
            $request->validate([
                'patient_id'             => 'required',
                'doctor_id'              => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }

           try{

        $data=DB::table('trusted')->where('patient_id',$request->patient_id)->where('doctor_id',$request->doctor_id)->delete();
    return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'DOCTOR_UNTRUSTED_SUCCESS');

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

          
    }

    public function getVideo(Request $request){
       $video=Video::get();

        $url= URL::to('/');
        foreach ($video as $res) {
           $data[]=$url.'/admin/images/doctor/'.$res->video;
        }
       return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $data);
    }

    public function patientrating(Request $request){
        try{
            $request->validate([
                'patient_id'             => 'required',
                'doctor_id'              => 'required',
                'rating'                 => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }
          
        try{

            $info= DB::table('doctor_rating')->insert([
                'patient_id'         =>  $request->patient_id,
                'doctor_id'          =>  $request->doctor_id??null,
                'rating'             =>  $request->rating??null,
                'comment'            =>  $request->comment??null,
                'cooperetive'        =>  $request->cooperetive??null,
                'mannered'           =>  $request->mannered??null,
                'understanding'      =>  $request->understanding??null,
                'consultation'       =>  $request->consultation??null,
                'rude'               =>  $request->rude??null,
                'help'               =>  $request->help??null,
                'uncomfortable'      =>  $request->uncomfortable??null,
                'unprofessional'     =>  $request->unprofessional??null,
                'date'               =>  date('Y-m-d'),
                'created_at'         => new \DateTime,
                'updated_at'         => new \DateTime,
                
            ]);

         $five = Rating::where(['rating'=>'5','doctor_id'=>$request->doctor_id])->count();
         $four = Rating::where(['rating'=>'4','doctor_id'=>$request->doctor_id])->count();
         $three= Rating::where(['rating'=>'3','doctor_id'=>$request->doctor_id])->count();
         $two  = Rating::where(['rating'=>'2','doctor_id'=>$request->doctor_id])->count();
         $one  = Rating::where(['rating'=>'1','doctor_id'=>$request->doctor_id])->count();
         $totalcount=($five*5 + $four*4 + $three*3 + $two*2 + $one*1) / ($five + $four + $three + $two + $one);
         $ratingUpdate=User::where('id',$request->doctor_id)->update([
                                'rating'        => $totalcount,
                                'updated_at'    => new \DateTime
                    ]);
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'DOCTOR_RATING_SUCCESS');

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }


     public function doctorrating(Request $request){
        try{
            $request->validate([
                'patient_id'             => 'required',
                'doctor_id'              => 'required',
                'rating'                 => 'required',
                //'comment'                => 'required', 
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }
          
        try{
          
          $info= DB::table('patient_rating')->insert([
                'patient_id'         =>  $request->patient_id,
                'doctor_id'          =>  $request->doctor_id??null,
                'rating'             =>  $request->rating??null,
                'comment'            =>  $request->comment??null,
                'cooperetive'        =>  $request->cooperetive??null,
                'mannered'           =>  $request->mannered??null,
                'understanding'      =>  $request->understanding??null,
                'consultation'       =>  $request->consultation??null,
                'rude'               =>  $request->rude??null,
                'help'               =>  $request->help??null,
                'uncomfortable'      =>  $request->uncomfortable??null,
                'unprofessional'     =>  $request->unprofessional??null,
                'date'               =>  date('Y-m-d'),
                'created_at'         => new \DateTime,
                'updated_at'         => new \DateTime,
            ]);

         
         $five = Patientrating::where(['rating'=>'5','patient_id'=>$request->patient_id])->count();
         $four = Patientrating::where(['rating'=>'4','patient_id'=>$request->patient_id])->count();
         $three= Patientrating::where(['rating'=>'3','patient_id'=>$request->patient_id])->count();
         $two  = Patientrating::where(['rating'=>'2','patient_id'=>$request->patient_id])->count();
         $one  = Patientrating::where(['rating'=>'1','patient_id'=>$request->patient_id])->count();
         $totalcount=($five*5 + $four*4 + $three*3 + $two*2 + $one*1) / ($five + $four + $three + $two + $one);
         
         $ratingUpdate=User::where('id',$request->patient_id)->update([
                                'rating'        => $totalcount,
                                'updated_at'    => new \DateTime
                    ]);
         
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'DOCTOR_RATING_SUCCESS');

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function getServices(Request $request){

         try{
            //dd($request->all());
            if($request->language =='1'){
        $data=Services::select('id','question','answer','image','phonenumber','created_at','updated_at')->get();
            }else{
        $data=Services::select('id','question_sp','answer_sp','image','phonenumber','created_at','updated_at')->get();        
            }

        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $data);
    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }
    public function getPermotions(Request $request){
     try{
        if($request->language =='1'){
        $data=Permotions::select('id','heading','off','image','created_at','updated_at')->get();
    }else{
        $data=Permotions::select('id','heading_es','off','image','created_at','updated_at')->get();
    }
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $data);
    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }
    public function skip(Request $request){
        try{
            $request->validate([
                'login_id'             => 'required',
               
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }
    try{
         
            $data= User::where('id',$request->login_id)->update([
                                 'skip'             => '1',
                                 'updated_at'       => new \DateTime
            ]);
        $user= User::Where(['id'=>$request->login_id])->first();
        // $url= URL::to('/');
        // if(!empty($result->profile_image)){
        //   $image=$url.'/'.$result->profile_image;
        // }else{ 
        //   $image=$result->profile_image;
        // }
        // $arrayName = array('id' => $result->id,
        //                    'name'=>$result->name,
        //                    'email'=>$result->email,
        //                    'role'=>$result->role,
        //                    'profile_image'=>$image,
        //                    'disease'=>$result->disease,
        //                    'account_status'=>$result->account_status,
        //                    'email_verified_at'=>$result->email_verified_at,
        //                    'phone_code'=>$result->phone_code,
        //                    'phone_number'=>$result->phone_number,
        //                    'is_complete'=>$result->is_complete,
        //                    'paid_consultation'=>$result->paid_consultation,
        //                    'free_consultation'=>$result->free_consultation,
        //                    'rating'=>$result->rating,
        //                    'is_login'=>$result->is_login,
        //                    'skip'=>$result->skip,
        //                    'gender'=>$result->userinfo->gender,
        //  );

          $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                $updatedUser=$this->userObj->user_resource($user);
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $updatedUser);

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

    }

    public function logout(Request $request){
         try{
            $request->validate([
                'user_id'             => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }

        try{

             User::where('id',$request->user_id)->update([
                        'is_login'           =>'0',
                        'device_token'       =>'',
                        'paid_consultation'  =>'0',
                        'free_consultation'  =>'0',
                       
            ]);

            $request->user()->device_token=null;
            $request->user()->save();
        $request->user()->token()->revoke();
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_LOGOUT_SUCCESS');
         // return response()->json([
             // 'message' => 'Successfully logged out'
        // ]);
        } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function ongoningCall(Request $request){
         try{
            $request->validate([
                'doctor_id'             => 'required',
            ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }
    try{
        $data=Chatrequest::where(['doctor_id'=>$request->doctor_id,'is_accept'=>1])->first();
        if(!empty($data)){
        $patient_id=$data->patient_id;
        $request_id=$data->id;
        $dataUser=User::where(['id'=>$patient_id])->first();
        
         $record=Userinfo::where('user_id',$dataUser->id)->first();
         $dateOfBirth = $record->born;
            
            $today = date('Y-m-d');
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            $year=$diff->format('%y');
            $month=$diff->format('%m');
            if($year =='0'){
            $born=$month.' '.'Month';
            }else{
            $born=$year.' '.'Year';
            }
        $dataUser['request_id']=$request_id;
        $url= URL::to('/');
        $image=$url.'/'.$dataUser['profile_image'];
        $dataUser['profile_image']= $image;
        $dataUser['age']=$born;

       }else{
        $dataUser['id']='';
        // $dataUser='';
       }
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $dataUser);
      } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function ongoningChat(Request $request){
     
     try{
            $request->validate([
                'request_id'             => 'required',
            ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }
        try{
         
         $data=Chatrequest::where(['id'=>$request->request_id])->first();
         if($data->is_accept == 3){
            $id['id']="0";
         }else if($data->is_accept == 1){
            $id['id']="1";
         }else{
            $id['id']="";
         }

         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $id);

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }    
    }

    public function allmedicine(Request $request){
         try{
            $request->validate([
                'request_id'             => 'required',
            ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }
             try{
         
        $data=Recommended::where('request_id',$request->request_id)->get();
        
        $rest=array();
        foreach ($data as $res) {

            if(!empty($res->frequency)){
            $frequency=explode(',',$res->frequency);
            }else{
            $frequency='';
            }
            // print_r($frequency);
            // die();
             $rest[]=array('id'=>$res->id,
                          'patient_id'=>$res->patient_id,
                          'doctor_id'=>$res->doctor_id,
                          'request_id'=>$res->request_id,
                          'name'=>$res->name,
                          'dosage'=>$res->dosage,
                          'no_day'=>$res->no_day,
                          'frequency'=>$res->frequency,
                          'instruction'=>$res->instruction,
                          'presentation' => $res->presentation,
                          'route_administrations'=>$res->route_administrations,
                          'created_at'=>$res->created_at,
                          'updated_at'=>$res->updated_at
                      );
            # code...
        }

         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $rest);

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    } 
    }




    public static function notification(){
        
        $token='euYO9OYyRjWDpJqe-5ocBP:APA91bFfWy86IMk3UXGoOYoEAIItZm8Z0spg2t1ajTxPyJyXthxZibxXVF-eegvzdXHc36so_4s5U0L6zpCrNxTWOGEWOrQuXuZ2dfDgbVTOXZW-B_G9xV5LUNGuC7Vlygo-ympZB-0J';

        $title='Notification';
        $body ='Today Notifications';
        $sound='true';

        $ch = curl_init("https://fcm.googleapis.com/fcm/send"); 
          $notification = array('title' =>$title , 'body' => $body, 'vibrate'=> true, 'sound'=> $sound, 'content-available' => true, 'priority' => 'high'); 
          $data = array('title' => $title, 'body' => $body);
          $arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $data);
          
           $json = json_encode($arrayToSend); 
           $headers = array();
           $headers[] = 'Content-Type: application/json';
           
           
           //Doctor
           $headers[] = 'Authorization: key=AAAAp5iBwWM:APA91bHb2T8c648g8fcaGk1rIsMOqLL7CdemQhzGbQ9tnn-EGPRfEpEYMIdKXwxdPNUrIEmwUeQaRfACAo0utP7uNojrdR86idI0Podt_LRUZJTeJuHjgKRYviK2LkPlUrks7inyWj59';
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
           curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
           curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
           
           curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, true);  
           curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_POST, 1);
      
          $response = curl_exec($ch);
          curl_close($ch);
          
          return $response ;
              
      }  


    public function PatientongoningCall(Request $request){
         try{
            $request->validate([
                'patient_id'             => 'required',
            ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }
    try{
        $data=Chatrequest::where(['patient_id'=>$request->patient_id,'is_accept'=>1])->first();
        if(!empty($data)){
        $doctor_id=$data->doctor_id;
        $request_id=$data->id;
        $dataUser=User::where(['id'=>$doctor_id])->first();
       
        $record=Trusted::where('patient_id',$request->patient_id)->where('doctor_id',$doctor_id)->where('status',1)->first();

        if(!empty($record->id)){
            $is_trusted='1';
        }else{
            $is_trusted='0';
        }

        $url= URL::to('/');
        $image=$url.'/'.$dataUser['profile_image'];
        $dataUser['profile_image']= $image;

        $dataUser['request_id']=$request_id;
        $dataUser['is_trusted']=$is_trusted;

       }else{
        $dataUser['id']='';
        // $dataUser='';
       }
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $dataUser);
      } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function medical_advice(Request $request){
        
        try{
            $request->validate([
                'patient_id'             => 'required',
                'doctor_id'              => 'required',
                'request_id'             => 'required',
                'advice'                 => 'required',
                //'type'                   => 'required',
            ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }
        try{
     
            DB::beginTransaction();
            $createdUser=$this->adviceObj->createAdvice([
                'patient_id'    =>  $request->patient_id??nul,
                'doctor_id'     =>  $request->doctor_id??null,
                'request_id'    =>  $request->request_id??null,
                'advice'        =>  $request->advice??null,
                
            ]);
        DB::commit(); 
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $createdUser);
      } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function patientTrusted(Request $request){
      try{
            $request->validate([
                'doctor_id'              => 'required',
            ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }

        try{
            
            $data=Trusted::where('doctor_id',$request->doctor_id)->where('status',1)->get();
            $info=array();
            foreach ($data as $res) {
                $patient_id=$res->patient_id;
                $info=User::where('id',$patient_id)->first();

                if(!empty($info->profile_image)){
                     $url= URL::to('/');

                    $image=$url.'/'.$info->profile_image;
                }else{
                    $image='';
                }

                $count=Chatrequest::where('doctor_id',$request->doctor_id)->where('patient_id',$info->id)->where('is_accept',3)->get();

                $n=0;
                foreach ($count as $reft) {
                    $n++;
                    if(!empty($reft->created_at)){
                        $created_at= $reft->created_at;
                    }else{
                        $created_at= '';
                    }

                   
                }

                $result[]=array('id'=>$info->id,
                                'name'=>$info->name,
                                'email'=>$info->email,
                                'role'=>$info->role,
                                'profile_image'=>$image,
                                'phone_code'=>$info->phone_code,
                                'phone_number'=>$info->phone_number,
                                'device_token'=>$info->device_token,
                                'is_login'=>$info->is_login,
                                'block_status'=>$info->block_status,
                                'count'=>$n,
                                'created_at'=>$created_at??null,
                            );
            }
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $result);
      } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }    
    }

    public function doctorChatHistory(Request $request){

      try{
            $request->validate([
                'doctor_id'              => 'required',
            ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }

        try{
            
            $data = Chatrequest::where('doctor_id', $request->doctor_id)->where('is_accept',3)->orderBy('id', 'DESC')->get();

           // print_r($data);
            //die();
                
            foreach ($data as $res) {
                $request_id=$res->id;
                $is_accept=$res->is_accept;
                $price_status=$res->price_status;
                $created_at=$res->created_at;
                


                 $data=User::where('id',$res->patient_id)->first();
                 if(!empty($data->profile_image)){
                     $url= URL::to('/');

                    $image=$url.'/'.$data->profile_image;
                    //$image=$info->profile_image;
                }else{
                    $image='';
                }

                 $result[]=array('id'=>$data->id,
                                'name'=>$data->name,
                                'email'=>$data->email,
                                'role'=>$data->role,
                                'price_status'=>$price_status,
                                'rating'=>$data->rating,
                                'profile_image'=>$image,
                                'phone_code'=>$data->phone_code,
                                'phone_number'=>$data->phone_number,
                                'device_token'=>$data->device_token,
                                'is_login'=>$data->is_login,
                                'block_status'=>$data->block_status,
                                'request_id'=>$request_id,
                                'is_accept'=>$is_accept,
                                'created_at' =>$created_at, 
                            );

            }
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $result);
      } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    } 
    }

    public function editResedentialinfo(Request $request){
       
            try{

            $request->validate([
               'address1'          =>'required',
               'address2'          =>'required',
               'zipcode'           =>'required',
               'country'           =>'required',
               'userid'            =>'required',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
         try{

             $row = User::where(['id'=>$request->userid])->first();
             if(!empty($row)){
              
            $userinfo= Userinfo::where('user_id',$request->userid)->update([
                            'address1'            => $request->address1,
                            'address2'            => $request->address2,
                            'interior_house'      => $request->interior_house,
                            'exterior_house'      => $request->exterior_house,
                            'zipcode'             => $request->zipcode,
                            'country'             => $request->country,
                            'updated_at'          => new \DateTime
            ]);

                $user=Auth::user();
                $user->device_token=$request->device_token??null;
                $user->save();
                $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                $updatedUser=$this->userObj->user_resource($user);

         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'PROFILE_EDIT_SUCCESS', 'response', $updatedUser);
     }else{
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_NOT_FOUND');
     }
              
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function medicalInfoEdit(Request $request){

      try{

            $request->validate([
               'chronic_illness'        =>'required',
               'consume_medicines'      =>'required',
               'allergic_medication'    =>'required',
               'fractures'              =>'required',
               'userid'                 =>'required',
               'supervison'             =>'required',
               'marital_status'         =>'required',
               'education_level'        =>'required',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{

             $row = User::where(['id'=>$request->userid])->first();
             if(!empty($row)){

                if(!empty($request->chronic_yes)){
                    $chronic_yes=implode(',', $request->chronic_yes);
                }else{
                    $chronic_yes='';
                }

                if(!empty($request->consume_medicines_yes)){
                    $consume_medicines_yes=implode(',', $request->consume_medicines_yes);
                }else{
                    $consume_medicines_yes='';
                }

                if(!empty($request->allergic_medication_yes)){
                     $allergic_medication_yes=implode(',', $request->allergic_medication_yes);
                   
                }else{
                    $allergic_medication_yes='';
                }

                if(!empty($request->fractures_yes)){
                    $fractures_yes=implode(',', $request->fractures_yes);
                }else{
                    $fractures_yes='';
                }

                if(!empty($request->supervison_yes)){
                    $supervison_yes=implode(',', $request->supervison_yes);
                }else{
                    $supervison_yes='';
                }
                
              
            $userinfo= Userinfo::where('user_id',$request->userid)->update([
                            'chronic_illness'         => $request->chronic_illness,
                            'consume_medicines'       => $request->consume_medicines,
                            'allergic_medication'     => $request->allergic_medication,
                            'fractures'               => $request->fractures,
                            'chronic_yes'             => $chronic_yes,
                            'supervison'              => $request->supervison,
                            'supervison_yes'          => $supervison_yes,
                            'marital_status'          => $request->marital_status,
                            'education_level'         => $request->education_level,
                            'consume_medicines_yes'   => $consume_medicines_yes,
                            'allergic_medication_yes' => $allergic_medication_yes,
                            'fractures_yes'           => $fractures_yes,
                            'updated_at'              => new \DateTime
            ]);

             $user=Auth::user();
                $user->device_token=$request->device_token??null;
                $user->save();
                $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                $updatedUser=$this->userObj->user_resource($user);

         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'PROFILE_EDIT_SUCCESS', 'response', $updatedUser);
     }else{
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_NOT_FOUND');
     }
              
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function editAccountInfo(Request $request){

        try{

            $request->validate([
               'upload_id'      =>'required',
               'userid'         =>'required',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
     
            if ($request->hasFile('upload_id')) {
                    $upload_id = $request->file('upload_id');
                    $uploadName=$this->uploadGalery($upload_id);
                }
             $userinfo= Userimage::where('user_id',$request->userid)->update([
                            'upload_id'         => $uploadName,
                            'updated_at'        => new \DateTime
            ]);
                $user=Auth::user();
                $user->device_token=$request->device_token??null;
                $user->save();
                $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                $updatedUser=$this->userObj->user_resource($user);

        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'PROFILE_EDIT_SUCCESS', 'response', $updatedUser);

      } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function consultationStatus(Request $request){
        
       try{
            $request->validate([
               'userid'         =>'required',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{
         
        
        
             $userinfo= User::where('id',$request->userid)->update([
                            'paid_consultation' => $request->paid_consultation,
                            'free_consultation' => $request->free_consultation,
                            'updated_at'        => new \DateTime
            ]);
                $user=User::where('id',$request->userid)->first();
                //$user->device_token=$request->device_token??null;
                $user->save();
                $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                $updatedUser=$this->userObj->user_resource($user);

                $userId=$updatedUser->id;
                $rester=User::where('id',$userId)->first();
                $socket_id=$rester->socket_id;


                $socket_data    = array(
                'socket_ids'    =>  json_encode($socket_id),
                'data'          =>  'tdstet',
                'type'          =>  'Message',
                'message'       =>  'Just for testing purpose',
                );

               //$redis = \Illuminate\Support\Facades\Redis::connection();
              // $test=$redis->publish('message',json_encode($socket_data));

               //Redis connection
                        //Redis connection
                $redis = Redis::connection();
                $test=$redis->publish('channel1_'.$socket_id,'test');


        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'PROFILE_EDIT_SUCCESS', 'response', $updatedUser);

      } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function homeDashboard(Request $request){
      
       try{
            $request->validate([
               'userid'         =>'required',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
         
                $date = date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-7 days'));
                $Pastweek=date('Y-m-d', strtotime('-14 days'));
                $users = Chatrequest::where('doctor_id',$request->userid)->where('date','>=',$fromweek)->where('date','<=',$date)->get();
                $total_price_sum='0';
                foreach ($users as $res) {
                $total_price_sum = $total_price_sum + $res->price_status;
                }
                $wekendIncome=$total_price_sum;

               //Past Weekend Earning

                $Pastusers = Chatrequest::where('doctor_id',$request->userid)->where('date','>=',$Pastweek)->where('date','<=',$fromweek)->get();
                $total_price_sums='0';
                foreach ($Pastusers as $Pastres) {
                $total_price_sums = $total_price_sums + $Pastres->price_status;
                }
                $PastwekendIncome=$total_price_sums;


   
                $userss = Chatrequest::where('doctor_id',$request->userid)->get();
                $total_price_sums='0';
                foreach ($userss as $rest) {
                $total_price_sums = $total_price_sums + $rest->price_status;
                }
                $wekendIncomes=$total_price_sums;



                //Consultation
                $WekanConsultation = Chatrequest::where('doctor_id',$request->userid)->where('is_accept','3')->count();

                $WekanConsultations = Chatrequest::where('doctor_id',$request->userid)->where('date','>=',$fromweek)->where('date','<=',$date)->where('is_accept','3')->count();

                 $WekanConsultationsWithArray = Chatrequest::where('doctor_id',$request->userid)->where('date','>=',$fromweek)->where('date','<=',$date)->where('is_accept','3')->where('price_status','!=',0)->get();
                $FreeWekanConsultationsWithArray = Chatrequest::where('doctor_id',$request->userid)->where('date','>=',$fromweek)->where('date','<=',$date)->where('is_accept','3')->where('price_status',0)->get();
                //Trusted Patient

                $trusted_patient=Trusted::where('doctor_id',$request->userid)->where('status',1)->count();

                $trusted_patients=Trusted::where('doctor_id',$request->userid)->where('date','>=',$fromweek)->where('date','<=',$date)->where('status',1)->count();

                $trusted_week=Trusted::where('doctor_id',$request->userid)->where('date','>=',$fromweek)->where('date','<=',$date)->where('status',1)->count();


                 $trusted_weeks=Trusted::where('doctor_id',$request->userid)->where('status',1)->count();

                //Rating

         $five = Rating::where(['rating'=>'5','doctor_id'=>$request->userid])->where('date','>=',$fromweek)->where('date','<=',$date)->where('date','>=',$fromweek)->where('date','<=',$date)->count();
         $four = Rating::where(['rating'=>'4','doctor_id'=>$request->userid])->where('date','>=',$fromweek)->where('date','<=',$date)->count();
         $three= Rating::where(['rating'=>'3','doctor_id'=>$request->userid])->where('date','>=',$fromweek)->where('date','<=',$date)->count();
         $two  = Rating::where(['rating'=>'2','doctor_id'=>$request->userid])->where('date','>=',$fromweek)->where('date','<=',$date)->count();
         $one  = Rating::where(['rating'=>'1','doctor_id'=>$request->userid])->where('date','>=',$fromweek)->where('date','<=',$date)->count();
         $totalcount=($five*5 + $four*4 + $three*3 + $two*2 + $one*1) / ($five + $four + $three + $two + $one);
                


         $fives = Rating::where(['rating'=>'5','doctor_id'=>$request->userid])->count();
         $fours = Rating::where(['rating'=>'4','doctor_id'=>$request->userid])->count();
         $threes= Rating::where(['rating'=>'3','doctor_id'=>$request->userid])->count();
         $twos  = Rating::where(['rating'=>'2','doctor_id'=>$request->userid])->count();
         $ones  = Rating::where(['rating'=>'1','doctor_id'=>$request->userid])->count();
         $totalcounts=($fives*5 + $fours*4 + $threes*3 + $twos*2 + $ones*1) / ($fives + $fours + $threes + $twos + $ones);


                $TotalInfo=array('week_earning'          => $wekendIncome,
                                 'pastWeekendEarning'    => $PastwekendIncome,
                                 'total_earning'         => $wekendIncomes,
                                 'week_consultation'     => $WekanConsultations,
                                 'total_consultation'    => $WekanConsultation,
                                 'total_trusted_patient' => $trusted_patient,
                                 'week_trusted_patient'  => $trusted_patients,
                                 'trusted_week'          => $trusted_week,
                                 'total_trusted'         => $trusted_weeks,
                                 'total_rating'          => round($totalcounts,1),
                                 'total_rating_week'     => round($totalcount,1),
                                 'revanue'               => $WekanConsultationsWithArray,
                                 'free_consultation'     => $FreeWekanConsultationsWithArray,

                                 );

        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $TotalInfo);

      } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

    }

    public function deleteRequest(Request $request){

        try{
            $request->validate([
               'patient_id'         =>'required',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
         
        $data=Chatrequest::where('patient_id',$request->patient_id)->where('is_accept',0)->first();
        if(!empty($data->id)){
         $dataId=$data->id;
         $data=DB::table('chat_request')->where('id',$dataId)->delete();
        }else{
             $data='1';
        }
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $data);
       
       

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    } 
    }

    public function totalearning(Request $request){
      
    try{
            $request->validate([
               'user_id'         =>'required',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
         
          $data= Chatrequest::where('doctor_id',$request->user_id)->get();
          foreach ($data as $res) {
          }
          if(!empty($res->id)){
         $total_price_sum='0';
                foreach ($data as $res) {
                $total_price_sum = $total_price_sum + $res->price_status;
                }
                $wekendIncome=$total_price_sum;
                $result=array('total_earning'=>$wekendIncome);
         }else{
            $result=array('total_earning'=>'0');
         }
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $result);
       
       

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

    }
    public function getDoctorchat(Request $request){
        try{
            $request->validate([
               'sender_id'         =>'required',
               'receiver_id'         =>'required',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }


        try{
         
          $data=ChatMessage::where('sender_id',$request->sender_id)->where('receiver_id',$request->receiver_id)->get();
         
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $data);
       
       

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function getroot(Request $request){

        if($request->language == '1'){
          $data=Administrator::select('id','name','delete_status','created_at','updated_at')->where('delete_status',0)->get();
        }else{
          $data=Administrator::select('id','name_es','delete_status','created_at','updated_at')->where('delete_status',0)->get();
        }
        
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $data);

    }

    public function medicationReminder(Request $request){
     
     try{
            $request->validate([
               'id'         =>'required',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

    try{
         
         $data=Recommended::where('id',$request->id)->update([
                     'status'       => '1',
            ]);
         
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'REMINDER');

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function addCard(Request $request){

        try{
            $request->validate([
               'card_number'          =>'required',
               'name'                 =>'required',
               'year'                 =>'required',
               'month'                =>'required',
               'user_id'              => 'required',
               'type'                 => 'required',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

         try{

            $data=Card::where('user_id',$request->user_id)->first();
          if(!empty($data->id)){
       $info= DB::table('carddetails')->insert([
                'name'               =>  $request->name??null,
                'card_number'        =>  $request->card_number??null,
                'year'               =>  $request->year??null,
                'month'              =>  $request->month??null,
                'user_id'            =>  $request->user_id??null,
                'type'               =>  $request->type??null,
                'created_at'         =>  new \DateTime,
                'updated_at'         =>  new \DateTime,
             
            ]);
        }else{

        $info= DB::table('carddetails')->insert([
                'name'               =>  $request->name??null,
                'card_number'        =>  $request->card_number??null,
                'year'               =>  $request->year??null,
                'month'              =>  $request->month??null,
                'user_id'            =>  $request->user_id??null,
                'type'               =>  $request->type??null,
                'active_card'        => '1',
                'created_at'         =>  new \DateTime,
                'updated_at'         =>  new \DateTime,
             
            ]);
        }
         
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'CARDADDED');

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

    }

    public function getCard(Request $request){
        try{
            $request->validate([
              
               'user_id'              => 'required',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

   try{ 
         
      $data= Card::where('user_id',$request->user_id)->get();
      return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $data);

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

    }

    public function active_card(Request $request){

        try{
            $request->validate([

               'user_id'              => 'required',
               'card_id'              => 'required',

            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

     try{ 
         
            $result=Card::where('user_id',$request->user_id)->get();
           foreach ($result as $res) {

               Card::where('id',$res->id)->update([
                           'active_card'       => '0',
               ]);
           }
               Card::where('id',$request->card_id)->update([
                           'active_card'       => '1',
               ]);

            
      return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'ACTIVECARD');

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }


    }


    public function updateSuperKids(Request $request){

        try{
        $request->validate([
            
            'user_id' => "required",
            'supervison_yes'=>'required',
            ]);
        
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        } 

        try{ 
         
         $data=Userinfo::where('user_id',$request->user_id)->first();
         $id=$data->id;

          if(!empty($request->supervison_yes)){
                   $supervison_yes=implode(',', $request->supervison_yes);
                }else{
                   $supervison_yes='';
                }

             Userinfo::where('id',$id)->update([
                           'supervison_yes'  => $supervison_yes,
               ]);

                $user=User::where('id',$request->user_id)->first();

                $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                $updatedUser=$this->userObj->user_resource($user);

       
      return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $updatedUser);

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

    }

    public function getpresentation(Request $request){

        if($request->language =='1'){
       $data=Presentation::select('id','name','created_at','updated_at')->get();
       }else{
       $data=Presentation::select('id','name_es','created_at','updated_at')->get();
       }
     return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $data);
    }

    public function sameTime(Request $request){

        try{
        $request->validate([
            
            'user_id' => "required",
            'doctor_id'=>'required',
            ]);
        
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        } 
        try{ 
         
         $data=User::where('id',$request->user_id)->first();
         $socket_id=$data->socket_id;
         $redis = Redis::connection();
         $test=$redis->publish('channel6_'.$socket_id,'sameTimesssss');
       
      return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS');

    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }


    }

   







    
}
