   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

     <script src="{{asset('web/js/main.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.toggleDiv').click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                $('.profileMenu').toggleClass("main");
            });
            // $('.registerDiv').click(function (e) {
            //   e.stopPropagation();
            // });
            $('body').click(function () {
                $('.profileMenu').removeClass("main");
            });
        });
    </script>

    <script>
        $('.news-slides').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            navText: ["<img src='web/images/ic_previous.png'>", "<img src='web/images/ic_next.png'>"],
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    </script>
    