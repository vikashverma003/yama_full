@extends('admin.layouts.app')

@section('content')
        
      <div class="content-wrapper">
          <div class="row">
             <h4 class="card-title">Edit Building</h4>
            
             @if (session('er_status'))
                  <div class="alert alert-danger">{!! session('er_status') !!}</div>
                @endif
                @if (session('su_status'))
                  <div class="alert alert-success">{!! session('su_status') !!}</div>
                @endif
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form action="{{url('admin/building_edit')}}/{{$buildings->id}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Building Name</label>
                          <input type="text" name="building_name" class="form-control" id="exampleInputEmail1" placeholder="building_name" value="{{$buildings->building_name}}">
                             </div>

                             <div class="form-group">
                          <label for="exampleInputEmail1">Image</label>
                          <input type="file" name="image" class="form-control" id="exampleInputEmail1" placeholder="status">
                           <img src="{{$buildings->image}}" width="300" height="250">

                             </div>
                          <div class="form-group">
                          <label for="exampleInputEmail1">Link</label>
                          <input type="text" name="link" class="form-control" id="exampleInputEmail1" placeholder="link" value="{{$buildings->link}}" >
                             </div>
                           <div class="form-group">
                          <label for="exampleInputEmail1">Floor</label>
                          <input type="number" name="floor" class="form-control" id="exampleInputEmail1" placeholder="floor" value="{{$buildings->floor}}">
                             </div>
                          <div class="form-group">
                          <label for="exampleInputEmail1">Space</label>
                          <input type="number" name="space" class="form-control" id="exampleInputEmail1" placeholder="space" value="{{$buildings->space}}">
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