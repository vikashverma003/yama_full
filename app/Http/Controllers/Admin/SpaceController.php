<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpaceDetail;
use App\Models\SpaceType;
use App\Models\Floor;
use App\Models\Building;
use URL;

class SpaceController extends Controller
{
     protected $spaceObj;
    public function __construct(SpaceDetail $space_detail)
    {
         $this->spaceObj =$space_detail;
    }
    public function index()
    {
        $space=SpaceDetail::all();
        foreach($space as $spaces)
        {
           $building_info= Building::where('id','=',$spaces->building_id)->first();
           $floor_info= Floor::where('id','=',$spaces->floor_id)->first();
           $all_spaces[]=[
               'building_name'=>$building_info->building_name,
               'floor_name'=>$floor_info->floor_name,
               'floor_number'=>$floor_info->floor_number,
               'space_name'=>$spaces->space_name,
               'space_number'=>$spaces->space_number,
               'image'=>$spaces->image,

           ];
        }
      //  print_r( $all_spaces);die();
        return view('admin.space_detail.space_listing')->with('all_spaces',$all_spaces);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($building_id,$floor_id)
    {
        
        $floor=Floor::where('id','=',$floor_id)->first();
        $building_info=Building::where('id','=',$building_id)->first();
        $space_type=SpaceType::get();
        return view('admin.space_detail.add_space_details',['space_type'=>$space_type,'floor'=>$floor,'building_info'=>$building_info]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
                $file = request()->file('image');
                $ext=$file->getClientOriginalExtension();
                $imagename1 = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('admin/images/space_detail', $imagename1);
                }
        $url= URL::to('/');
        $logo=$url.'/admin/images/space_detail/'.$imagename1;
        $addData = [
                   'building_id' => $request->input('building_id'),
                   'floor_id' => $request->input('floor_id'),
                   'space_number' =>$request->input('space_number'),
                   'space_name' => $request->input('space_name'),
                   'image'=> $logo,
                    'space_type'=>$request->input('space_type'),                   
                ];
        $createdItem=$this->spaceObj->create_space_detail($addData);
        if ($createdItem) {
                        return redirect('admin/building_floor_listing')->with("su_status", "Space Details has been added");                  
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
