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
                <a href="{{url('admin/vendor/create')}}" class="btn addLangBtn">
                  ADD VENDOR
                          </a>
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Vendor Id</th>
                            <th width="5%">Vendor Type</th>
                            <th width="5%">Name</th>
                            <th width="5%">Logo</th>
                            <th width="5%">Description</th>
                            <th width="5%">Gst Number</th>
                            <th width="5%">Food</th>
                            <th width="5%">License Number</th>
                            <th width="5%">Action</th>

                        </tr>
                      </thead>

                      <tbody>
                        @foreach($vendor as $vendor)
                        <tr>
                            <td>{{$vendor->id}}</td>
                            <td>{{$vendor->vendor_type}}</td>

                            <td>{{$vendor->name}}</td>
                            <td><img src="{{$vendor->logo}}" width="100" height="100" alt="image"/></td>
                            <td>{{$vendor->description}}</td>
                            <td>{{$vendor->gst_number}}</td>
                            <td>{{$vendor->food}}</td>
                            <td>{{$vendor->license_number}}</td>
                            <td>
                              <ul class="navbar-nav">
                                <li class="nav-item dropdown d-none d-lg-flex">
                                  <a class="nav-link  nav-btn" id="actionDropdown" href="#" data-toggle="dropdown">
                                    <button class="btn btn-outline-primary">Action</button>
                                  </a>
                                  <div class="dropdown-menu navbar-dropdown" aria-labelledby="actionDropdown">
                                     <a href="{{url('admin/vendor')}}/{{$vendor->id}}/edit" class="dropdown-item" >Edit</a>
                                      <a href="{{url('admin/vendor')}}/{{$vendor->id}}/delete" class="dropdown-item" >Delete</a>

                                  </div>
                                </li>
                              </ul>
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
@endsection