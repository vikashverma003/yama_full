@extends('admin.layouts.app2')

@section('content')
<!-- header -->
       
       <section class="filters">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group search">
                            <img src="{{asset('colla/images/ic_search_.png')}}">
                            <input type="search" placeholder="Add your address or location" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option>Building Type</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option>Floor Number</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option>More Filters</option>
                                </select>
                            </div>
                        </div>
                    </div>                    
                </div>
           </div>
       </section>
       

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="search-food-listing">
                <!-- banner -->
                <div class="banner mb-4">
                    <img src="{{asset('colla/images/banner.png')}}">
                    <span>+25 more images</span>
                </div> 
                <!-- banner -->
                <div class="row">
                    <div class="col-md-8">
                        <h3>Yama Online Food Service</h3>
                        <p>Microbrewery, Casual Dining - European, Continental, North Indian, Finger Food, Sushi, Asian</p>
                        <p class="timing">Open now - <span>10:30am to 11:30pm (Today)</span></p>
                    </div>
                    <div class="col-md-4 text-right">
                        <h4 class="star-rating">4.5 <img src="{{asset('colla/images/star.png')}}"> <span>(418 Reviews)</span></h4>
                    </div>
                     <button type="button" class="btn btn-info" data-toggle="dropdown" >
                    <a href="{{ url('admin/food_ordering/cart/checkout') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">@if(session('cart')!==null)
{{ count(session('cart')) }} @endif</span></a>
                </button>
                </div>
                
                <div class="order-menu">
                    <div class="menu-category">
                        <h4>menu category</h4>
                        <ul>
                            <li><a href="#">Bestsellers (10)</a></li>
                            <li><a href="#">Yama Meals (19)</a></li>
                            <li><a href="#">Yama Sushi (15)</a></li>
                            <li><a href="#">Dim Sums (5)</a></li>
                            <li><a href="#">Burgers and Sandwiches (6)</a></li>
                            <li><a href="#">Bibimbap (3)</a></li>
                            <li><a href="#">Boatie Pizza (12)</a></li>
                            <li><a href="#">Starters (15)</a></li>
                            <li><a href="#">Indian Main Course (13)</a></li>
                            <li><a href="#">Planks (4)</a></li>
                            <li><a href="#">From The Sea (8)</a></li>
                            <li><a href="#">Poultry Meat (15)</a></li>
                            <li><a href="#">Sweet Endings (3)</a></li>
                            <li><a href="#">Salads (5)</a></li>
                            <li><a href="#">Soups (6)</a></li>
                        </ul>
                    </div>
                    <div class="menu-right-div">                    
                        <div class="our-food-menu row">
                            <div class="left col-md-5">
                                <h4>Our food menu</h4>
                                <p class="p-0">Track our order live 45 mins</p>                        
                            </div>
                            <div class="right col-md-7">
                                <div class="search mt-4">
                                    <img src="{{asset('colla/images/ic_search_.png')}}">
                                    <input type="search" placeholder="Search with menu" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="food-deliver-alert mt-4">
                            <span>Delivering food to 2nd floor, Yama Jardines del padregal</span>    
                            <span class="change-location">change location</span>                           
                        </div>
                        <div class="best-seller">
                            <h5>Bestseller</h5>
                            <label>
                                <input type="checkbox"> Veg only
                            </label>
                        </div>
                        
                        <div class="order-menu-tems">
                            <ul>
                                <li>
                                    <div class="order-menu-tems-box">
                                        <div class="row">
                                            <div class="col-lg-10 col-md-12">
                                                <div class="order-menu-tems-image">
                                                    <img src="{{asset('colla/images/menu-item.png')}}">
                                                </div>                                           
                                                <div class="order-menu-tems-detail">
                                                    <h3>Jerked Rub Cottage Cheese Fajitas</h3>
                                                        <p><span>$16.50</span> $14.50</p>
                                                        <h6>Cottage cheese steaks, char-grilled and rolled up in our whole wheat tortillas with onions, peppers and cilantro.</h6>                                                   
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-12">
                                                <div class="order-menu-tems-btn">
                                                    <a href="">+ Add</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="order-menu-tems-box">
                                        <div class="row">
                                            <div class="col-lg-10 col-md-12">
                                                <div class="order-menu-tems-image">
                                                    <img src="{{asset('colla/images/menu-item.png')}}">
                                                </div>                                           
                                                <div class="order-menu-tems-detail">
                                                    <h3>Jerked Rub Cottage Cheese Fajitas</h3>
                                                        <p><span>$16.50</span> $14.50</p>
                                                        <h6>Cottage cheese steaks, char-grilled and rolled up in our whole wheat tortillas with onions, peppers and cilantro.</h6>                                                   
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-12">
                                                <div class="order-menu-tems-btn">
                                                    <div class='ctrl'>
                                                      <div class='ctrl-button ctrl-button-decrement'>-</div>
                                                      <div class='ctrl-counter'>
                                                        <input class='ctrl-counter-input' maxlength='10' type='text' value='0'>
                                                        <div class='ctrl-counter-num'>0</div>
                                                      </div>
                                                      <div class='ctrl-button ctrl-button-increment'>+</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="order-menu-tems-box">
                                        <div class="row">
                                            <div class="col-lg-10 col-md-12">
                                                <div class="order-menu-tems-image">
                                                    <img src="{{asset('colla/images/menu-item.png')}}">
                                                </div>                                           
                                                <div class="order-menu-tems-detail">
                                                    <h3>Jerked Rub Cottage Cheese Fajitas</h3>
                                                        <p><span>$16.50</span> $14.50</p>
                                                        <h6>Cottage cheese steaks, char-grilled and rolled up in our whole wheat tortillas with onions, peppers and cilantro.</h6>                                                   
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-12">
                                                <div class="order-menu-tems-btn">
                                                    <a href="">+ Add</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="order-menu-tems-box">
                                        <div class="row">
                                            <div class="col-lg-10 col-md-12">
                                                <div class="order-menu-tems-image">
                                                    <img src="{{asset('colla/images/menu-item.png')}}">
                                                </div>                                           
                                                <div class="order-menu-tems-detail">
                                                    <h3>Jerked Rub Cottage Cheese Fajitas</h3>
                                                        <p><span>$16.50</span> $14.50</p>
                                                        <h6>Cottage cheese steaks, char-grilled and rolled up in our whole wheat tortillas with onions, peppers and cilantro.</h6>                                                   
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-12">
                                                <div class="order-menu-tems-btn">
                                                    <a href="">+ Add</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="order-menu-tems-box">
                                        <div class="row">
                                            <div class="col-lg-10 col-md-12">
                                                <div class="order-menu-tems-image">
                                                    <img src="{{asset('colla/images/menu-item.png')}}">
                                                </div>                                           
                                                <div class="order-menu-tems-detail">
                                                    <h3>Jerked Rub Cottage Cheese Fajitas</h3>
                                                        <p><span>$16.50</span> $14.50</p>
                                                        <h6>Cottage cheese steaks, char-grilled and rolled up in our whole wheat tortillas with onions, peppers and cilantro.</h6>                                                   
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-12">
                                                <div class="order-menu-tems-btn">
                                                    <a href="">+ Add</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

     
    @endsection