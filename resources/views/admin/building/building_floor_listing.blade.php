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
                           <h4 class="card-title">Floors Listing</h4>
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Floor Id</th>
                            <th>Floor Name</th>
                            <th width="5%">Building Name</th>
                            <th>Room Number</th>
                            <th width="5%">Floor Image</th>
                            <th> Number of Rooms</th>
                            <th> Add Space Details</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($floor as $floors)
                        <tr>
                            <td>{{$floors['id']}}</td>
                            <td>{{$floors['floor_name']}}</td>       
                            <td>{{$floors['building_name']}}</td>
                           <td>{{$floors['floor_number']}}</td> 
                            <td><img src="{{$floors['image']}}" width="100" height="100" alt="image"/></td>
                            <td>{{$floors['number_of_rooms']}}</td> 
                            
                            <td> @if($floors['check_space_details']=='0')
                              <a href="{{url('admin/space_details/create')}}/{{$floors['building_id']}}/{{$floors['id']}}">Add</a>  
                                 @else
                            <p><a href="#" data-toggle="modal" data-target="#exampleModal3" data-whatever="@mdo" >Add</a></p>
                            @endif
                            </td>
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
        <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
              <div class="col-lg-6">
                    <p>We have already added Space Details</p>
               </div>
              </div>       
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            
            </div>
            </div>
          </div>
          </div>
        </div>
@endsection