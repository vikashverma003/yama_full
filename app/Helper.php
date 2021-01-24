<?php

namespace App;
use URL;

class Helper
{
    public static function userimg($data)
    {
        if($data){
            return  $data;
        }else{
          return  URL::to("/").'/images/users/no_img.png';
        }
      
    }

    public static function productImage($data)
    {
        if($data){
            return  $data;
        }else{
          return  URL::to("/").'/images/review-banner.png';
        }
      
    }

    public static function encodeNum($num)
    {
       return base64_encode($num);
    }

    public static function decodeNum($num) 
    {
       return base64_decode($num); 
    } 


    public static function SendPushNotificationsDoctor($token,$title,$body,$sound=null){

       if(!empty($sound)){
        $res=$sound;
       }else{
        $res='true';
       }

        $ch = curl_init("https://fcm.googleapis.com/fcm/send"); 
          $notification = array('title' =>$title , 'body' => $body, 'vibrate'=> true, 'sound'=> $sound, 'content-available' => true, 'priority' => 'high','android_channel_id'=>'custom_fcm_FirebaseNotifiction_default_channel'); 
          $data = array('title' => 'custom', 'body' => $body,'sound'=> $sound);
          $arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $data);
          
          $json = json_encode($arrayToSend); 
           $headers = array();
           $headers[] = 'Content-Type: application/json';
           $headers[] = 'Authorization: key=AAAANSXMhwg:APA91bF-qQcDOBMqFE5N3lnx2l_3vql-YTsG1L7YTOq93VZwFnKegELtear7v-RvZz0Kgt09PxZwce8CsIFGRpasidfoQ_2X3K96QVx6wZvJ9UxeEoVxa1HwSKinFeDm7Tv0fCPKbz-A';
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
           curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
           curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
           
           curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, true);  
           curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_POST, 1);
           $response = curl_exec($ch);
           curl_close($ch);
          // \Log::error($response);
          return $response ;     
      }  
     

     public static function SendPushNotificationsDoctors($token,$title,$body,$sound=null){
      
       
        $ch = curl_init("https://fcm.googleapis.com/fcm/send"); 
          $notification = array('title' =>$title , 'body' => $body, 'vibrate'=> true, 'sound'=> $sound, 'content-available' => true, 'priority' => 'high'); 
          $data = array('title' => $title, 'body' => $body);
          $arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $data);
          
          $json = json_encode($arrayToSend); 
           $headers = array();
           $headers[] = 'Content-Type: application/json';
           $headers[] = 'Authorization: key=AAAANSXMhwg:APA91bF-qQcDOBMqFE5N3lnx2l_3vql-YTsG1L7YTOq93VZwFnKegELtear7v-RvZz0Kgt09PxZwce8CsIFGRpasidfoQ_2X3K96QVx6wZvJ9UxeEoVxa1HwSKinFeDm7Tv0fCPKbz-A';
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

      public static function SendPushNotificationsPatients($token,$title,$body,$sound=null){

      

        $ch = curl_init("https://fcm.googleapis.com/fcm/send"); 
          $notification = array('title' =>$title , 'body' => $body, 'vibrate'=> true, 'sound'=> $sound, 'content-available' => true, 'priority' => 'high'); 
          $data = array('title' => $title, 'body' => $body);
          $arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $data);
          
          $json = json_encode($arrayToSend); 
           $headers = array();
           $headers[] = 'Content-Type: application/json';
           $headers[] = 'Authorization: key=AAAANSXMhwg:APA91bF-qQcDOBMqFE5N3lnx2l_3vql-YTsG1L7YTOq93VZwFnKegELtear7v-RvZz0Kgt09PxZwce8CsIFGRpasidfoQ_2X3K96QVx6wZvJ9UxeEoVxa1HwSKinFeDm7Tv0fCPKbz-A';
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





      public static function SendPushNotificationsPatient($token,$title,$body,$sound=true){
        $ch = curl_init("https://fcm.googleapis.com/fcm/send"); 
          $notification = array('title' =>$title , 'body' => $body, 'vibrate'=> true, 'sound'=> $sound, 'content-available' => true, 'priority' => 'high'); 
          $data = array('title' => $title, 'body' => $body);
          $arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $data);
          
          $json = json_encode($arrayToSend); 
           $headers = array();
           $headers[] = 'Content-Type: application/json';
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



}
