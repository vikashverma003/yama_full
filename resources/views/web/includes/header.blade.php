<header>
        <div class="navigation-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav class="navbar navbar-expand-md">

                            <a class="navbar-brand" href="{{url('/')}}">
                                <img src="{{asset('web/images/header_logo.png')}}" alt="">
                            </a>
                          <?php $data= Auth::user() ?>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto py-4 py-md-0">
                                    <li class="nav-item pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link" href="#">
                                            <img src="{{asset('web/images/request.png')}}" alt="" class="requestIcon">
                                            Request
                                        </a>

                                    </li>

                                      @if(@$data->role == '4')
                                    <li class="nav-item pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link toggleDiv">
                                            <img src="{{asset('web/images/thomas m.png')}}" alt="" class="profileIcon">
                                           {{$data->first_name}} {{$data->last_name}}
                                            <img src="{{asset('web/images/dropdown.png')}}" alt="" class="dropdownIcon">
                                        </a>
                                    </li>
                                </ul>

                                <div class="profileMenu">
                                    <ul>
                                         
                                        <li>
                                            <a href="#">
                                                Bookings/Request
                                            </a>
                                        </li>

                                       

                                  
                                        <li>
                                            <a href="#">
                                                My Account
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('owner/userlist')}}">
                                                My Users
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Contact us
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Help
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('logout')}}">
                                                Sign out
                                            </a>
                                        </li>
                                        @elseif(@$data->role =='2')
                                           <li class="nav-item pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link toggleDiv">
                                            <img src="{{asset('web/images/thomas m.png')}}" alt="" class="profileIcon">
                                           {{$data->first_name}} {{$data->last_name}}
                                            <img src="{{asset('web/images/dropdown.png')}}" alt="" class="dropdownIcon">
                                        </a>
                                    </li>
                                </ul>

                                <div class="profileMenu">
                                    <ul>
                                         
                                        
                                        <li>
                                            <a href="{{url('logout')}}">
                                                Sign out
                                            </a>
                                        </li>
                                         @elseif(@$data->role =='3')
                                            <li class="nav-item pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link toggleDiv">
                                            <img src="{{asset('web/images/thomas m.png')}}" alt="" class="profileIcon">
                                           {{$data->first_name}} {{$data->last_name}}
                                            <img src="{{asset('web/images/dropdown.png')}}" alt="" class="dropdownIcon">
                                        </a>
                                    </li>
                                </ul>

                                <div class="profileMenu">
                                    <ul>
                                         
                                        
                                        <li>
                                            <a href="{{url('logout')}}">
                                                Sign out
                                            </a>
                                        </li>
                                          @else
                                         <!-- <li>
                                            <a href="{{url('owner/signin')}}">
                                                Sign In
                                            </a>
                                        </li> -->
                                        <li class="nav-item pl-md-0 ml-0 ml-md-4">
                                        <a href="{{url('owner/signin')}}" class="nav-link">
                                            <img src="{{asset('web/images/thomas m.png')}}" alt="" class="profileIcon">
                                            Sign In
                                           
                                        </a>
                                    </li>

                                        @endif

                                    </ul>
                                </div>

                            </div>

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>