@extends('layouts.auth')

@section('content')
    <!-- ==== banner start ==== -->
    <section class="section cmn-banner" data-background="{{ asset('assets/images/banner/banner-bg.png') }}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cmn-banner__content wow fadeInUp" data-wow-duration="600ms" data-wow-delay="300ms">
                        <h3 class="h3">Sign In</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Sign In
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="anime">
            <img src="{{ asset('assets/images/anime-one.png') }}" alt="Image" class="one">
            <img src="{{ asset('assets/images/anime-two.png') }}" alt="Image" class="two">
        </div>
    </section>
    <!-- ==== / banner end ==== -->
    <section class="section authentication pb-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-6">
                    <div class="authentication__inner wow fadeInUp" data-wow-duration="600ms" data-wow-delay="300ms">
                        <div class="section__header text-start">
                            <h2 class="h3">{{ __('Welcome Back') }}</h2>
                            @if ($message = Session::get('success'))
                                <div class="alert alert-login alert-success">
                                    <strong><i class="fa fa-check-circle"></i> {{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('error'))
                                <div class="alert alert-login alert-danger">
                                    <strong><i class="fa fa-exclamation-triangle"></i> {{ $message }}</strong>
                                </div>
                            @endif
                        </div>
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="input-single">
                                <input
                                    class=" @error('email') is-invalid @enderror"
                                    type="email"
                                    name="email"
                                    id="email"
                                    autocomplete="off"
                                    placeholder="{{ __('Email Address') }}"
                                    required
                                >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="input-single">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    autocomplete="off"
                                    class="@error('password') is-invalid @enderror"
                                    placeholder="{{ __('Password') }}"
                                    required
                                >
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            @if (config('settings.oauth_login') == 'enabled')
                                <div class="divide">
                                    <p>OR</p>
                                </div>
                                <div class="authentic">
                                    @if(config('services.google.enable') == 'on')
                                        <button type="submit" class="btn btn--nonary">
                                            <img src="{{ asset('assets/images/google.png') }}" alt="Image">
                                            continue with google
                                        </button>
                                    @endif
                                    @if(config('services.facebook.enable') == 'on')
                                        <button type="submit" class="btn btn--nonary">
                                            <img src="{{ asset('assets/images/facebook.png') }}" alt="Image">
                                            continue with facebook
                                        </button>
                                    @endif
                                </div>
                            @endif

                            <div class="group-radio">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="createInCheck">
                                    {{ __('Keep me logged in') }}
                                </label
                                >
                            </div>
                            <div class="form-cta">
                                <button type="submit" aria-label="post comment" class="btn btn--ocotonary">
                                    {{ __('Login') }}
                                </button>
                                @if (config('settings.registration') == 'enabled')
                                    <p>
                                        Don't Have an account?
                                        <a href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                                    </p>
                                @endif
                                <p class="fs-10 text-muted pt-3">{{ __('By continuing, you agree to our') }} <a href="{{ route('terms') }}" class="text-info">{{ __('Terms and Conditions') }}</a> {{ __('and') }} <a href="{{ route('privacy') }}" class="text-info">{{ __('Privacy Policy') }}</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    @if (config('services.google.recaptcha.enable') == 'on')
        <!-- Google reCaptcha JS -->
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.google.recaptcha.site_key') }}"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.google.recaptcha.site_key') }}', {action: 'contact'}).then(function(token) {
                    if (token) {
                    document.getElementById('recaptcha').value = token;
                    }
                });
            });
        </script>
    @endif

@endsection
