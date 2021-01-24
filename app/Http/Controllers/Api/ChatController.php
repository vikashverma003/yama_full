<?php

namespace App\Http\Controllers\Api;


use App\Models\Chatrequest;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modals\Notification;
use App\Models\Trusted;
use App\User;
use Validator;
use Session;
use App\Helper;
use DB;
use URL;
use Auth;
use App\Traits\GeneralTrait;
use Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

/**
 * Class ChatController
 *
 * @package App\Http\Controllers\Api
 */
class ChatController extends Controller {

    use GeneralTrait;
    use \App\Traits\APIResponseManager;
    use \App\Traits\CommonUtil;

    protected $chatObj;
   

    public function __construct(ChatMessage $chat)
    {
        $this->chatObj=$chat;
        
    }

    public function sendMessage(Request $request){
        try{


           $createdUser= DB::table('chat_message')->insertGetId(
                    ['sender_id' => $request->user_id, 'receiver_id' =>$request->other_user_id,'message'=>$request->message,'request_id'=>$request->id,'image'=>$request->image,'message_type'=>$request->message_type,'created_at'=>new \DateTime,'updated_at'=>new \DateTime]);
          

              $result=ChatMessage::where('id',$createdUser)->first(); 
              // print_r($request);
              // die();
            
       $data=User::where(['id'=>$request->other_user_id])->first();
       $token=$data->device_token;
       if($data->role =='patient'){
        
       Helper::SendPushNotificationsPatient($token,'Vinku Message',$request->message);
       //\Log::error($ren); 
        return response()->json(array('success'=>'1','message'=> 'Message Sent','response'=>$result),200);
       }else{
        
        Helper::SendPushNotificationsDoctors($token,'Vinku Message',$request->message); 
        return response()->json(array('success'=>'1','message'=> 'Message Sent','response'=>$result),200);
       }
     
        }
        catch(Exception $e){
            return $this->sendResponse(500);
        }
    }

    public function endChat(Request $request){
        //die($request->request_id);

         try{

             $result=Chatrequest::where('id',$request->request_id)->update([
                        'is_accept'       => '3',
                        'updated_at'      => new \DateTime
            ]);
     return response()->json(array('success'=>'1','message'=> 'Chat has been ended','response'=>$request->request_id),200);

        }
        catch(Exception $e){
            return $this->sendResponse(500);
        }
    }




    public function allMessages(Request $request){
        try{
        // return all the messages in a conversation //
        // ? paging
        // use sent as if same user can link by multiple profile //
        // update the max_read_count for the user //

        $validator = Validator::make($request->all(),array('assignment_id' => 'required|numeric'));
        if($validator->fails())
            $this->sendResponse(400, "Validation Errors",$validator->errors());
//            return response()->json(array('success'=>'0','message'=>$validator->errors()->first()),400);

        $assignment_id = $request->input('assignment_id');
        // $other_user_id = $request->input('other_user_id');
        // $page            = $request->input('page',null);
        // $last_message_id = $request->input('last_message_id',null);
        $getMessages=ChatMessage::where('assignment_id',$assignment_id)->with(['sender','receiver'])->orderBy('chat_message_id','DESC')->get();
        // $res = DB::table("conversation_users")
        //         ->select("conversation_id", DB::raw("count(id) as mark"))
        //         ->where("user_id", $user_id)
        //         ->orwhere("user_id", $other_user_id)
        //         ->groupBy("conversation_id")
        //         ->havingRaw("mark >= 2")
        //         ->get();
        //         // dd($res);
        // if(count($res) > 0)
        //     $conversation_id = $res[0]->conversation_id;//$request->input('conversation_id');
        // else
        //     return $this->sendResponse(200, null, []);
        // // get the conversation user id //
        // $conv_user = ConversationUser::where('conversation_id',$conversation_id)->where('user_id',$user_id)->select('id')->first();
        //
        // // check if max_delete message id //
        // $max_delete = ConversationUserDelete::where('conversation_id',$conversation_id)->where('conversation_user_id',$conv_user->id)->select('conversation_message_id')->first();
        //
        // if($max_delete){
        //     if($max_delete->conversation_message_id > $last_message_id){
        //         $last_message_id = $max_delete->conversation_message_id;
        //     }
        // }
        //
        // if($last_message_id){
        //     // return all the messages after the given id //
        //     $data = ConversationMessage::with([
        //         'sender.user'
        //         ])->where('conversation_id',$conversation_id)
        //         ->where('id','>',$last_message_id)
        //         ->get();
        // }else{
        //     // return all the messages [user don't have any saved messages]
        //     $data = ConversationMessage::with([
        //         'sender.user'
        //         ])->where('conversation_id',$conversation_id)
        //         ->get();
        //
        // }
        //
        // // get and update the max_read_id //
        // $max_message_id = ConversationMessage::where('conversation_id',$conversation_id)->max('id');
        // Conversation::updateMaxReadId($conv_user->id,$max_message_id);
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_CHAT_MESSAGE', 'response',  @$getMessages);
//        return response()->json(array('success'=>'1','message'=> "Retrieval Successful",'data'=>$data),200);
        }
        catch (\Exception $e)
        {
            return $e->getMessage();//$this->sendResponse(500);
//            return response()->json(array('success'=>'0','message'=> "Some error occurred.",'data'=>[]),500);
        }
    }


