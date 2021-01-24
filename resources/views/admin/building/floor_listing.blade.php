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
                <!-- <a href="{{url('admin/add_building')}}" class="btn addLangBtn">
                  ADD BUILDING
                          </a> -->
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Building Id</th>
                            <th width="5%">Building Name</th>
                            <th width="5%">Image</th>
                            <th>Room Number</th>
                            <th>Number of Guests</th>
                            <th>Amount</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($floor as $floors)
                        <tr>
                            <td>{{$building_info->id}}</td>
                            <td>{{$building_info->building_name}}</td>
                            <td><img src="{{$building_info->image}}" width="100" height="100" alt="image"/></td>
                            <td>{{$floors->room_number}}</td>  
                            <td>{{$floors->guest}}</td>                            
                           <td>{{$floors->amount}}</td> 
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