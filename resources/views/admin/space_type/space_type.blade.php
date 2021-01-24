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
                 <a href="{{url('admin/spacetype/create')}}" class="btn addLangBtn">
                  ADD SPACE TYPE
                          </a> 
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Space Type Id</th>
                            <th width="5%">Space Type Name</th>
                            <th width="5%">Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($space_type as $space_types)
                        <tr>
                            <td>{{$space_types->id}}</td>
                            <td>{{$space_types->category}}</td>
                            <!--<td><a href="{{url('admin/spacetype')}}/{{$space_types->id}}/edit">Edit</a>
                           <a href="{{url('admin/spacetype')}}/{{$space_types->id}}/delete">Delete</a></td> -->
                            <td>
                              <ul class="navbar-nav">
                                <li class="nav-item dropdown d-none d-lg-flex">
                                  <a class="nav-link  nav-btn" id="actionDropdown" href="#" data-toggle="dropdown">
                                    <button class="btn btn-outline-primary">Action</button>
                                  </a>
                                  <div class="dropdown-menu navbar-dropdown" aria-labelledby="actionDropdown">
                                     <a href="{{url('admin/spacetype')}}/{{$space_types->id}}/edit" class="dropdown-item" >Edit</a>
                                      <a href="{{url('admin/spacetype')}}/{{$space_types->id}}/delete" class="dropdown-item" >Delete</a>
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