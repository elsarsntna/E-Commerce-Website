<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <!-- Font Icon -->
    <link rel="stylesheet"
        href="{{ asset('ecommerce/login/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('ecommerce/login/css/style.css') }}">
    <title>Register</title>

</head>

<body>

    <div class="main">

        <!-- Sing in  Form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">

                        <h2 class="form-title">Sign up</h2>
                        <div class="mb-2">

                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                        </div>
                        <form action="{{ route('customer.post_register') }}" method="POST" class="register-form"
                            id="register-form" novalidate="novalidate">
                            @csrf
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" autocomplete="off" name="name" id="name"
                                    placeholder="Username" />
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" autocomplete="off" name="email" id="email"
                                    placeholder="Your Email" />
                            </div>
                            <div class="form-group">
                                <label for="phone_number"><i class="zmdi zmdi-phone"></i></label>
                                <input type="phone_number" autocomplete="off" name="phone_number" id="phone_number"
                                    placeholder="Your phone" />
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="zmdi zmdi-pin"></i></label>
                                <input type="address" autocomplete="off" name="address" id="address"
                                    placeholder="Your address" />
                            </div>

                            {{-- <div class="form-group">
								<input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
								<label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
							</div> --}}
                            <div class="form-group form-button">
                                <button type="submit" class="btn_oren">Sign Up</button>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="{{ asset('ecommerce/login/images/signup-image.jpg') }}" alt="sing up image">
                        </figure>
                        <a href="{{ route('customer.login') }}" class="signup-image-link">I am already member</a>
                        <a href="{{ route('front.index') }}" class="signup-image-link">Back To Home</a>
                    </div>
                </div>
            </div>
        </section>
    </div>




    <!-- JS -->
    <script src="{{ asset('ecommerce/login/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('ecommerce/loginjs/main.js') }}"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
