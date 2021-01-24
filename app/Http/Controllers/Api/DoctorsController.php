<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use App\Models\Userinfo;
use App\Models\Userimage;
use App\Models\Billing;
use App\Models\Advice;
use App\Models\Recommended;
use App\Models\Trusted;
use App\Models\NotificationMedication;
use App\Models\Chatrequest;
use App\Models\Disease;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;
use URL;
use DateTime;
use Mail;
use App\Repositories\Interfaces\LocationRepositoryInterface;

class DoctorsController extends Controller
{
    use \App\Traits\APIResponseManager;
    use \App\Traits\CommonUtil;

    protected $docObj;
    
   

    public function __construct(Recommended $doc)
    {
        $this->docObj=$doc;
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

   

    public function medicineRecomend(Request $request){
         try{
            $request->validate([
                'patient_id'             => 'required',
                'doctor_id'              => 'required',
                'request_id'             => 'required',
                'name'                   => 'required',
                'dosage'                 => 'required',
                'no_day'                 => 'required',
                //'frequency'              => 'required',
                //'instruction'            => 'required',
                //'route_administrations'  => 'required',
            ]);

             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }

           try{
            DB::beginTransaction();
            $createdUser=$this->docObj->createRecomend([
                'patient_id'             =>  $request->patient_id??null,
                'doctor_id'              =>  $request->doctor_id??null,
                'request_id'             =>  $request->request_id??null,
                'name'                   =>  $request->name??null,
                'dosage'                 =>  $request->dosage??null,
                'no_day'                 =>  $request->no_day??null,
                'presentation'           =>  $request->presentation??null,
                'frequency'              =>  $request->frequency??null,
                'instruction'            =>  $request->instruction??null,
                'route_administrations'  =>  $request->route_administrations??null,
                'date'                   =>  date('Y-m-d'),
            ]);
             DB::commit();
             
              if(!empty($request->frequency)){

             foreach ($request->frequency as $rester) {
              
            $info= DB::table('notification_medication')->insert([
                'medication_id'         =>  $createdUser->id,
                'day'                   =>  $rester??null,
                //'time'                  =>  $born??null,
                'created_at'            =>  new \DateTime,
                'updated_at'            =>  new \DateTime,
             
            ]);
          }
             }

             if($createdUser){
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
                          'route_administrations'=>$res->route_administrations,
                          'presentation' => $res->presentation,
                          'created_at'=>$res->created_at,
                          'updated_at'=>$res->updated_at
                      );
            # code...
        }

              return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_RECOMND_SUCCESS', 'response',  $rest);
             }

        
    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function editEedicineRecomend(Request $request){
        try{
            $request->validate([
                'patient_id'             => 'required',
                'id'                     => 'required',
                'doctor_id'              => 'required',
                'request_id'             => 'required',
                'name'                   => 'required',
                'dosage'                 => 'required',
                'no_day'                 => 'required',
                //'frequency'              => 'required',
                //'instruction'            => 'required',
                //'route_administrations'  => 'required',
            ]);

             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }

           try{

           $frequency= implode(',',$request->frequency);
            

            $data= Recommended::where('id',$request->id)->update([
                        'patient_id'             => $request->patient_id,
                        'doctor_id'              => $request->doctor_id,
                        'request_id'             => $request->request_id,
                        'name'                   => $request->name,
                        'dosage'                 => $request->dosage,
                        'no_day'                 => $request->no_day,
                        'frequency'              => $frequency,
                        'presentation'           => $request->presentation,
                        'instruction'            => $request->instruction,
                        'route_administrations'  => $request->route_administrations,   
            ]);
            
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'MEDICATIONS_RECOMND_SUCCESS');
   
        
    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

        }


    public function getMedicine(Request $request){

        try{
            $request->validate([
                'patient_id'             => 'required',
                'request_id'             => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }

           try{
             $row= Recommended::where(['patient_id'=>$request->patient_id,'request_id'=>$request->request_id])->with('notificationMedication')->get();
             $data=Advice::where(['patient_id'=>$request->patient_id,'request_id'=>$request->request_id])->first();
             $datanew['recomend']=$row;
              $datanew['adviceecomend']=(object)$data;
             if(!empty($row)){
              return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $datanew);
              }else{
                 return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'RECORD_NOT_FOUND');
              }
             
    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function trustedList(Request $request){

        try{
            $request->validate([
                'patient_id'             => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }

            try{
                
               $datas = Chatrequest::where('patient_id', $request->patient_id)->distinct()->pluck('doctor_id')->all();
              
               $record=Trusted::where('patient_id',$request->patient_id)->pluck('doctor_id')->all();

               $result=array_intersect($datas,$record);

               $resss=array_diff($datas,$record);
               
               foreach ($result as $match) {
                    
                   $matchdata=User::where(['id'=>$match])->with('medicalchat')->first();
                   if(!empty($matchdata->profile_image)){
                     $url= URL::to('/');
                     $image=$url.'/'.$matchdata->profile_image;
                     }else{
                     $image='';
                     }

                     $matchRecord[]=array('id'=>$matchdata->id, 
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
                                     'price' => $matchdata->price,
                                     'block_status'=>$matchdata->block_status,
                                     'is_login'=>$matchdata->is_login,
                                     'skip'=>$matchdata->skip,
                                     'short_description'=>$matchdata->medicalchat->short_description,
                                     'experience'=>$matchdata->medicalchat->experience,
                                     'degrees'=>$matchdata->medicalchat->degrees,
                                     'created_at'=>$matchdata->created_at,
                                     'updated_at'=>$matchdata->updated_at,
                                     'trusted'    =>'1',
                                    );

               }

               if(!empty($matchRecord)){
                $mat=$matchRecord;
               }else{
                $mat=[];
               }
             
               
               foreach ($resss as $diffrent) {
                    
                   $diffrentdata=User::where(['id'=>$diffrent])->with('medicalchat')->first();
                   if(!empty($diffrentdata->profile_image)){
                     $url= URL::to('/');
                     $image=$url.'/'.$diffrentdata->profile_image;
                     }else{
                     $image='';
                     }
                     $diffrentRecord[]=array('id'=>$diffrentdata->id, 
                                     'name'=>$diffrentdata->name,
                                     'email'=>$diffrentdata->email,
                                     'role'=>$diffrentdata->role,
                                     'profile_image'=>$image,
                                     'disease'=>$diffrentdata->disease,
                                     'account_status'=>$diffrentdata->account_status,
                                     'email_verified_at'=>$diffrentdata->email_verified_at,
                                     'phone_code'=>$diffrentdata->phone_code,
                                     'phone_number'=>$diffrentdata->phone_number,
                                     'random'=>$diffrentdata->random,
                                     'device_token'=>$diffrentdata->device_token,
                                     'is_complete'=>$diffrentdata->is_complete,
                                     'paid_consultation'=>$diffrentdata->paid_consultation,
                                     'free_consultation'=>$diffrentdata->free_consultation,
                                     'rating'=>$diffrentdata->rating,
                                     'fees'=>$diffrentdata->fees,
                                     'price' => $diffrentdata->price,
                                     'block_status'=>$diffrentdata->block_status,
                                     'is_login'=>$diffrentdata->is_login,
                                     'skip'=>$diffrentdata->skip,
                                     'short_description'=>$diffrentdata->medicalchat->short_description,
                                     'experience'=>$diffrentdata->medicalchat->experience,
                                     'degrees'=>$diffrentdata->medicalchat->degrees,
                                     'created_at'=>$diffrentdata->created_at,
                                     'updated_at'=>$diffrentdata->updated_at,
                                     'trusted'    =>'0',
                                    );

               }

               if(!empty($diffrentRecord)){
                   $diff=$diffrentRecord;
               }else{
                 $diff=[];
               }
              
            $rester=array_merge($mat,$diff);

             if(!empty($rester)){

    return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',$rester);
     }
             
    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function vinkuproList(Request $request){

       if($request->language=='1'){ 
       $disease=Disease::get();
       $url= URL::to('/');
       $data=array();
       foreach ($disease as $val) {
        $id=$val->id;
        $image=$url.'/admin/images/doctor/'.$val->image;
        $res=User::where(['disease'=>$id])->count();       
        $data[]=array('id'=>$id,'name'=>$val->name,'imgae'=>$image,'description'=>$val->description,'doctor_count'=>$res);
       }
   }else{
       $disease=Disease::get();
       $url= URL::to('/');
       $data=array();
       foreach ($disease as $val) {
        $id=$val->id;
        $image=$url.'/admin/images/doctor/'.$val->image;
        $res=User::where(['disease'=>$id])->count();       
        $data[]=array('id'=>$id,'name_es'=>$val->name,'imgae'=>$image,'description_es'=>$val->description,'doctor_count'=>$res);
       }
   }
      return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $data);
    }
    public function doctorList(Request $request){
       try{
            $request->validate([
                'doctor_id'             => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }

        try{
            
             $row=User::where(['disease'=>$request->doctor_id])->with('general')->with('billing')->with('deposit')->with('fiscal')->with('medicalpro')->with('medicalchat')->with('cfdi')->get();
             foreach ($row as $res) {
                     $url= URL::to('/');
                     $res['profile_image']=$url.'/'.$res->profile_image;
             }
             if(!empty($row)){

              return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $row);
            }else{
               return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_NOT_FOUND');
            }
             
    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }
    public function singleDoctorInfo(Request $request){
      try{
            $request->validate([
                'doctor_id'             => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }
            try{
            
             $row=User::where(['id'=>$request->doctor_id])->with('medicalchat')->first();
             if(!empty($row)){
              return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $row);
            }else{
               return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_NOT_FOUND');
            }
             
    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }
    public function recommendedMedications(Request $request){
      try{
            $request->validate([
                'patient_id'             => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }
           try{
            $data=DB::table('medication_recommended')->select('request_id','doctor_id')->distinct('request_id','doctor_id')->where('patient_id',$request->patient_id)->orderBy('request_id', 'DESC')->get();
            
             $rester=array();
             //$requestData=array();
             foreach ($data as $res) {
                $doctor=$res->doctor_id;
                $doctorData=User::where(['id'=>$doctor])->first();
                $count= Recommended::where('patient_id',$request->patient_id)->where('doctor_id',$doctor)->count();
                 $datemedc= Recommended::where('patient_id',$request->patient_id)->where('doctor_id',$doctor)->first();

                $url= URL::to('/');
                     $image=$url.'/'.$doctorData->profile_image;
                 $rester[]=array('profile_image'         =>$image,
                                 'name'                  =>$doctorData->name,
                                 'id'                    =>$res->request_id,
                                 'medication_recommended'=>$count,
                                 'created_at'            =>$datemedc->created_at,
                                 );
             }
            
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $rester);

    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }
    public function recommendedMedicationsInfo(Request $request){

        try{
            $request->validate([
                'id'             => 'required',
            ]);
             }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }
           try{
            
            $data=DB::table('medication_recommended')->where(['request_id'=>$request->id])->get();
            if(!empty($data)){
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $data);
             }else{
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'RECORD_NOT_FOUND');
             }

    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

    }

    public function getDoctorList(Request $request){

       $row=User::where(['role'=>'doctor','account_status'=>0,'approved_status'=>1])->with('diseases')->with('general')->with('billing')->with('deposit')->with('fiscal')->with('medicalpro')->with('medicalchat')->with('cfdi')->get();
       foreach ($row as $rest) {
        $url= URL::to('/');
        $rest['profile_image']=$url.'/'.$rest->profile_image;
       }
        

        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $row);

    }

    public function updateMedicationTime(Request $request){
      try{
            $request->validate([
              //  'id'             => 'required',
               // 'time'           => 'required',

            ]);
             }catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }


        try{

           //$data= json_decode($request->time_list);
           // \Log::error($request->time_list);

            foreach ($request->time_list as $res) {
            $data= NotificationMedication::where('id',$res['id'])->update([
                        'time'             => $res['time'],
                        'status'           => '1',
                        'updated_at'       =>   new \DateTime , 
            ]);
             }

             Recommended::where('id',$request->id)->update([
                        'status'           => '1',
                        'updated_at'       =>   new \DateTime , 
             ]);
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SETTIMER');
             

    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function getInfos(){
      $data=Recommended::where('status',1)->with('notificationMedication')->get();
      $test=$data->toArray();

      foreach ($test as $res) {
        $tes=$res['notification_medication'];
       

      }
       print_r($test);
      //print_r($data->toArray());
      //return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $test);
    }
           
    




    
}
