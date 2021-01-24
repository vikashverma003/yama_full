<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Group;
use App\Models\Chatrequest;
use App\Models\FoodMenu;
use App\User;
use URL;
use Hash;
use Mail;
//use Conekta\Conekta;
use DB;
class InventoryController extends Controller
{
    protected $InventoryObj; 
    public function __construct(FoodMenu $Inventory)
    {
         $this->InventoryObj   =$Inventory;
        
    }
    

    public function inventory(Request $request){

        $user=Auth::user();
        $group=FoodMenu::get();
       
        //$allUser = User::where('role',config('constants.role.USER'))->where('account_status','0')->get();
        return view('admin.admin.viewinventory', ['title' => 'Users','user'=>$user, 'group'=>$group]);  

    }



    public function addInventory(){
         $user=Auth::user();
         $group=Group::get();
         $groupitem=FoodMenu::get();
        return view('admin.admin.addinventory', ['title' => 'Users','user'=>$user,'group'=>$group,'groupitem'=>$groupitem]);  

    }

    public function createInventory(Request $request){

        if(!empty($request->id)){

             FoodMenu::where('id',$request->id)->update([
                'item_name'    =>  $request->item_name??null,
                'barcode'      =>  $request->barcode??null,
                'item_group'   =>  $request->item_group??null,
                'sub_group'    =>  $request->sub_group??null,
                'sale_price'   =>  $request->sale_price??null,
                'tax'          =>  $request->tax??null,
                'discount'     =>  $request->discount??null,
                'min_stock'    =>  $request->min_stock??null,
                're_order'     =>  $request->re_order??null,
                'gst'          =>  $request->gst??null,
                       
              ]);

         return redirect('admin/inventory')->with('status','Inventory has been Updated Successfully.');    

        }else{
             if ($request->hasFile('image')) {
                $file = request()->file('image');
                $ext=$file->getClientOriginalExtension();
                $imagename1 = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('admin/images/food_menu', $imagename1);
                }
                $url= URL::to('/');
                $logo=$url.'/admin/images/food_menu/'.$imagename1;

            $createdInventor=$this->InventoryObj->createInventory([
            'item_name'    =>  $request->item_name??null,
            'barcode'      =>  $request->barcode??null,
            'item_group'   =>  $request->item_group??null,
            'sub_group'    =>  $request->sub_group??null,
            'sale_price'   =>  $request->sale_price??null,
            'tax'          =>  $request->tax??null,
            'discount'     =>  $request->discount??null,
            'min_stock'    =>  $request->min_stock??null,
            're_order'     =>  $request->re_order??null,
            'gst'          =>  $request->gst??null,
            'food_description' =>  $request->food_description??null,
            'image'          =>  $logo,

            ]);

         return redirect('admin/inventory')->with('status','Inventory has been added Successfully.');

        }


    }

    public function get_inventory(Request $request){
       $data=FoodMenu::where('id',$request->user_id)->get();
       return json_encode($data);
    }

    public function hide(Request $request){
  // die($id);
       $user = FoodMenu::where('id',$request->user_id)->first();
        if ($request->status == 'Hide')
        {
            
            if ($user->status == '0')
              return response()->json(['success' => false,'message' => 'User Already Unblocked']);
            FoodMenu::where('id',$request->user_id)->update([
                'hide' => '1',
                'updated_at' => new \DateTime
            ]);
            return response()->json(['success' => true,'message' => 'User Unblocked Successfully']);

        }else{
            
            if ($user->status == '1')
              return response()->json(['success' => false,'message' => 'User Already Blocked']);
            FoodMenu::where('id',$request->user_id)->update([
                'hide' => '0',
                'updated_at' => new \DateTime
            ]);
            // dd($user = User::where('_id',$request->user_id)->first());
            return response()->json(['success' => true,'message' => 'User Blocked Successfully']);
        }
    }

}
