<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Language;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Disease;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use DB;
class DashboardController extends Controller
{
    public function index(){
         $user           = Auth::user();
         $collaborators  = User::where('role',2)->count();
         $adminsitators  = User::where('role',3)->count();
         $owner          = User::where('role',4)->count();
         $building       = Building::count();
         $floor          = Floor::count();
        // $docCount    = User::where(['role'=>'doctor'])->count();
        // $DiseaseCount= Disease::get()->count();
        // $Transaction = Transaction::get()->count();
        // $earn        = Transaction::get();
        // $n=0;
        // foreach ($earn as $res) {
        // 	$n+=$res->amount;
        // }
       
        return view('admin.dashboard', ['title' => 'Dashboard','user'=>$user,'collaborators'=>$collaborators,'adminsitators'=>$adminsitators,'owner'=>$owner,'building'=>$building,'floor'=>$floor]);
    }
}
