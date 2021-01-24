@extends('admin.layouts.app')

@section('content')
        
      <div class="content-wrapper">
          <div class="row">
             <h4 class="card-title">Add Food Item</h4>
            
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
                      <form action="{{url('admin/food_item')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <div class="row">
                           <div class="col-md-6">
                          <label for="exampleInputEmail1">Food Name</label>
                          <input type="text" name="food_name" class="form-control" id="exampleInputEmail1" placeholder="food_name" required>
                         </div>

                         <div class="col-md-6">
                                <label for="title" class="exampleInputEmail1">Food Type</label>
                                      <select  id="vendor_type" name="food_type" class="form-control">
                                       <option value="veg">Veg</option>
                                        <option value="non-veg">Non-veg</option>
                                      </select>                                    
                            </div>
                          </div></div>

                             <div class="form-group ">
                              <div class="row">
                              <div class="col-md-6">
                                  <label for="exampleInputEmail1">Group Name</label>
                                  <input type="text" name="group_name" class="form-control" id="exampleInputEmail1" placeholder="group_name" required>
                                 </div> 
                               
                               <div class="col-md-6">
                                  <label for="exampleInputEmail1">Sub Group</label>
                                  <input type="text" name="sub_group" class="form-control" id="exampleInputEmail1" placeholder="sub_group" required="">
                                 </div>
                                   </div></div>
                                   <div class="form-group ">
                              <div class="row">
                              <div class="col-md-6">
                                <label for="title" class="exampleInputEmail1">Building Name</label>
                                      <select  id="vendor_type" name="building_id" class="form-control">
                                      @foreach($building as $buildings)
                                        <option value="{{$buildings->id}}">{{$buildings->building_name}}</option>
                                      @endforeach
                                      </select>                                    
                            </div>
                               
                              <div class="col-md-6">
                                <label for="title" class="exampleInputEmail1">Floor Name</label>
                                     <select  id="vendor_type" name="floor_id" class="form-control">
                                      @foreach($floor as $floors)
                                        <option value="{{$floors->id}}">{{$floors->floor_name}}</option>
                                      @endforeach
                                      </select>                                        
                            </div>
                                   </div></div>    
                          
                           <div class="form-group">
                            <div class="row">
                             <div class="col-md-6">
                          <label for="exampleInputEmail1">Price</label>
                          <input type="number" name="price" class="form-control" id="exampleInputEmail1" placeholder="price" required>

                             </div>
                             <div class="col-md-6">
                          <label for="exampleInputEmail1">Image</label>
                          <input type="file" name="image" class="form-control" id="exampleInputEmail1" placeholder="image" required>
                             </div></div></div>
                                <div class="form-group">
                            <div class="row">
                             <div class="col-md-6">
                          <label for="exampleInputEmail1">Tax</label>
                          <input type="number" name="taxes" class="form-control" id="exampleInputEmail1" placeholder="taxes" required>
                             </div>
                             </div></div>

                              

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