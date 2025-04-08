<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- required meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- #favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ config('app.name') }}</title>
    <!-- #keywords -->
    <meta name="keywords" content="(keywords)">
    <!-- #description -->
    <meta name="description" content="AI Toolkit HTML5 Template">
    <!-- ==== css dependencies start ==== -->
    <!-- bootstrap five css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- font awesome six css -->
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <!-- glyphter css -->
    <link rel="stylesheet" href="{{ asset('assets/css/Glyphter.css') }}">
    <!-- nice select css -->
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <!-- magnific popup css -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- slick css -->
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!-- google font source -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <!-- ==== / css dependencies end ==== -->
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">

</head>
<body>
<!-- preloader -->
<div id="preloader">
    <div id="loader"></div>
</div>
<!-- ==== page wrapper start ==== -->
<div class="my-app">
    <!-- ==== header start ==== -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="nav">
                        <div class="nav__content">
                            <div class="nav__logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{ URL::asset('img/brand/logo.png') }}" alt="Logo">
                                </a>
                            </div>
                            <div class="nav__menu">
                                <ul class="nav__menu-items">
                                    <li class="nav__menu-item nav__menu-item--dropdown">
                                        <a href="javascript:void(0)" class="nav__menu-link nav__menu-link--dropdown">
                                            {{ __('Home') }}
                                        </a>
                                        <div class="nav__dropdown nav__dropdown--alt">
                                            <ul>
                                                <li class="atery">
                                                    <i class="fa-solid fa-moon"></i>
                                                    Dark
                                                </li>
                                                <li>
                                                    <a class="nav__dropdown-item hide-nav" href="index.html">
                                                        Voice Over
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    @if (config('frontend.pricing_section') == 'on')
                                        <li class="nav__menu-item">
                                            <a href="about-us.html" class="nav__menu-link hide-nav">
                                                {{ __('Prices') }}
                                            </a>
                                        </li>
                                    @endif
                                    @if (config('frontend.blogs_section') == 'on')
                                        <li class="nav__menu-item">
                                            <a href="about-us.html" class="nav__menu-link hide-nav">
                                                {{ __('Blogs') }}
                                            </a>
                                        </li>
                                    @endif
                                    @if (config('frontend.faq_section') == 'on')
                                        <li class="nav__menu-item">
                                            <a href="about-us.html" class="nav__menu-link hide-nav">
                                                {{ __('FAQs') }}
                                            </a>
                                        </li>
                                    @endif
                                    @if (config('frontend.contact_section') == 'on')
                                        <li class="nav__menu-item">
                                            <a href="about-us.html" class="nav__menu-link hide-nav">
                                                {{ __('Contact Us') }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <div class="social">
                                    <a href="index.html" aria-label="social media">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    <a href="index.html" aria-label="social media">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                    <a href="index.html" aria-label="social media">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                    <a href="index.html" aria-label="social media">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="nav__uncollapsed">
                                @if (Route::has('login'))
                                    <div class="nav__uncollapsed-item d-none d-md-flex">
                                        @auth
                                            <a href="{{ route('user.dashboard') }}" class="btn btn--secondary">
                                                {{ __('Dashboard') }}
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn--secondary">
                                                {{ __('Login') }}
                                            </a>
                                            @if (config('settings.registration') == 'enabled')
                                                @if (Route::has('register'))
                                                    <a href="{{ route('register') }}" class="btn btn--secondary">
                                                        {{ __('Sign Up') }}
                                                    </a>
                                                @endif
                                            @endif
                                        @endauth
                                    </div>
                                @endif
                                <button class="nav__bar d-block d-xl-none">
                                    <span class="icon-bar top-bar"></span>
                                    <span class="icon-bar middle-bar"></span>
                                    <span class="icon-bar bottom-bar"></span>
                                </button>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="backdrop"></div>
    </header>
    <!-- ==== / header end ==== -->
    <!-- ==== mobile menu start ==== -->
    <div class="mobile-menu d-block d-xl-none">
        <nav class="mobile-menu__wrapper">
            <div class="mobile-menu__header">
                <div class="nav__logo">
                    <a href="{{ url('/') }}" aria-label="home page" title="logo">
                        <img src="{{ URL::asset('img/brand/logo.png') }}" alt="Image">
                    </a>
                </div>
                <button aria-label="close mobile menu" class="close-mobile-menu">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="mobile-menu__list"></div>
            <div class="mobile-menu__social social">
                <a href="index.html" aria-label="social media">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="index.html" aria-label="social media">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="index.html" aria-label="social media">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
                <a href="index.html" aria-label="social media">
                    <i class="fa-brands fa-instagram"></i>
                </a>
            </div>
        </nav>
    </div>
    <div class="mobile-menu__backdrop"></div>
    <!-- ==== / mobile menu end ==== -->
    @include('layouts.flash')
    <!-- ==== authentication start ==== -->
    @yield('content')
    <!-- ==== / authentication end ==== -->
    <!-- ==== footer start ==== -->
    <footer class="footer section pb-0 footer-light">
        <div class="container">
            <div class="row items-gap-two">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="footer__single wow fadeInUp" data-wow-duration="600ms">
                        <h5 class="h5">our Products</h5>
                        <ul>
                            <li>
                                <a href="about-us.html"> AI Article Writer</a>
                            </li>
                            <li>
                                <a href="about-us.html"> Image background remover</a>
                            </li>
                            <li>
                                <a href="about-us.html"> audio voice over AI</a>
                            </li>
                            <li>
                                <a href="about-us.html"> Text Summarizer AI</a>
                            </li>
                            <li>
                                <a href="about-us.html">Art Generator</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="footer__single wow fadeInUp" data-wow-duration="600ms" data-wow-delay="200ms">
                        <h5 class="h5">About tech AI</h5>
                        <ul>
                            <li>
                                <a href="about-us.html">About</a>
                            </li>
                            <li>
                                <a href="blog.html">Blog</a>
                            </li>
                            <li>
                                <a href="sign-in.html">Sign in</a>
                            </li>
                            <li>
                                <a href="register.html">Register</a>
                            </li>
                            <li>
                                <a href="contact-us.html">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="footer__single wow fadeInUp" data-wow-duration="600ms" data-wow-delay="400ms">
                        <h5 class="h5">Use Cases</h5>
                        <ul>
                            <li>
                                <a href="use-case.html"> AI Voiceover for Videos</a>
                            </li>
                            <li>
                                <a href="use-case.html">E- Learning</a>
                            </li>
                            <li>
                                <a href="use-case.html"> All interactive Voice</a>
                            </li>
                            <li>
                                <a href="use-case.html"> Auto Accessibility</a>
                            </li>
                            <li>
                                <a href="use-case.html">YouTube Videos</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="footer__single wow fadeInUp" data-wow-duration="600ms" data-wow-delay="600ms">
                        <h5 class="h5">support</h5>
                        <ul>
                            <li>
                                <a href="about-us.html">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="about-us.html">Terms of Service</a>
                            </li>
                            <li>
                                <a href="about-us.html">Cookie Policy</a>
                            </li>
                            <li>
                                <a href="use-case.html">FAQ</a>
                            </li>
                            <li>
                                <a href="contact-us.html">Helpdesk</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="copyright-inner">
                        <div class="row items-gap align-items-center">
                            <div class="col-12 col-lg-3">
                                <div class="logo text-center text-lg-start">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ URL::asset('img/brand/logo-white.png') }}" alt="Image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <p class="text-center">
                                    Copyright &copy;
                                    <span id="copyYear"></span>
                                    <a href="{{ url('/') }}">techAI</a>
                                    . Designed By
                                    <a href="(autho-url.html">HugeBinary</a>
                                </p>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="social justify-content-center justify-content-lg-end">
                                    <a href="index.html" aria-label="social media">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    <a href="index.html" aria-label="social media">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                    <a href="index.html" aria-label="social media">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                    <a href="index.html" aria-label="social media">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="anime">
            <img src="{{ asset('assets/images/anime-one.png') }}" alt="Image" class="one">
            <img src="{{ asset('assets/images/anime-two.png') }}" alt="Image" class="two">
        </div>
    </footer>
    <!-- ==== / footer end ==== -->
</div>
<!-- ==== / page wrapper end ==== -->
<!-- scroll to top -->
<div class="progress-wrap">
    <svg
        class="progress-circle svg-content"
        width="100%"
        height="100%"
        viewBox="-1 -1 102 102"
    >
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
    </svg>
</div>
@include('layouts.footer-frontend')
</body>
</html>


