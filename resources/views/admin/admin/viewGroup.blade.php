@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
        <div class="content-wrapper" style="min-height: 1545px;">
          <div class="card">
            <div class="card-body">
               @foreach($errors->all() as $error)
                      <div class="alert alert-dismissable alert-danger">
                          {!! $error !!}
                      </div>
                  @endforeach

                  @if (session('status'))
                      <div class="alert alert-success">
                          {{ session('status') }}
                      </div>
                  @endif
                <a href="{{url('admin/addGroup')}}" class="btn addLangBtn">
                  ADD FOOD GROUP
                          </a>
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Series</th>
                            <th width="5%">Image</th>
                            <th width="10%">Name</th>
                            <th width="20%">description</th>
                            <th width="20%">Restaurants</th>
                            <th width="10%">Actions</th>
                        </tr>
                      </thead>

                      <tbody>
                       @php $i=0; @endphp
                        @foreach($group as $user)
                        @php $i++; @endphp
                        <tr>
                          <td> @php echo $i; @endphp</td>
                          @php if(!empty($user->image)){ @endphp
                          <td><img src="{{asset($user->image)}}" alt="image" /></td>
                          @php }else{ @endphp

                             <td><img src="{{asset('admin/images/dummy-image.jpg')}}" alt="image" /></td>
                           @php } @endphp
                           
                            <td>{{$user->heading}}</td>
                            <td>{{$user->description}}</td>
                            <td>{{$user->restaurant_id}}</td>
                        
                            <td>
                              <ul class="navbar-nav">
                                <li class="nav-item dropdown d-none d-lg-flex">
                                  <a class="nav-link  nav-btn" id="actionDropdown" href="#" data-toggle="dropdown">
                                    <button class="btn btn-outline-primary">Action</button>
                                  </a>
                                  <div class="dropdown-menu navbar-dropdown" aria-labelledby="actionDropdown">
                                     <a href="{{route('viewGroup',$user->id)}}" class="dropdown-item" >Edit</a>
                                   <!--  <a href="#" class="dropdown-item" onclick="delete_confirmation('{{$user->id}}')">Delete</a> -->
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