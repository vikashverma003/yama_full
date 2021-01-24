<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FoodItem;
use App\Models\Building;
use App\Models\Floor;
use Log;
use URL;
use Image;

class FoodItemController extends Controller
{
    
    protected $foodObj;
    public function __construct(FoodItem $food_item)
    {
         $this->foodObj =$food_item;
    }
    public function index()
    {
        $food_item=FoodItem::all();
        foreach($food_item as $food_items){
             $building=Building::where('id','=',$food_items->building_id)->first();
              $floor=Floor::where('id','=',$food_items->floor_id)->first();
              $items[]= [
              'building_name'=>  $building->building_name,
              'floor_name'=>  $floor->floor_name,
              'food_name'=>  $food_items->food_name,
               'id'=>  $food_items->id,
              'group_name'=>  $food_items->group_name,
              'food_type'=>  $food_items->food_type,
              'price'=>  $food_items->price,
              'taxes'=>  $food_items->taxes,
              'image'=>  $food_items->image,
              'sub_group'=>  $food_items->sub_group,
              ];
        }
        // print_r($items);
        // die();
        return view('admin.food_item.food_item_listing')->with('food_item', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $building=Building::all();
        $floor=Floor::all();
        return view('admin.food_item.add_food_item',['floor'=>$floor,'building'=>$building]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // if ($request->hasFile('image')) {
         //        $file = request()->file('image');
         //        $ext=$file->getClientOriginalExtension();
         //        $imagename1 = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
         //        $file->move('admin/images/inventory', $imagename1);
                
         //        }
        if ($request->hasFile('image')) {
        $file = request()->file('image');


        $fileType = substr($file->getClientMimeType(), 0,5);            //get file type of file

        if($fileType == 'image'){

        $fileSize = $image->getSize();                                //get size of image file
    echo $fileSize ."<br>";

        Log::info('Image size in bytes --- '.$fileSize);
    }
    echo $fileSize;

}
die();




        $url= URL::to('/');
        $logo=$url.'/admin/images/inventory/'.$imagename1;
        $addData = [
                   'food_name' => strtoupper($request->input('food_name')),
                   'group_name' => strtoupper($request->input('group_name')),
                   'food_type' =>strtoupper($request->input('food_type')),
                   'price' => strtoupper($request->input('price')),
                   'taxes'=>$request->input('taxes'),
                    'building_id'=>$request->input('building_id'),
                   'floor_id'=>$request->input('floor_id'),
                   'hide'=>0,                
                   'image'=>$logo,
                   'sub_group' => strtoupper($request->input('sub_group')),   
                ];
        $createdItem=$this->foodObj->create_food_item($addData);
        if ($createdItem) {
                        return redirect('admin/food_item')->with("su_status", "Food Item has been added");                  
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
