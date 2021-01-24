@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
      <div class="content-wrapper">
          <div class="row">
             <h4 class="card-title">Edit Group</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form action="{{url('admin/updateGroup')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Group Name</label>
                          <input type="text" name="food_name" class="form-control" id="exampleInputEmail1" value="{{$data->heading}}" placeholder="Enter Name" required="">
                           <input type="hidden" name="id" class="form-control" id="exampleInputEmail1" value="{{$data->id}}" placeholder="Enter Name" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Restaurants</label>
                          <select class="form-control border-primary" name="restaurants" id="exampleSelectPrimary" required="">
                          <option>--Select--</option>
                          <option value="1" <?php if($data->restaurant_id == '1'){ echo "selected"; } ?>>Pink Sugar</option>
                          <option value="2" <?php if($data->restaurant_id == '2'){ echo "selected"; } ?>>Vintage Machine</option>
                          <option value="3" <?php if($data->restaurant_id == '3'){ echo "selected"; } ?>>The Gourmet Kitchen</option>
                          <option value="4" <?php if($data->restaurant_id == '4'){ echo "selected"; } ?>>The Saffron Boutique</option>
                          <option value="5" <?php if($data->restaurant_id == '5'){ echo "selected"; } ?>>Wasabi by Morimoto</option>
                          </select>
                        </div>

                      <div class="form-group">
                      <label for="exampleTextarea1">Description</label>
                      <textarea class="form-control"  name="description" id="exampleTextarea1" rows="4" required="">{{$data->description}}</textarea>
                      </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">Image</label>
                      <input type="file" name="image" id="professional_title" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                        <span class="input-group-btn">

                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>

                      </div>
                      <img src="{{$data->image}}" style="width: 45px; height: 45px;">
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