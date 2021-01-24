<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpaceType;
class SpaceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $space_type=SpaceType::all();
        return view('admin.space_type.space_type')->with('space_type',$space_type);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.space_type.add_space_type');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
         $space_type= new SpaceType;
         $space_type->category=strtoupper($request->input('sp_type'));
         $space_type->save();
         return redirect('admin/spacetype');

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
         $space_type= SpaceType::find($id);
         return view('admin.space_type.edit_sp_type')->with('space_type',$space_type);

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
        
        $updateData = [
                   'category' => strtoupper($request->input('sp_type')),                                                                
                ];
           $update =  SpaceType::where(['id'=>$id])->update($updateData);
        return redirect('admin/spacetype')->with("su_status", "Updation has been succsessfull");

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
         $delete_sp_type=SpaceType::where('id','=', $id)->delete();
         return redirect('admin/spacetype')->with("su_status", "Deletion has been succsessfull");
    }
}
