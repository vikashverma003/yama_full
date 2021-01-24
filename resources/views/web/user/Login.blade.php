<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>


    <link rel="shortcut icon" href="images/fav.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <link rel="stylesheet" href=" {{asset('web/css/style.css')}}">
</head>

<body>
    <section class="emailSection">
        <div class="container">
             @if (\Session::has('error'))
                    <div class="alert alert-danger">
                       {!! \Session::get('error') !!}
                    </div>
                  @endif
            <div class="row">
                <div class="offset-md-4 col-md-4">
                   <form action="{{url('loginUser')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
                      @csrf
                    <img src="{{asset('web/images/logo.png')}}" alt="">
                     
                    <input type="text" placeholder="Enter your email" name="email" required="">
                    <input type="password" placeholder="Enter your password" name="password" required="">

                    <button type="submit">Continue</button>
                    </form>
                    <span>By logging in you agree to our <a href="#">Terms of Service</a> & <a href="#">Privacy
                            Policy</a> </span>

                </div>
            </div>
        </div>
    </section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script src="/js/main.js"></script>
</body>

</html>