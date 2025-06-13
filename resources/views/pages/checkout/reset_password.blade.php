<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>

   {{-- Reset Password --}}
     <!-- Font Icon -->
    <link rel="stylesheet" href="{{asset('frontend/login-checkout/fonts/material-icon/css/material-design-iconic-font.min.css')}}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{asset('frontend/login-checkout/css/style.css')}}">
    {{--Reset Password --}}
</head>
<body>

    <div class="main">

        <!-- Sing in  Form -->
        <section class="sign-in">
             @if(session()->has('message'))
             <div class="alert alert-success">
                {!! session()->get('message') !!}
            </div>
            @elseif(session()->has('error'))
            <div class="alert alert-danger">
                {!! session()->get('error') !!}
            </div>
            @endif
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image ">
                        <figure><img src="{{asset('frontend/login-checkout/images/signin-image.jpg')}}" alt="sing up image"></figure>
                        <a style="width: 100px;float: left;text-align: center;" href="{{URL::to('/login-checkout')}}" class="signup-image-link">Có tài khoản</a>
                        <a href="{{URL::to('/trang-chu')}}" class="signup-image-link">Trở về trang chủ</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Reset Password</h2>
                        <form  action="{{URl::to('/send-reset')}}" method="POST" class="register-form" id="login-form">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="email" name="email_account" id="your_name" placeholder="Nhập địa chỉ email của bạn"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Reset Password"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

       {{-- Login checkout --}}
    <script src="{{asset('frontend/login-checkout/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/login-checkout/js/main.js')}}"></script>
    {{-- End Login checkout --}}
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>