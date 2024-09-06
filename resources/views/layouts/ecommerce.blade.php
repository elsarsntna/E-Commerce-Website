<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!-- title -->
    @yield('title')

    <!-- favicon -->
    {{-- <link rel="shortcut icon" type="image/png" href="{{ asset('ecommerce/img/favicon.png')}}"> --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{ asset('ecommerce/css/all.min.css') }}">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('ecommerce/bootstrap/css/bootstrap.min.css') }}">
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('ecommerce/css/owl.carousel.css') }}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{ asset('ecommerce/css/magnific-popup.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('ecommerce/css/animate.css') }}">
    <!-- mean menu css -->
    <link rel="stylesheet" href="{{ asset('ecommerce/css/meanmenu.min.css') }}">
    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('ecommerce/css/main.css') }}">
    <!-- responsive -->
    <link rel="stylesheet" href="{{ asset('ecommerce/css/responsive.css') }}">

</head>

<body>

    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->

    <!-- header -->
    <div class="top-header-area" id="sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center">
                    <div class="main-menu-wrap">
                        <!-- logo -->
                        <div class="site-logo">
                            <a href="{{ route('front.index') }}">
                                <img src="{{ asset('ecommerce/img/logo2.png') }}" alt="">
                            </a>
                        </div>
                        <!-- logo -->

                        <!-- menu start -->
                        <nav class="main-menu">
                            <ul>
                                <li
                                    class="current-list-item {{ request()->routeIs('front.product') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('front.index') }}">Home</a>
                                </li>
                                <li class="current-list-item {{ request()->routeIs('front.index') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('front.product') }}">Product</a>
                                </li>
                                <li>
                                    <div class="header-icons">
                                        <a class="mobile-hide search-bar-icon" href="#"><i
                                                class="fas fa-search"></i></a>


                                        @if (auth()->guard('customer')->check())
                                            <!-- Jika sudah login, arahkan ke dashboard -->
                                            <a class="shopping-cart" href="{{ route('front.list_cart') }}">
                                                <i class="fas fa-shopping-cart"></i>
                                                @if (session()->has('cart_total'))
                                                    <span>{{ session('cart_total') }}
                                                    @else
                                                        0
                                                @endif
                                                </span>
                                            </a>
                                            <a class="user-cart" href="{{ route('customer.dashboard') }}"><i
                                                    class="fas fa-user"></i></a>
                                            <a class="user-cart" href="{{ route('customer.logout') }}"><i
                                                    class="fas fa-sign-out-alt"></i></a>
                                        @else
                                            <!-- Jika belum login, arahkan ke halaman login -->
                                            <a class="user-cart" href="{{ route('customer.login') }}"><i
                                                    class="fas fa-user"></i></a>
                                        @endif


                                    </div>
                                </li>
                            </ul>
                        </nav>
                        <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
                        <div class="mobile-menu"></div>
                        <!-- menu end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end header -->

    <!-- search area -->
    <div class="search-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="close-btn"><i class="fas fa-window-close"></i></span>
                    <div class="search-bar">
                        <div class="search-bar-tablecell">
                            <h3>Search For:</h3>
                            <form action="{{ route('front.product') }}" method="get">
                                <input type="text" autocomplete="off" placeholder="Keywords" name="q"
                                    value="{{ request()->q }}">
                                <button type="submit">Search <i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end search area -->

    @yield('content')



    <!-- footer -->
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-box about-widget">
                        <h2 class="widget-title">About us</h2>
                        <p>

                            We offer a diverse collection of fashion, ranging from everyday wear to statement pieces,
                            prioritizing quality and customer satisfaction, allowing you to confidently explore the
                            latest trends and discover your unique style with us.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-box get-in-touch">
                        <h2 class="widget-title">Get in Touch</h2>
                        <ul>
                            <li>JL. Rahasia PT.BAHAGIA JAWA BARAT NO.001</li>
                            <li>elsarstna12@gmail.com</li>
                            <li>(021)12345678</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-box pages">
                        <h2 class="widget-title">Pages</h2>
                        <ul>
                            <li><a href="{{ route('front.index') }}">Home</a></li>
                            <li><a href="{{ route('front.product') }}">Shop</a></li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end footer -->



    <!-- jquery -->
    <script src="{{ asset('ecommerce/js/jquery-1.11.3.min.js') }}"></script>
    <!-- bootstrap -->
    <script src="{{ asset('ecommerce/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- count down -->
    <script src="{{ asset('ecommerce/js/jquery.countdown.js') }}"></script>
    <!-- isotope -->
    <script src="{{ asset('ecommerce/js/jquery.isotope-3.0.6.min.js') }}"></script>
    <!-- waypoints -->
    <script src="{{ asset('ecommerce/js/waypoints.js') }}"></script>
    <!-- owl carousel -->
    <script src="{{ asset('ecommerce/js/owl.carousel.min.js') }}"></script>
    <!-- magnific popup -->
    <script src="{{ asset('ecommerce/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- mean menu -->
    <script src="{{ asset('ecommerce/js/jquery.meanmenu.min.js') }}"></script>
    <!-- sticker js -->
    <script src="{{ asset('ecommerce/js/sticker.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('ecommerce/js/main.js') }}"></script>
    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };
    </script>

    <script>
        window.onload = function() {
            window.history.forward();
            setTimeout("preventBack()", 0);
        };

        function preventBack() {
            window.history.forward();
        }
    </script>
    @yield('js')
</body>

</html>
