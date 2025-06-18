<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from themeturn.com/tf-db/edumel-demo/edumel/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 01 Dec 2022 09:47:23 GMT -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="Edumel- Education Html Template by dreambuzz">
    <meta name="keywords"
        content="education,edumel,instructor,lms,online,instructor,dreambuzz,bootstrap,kindergarten,tutor,e learning">
    <meta name="author" content="dreambuzz">

    <title>iaaconference</title>

    <!-- Mobile Specific Meta-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap/bootstrap.css')}}">
    <!-- Iconfont Css -->
    <link rel="stylesheet" href="{{asset('assets/vendors/awesome/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/flaticon/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/gilroy/font-gilroy.html')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/magnific-popup/magnific-popup.css')}}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{asset('assets/vendors/animate-css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/animated-headline/animated-headline.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/owl/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/owl/assets/owl.theme.default.min.css')}}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/css/woocomerce.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">

</head>

<body id="top-header">
    <header class="header-style-1">
        <div class="header-topbar topbar-style-2">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-xl-8 col-lg-6 col-md-12">
                        <div class="header-contact text-center text-lg-start d-none d-sm-block">
                            <ul class="list-inline">
                                @php
                                    $primary_menus = App\Models\Primary_menu::where('is_published',1)
                                    ->where('menu_id',1)
                                    ->get()
                                @endphp
                                @foreach ($primary_menus as $primary_menu)
                                    <li class="list-inline-item">
                                        <span class="text-color me-2"><i class="fa fa-{{$primary_menu->name}}"></i></span><a
                                            href="{{$primary_menu->content}}"> {{$primary_menu->content}}</a>
                                    </li>
                                @endforeach
                            
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-navbar navbar-sticky" style="border-bottom: 4px solid #10497E;">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="site-logo">
                        @php
                            $logos =  App\Models\Logo::where('is_published',1)
                            ->where('name','iaa logo')
                            ->get()
                        @endphp
                        <a href="index.html">
                            @foreach ($logos as $logo)
                            <img src="/storage/{{$logo->photo}}" alt="{{$logo->name}}" class="img-fluid" />
                            @endforeach
                        </a>
                    </div>

                    <div class="offcanvas-icon d-block d-lg-none">
                        <a href="#" class="nav-toggler"><i class="fal fa-bars"></i></a>
                    </div>
                    @include('includes.nav')
                </div>
            </div>
        </div>
    </header>
    <!--====== Header End ======-->
        @yield('content')
    <!-- Footer section start -->
    <section class="footer-3">
        <div class="footer-btm text-center" style="border-top: 4px solid #10497E; background-color: #fff;">
            <div class="container text-center">
                <div class="row ">
                    <p class="mb-0 copyright" style="padding-bottom: 20px;">Copyright © 2024 Institute of Accountancy
                        Arusha. All rights reserved</p>
                </div>
            </div>
        </div>

        <div class="fixed-btm-top">
            <a href="#top-header" class="js-scroll-trigger scroll-to-top"><i class="fa fa-angle-up"></i></a>
        </div>

    </section>
    <!-- Footer section End -->





    <!--
    Essential Scripts
    =====================================-->

    <!-- Main jQuery -->
    <script src="{{asset('assets/vendors/jquery/jquery.js')}}"></script>
    <!-- Bootstrap 5:0 -->
    <script src="{{asset('assets/vendors/bootstrap/popper.min.js')}}"></script>
    <script src="{{asset('assets/vendors/bootstrap/bootstrap.js')}}"></script>
    <!-- Counterup -->
    <script src="{{asset('assets/vendors/counterup/waypoint.js')}}"></script>
    <script src="{{asset('assets/vendors/counterup/jquery.counterup.min.js')}}"></script>
    <!--  Owl Carousel -->
    <script src="{{asset('assets/vendors/owl/owl.carousel.min.js')}}"></script>
    <!-- Isotope -->
    <script src="{{asset('assets/vendors/isotope/jquery.isotope.js')}}"></script>
    <script src="{{asset('assets/vendors/isotope/imagelaoded.min.js')}}"></script>
    <!-- Animated Headline -->
    <script src="{{asset('assets/vendors/animated-headline/animated-headline.js')}}"></script>
    <!-- Magnific Popup -->
    <script src="{{asset('assets/vendors/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

    <script src="{{asset('assets/js/script.js')}}"></script>

</body>

<!-- Mirrored from themeturn.com/tf-db/edumel-demo/edumel/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 01 Dec 2022 09:48:03 GMT -->

</html>
