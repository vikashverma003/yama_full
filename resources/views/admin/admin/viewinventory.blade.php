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
                <a href="{{url('admin/addInventory')}}" class="btn addLangBtn">
                  Add FOOD ITEM
                          </a>
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Series</th>
                            <th width="5%">Item Name</th>
                            <th width="5%">Hide Status</th>
                            <th width="10%">Barcode</th>
                            <th width="20%">Group Item</th>
                            <th width="20%">Sub Group</th>
                            <th width="20%">Price</th>
                            <th width="10%">Actions</th>
                        </tr>
                      </thead>

                      <tbody>
                       @php $i=0; @endphp
                        @foreach($group as $user)
                        @php $i++; @endphp
                        <tr>
                          <td> @php echo $i; @endphp</td>
                          
                             <td>{{$user->item_name}}</td>
                             <td>
                                <label class="badge {{$user->hide == '0' ? 'badge-success' : 'badge-danger'}}"> {{$user->hide == '0' ? 'Hide' : 'Unhide'}}</label>
                            </td>
                        
                           
                            <td>{{$user->barcode}}</td>
                            <td>{{$user->item_group}}</td>
                            <td>{{$user->sub_group}}</td>
                            <td>{{$user->sale_price}}</td>
                        
                            <td>
                              <ul class="navbar-nav">
                                <li class="nav-item dropdown d-none d-lg-flex">
                                  <a class="nav-link  nav-btn" id="actionDropdown" href="#" data-toggle="dropdown">
                                    <button class="btn btn-outline-primary">Action</button>
                                  </a>
                                  <div class="dropdown-menu navbar-dropdown" aria-labelledby="actionDropdown">
                                    <!--  <a href="{{route('hide',$user->id)}}" class="dropdown-item" >Hide</a>
                                     -->

                                      @if($user->hide == '0')
                                      <a href="#" class="dropdown-item" onclick="block_confirmation('{{$user->id}}','Hide')">Hide</a>
                                    @else
                                    <a href="#" class="dropdown-item" onclick="block_confirmation('{{$user->id}}','Unhide')"> Unhide</a>
                                    @endif
                                   
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
           url: "{{route('hide')}}?user_id="+id+"&status="+status,
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