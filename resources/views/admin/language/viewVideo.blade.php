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

              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Series</th>
                            <th width="5%">Video</th>
                            <th width="10%">Actions</th>
                        </tr>
                      </thead>
                      <?php 
                         $url= URL::to('/');
                         ?>
                      <tbody>
                        @php $i=0; @endphp
                        @foreach($video as $lag)
                        @php $i++; @endphp
                        <tr>
                            <td> @php echo $i; @endphp </td>
                            <td>

                            <video width="400" style="height: 114px; width: 192px;" controls>
                            <source src="{{$url}}/admin/images/doctor/{{$lag->video}}" type="video/mp4">
                            <source src="mov_bbb.ogg" type="video/ogg">
                            Your browser does not support HTML5 video.
                            </video>
                            </td>
                            <td>
                              <ul class="navbar-nav">
                                <li class="nav-item dropdown d-none d-lg-flex">
                                  <a href="{{route('editVideo',$lag->id)}}" class="" id="actionDropdown" href="#" data-toggle="">
                                    <i class="fa fa-edit"></i>
                                  </a>
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
          url: "{{route('delete_lang')}}?user_id="+id,
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