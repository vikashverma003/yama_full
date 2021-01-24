@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
      <div class="content-wrapper">
          <div class="row">
             <h4 class="card-title">Edit Disease</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form action="{{url('admin/updateDeaseas')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" name="name" value="{{$disease->name}}" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" required="">
                            <input type="hidden" name="id" value="{{$disease->id}}" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
                             </div>

                              <div class="form-group">
                          <label for="exampleInputEmail1">Name (Spanish)</label>
                          <input type="text" name="name_es" value="{{$disease->name_es}}" class="form-control" id="exampleInputEmail1" placeholder="Enter name" required="">
                            
                             </div>


                             <div class="form-group">
                          <label for="exampleInputPassword1">Upload Image</label>
                           <input type="file" name="image" id="official_identification" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <?php 
                         $url= URL::to('/');
                         ?>
                     <img src="{{$url}}/admin/images/doctor/{{$disease->image}}" style="height: 90px; width: 120px;">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Description</label>
                          <input type="text" name="description" value="{{$disease->description}}" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required="">
                             </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Description (Spanish)</label>
                          <input type="text" name="description_es" value="{{$disease->description_es}}" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required="">
                             </div>     


                         <button type="submit" class="btn btn-success mr-2">Submit</button>
                         
                     </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
                
          </div>
        </div>

@endsection