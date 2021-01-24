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
                      <form action="{{url('admin/store_floor_details')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <div class="row">
                           <div class="col-md-6">
                          <label for="exampleInputEmail1">Building Name</label>
                          <input type="text" name="building_name" class="form-control" id="exampleInputEmail1" placeholder="building_name" value="{{strtoupper($building_info->building_name)}}" disabled>
                         </div>

                          <div class="col-md-6">
                                  <label for="exampleInputEmail1">Floor Number</label>
                                  <input type="number" name="floor_number" class="form-control" id="exampleInputEmail1" placeholder="floor number" value="{{strtoupper($building_info->floor)}}" disabled>
                                  <input type="hidden" name="building_id" value="{{$building_info->id}}">

                                 </div>
                          </div></div>

                             <div class="form-group ">
                              <div class="row">
                              <div class="col-md-6">
                                  <label for="exampleInputEmail1">Floor Name</label>
                                  <input type="text" name="floor_name" class="form-control" id="exampleInputEmail1" placeholder="floor name" >
                                 </div> 
                               
                               <div class="col-md-6">
                                  <label for="exampleInputEmail1">Number of Rooms</label>
                                  <input type="number" name="number_of_rooms" class="form-control" id="exampleInputEmail1" placeholder="number of rooms" required="">
                                 </div>
                                   </div></div>  
                          
                           <div class="form-group">
                            <div class="row">
                             <div class="col-md-6">
                          <label for="exampleInputEmail1">Area</label>
                          <input type="number" name="area" class="form-control" id="exampleInputEmail1" placeholder="area">
                             <input type="hidden" name="floor_number" value="{{$building_info->floor}}">

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
            <div class="container">
              <h4>Floors Details </h4>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Floor Name</th>
                    <th>Floor Number</th>
                    <th>Number of Rooms</th>                    
                    <th>Area</th>
                    <th>Image</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach($floor_info as $floor_info)
                  <tr>
                  <td>{{$floor_info->floor_name}}</td>
                  <td>{{$floor_info->floor_number}}</td>
                  <td>{{$floor_info->number_of_rooms}}</td>
                  <td>{{$floor_info->area}}</td>
                  <td><img src="{{$floor_info->image}}" width="100" height="100" alt="image"/></td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>      
          </div>
        </div>


@endsection