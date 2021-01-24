@include('admin.includes.sidebar-skin')
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <div class="nav-link">
                <div class="profile-image">
                  @php
                    $user=Auth::user();
                  
                    @endphp

                  <img src="{{asset($user->profile_image)}}" alt="image" />
                  <span class="online-status online"></span> <!--change class online to offline or busy as needed-->
                </div>
                <div class="profile-name">
                  <p class="name">
                  @yield('user_name')
                  </p>
                  <p class="designation">
                  @yield('role')
                  </p>
                </div>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/dashboard')}}">
                <i class="icon-rocket menu-icon"></i>
                <span class="menu-title">Dashboard </span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>

            

            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/viewowner')}}">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Owner</span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>

            <!-- <li class="nav-item">
              <a class="nav-link" href="{{url('admin/viewadministrator')}}">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Administrator</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/viewcollaborators')}}">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Collaborators</span>
              </a>
            </li> -->

           <!--  <li class="nav-item">
              <a class="nav-link" href="{{url('admin/inventory')}}">
                <i class="icon-rocket menu-icon"></i>
                <span class="menu-title">valet </span>
              </a>
            </li> -->
            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#page-layoutsss" aria-expanded="false" aria-controls="page-layoutss">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Building</span>
              </a>
              <div class="collapse" id="page-layoutsss">
                <ul class="nav flex-column sub-menu">
                  <!--<li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/add_building')}}">Add Building</a>
                  </li>-->
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/building_list')}}">Manage Building</a>
                  </li>
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/building_floor_listing')}}">Floor Listing</a>
                  </li>
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/space_details')}}">Space Listing</a>
                  </li>
                  <!--<li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/parking_space_listing')}}">Add/Modify Parking</a>
                  </li>-->
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#page-layoutssss" aria-expanded="false" aria-controls="page-layoutss">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Vendor</span>
              </a>
              <div class="collapse" id="page-layoutssss">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/vendor')}}">Manage Vendors</a>
                  </li>
                </ul>
              </div>
            </li>
             <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#page-layoutssssk" aria-expanded="false" aria-controls="page-layoutss">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Food Ordering</span>
              </a>
              <div class="collapse" id="page-layoutssssk">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/food_ordering')}}">Order Food</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#page-layoutsssskc" aria-expanded="false" aria-controls="page-layoutss">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Click Image</span>
              </a>
              <div class="collapse" id="page-layoutsssskc">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/vendor/random/image')}}">Click Image</a>
                  </li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#page-layoutsf" aria-expanded="false" aria-controls="page-layoutss">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Master</span>
              </a>
              <div class="collapse" id="page-layoutsf">
                <ul class="nav flex-column sub-menu">
                  <!--<li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/add_building')}}">Add Building</a>
                  </li>-->
                 <!-- <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/group')}}">Manage Food Groups</a>
                  </li> -->
                  <!-- <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/food_item')}}">Manage Food Menu</a>
                  </li> -->
                  
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/spacetype')}}">Manage Space Type</a>
                  </li>
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/group')}}">Manage Food Group</a>
                  </li>
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/inventory')}}">Manage Food Menu</a>
                  </li>
                </ul>
              </div>
            </li>


            <!-- <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#page-layoutss" aria-expanded="false" aria-controls="page-layoutss">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Doctor</span>
              </a>
              <div class="collapse" id="page-layoutss">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/doctors')}}">Save Doctors</a>
                  </li>
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/approveddoctors')}}">Approved Doctors</a>
                  </li>

                </ul>
              </div>
            </li> -->

           <!-- <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#survey-layouts" aria-expanded="false" aria-controls="page-layouts">
                <i class="mdi mdi-settings menu-icon"></i>
                <span class="menu-title">Settings</span>
               
              </a>
              <div class="collapse" id="survey-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/permotionsList')}}">Permotions</a>
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/language')}}">Language</a>
                  </li>

                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/video')}}">Video</a>
                  </li>
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/disease')}}">Disease</a>
                  </li>
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/services')}}">Services</a>
                  </li>
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/administrator')}}">Root of administrator</a>
                  </li>
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/paymentPercentage')}}">Payment Percentage</a>
                  </li>
                   <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/presentation')}}">Presentation</a>
                  </li>

                </ul>
              </div>
            </li> -->

          <!--   <li class="nav-item">
              <a class="nav-link" href="{{url('admin/viewPayment')}}">
                <i class="icon-briefcase menu-icon"></i>
                <span class="menu-title">Payment Transaction </span>
              </a>
            </li> -->

              
          </ul>
        </nav>
        <!-- partial -->