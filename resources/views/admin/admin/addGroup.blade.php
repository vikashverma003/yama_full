@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
      <div class="content-wrapper">
          <div class="row">
             <h4 class="card-title">Add Group</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form action="{{url('admin/createGroup')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Group Name</label>
                          <input type="text" name="food_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Restaurants</label>
                          <select class="form-control border-primary" name="restaurants" id="exampleSelectPrimary" required="">
                          <option>--Select--</option>
                          <option value="1">Pink Sugar</option>
                          <option value="2">Vintage Machine</option>
                          <option value="3">The Gourmet Kitchen</option>
                          <option value="4">The Saffron Boutique</option>
                          <option value="5">Wasabi by Morimoto</option>
                          </select>
                        </div>

                      <div class="form-group">
                      <label for="exampleTextarea1">Description</label>
                      <textarea class="form-control" name="description" id="exampleTextarea1" rows="4" required=""></textarea>
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