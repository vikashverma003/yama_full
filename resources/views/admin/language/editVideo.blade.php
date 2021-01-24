@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
      <div class="content-wrapper">
          <div class="row">
             <h4 class="card-title">Add Language</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form action="{{url('admin/uploadVideo')}}" method="POST" enctype="multipart/form-data" class="forms-sample">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Video</label>
                          <input type="file" name="video" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required="">
                          <input type="hidden" name="id" value="{{$video->id}}">
                           <?php 
                         $url= URL::to('/');
                         ?>
                             <video width="400" style="height: 114px; width: 192px;" controls>
                            <source src="{{$url}}/admin/images/doctor/{{$video->video}}" type="video/mp4">
                            <source src="mov_bbb.ogg" type="video/ogg">
                            Your browser does not support HTML5 video.
                            </video>
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