    public function allConversations(Request $request){

        // $validator = Validator::make($request->all(),array('assignment_id' => 'required|numeric'));
        // if($validator->fails())
        //     return $this->sendResponse(400, "Validation Errors", $validator->errors());
            $user_id = Auth::user()->id;
        // $conversation=ChatMessage::where('assignment_id',$request->assignment_id)->orderBy('created_at','DESC')->get();
        $getAssignments=ConversationUser::where('user_id',$user_id)->get();
        foreach($getAssignments as $getAssignment){
          $assignment_id[]=$getAssignment->assignment_id;
        }
        if(@$assignment_id){
        $getUsers=ConversationUser::whereIn('assignment_id',@$assignment_id)->where('user_id','<>',@$user_id)->with(['user','chat_message','assignment'])->get();
        }
        // get the conversations
       // DB::enableQueryLog();
       // 'user.devices'=>function($q){
       //         $q->whereNotNull('device_token')->where('device_token','<>','');
       //     }])

            $con_list = DB::table("conversations as c")
                    ->select("c.id")
                    ->join("conversation_users as cu", "cu.conversation_id", "=", "c.id")
                    ->where("cu.user_id", $user_id)
                    ->get();
            $con_list = json_decode(json_encode($con_list), true);
//        Select * from conversations as c inner join conversation_users cu on cu.conversation_id = c.id where cu.user_id = 5
        $conversation = Conversation::whereIn("id", $con_list)->with("last_message","receiver")
                ->get()->toArray();
//        print_r($conversation);



        foreach($conversation as $key1 => $con)
        {
            $all_msg =  DB::table("conversations as c")
                ->selectRaw('count(cm.id) as unread')
                ->join("conversation_messages as cm", "cm.conversation_id", "c.id")
                ->join("conversation_users as cu", "cu.id", "cm.conversation_user_id")
                ->where("cu.user_id","!=", $user_id)
                ->where("cm.conversation_id",$con['id'])
                ->where("cm.is_read", "0")
                ->get();

            $conversation[$key1]["count"] = $all_msg;
            foreach($con['receiver'] as $key2 => $val)
            {
                if($val['user_id'] != $user_id)
                    $conversation[$key1]['receiver'] = $val;
            }

        }

        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_CHAT_LISTED', 'response',  @$getUsers);
        // return $this->sendResponse(200, null, @$getUsers);

    }


    public function ConversationId(Request $request) {
        try {
            $validator = Validator::make(
                            $request->all(), [
                        // 'chat_type' => 'required|in:INDIVIDUAL,CAMPAIGN,RESEARCH',
                        // 'chat_id' => 'required_unless:chat_type,INDIVIDUAL|numeric',
                        'other_user_id' => 'required_if:chat_type,==,INDIVIDUAL|numeric|exists:users,id'
                            ], [
                        // 'chat_id.required_if' => 'Chat Id is required',
                        'other_user_id.required_if' => 'Receiver Id is required'
                            ]
            );
            if ($validator->fails())
                return response()->json(['error' => $validator->errors()], $this->errorValidation);

            $user_id = Auth::user()->id;
            // $chat_type = $request->input('chat_type');
            // if ($chat_type == "INDIVIDUAL")
                $other_user_id = $request->input('other_user_id');
            // else {
            //     $con_id = $request->input('chat_id');
            //     $convers_id = Conversation::where(["code" => $con_id, "type" => $chat_type, "is_active" => true])->first();
            // }


            if (isset($other_user_id)) {
                $res = ConversationUser::select("conversation_id")->where("user_id", $user_id)->whereIn("conversation_id", function($q) use($other_user_id) {
                            $q->select(DB::raw("conversation_id from conversation_users WHERE user_id=" . $other_user_id . ""));
                        })->get();

                if (count($res) > 0)
                    $conversation_id = $res[0]->conversation_id; //$request->input('conversation_id');
                else
                    return response()->json(['success' => []]);
            }
            else {
                if (!empty($convers_id))
                    $conversation_id = $convers_id->id;
            }
            return response()->json(['success' => ["conversation_id" => $conversation_id]]);
        } catch (Exception $ex) {
            return response()->json(['error' => "Something went wrong. Try again"], $this->errorStatus);
        }
    }




