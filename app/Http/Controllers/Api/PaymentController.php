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
use App\Models\Chatrequest;
use App\Models\Transaction;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;
use URL;
use DateTime;
use Mail;
use App\Repositories\Interfaces\LocationRepositoryInterface;

class PaymentController extends Controller
{
    use \App\Traits\APIResponseManager;
    use \App\Traits\CommonUtil;

    protected $trsObj;
    
   

    public function __construct(Transaction $trs)
    {
        $this->trsObj=$trs;
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

   
   public function createPayment(Request $request){

    try{
            $request->validate([
               'token'      =>'required',
               'doctor_id'  =>'required',
               'patient_id' =>'required',
               'price'      =>'required',
               //'request_id' =>'required',
            ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
          }

          try{

             include(base_path() . '/vendor/lib/Conekta.php');
                \Conekta\Conekta::setApiKey("key_SSzVN4i7mfmVkYKa5Fo7SA");
                \Conekta\Conekta::setApiVersion("2.0.0");
                $token_id=$request->token;

                $patientinfo=User::where('id',$request->patient_id)->with('userinfo')->first();

                $customer = \Conekta\Customer::create(
                array(
                "name" =>  "Test Demo",
                "email" => $patientinfo->email,
                "phone" => "+52181818181",
                "payment_sources" => array(
                array(
                "type" => "card",
                "token_id" => $token_id
                )
                )//payment_sources
                )//customer
                );
                $price=$request->price;
                $amount=$price*100;
             $order = \Conekta\Order::create(
                array(
                  "line_items" => array(
                    array(
                      "name" => "Tacos",
                      "unit_price" => 0,
                      "quantity" => 1
                    )//first line_item
                  ), //line_items
                  "shipping_lines" => array(
                    array(
                      "amount"  => $amount,
                      "carrier" => "FEDEX"
                    )
                  ), //shipping_lines - physical goods only
                  "currency" => "MXN",
                  "customer_info" => array(
                    "customer_id" => $customer->id
                  ), //customer_info
                  "shipping_contact" => array(
                    "address" => array(
                      "street1" => 'new address',
                      "postal_code" => '06100',
                      "country" => "MX"
                    )//address
                  ), //shipping_contact - required only for physical goods
                 // "metadata" => array("reference" => "12987324097", "more_info" => "lalalalala"),
                  "charges" => array(
                      array(
                          "payment_method" => array(
                                  "type"   => "default"
                          ) //payment_method - use customer's default - a card
                            //to charge a card, different from the default,
                            //you can indicate the card's source_id as shown in the Retry Card Section
                      ) //first charge
                  ) //charges
                )//order
              );


                } catch (\Conekta\ProccessingError $error){
                echo $error->getMesage();
                } catch (\Conekta\ParameterValidationError $error){
                echo $error->getMessage();
                } catch (\Conekta\Handler $error){
                echo $error->getMessage();
        }

            
       $status=array('id'         => $order->id,
                     'status'     => $order->payment_status,
                     'amount'     => $order->amount/100,
                     'currency'   => $order->currency,
                     'code'       => $order->charges[0]->payment_method->auth_code,
                     'patient_id' => $request->patient_id,
                     'doctor_id'  => $request->doctor_id,
                    );
        DB::beginTransaction();
            $createdTrs=$this->trsObj->createdTrs([
                'transaction_id'  =>  $order->id,
                'status'          =>  $order->payment_status??null,
                'amount'          =>  $order->amount/100??null,
                'currency'        =>  $order->currency,
                'code'            =>  $order->charges[0]->payment_method->auth_code,
                'patient_id'      =>  $request->patient_id,
                'doctor_id'       =>  $request->doctor_id,
                'request_id'      =>  $request->request_id,
            ]);
        DB::commit(); 

         // Chatrequest::where('id',$request->request_id)->update([
         //                    'price_status'         => $order->amount/100??null,
         //                    'updated_at'           => new \DateTime
         //     ]);



    return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $createdTrs);
   }

   public function patientPaymentHistory(Request $request){

       try{
            $request->validate([
               'patient_id'      =>'required',
            ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
          }

    try{
          
          $data=Transaction::where('patient_id',$request->patient_id)->orderBy('id', 'DESC')->get();
          foreach ($data as $res) {
            $url= URL::to('/');
            $info=User::where('id',$res->doctor_id)->first();
             $info['profile_image']=$url.'/'.$info->profile_image;

           $result[]=array('transaction_id'=>$res->transaction_id,
                           'status'        =>$res->status,
                           'amount'        =>$res->amount,
                           'currency'      =>$res->currency,
                           'code'          =>$res->code,
                           'patient_id'    =>$res->patient_id,
                           'doctor_id'     =>$info,
                           'request_id'    =>$res->request_id,
                           'created_at'    =>$res->created_at,
                        );
          }
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response', $result);
    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }     

    }
    
}
