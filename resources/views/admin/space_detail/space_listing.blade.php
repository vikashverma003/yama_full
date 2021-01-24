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
               <h4 >Space Listing</h4><br/>
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Building Name</th>
                            <th width="5%">Floor Name</th>
                            <th width="5%">Floor Number</th>
                            <th width="5%">Space Name</th>
                            <th width="5%">Space Number</th>
                            <th width="5%">Image</th>
                            <!--<th width="5%">Floor Details</th> -->
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($all_spaces as $spaces)
                        <tr>
                            <td>{{$spaces['building_name']}}</td> 
                            <td>{{$spaces['floor_name']}}</td> 
                            <td>{{$spaces['floor_number']}}</td> 
                            <td>{{$spaces['space_name']}}</td> 
                            <td>{{$spaces['space_number']}}</td> 
                            <td><img src="{{$spaces['image']}}" width="100" height="100" alt="image"/></td>
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