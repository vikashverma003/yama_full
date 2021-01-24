@extends('web.layouts.app')
@section('title', __('messages.header_titles.HOME'))

@section('content')


<section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="weatherDiv">
                        <img src="{{asset('web/images/ic_weather.png')}}" alt="">
                        <h3>
                            27
                            <sup>
                                &#8451;
                            </sup>
                        </h3>
                        <h2>/</h2>
                        <h3>
                            81
                            <sup>
                                &#8457;
                            </sup>
                        </h3>

                        <h4>25 Diciembre, Jueves
                            <span>Parcialmente nublado Humedad 65%</span>
                        </h4>
                    </div>
                    <h2>Eventos</h2>
                    <ul class="eventosList">
                        <li>
                            <img src="{{asset('web/images/eventos.png')}}" alt="" class="eventosImg">
                            <h3>Presentation AVASA</h3>
                            <h4>10:00 - 13:00 hrs, 25 Dec, 2020</h4>
                            <h5>AVASA</h5>
                            <h6>Terraza de eventos</h6>
                            <button type="button" class="viewEventsBtn">
                                View Events
                                <img src="{{asset('web/images/ic_next_orange.png')}}" alt="">
                            </button>
                        </li>
                        <li>
                            <img src="{{asset('web/images/eventos.png')}}" alt="" class="eventosImg">
                            <h3>Presentation AVASA</h3>
                            <h4>10:00 - 13:00 hrs, 25 Dec, 2020</h4>
                            <h5>AVASA</h5>
                            <h6>Terraza de eventos</h6>
                            <button type="button" class="viewEventsBtn">
                                View Events
                                <img src="{{asset('web/images/ic_next_orange.png')}}" alt="">
                            </button>
                        </li>
                        <li>
                            <img src="{{asset('web/images/eventos.png')}}" alt="" class="eventosImg">
                            <h3>Presentation AVASA</h3>
                            <h4>10:00 - 13:00 hrs, 25 Dec, 2020</h4>
                            <h5>AVASA</h5>
                            <h6>Terraza de eventos</h6>
                            <button type="button" class="viewEventsBtn">
                                View Events
                                <img src="{{asset('web/images/ic_next_orange.png')}}" alt="">
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="offset-md-1 col-md-5">
                    <img src="{{asset('web/images/image.png')}}" alt="" class="spaceImg">
                </div>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{asset('web/images/ic_easilybook.png')}}" alt="">
                    <h2>Easily book space on rent</h2>
                    <p>Neque porro quisquam est qui dolorem ipsum quia dolo amet consectetur
                        adipisci velit.</p>
                </div>
                <div class="col-md-4">
                    <img src="{{asset('web/images/illustration_food.png')}}" alt="">
                    <h2>Order your favorite food</h2>
                    <p>Neque porro quisquam est qui dolorem ipsum quia dolo amet consectetur
                        adipisci velit.</p>
                </div>
                <div class="col-md-4">
                    <img src="{{asset('web/images/illustration_parking.png')}}" alt="">
                    <h2>Parking spot made easy</h2>
                    <p>Neque porro quisquam est qui dolorem ipsum quia dolo amet consectetur
                        adipisci velit.</p>
                </div>
            </div>
            <button type="button">Get Started</button>
        </div>
    </section>

    <section class="news-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-6">
                    <h2>News</h2>

                    <div class="owl-carousel owl-theme news-slides">
                        <div class="item">
                            <img src="{{asset('web/images/news.png')}}" class="news-img">
                            <h2>The Mexican Healthy Products Summit</h2>
                            <p>From Healthyproductssummit.com: Start Selling in Mexico! Top Mexican Buyers and
                                Distributors to Meet Healthy Products Suppliers in Puerto Vallarta, Jan. 24-26, 2020 7th
                                Annual The Mexican Healthy Products Summit Join us at the ...</p>
                        </div>
                        <div class="item">
                            <img src="{{asset('web/images/news.png')}}" class="news-img">
                            <h2>The Mexican Healthy Products Summit 2</h2>
                            <p>From Healthyproductssummit.com: Start Selling in Mexico! Top Mexican Buyers and
                                Distributors to Meet Healthy Products Suppliers in Puerto Vallarta, Jan. 24-26, 2020 7th
                                Annual The Mexican Healthy Products Summit Join us at the ...</p>
                        </div>
                        <div class="item">
                            <img src="{{asset('web/images/news.png')}}" class="news-img">
                            <h2>The Mexican Healthy Products Summit 3</h2>
                            <p>From Healthyproductssummit.com: Start Selling in Mexico! Top Mexican Buyers and
                                Distributors to Meet Healthy Products Suppliers in Puerto Vallarta, Jan. 24-26, 2020 7th
                                Annual The Mexican Healthy Products Summit Join us at the ...</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection