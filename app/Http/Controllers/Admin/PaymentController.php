<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Services;
use App\Models\Administrator;
use App\Models\Permotions;
use App\Models\Percentage;
use App\Models\Transaction;
use App\User;
use URL;
//use Conekta\Conekta;
use DB;
class PaymentController extends Controller
{
    protected $serviceObj;
    protected $permotionsObj;
    
    public function __construct(Services $service, Permotions $permotions)
    {
         $this->serviceObj     =$service;
         $this->permotionsObj  =$permotions;
        
    }

    public function viewPayment(){

     $user=Auth::user();
     $transactionData = Transaction::with('patient')->with('doctor')->get();
    
     return view('admin.admin.viewPayment', ['title' => 'Users','user'=>$user,'data'=>$transactionData]);

    }

    public function viewTransaction(Request $request,$id){
        
        $user=Auth::user();
        $data = Transaction::where('id',$id)->with('patient')->with('doctor')->first();
        return view('admin.admin.singleTransactionHistory', ['title' => 'Users','user'=>$user,'data'=>$data]);
    }

    public function changeStatus(Request $request,$id){
     
       $updatd=Transaction::where('id',$id)->update([
                    'admin_status'   => '1',
                    'updated_at'      => new \DateTime
            ]);
    return redirect('admin/viewPayment')->with('status','Payment has been paid Successfully.');
    }
    

   
}
