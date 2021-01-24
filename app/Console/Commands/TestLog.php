<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Recommended;
use DateTime;
use App\Helper;
use App\User;

class TestLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:testlog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store dummy log based for testing cron';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         //\Log::error('dummy text for cron testing'.date("Y-m-d",time()));
       $data=Recommended::where('status',1)->with('notificationMedication')->get();
      
       $finalArray=$data->toArray();
       foreach ($finalArray as $res) {
        $date=$res['date'];
        $no_day=$res['no_day'];
        $today=date("Y-m-d");
        $to = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
        $diff_in_days = $to->diffInDays($from,false);
        $medicationArray=$res['notification_medication'];
        // \Log::error('dfsfdffgdfg');

        

        if($diff_in_days <= $no_day){

           $patient_id=$res['patient_id'];

        foreach ($medicationArray as $newtest) {
          
           if($newtest['day'] == 'Morning' OR $newtest['day'] =='Mañana'){
            $datas=User::where('id',$patient_id)->first();
             //\Log::error($datas);
            $token=$datas->device_token;
            date_default_timezone_set($datas->time_zone);
            $times = date( 'h:i A', time () );
           if($newtest['time'] == $times){

            \Log::error('Morning');
               $rest=Helper::SendPushNotificationsPatient($token,$newtest['day'].' Medicine Reminder','Please take your medicine.');
           }
          }


           if($newtest['day'] == 'Noon' OR $newtest['day'] =='Mediodía'){
            $datas=User::where('id',$patient_id)->first();
             //\Log::error($datas);
            $token=$datas->device_token;
            date_default_timezone_set($datas->time_zone);
            $times = date( 'h:i A', time () );
           if($newtest['time'] == $times){
               \Log::error('Noon');
               $rest=Helper::SendPushNotificationsPatient($token,$newtest['day'].' Medicine Reminder','Please take your medicine.');

           }
          }


           if($newtest['day'] == 'Evening' OR $newtest['day'] =='Noche'){
            $datas=User::where('id',$patient_id)->first();
             //\Log::error($datas);
            $token=$datas->device_token;
            date_default_timezone_set($datas->time_zone);
            $times = date( 'h:i A', time () );
           if($newtest['time'] == $times){
                \Log::error('Evening');
               $rest=Helper::SendPushNotificationsPatient($token,$newtest['day'].' Medicine Reminder','Please take your medicine.');
           }
          }
        

        }
      }
       

      }



      
      
      
    }
}
