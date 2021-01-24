@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
      <div class="content-wrapper">
          <div class="row">
             <h4 class="card-title">Add Owner</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form action="{{url('admin/createowner')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">First Name</label>
                          <input type="text" name="first_name" class="form-control" id="exampleInputEmail1" placeholder="Enter First Name" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Last Name</label>
                          <input type="text" name="last_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Last Name" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Email</label>
                          <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Email" required="">
                        </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">Image</label>
                      <input type="file" name="image" id="professional_title" class="file-upload-default" required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="title_Professional" style="color: red;"></span>
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