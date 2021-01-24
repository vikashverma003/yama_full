@extends('admin.layouts.app')

@section('content')
        
      <div class="content-wrapper">
          <div class="row">
             <h4 class="card-title">Add Floor Details</h4>
            
             @if (session('er_status'))
                  <div class="alert alert-danger">{!! session('er_status') !!}</div>
                @endif
                @if (session('su_status'))
                  <div class="alert alert-success">{!! session('su_status') !!}</div>
                @endif
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-12 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form action="{{url('admin/space_details')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <div class="row">
                           <div class="col-md-6">
                          <label for="exampleInputEmail1">Building Name</label>
                          <input type="text" name="building_id" class="form-control" id="exampleInputEmail1" placeholder="building_name" value="{{$building_info->building_name}}" disabled>
                         </div>

                          <div class="col-md-6">
                                  <label for="exampleInputEmail1">Floor Name</label>
                                  <input type="text" name="floor_id" class="form-control" id="exampleInputEmail1" placeholder="floor name" value="{{$floor->floor_name}}" disabled>

                                 </div>
                          </div></div>

                             <div class="form-group ">
                              <div class="row">
                              <div class="col-md-6">
                                  <label for="exampleInputEmail1">Space Name</label>
                                  <input type="text" name="space_name" class="form-control" id="exampleInputEmail1" placeholder="floor name" >
                                 <input type="hidden" name="building_id" value="{{$building_info->id}}">
                                 <input type="hidden" name="floor_id" value="{{$floor->id}}">

                                 </div> 
                               
                               <div class="col-md-6">
                                  <label for="exampleInputEmail1">Space Number</label>
                                  <input type="number" name="space_number" class="form-control" id="exampleInputEmail1" placeholder="number of rooms" required="">
                                 </div>
                                   </div></div>  
                          
                           <div class="form-group">
                            <div class="row">
                             <div class="col-md-6">
                                <label for="title" class="exampleInputEmail1">Space Type</label>
                                      <select  id="space_type" name="space_type" class="form-control">
                                        @foreach($space_type as $space_type)
                                        <option value="{{$space_type->id}}">{{$space_type->category}}</option>
                                        @endforeach
                                      </select>                                    
                            </div>
                             <div class="col-md-6">
                          <label for="exampleInputEmail1">Image</label>
                          <input type="file" name="image" class="form-control" id="exampleInputEmail1" placeholder="image">
                             </div></div></div>

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