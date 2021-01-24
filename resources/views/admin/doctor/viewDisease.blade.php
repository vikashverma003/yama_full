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

                <a href="{{url('admin/addDisease')}}" class="btn addLangBtn">
                  Add Disease
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
                            <th width="5%">Name</th>
                            <th width="5%">Spanish</th>
                            <th width="10%">Actions</th>
                        </tr>
                      </thead>

                      <tbody>
                        @php $i=0; @endphp
                        @foreach($disease as $lag)
                        @php $i++; @endphp
                        <tr>
                            <td> @php echo $i; @endphp </td>
                             <?php 
                              $url= URL::to('/');
                              ?>
                            <td><label class="badge"><img src="{{$url}}/admin/images/doctor/{{$lag->image}}"></label></td>
                            <td><label class="badge">{{$lag->name}}</label></td>
                            <td><label class="badge">{{$lag->name_es}}</label></td>
                            <td>
                              <ul class="navbar-nav">
                                <li class="nav-item dropdown d-none d-lg-flex">
                                  <a class="nav-link  nav-btn" id="actionDropdown" href="#" data-toggle="dropdown">
                                    <button class="btn btn-outline-primary">Action</button>
                                  </a>
                                  <div class="dropdown-menu navbar-dropdown" aria-labelledby="actionDropdown">
                                    <!-- <div class="dropdown-divider"></div> -->
                                    <a href="{{route('editdisease',$lag->id)}}" class="dropdown-item" >Edit</a>
                                    <a href="#" class="dropdown-item" onclick="delete_confirmation('{{$lag->id}}')">Delete</a>
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

   function delete_confirmation(id)
  {
    swal({
        title: "Are you sure want to delete this user?",
        text: "Please ensure and then confirm",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ab8be4",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    })
   
    .then((willDelete) => {
      if (willDelete) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          type: 'GET',
          url: "{{route('delete_disease')}}?user_id="+id,
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