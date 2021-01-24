<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use URL;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $vendorObj;
    public function __construct(Vendor $vendor)
    {
         $this->vendorObj =$vendor;
    }
    public function index()
    {
        //
       $vendor=Vendor::all();
       return view('admin.vendor.vendor_listing')->with('vendor', $vendor);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.vendor.add_vendor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                 if ($request->hasFile('logo')) {
                $file = request()->file('logo');
                $ext=$file->getClientOriginalExtension();
                $imagename1 = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('admin/images/kitchen_logo', $imagename1);
                }

        $url= URL::to('/');
        $logo=$url.'/admin/images/kitchen_logo/'.$imagename1;
        $addData = [
                   'name' => strtoupper($request->input('name')),
                   'vendor_type' => strtoupper($request->input('vendor_type')),
                   'food' =>strtoupper($request->input('food')),
                   'description' => strtoupper($request->input('description')),
                   'gst_number'=>$request->input('gst_number'),
                   'logo'=>$logo,
                   'license_number' => $request->input('license_number'),   
                ];

        $createdVendor=$this->vendorObj->create_vendor($addData);
        if ($createdVendor) {
                        return redirect('admin/vendor')->with("su_status", "Vendor  information has been added");                  
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
        $kitchen=Vendor::find($id);
        return view('admin.vendor.edit_vendor')->with('kitchen', $kitchen);
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
        if ($request->hasFile('logo')) {
                $file = request()->file('logo');
                $ext=$file->getClientOriginalExtension();
                $imagename1 = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('admin/images/kitchen_logo', $imagename1);
                }

                if(!empty($imagename1)){            
                $url= URL::to('/');
                $logo=$url.'/admin/images/kitchen_logo/'.$imagename1;
                 }
                 else{
                     $reqInfo=Vendor::where('id','=',$id)->first();
                     $logo=$reqInfo->logo;
                 }
                    $updatedData = [
                          'name' => strtoupper($request->input('name')),
                          'vendor_type' => strtoupper($request->input('vendor_type')),
                           'food' =>strtoupper($request->input('food')),
                           'description' => strtoupper($request->input('description')),
                           'gst_number'=>$request->input('gst_number'),
                           'logo'=>$logo,
                           'license_number' => $request->input('license_number'),
                        ];
                   $update =  Vendor::where(['id'=>$id])->update($updatedData);
                   return redirect('admin/vendor')->with("su_status", "Vendor  information has been updated"); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
        $delete_vendor=Vendor::where('id','=', $id)->delete();
        return redirect('admin/vendor')->with("su_status", "Vendor has been deleted");
    }

    public function clickImage(Request $request){

         $vendor=Vendor::all();
       return view('admin.vendor.click_image')->with('vendor', $vendor);
    }
}
