@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
        <div class="content-wrapper" style="min-height: 1545px;">
          <div class="card">
            <div class="card-body">
               @if (\Session::has('error'))
                    <div class="alert alert-danger">
                       {!! \Session::get('error') !!}
                    </div>
                  @endif
              @if (session('er_status'))
                  <div class="alert alert-danger">{!! session('er_status') !!}</div>
                @endif
                @if (session('su_status'))
                  <div class="alert alert-success">{!! session('su_status') !!}</div>
                @endif
                <a href="{{url('admin/add_owner')}}" class="btn addLangBtn">
                  ADD OWNER
                          </a>
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Series</th>
                            <th width="5%">User</th>
                            <th width="5%">Status</th>
                            <th width="10%">Name</th>
                            <th width="20%">Phone Number</th>
                            <th width="20%">Email</th>
                            <th width="10%">Actions</th>
                        </tr>
                      </thead>

                      <tbody>
                       @php $i=0; @endphp
                        @foreach($data as $user)
                        @php $i++; @endphp
                        <tr>
                          <td> @php echo $i; @endphp</td>
                          @php if(!empty($user->profile_image)){ @endphp
                          <td><img src="{{asset($user->profile_image)}}" alt="image" /></td>
                          @php }else{ @endphp

                             <td><img src="{{asset('admin/images/dummy-image.jpg')}}" alt="image" /></td>
                           @php } @endphp
                            <td>
                                <label class="badge {{$user->block_status == '0' ? 'badge-success' : 'badge-danger'}}"> {{$user->block_status == '0' ? 'UNBLOCK' : 'BLOCK'}}</label>
                            </td>
                           
                            <td>{{$user->first_name}}{{$user->last_name}}</td>
                            <td>{{$user->phone_number}}</td>
                            <td>{{$user->email}}</td>
                        
                           <td>
                              <ul class="navbar-nav">
                                <li class="nav-item dropdown d-none d-lg-flex">
                                  <a class="nav-link  nav-btn" id="actionDropdown" href="#" data-toggle="dropdown">
                                    <button class="btn btn-outline-primary">Action</button>
                                  </a>
                                  <div class="dropdown-menu navbar-dropdown" aria-labelledby="actionDropdown">
                                    <!--  <a href="{{route('viewUser',$user->id)}}" class="dropdown-item" >View</a> -->
                                  @if($user->block_status == '0')
                                      <a href="#" class="dropdown-item" onclick="block_confirmation('{{$user->id}}','Block')">Block</a>
                                    @else
                                    <a href="#" class="dropdown-item" onclick="block_confirmation('{{$user->id}}','Unblock')"> Unblock</a>
                                    @endif
                                   
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
<script type="text/javascript">
   function block_confirmation(id, status)
  {
    swal({
        title: "Are you sure you want to "+status+"?",
        text: "Please ensure and then confirm",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ab8be4",
        confirmButtonText: "Yes, "+status+" it!",
        closeOnConfirm: false
    })
   
    .then((willDelete) => {
      if (willDelete) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          type: 'GET',
           url: "{{route('block_user')}}?user_id="+id+"&status="+status,
          success:function(data){
            if(data.success == true)
            {
              swal("Done!", data.message, "success");
            }
            else
            {
              swal("Error!", data.message, "error");
            }
            setTimeout(function(){ location.reload()}, 3000);
          }
        });
      } 
    });
  }

 
</script>
@endsection