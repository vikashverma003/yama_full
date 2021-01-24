
@extends('admin.layouts.app2')

@section('content')
<div class="checkout-page">
    <div class="container">
        <div class="food-deliver-alert mb-4">
            <span>Delivering food to 2nd floor, Yama Jardines del padregal</span>    
            <span class="change-location">change location</span>                           
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="your-cart">
                    <h3></h3>
                    <p></p>
                     <?php $total = 0 ?>
                     <div class="order-menu-tems">
                            <ul>

                                 @if(session('cart'))
                                 @foreach(session('cart') as $id => $details)
                                <?php $total += $details['price'] * $details['quantity'] ?>

                                <li>
                                    <div class="order-menu-tems-box">
                                        <div class="row">
                                            <div class="col-lg-10 col-md-12">
                                                <div class="order-menu-tems-image">
                                                    <!-- <img src="{{asset('colla/images/menu-item.png')}}"> -->
                                                    <img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive">
                                                    
                                                </div>                                           
                                                <div class="order-menu-tems-detail">
                                                    <h3>{{ $details['name'] }}</h3>
                                                        <p><span>$16.50</span> ${{ $details['price'] }}</p>
                                                        <h6>{{ $details['name'] }}</h6>                                                   
                                                </div>
                                            </div>
                                              <!--  <button  class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>--> 

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
                                @endforeach
                                @endif
                               <!-- <li>
                                    <div class="order-menu-tems-box">
                                        <div class="row">
                                            <div class="col-lg-10 col-md-12">
                                                <div class="order-menu-tems-image">
                                                    <img src="{{asset('colla/images/menu-item.png')}}">
                                                </div>                                           
                                                <div class="order-menu-tems-detail">
                                                    <h3>Jerked Rub Cottage Cheese Fajitas</h3>
                                                        <p><span>$16.50</span> $14.50</p>                                                  
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
                                </li>-->
                            </ul>
                        </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cart-detail">
                    <h4>Order Details</h4>
                    <p>Total items Price <span>{{$total}}</span></p>
                    <p class="credit-points">Credit Points <span>$-5.00</span></p>
                    <p>VAT <span>%1.50</span></p>
                    <p class="total">Total <span>$53.50</span></p>                  
                    <label>
                        <input type="checkbox"> Total credit amount ($5.00)
                    </label>
                    
                    <button type="button" class="orange-btn">Make Payment</button>
                </div>
            </div>
        </div>
    </div>
</div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('admin/food_ordering/cart/remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });

    </script>
    @endsection