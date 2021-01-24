@extends('admin.layouts.app')
@section('content')
        
        <div class="content-wrapper" style="min-height: 1545px;">
          <div class="card">
            <div class="card-body">
                @if (session('er_status'))
                  <div class="alert alert-danger">{!! session('er_status') !!}</div>
                @endif
                @if (session('su_status'))
                  <div class="alert alert-success">{!! session('su_status') !!}</div>
                @endif
               
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%"> Id</th>
                            <th width="5%">Name</th>
                            <th width="5%">Logo</th>
                            

                        </tr>
                      </thead>

                      <tbody>
                        @foreach($vendor as $vendor)
                        <tr>
                            <td>{{$vendor->id}}</td>

                            <td>{{$vendor->name}}</td>
                            <td><a href="{{url('admin/vendor/random/data')}}" target="_blank"><img src="{{$vendor->logo}}" width="100" height="100" alt="image"/></td>
                              
                        </tr>
                        @endforeach
                      </tbody>
                    </table>                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection