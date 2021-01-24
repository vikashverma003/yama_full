
@extends('web.layouts.app')
@section('title', __('messages.header_titles.HOME'))

@section('content')
 


<section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
      <?php $info=Auth::user(); ?>
                    <div class="profile-tabs">
                        <img src="{{asset('web/images/image.png')}}" alt="" class="profileImg">
                        <button type="button" class="updateBtn">Updated Photo</button>
                        <div class="line-bottom"></div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" href="#viewProfile" role="tab" data-toggle="tab">
                                    View Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#myUsers" role="tab" data-toggle="tab">
                                    My Users (Employees)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#changePassword" role="tab" data-toggle="tab">
                                    Change Password
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#notification" role="tab" data-toggle="tab">
                                    Notification settings
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="col-md-8">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade " id="viewProfile">

                            <div class="profileDiv">
                                <h1>{{$info->first_name}} {{$info->last_name}}</h1>
                                <button type="button" class="editProfileBtn">Edit Profile</button>
                                <h2>Owner</h2>
                                <div class="creditsDiv">

                                    <h6> <span>3025</span>Available Credits</h6>
                                    <button type="button" class="creditsBtn">Buy More Credits</button>
                                </div>
                                <div class="line-bottom"></div>
                                <h3>Email</h3>
                                <h4>{{$info->email}}</h4>

                                <h3>Phone</h3>
                                <h4>+91 01234 56789</h4>

                                <h3>Address</h3>
                                <h4>Plot no. 5, CDCL building Chandigarh, India, 160062</h4>

                                <div class="line-bottom"></div>

                                <h5>Other information</h5>
                                <h3>Bio</h3>
                                <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur,
                                    adipisci velit</p>
                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane fade show active" id="myUsers">
                            <div class="myUsersDiv">
                                <h1>My Users (Employees)</h1>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="totalDiv">
                                            <h5>
                                                Total Collaborators
                                                <?php $pos=0 ?>
                                                @foreach($data as $user)
                                                <?php  $pos++ ?>
                                                @endforeach
                                                 
                                                <strong>{{$pos}}</strong>
                                                <img src="{{asset('web/images/total_collaborators.png')}}" alt="">
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="totalDiv">
                                            <h5>
                                                Total Administrator
                                                 <?php $posts=0 ?>
                                                @foreach($datas as $users)
                                                <?php  $posts++ ?>
                                                @endforeach
                                                <strong>{{$posts}}</strong>
                                                <img src="{{asset('web/images/total_administrator.png')}}" alt="">
                                            </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="myUsersTabs">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#collaborators" role="tab"
                                                data-toggle="tab">
                                                Collaborators
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#administrator" role="tab" data-toggle="tab">
                                                Administrator
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- <button type="button" class="addUserBtn">+ Add New User</button> -->
                                    <a href="#" class="addUserBtn" data-toggle="modal" data-target="#addUserModal">+ Add
                                        New User</a>

                                    <!-- Add New User modal -->
                                    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog"
                                        aria-labelledby="basicModal" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-body">
                                                    <h2>Add New User</h2>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <img src="{{asset('web/images/ic_popup_close.png')}}" alt="">
                                                    </button>
                                                   <form action="{{url('owner/createUser')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                                                     @csrf
                                                    <h4>Enter User (Employees) personal details </h4>
                                                    <img src="{{asset('web/images/ic_upload_user.png')}}" alt="" class="uploadUserImg">
<!-- <input type='file' id="imgInp" />
  <img id="blah" src="#" alt="your image" class="uploadUserImg" /> -->
                                                    <div style="position: relative;display: inline-block;">
                                                        <input type="file" name="image" id="imageUpload">
                                                        <label for="imageUpload" class="uploadImgLabel">
                                                            + Upload User Image
                                                        </label>
                                                    </div>
                                                   <!--  <input type="file" name="image" class="uploadImgBtn">
                                                        + Upload User Image
                                                    </input> -->

                                                    <div class="row mt-4 mb-4">
                                                        <div class="col-md-6">
                                                            <h3>First Name</h3>
                                                            <input type="text" placeholder="First Name" name="f_name"
                                                                class="user-input" required="">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h3>Last Name</h3>
                                                            <input type="text" placeholder="Last Name"  name="l_name"
                                                                class="user-input" required="">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h3>Email address</h3>
                                                            <input type="text" placeholder="howe.marcelle@yahoo.com" name="email"
                                                                class="user-input" required="">
                                                                <input type="hidden" name="id" value="{{$info->id}}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h3>Contact Number</h3>
                                                            <input type="text" placeholder="+91  01234 56789" name="phone_number" 
                                                                class="user-input" required="">
                                                        </div>
                                                    </div>

                                                    <h1>Platform Permission</h1>
                                                   <!--  <div class="row mb-5">
                                                        <div class="col-md-4 d-flex">
                                                            <input type="radio" id="checkbox1" value="2" name="role" required="">
                                                            <label for="checkbox1" >
                                                                Make Collaborators
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4 d-flex">
                                                            <input type="radio" id="checkbox2" value="3" name="role" required="">
                                                            <label for="checkbox2">
                                                                Make Administrator
                                                            </label>
                                                        </div>
                                                    </div> -->

                                                    <div class="row mb-5">
                                                        <div class="col-md-4 d-flex">
                                                            <input type="radio" value="2" id="radio1" name="role">
                                                            <label for="radio1">
                                                                Make Collaborators
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4 d-flex">
                                                            <input type="radio" value="3" id="radio2" name="role">
                                                            <label for="radio2">
                                                                Make Administrator
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="continueBtn">Continue</button>
                                                </form>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade show active" id="collaborators">

                                        <table>
                                            @php $i=0; @endphp
                                             @foreach($data as $user)
                                             @php $i++; @endphp
                                            <tr>
                                                <td class="pr-3">
                                                    @php echo $i; @endphp
                                                </td>
                                                <td>
                                                    <img src="{{$user->profile_image}}" alt="" class="userImg">
                                                    {{$user->first_name}}{{$user->last_name}}
                                                </td>
                                                <td>
                                                    {{$user->email}}
                                                </td>
                                                <td>
                                                    {{$user->phone_number}}
                                                </td>
                                                <td>
                                                    {{$user->created_at}}
                                                </td>
                                                <td>
                                                    <button type="button" class="editBtn">
                                                        <img src="{{asset('web/images/ic_edit.png')}}" alt="">
                                                    </button>
                                                    <button type="button" class="moreBtn">
                                                        <img src="{{asset('web/images/ic_more.png')}}" alt="">
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </table>

                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="administrator">
                                       <table>
                                            @php $i=0; @endphp
                                             @foreach($datas as $user)
                                             @php $i++; @endphp
                                            <tr>
                                                <td class="pr-3">
                                                   @php echo $i; @endphp
                                                </td>
                                                <td>
                                                    <img src="{{$user->profile_image}}" alt="" class="userImg">
                                                    {{$user->first_name}}{{$user->last_name}}
                                                </td>
                                                <td>
                                                    {{$user->email}}
                                                </td>
                                                <td>
                                                    {{$user->phone_number}}
                                                </td>
                                                <td>
                                                    {{$user->created_at}}
                                                </td>
                                                <td>
                                                    <button type="button" class="editBtn">
                                                        <img src="{{asset('web/images/ic_edit.png')}}" alt="">
                                                    </button>
                                                    <button type="button" class="moreBtn">
                                                        <img src="{{asset('web/images/ic_more.png')}}" alt="">
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="changePassword">
                            Change Password
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="notification">
                            Notification settings
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
    <script type="text/javascript">
        
        function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#imgInp").change(function() {
  readURL(this);
});
    </script>

    