<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\SpaceType;
use App\Models\ParkingSpace;
use App\Models\Floor;
use App\Models\SpaceDetail;
use URL;
use Validator;


class BuildingController extends Controller
{
    //
    protected $buildingObj;
    protected $floorObj;

    public function __construct(Building $building,Floor $floor)
    {
         $this->buildingObj =$building;
         $this->floorObj =$floor;

    }
    public function create_building(Request $request){

    	return view('admin.building.create_building');
    }

    public function store_building(Request $request){
      $messages = [
                  'building_name.required' => 'Building name is required.',
                  'link.required' => 'Link is required.',
                  'floor.required' => 'floor is required.',
                  'image.required' => 'Image is required.',
                  'space.required' => 'Space is required.',
                  'floor.required' => 'floor is required.',
              ];

              $validator = Validator::make($request->all(), [
                 
                  'building_name' => 'required',
                  'link' => 'required',
                  'floor' => 'required',
                  'image' => 'required',
                  'space' => 'required',
                 
              ], $messages);
        
              if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
              } else {    	
	 
        	  if ($request->hasFile('image')) {
        	            $file = request()->file('image');
        	            $ext=$file->getClientOriginalExtension();
        	            $imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        	            $file->move('admin/images/building', $imagename);
        	            }

        	    $url= URL::to('/');
        	    $groupImage=$url.'/admin/images/building/'.$imagename;
                $addData = [
                           'building_name' => strtoupper($request->input('building_name')),
                           'image' =>$groupImage,
                           'link' => $request->input('link'),
                           'floor' => $request->input('floor'),   
                           'space' => $request->input('space'),                                             
                        ];
                $createdBuilding=$this->buildingObj->create_buildings($addData);
                if ($createdBuilding) {
                                return redirect('admin/building_list')->with("su_status", "Building  information has been added");                  
                        } 
                else {
                       return Redirect::back()->with('er_status', 'No Parking Space  added!');
                      }
               }
    }

    public function building_listing(Request $request){
    	$buildings=Building::all();
    	return view('admin.building.building_list')->with('buildings',$buildings);
    }

    public function building_edit(Request $request,$id){
    	$buildings=Building::where('id','=', $id)->first();
    	return view('admin.building.building_edit')->with('buildings',$buildings);

    }

    public function building_edit_update(Request $request, $id){

    	//print_r($_POST);die();
    	if ($request->hasFile('image')) {
            $file = request()->file('image');
            $ext=$file->getClientOriginalExtension();
            $imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('admin/images/building', $imagename);
            }
            if(!empty($imagename)){
              $url= URL::to('/');
              $groupImage=$url.'/admin/images/building/'.$imagename;
            }else{
              $reqInfo=Building::where('id','=',$id)->first();
              $groupImage=$reqInfo->image;
          }
           $updateData = [
                   'building_name' => strtoupper($request->input('building_name')),
                   'image' =>$groupImage,
                   'link' => $request->input('link'),
                   'floor' => $request->input('floor'),   
                   'space' => $request->input('space'),                                             
                ];
           $update =  Building::where(['id'=>$id])->update($updateData);
           return redirect('admin/building_list')->with("su_status", "Building  information has been updated");                  
    }

    public function delete_building(Request $request,$id){
        //echo $id;
         $delete_building=Building::where('id','=', $id)->delete();
         return redirect('admin/building_list')->with("su_status", "Deletion has been succsessfull");
    }

    public function add_floor_details(Request $request,$id){
      $building_info=Building::where('id','=',$id)->first();
      $floor_info=Floor::where('building_id','=',$id)->get();
    	return view('admin.building.add_floor_details', ['building_info'=>$building_info,'floor_info'=>$floor_info]);
    }

    public function store_floor_details(Request $request){
    	//print_r($_POST);
      if ($request->hasFile('image')) {
                      $file = request()->file('image');
                      $ext=$file->getClientOriginalExtension();
                      $imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                      $file->move('admin/images/building', $imagename);
                      }

                    $url= URL::to('/');
                    $groupImage=$url.'/admin/images/building/'.$imagename;             
    	 $addData = [
                   'building_id' => $request->input('building_id'),
                   'room_number' =>$request->input('room_number'),                 
                   'number_of_rooms' => $request->input('number_of_rooms'),   
                   'floor_name' => strtoupper($request->input('floor_name')),
                   'floor_number' => $request->input('floor_number'),                                             
                   'area' => $request->input('area'),                                             
                   'image' => $groupImage,                                                                                          
                ];
                $bu_id=$request->input('building_id');
        $createdFloor=$this->floorObj->add_floor_building($addData);
        if ($createdFloor) {
                        //return redirect('admin/building_list')->with("su_status", "Floor information has been added");                  
                return redirect()->to('admin/add_floor_details/'.$bu_id);

                } 
    }

    public function floor_listing(Request $request,$id){
         $floor=Floor::where('building_id','=',$id)->get();
         $building_info=Building::where('id','=',$id)->first();
         return view('admin.building.floor_listing', ['floor'=>$floor,'building_info'=>$building_info]);
    }

    public function building_floor_listing(Request $request){
               $floor=Floor::get();
               $floor_building=array();
               foreach($floor as $floors)
               {
                      $building_info=Building::where('id','=',$floors['building_id'])->first();
                       // $floor_building['building_name']= $building_info->building_name;
                       // $floor_building['floor_id']= $floors->id;
                       // $floor_building['floor_number']= $floors->floor_number;
                       // $floor_building['floor_name']= $floors->floor_name;
                       // $floor_building['number_of_rooms']= $floors->number_of_rooms;
                       // $floor_building['area']= $floors->area;
                       // $floor_building['image']= $floors->image;

                      $check_space_details=SpaceDetail::where('building_id','=', $floors['building_id'])->where('floor_id','=', $floors['id'])->first();
                       $floor_building[]= [
                            'building_name'=>$building_info->building_name,
                            'id'=>$floors->id,
                             'building_id'=>$building_info->id,
                             'check_space_details'=>$check_space_details !=''?1:0,
                            'floor_number'=>$floors->floor_number,
                            'floor_name'=>$floors->floor_name,
                            'number_of_rooms'=>$floors->number_of_rooms,
                            'area'=>$floors->area,
                            'image'=>$floors->image,
                       ];
               }
               // echo "<pre>";
               // print_r($floor_building);die();
               return view('admin.building.building_floor_listing',['floor'=>$floor_building]);
    }
}
