@extends('admin.layouts.app')

@section('content')
        
      <div class="content-wrapper">
          <div class="row">
             <h4 class="card-title">Add Vendor</h4>
            
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
                      <form action="{{url('admin/vendor')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                          <div class="col-md-6">
                                <label for="title" class="exampleInputEmail1">Vendor Type</label>
                                      <select  id="vendor_type" name="vendor_type" class="form-control">
                                       <option value="">Select Vendor Type</option>
                                       <option value="valet">Valet</option>
                                        <option value="kitchen">Kitchen</option>
                                      </select>                                    
                            </div>
                          </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="name" required="">
                             </div>

                          
                            <div class="form-group">
                          <label for="exampleInputEmail1">Logo</label>
                          <input type="file" name="logo" class="form-control" id="exampleInputEmail1" placeholder="logo" required="">
                             </div>
                              <div class="form-group">
                          <label for="exampleInputEmail1">Description</label>
                          <input type="text" name="description" class="form-control" id="exampleInputEmail1" placeholder="description" required="">
                             </div>
                             <div class="form-group">
                          <label for="exampleInputEmail1">Gst Number</label>
                          <input type="number" name="gst_number" class="form-control" id="exampleInputEmail1" placeholder="description" required="">
                             </div>
                              <div class="form-group">
                          <label for="exampleInputEmail1">Food</label>
                          <input type="text" name="food" class="form-control" id="exampleInputEmail1" placeholder="food" required="">
                             </div>
                             <div class="form-group">
                          <label for="exampleInputEmail1">License Number</label>
                          <input type="number" name="license_number" class="form-control" id="exampleInputEmail1" placeholder="license_number" required="">
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