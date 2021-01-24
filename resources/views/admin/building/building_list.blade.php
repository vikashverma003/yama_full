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
                <a href="{{url('admin/add_building')}}" class="btn addLangBtn">
                  ADD BUILDING
                          </a>
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
                            <th width="5%">Link</th>
                            <th width="5%">Floor</th>
                            <th width="5%">Space</th>
                            <th width="5%">Action</th>
                            <th width="5%">Add Floor</th>
                            <!--<th width="5%">Floor Details</th> -->
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($buildings as $buildingss)
                        <tr>
                            <td>{{$buildingss->id}}</td>
                            <td>{{$buildingss->building_name}}</td>
                            <td><img src="{{$buildingss->image}}" width="100" height="100" alt="image"/></td>
                            <td>{{$buildingss->link}}</td>  
                            <td>{{$buildingss->floor}}</td>                            
                           <td>{{$buildingss->space}}</td> 
                          <!-- <td>
                              <a href="{{url('/admin/building_edit')}}/{{$buildingss->id}}">Edit</a>
                            
                              <a href="{{url('/admin/delete_building')}}/{{$buildingss->id}}">Delete</a>
                            </td>  -->
                            <td>
                              <ul class="navbar-nav">
                                <li class="nav-item dropdown d-none d-lg-flex">
                                  <a class="nav-link  nav-btn" id="actionDropdown" href="#" data-toggle="dropdown">
                                    <button class="btn btn-outline-primary">Action</button>
                                  </a>
                                  <div class="dropdown-menu navbar-dropdown" aria-labelledby="actionDropdown">
                                     <a href="{{url('/admin/building_edit')}}/{{$buildingss->id}}" class="dropdown-item" >Edit</a>
                                      <a href="{{url('/admin/delete_building')}}/{{$buildingss->id}}" class="dropdown-item" >Delete</a>

                                  </div>
                                </li>
                              </ul>
                            </td> 

                        <td><a href="{{url('/admin/add_floor_details')}}/{{$buildingss->id}}">Add</a></td> 
                            <!--<td><a href="{{url('/admin/floor_listing')}}/{{$buildingss->id}}">Details</a></td> -->

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