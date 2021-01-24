@extends('admin.layouts.app')

@section('content')
        
      <div class="content-wrapper">
          <div class="row">
             <h4 class="card-title">Add Space Types</h4>
            
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
                      <form action="{{url('admin/spacetype')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                          <div class="row">
                           <div class="col-md-6">
                          <label for="exampleInputEmail1">Space Type</label>
                          <input type="text" name="sp_type" class="form-control" id="exampleInputEmail1" placeholder="building_name">
                         </div>
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