    public function initChat(Request $request) {
        try{
            $validator = Validator::make($request->all(),array('id_din' => 'required|numeric|exists:user_info,id_din'));
            if($validator->fails())
                return $this->sendResponse (400, "Validation Errors", $validator->errors());
            $check = UserInfo::where("id_din", $request->id_din);
            if($check->exists())
            {
                $res = $check->first();
                return $this->sendResponse(200, "true", ["user_id"=>$res->id]);
            }
            else
            {
                return $this->sendResponse(200, "false");
            }
        } catch (Exception $ex) {
            return $this->sendResponse (500);
        }
    }

    public function chatList(Request $request){
         try{
        $request->validate([
            //'request_id'  =>'required',
            //'sender_id'   =>'required',
            //'receiver_id' =>'required',

            ]);
        
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
            if(!empty($request->request_id)){
            $user = ChatMessage::where('request_id',$request->request_id)->get();
            }else{
           
          
            $data = ChatMessage::where('sender_id',$request->sender_id)->where('receiver_id',$request->receiver_id)->distinct('request_id')->get('request_id');

              $user=array();
              $request_id=array();
            foreach ($data as $res) {
                $request_id[]= $res->request_id;
            }
           $user = ChatMessage::whereIn('request_id',$request_id)->get();
            }
                
            //$test=$user;->whereIn('id', [1, 2, 3])
            //$test=array_values((array)$test);

        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_LOGIN_SUCCESS', 'response', $user);
    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }


    // public function endChat(Request $request){
    //      try{
    //     $request->validate([
    //         'request_id'  =>'required',
    //         ]);
    //      } catch (\Illuminate\Validation\ValidationException $e) {
    //         $errorResponse = $this->ValidationResponseFormating($e);
    //         return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
    //         'BAD_REQUEST', 'error_details', $errorResponse);
    //     }
    //     try{
    //         $result=Chatrequest::where('id',$request->request_id)->update([
    //                     'is_accept'       => '3',
    //                     'updated_at'     => new \DateTime
    //         ]);
    //     return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_CHATEND_SUCCESS', 'response', $request->request_id);
    // } catch (\PDOException $e) {
    //     $errorResponse = $e->getMessage();
    //     return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    // }
    // }



    public function chatHistorty(Request $request){

    try{
            $request->validate([
                'patient_id'             => 'required',
               // 'is_accept'              => 'required',
            ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
           }
    try{
              
             $data=Chatrequest::where('patient_id',$request->patient_id)->where('is_accept', '!=' ,1)->where('is_accept', '!=' ,0)->orderBy('id', 'DESC')->get();
             $result=array();
           foreach ($data as $resrr) {

           }
           if(!empty($resrr->id)){
             foreach ($data as $resrr) {
                

                  $result=User::where(['id'=>$resrr->doctor_id])->first();
                 //echo $resrr->id;
                
                   //$reults=array();
                  // foreach ($result as $res) {
                     
                    if(!empty($result->profile_image)){
                     $url= URL::to('/');
                     $image=$url.'/'.$result->profile_image;
                     }else{
                        $image='';
                     }

                  //     $newid=$res->id;
                  //    $newData=Chatrequest::where('doctor_id',$newid)->first();
                  //    $newdate=$newData->created_at;
                     $trustedData=Trusted::where('patient_id',$request->patient_id)->where('doctor_id',$result->id)->first();

                     if(!empty($trustedData)){
                        $trustDoctor='1';
                     }else{
                        $trustDoctor='0';
                     }


                    $reults[]=array( 'id'=>$result->id, 
                                     'name'=>$result->name,
                                     'email'=>$result->email,
                                     'role'=>$result->role,
                                     'profile_image'=>$image,
                                     'disease'=>$result->disease,
                                     'account_status'=>$result->account_status,
                                     'email_verified_at'=>$result->email_verified_at,
                                     'phone_code'=>$result->phone_code,
                                     'phone_number'=>$result->phone_number,
                                     'random'=>$result->random,
                                     'device_token'=>$result->device_token,
                                     'is_complete'=>$result->is_complete,
                                     'paid_consultation'=>$result->paid_consultation,
                                     'free_consultation'=>$result->free_consultation,
                                     'rating'=>$result->rating,
                                     'fees'=>$result->fees,
                                     'block_status'=>$result->block_status,
                                     'is_login'=>$result->is_login,
                                     'skip'=>$result->skip,
                                     'created_at'=>$result->created_at,
                                     'updated_at'=>$result->updated_at,
                                     'request_id' =>$resrr->id,
                                     'chat_start_date'=>$resrr->created_at,
                                     'trusted_status'=>$trustDoctor,
                                     'is_accept'   =>$resrr->is_accept,
                                    
                                    );
                 // }

             }
         }else{
            $reults=User::where('id',0)->get();
         }

             return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $reults);
    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

   
}
