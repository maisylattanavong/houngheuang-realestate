<!doctype html>
<html lang="{{ app()->getLocale() }}">
@php
    use App\Models\Company;
    $aboutCompany = Company::first();
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
        {{ config('app.name') }}
    </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- flag --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
    <link href="https://fonts.cdnfonts.com/css/phetsarath" rel="stylesheet">


    <!-- slick slider link  -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" /> --}}

    {{-- typing effect  --}}
    {{-- <link rel="stylesheet" href="https://ankitjha2603.github.io/typingEffect/typing.css"> --}}

    {{-- light box gallery css  --}}
    {{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/lightbox.css') }}"> --}}

    {{-- navbar custom css  --}}
    {{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/contact-card.css') }}"> --}}

    {{-- fontawsome css  --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome-all.min.css') }}">

    {{-- show toast --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}"> --}}

    <!-- Toast CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Real Estate -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/bootstrap/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style_realestate.css') }}">

    <!-- Owl stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/owl-carousel/owl.theme.css') }}">
    <!-- Owl stylesheet -->

    <!-- slitslider -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/slitslider/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/slitslider/css/custom.css') }}" />
    <!-- slitslider -->

    <!-- End Real Estate -->

    {{-- Bootstrap --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}

        @livewireStyles
</head>

<body>

    <!-- preloader-end -->
    {{-- <div id="preloader">
        <div class="rasalina-spin-box"></div>
    </div> --}}

    <!-- Scroll-top -->
    {{-- <button class="scroll-top scroll-to-target" data-target="html">
        <i class="fas fa-angle-up"></i>
    </button> --}}

    <!-- Header Starts -->
    @include('frontend.body.header')
    <!--End Header  -->

    <!-- Content Start -->
    @yield('frontend')
    <!--End Content  -->


    <!-- Header Starts -->
    @include('frontend.body.footer')
    <!--End Header  -->

    {{-- <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script> --}}

    {{-- Boostrapt js for dropdown --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script> --}}
    {{-- bootstrap css and script --}}

    {{-- <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script> --}}

    {{-- slick slider js --}}
    {{-- <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/slick-slide.js') }}"></script> --}}


    {{-- typing effect script  --}}
    {{-- <script src="https://ankitjha2603.github.io/typingEffect/typing.js"></script> --}}

    {{-- main js  --}}
    {{-- <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/navbar.js') }}"></script> --}}

    {{-- gallery script  --}}
    {{-- <script src="{{ asset('frontend/assets/js/lightbox-plus-jquery.js') }}"></script> --}}

    {{-- get current url script  --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="{{ asset('frontend/assets/js/copy-current-url.js') }}"></script> --}}

    {{-- show toast --}}
    {{-- <script src="{{ asset('backend/assets/js/app.js') }}"></script> --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        @if (Session::has('message'))
            toastr.options.positionClass = 'toast-bottom-right';
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('mmessagesg') }} ");
                    break;
            }
        @endif
    </script>

    <!-- Messenger Chat Plugin Code -->
    {{-- <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "103131252146734");
        chatbox.setAttribute("attribution", "biz_inbox");
    </script> --}}

    <!-- Your SDK code -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v16.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- End Chat Plugin code -->

    <!-- Real Estate Script-->
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="{{ asset('frontend/assets/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/script_realestate.js') }}"></script>
    <!-- Owl stylesheet -->
    <script src="{{ asset('frontend/assets/owl-carousel/owl.carousel.js') }}"></script>
    <!-- Owl stylesheet -->

    <!-- slitslider -->
    <script type="text/javascript" src="{{ asset('frontend/assets/slitslider/js/modernizr.custom.79639.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/slitslider/js/jquery.ba-cond.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/slitslider/js/jquery.slitslider.js') }}"></script><!-- slitslider -->
    <!-- End Real Estate Script -->

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script> --}}

    @livewireScripts
</body>

</html>
