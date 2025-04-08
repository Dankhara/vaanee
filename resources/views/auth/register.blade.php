@extends('layouts.auth')

@section('css')
@endsection

@section('content')
    @if (config('frontend.maintenance') == 'on')
        <div class="container h-100vh">
            <div class="row text-center h-100vh align-items-center">
                <div class="col-md-12">
                    <img src="{{ URL::asset('img/files/maintenance.png') }}" alt="Maintenance Image">
                    <h2 class="mt-4 font-weight-bold">We are just tuning up a few things.</h2>
                    <h5>We apologize for the inconvenience but <span
                            class="font-weight-bold text-info">{{ config('app.name') }}</span> is currenlty undergoing
                        planned maintenance.</h5>
                </div>
            </div>
        </div>
    @else
        @if (config('settings.registration') == 'enabled')
            <section class="section cmn-banner" data-background="{{ asset('assets/images/banner/banner-bg.png') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="cmn-banner__content wow fadeInUp" data-wow-duration="600ms" data-wow-delay="300ms">
                                <h3 class="h3">Create Account</h3>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb justify-content-center">
                                        <li class="breadcrumb-item">
                                            <a href="{{ url('/') }}">Home</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Create Account
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
            <!-- ==== authentication start ==== -->
            <section class="section authentication pb-0">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10 col-xl-6">
                            <div class="authentication__inner wow fadeInUp" data-wow-duration="600ms" data-wow-delay="300ms">
                                <div class="section__header text-start">
                                    <h2 class="h3">{{ __('Sign Up') }}</h2>
                                </div>
                                <form action="{{ route('register') }}" method="post">
                                    @csrf
                                    <div class="input-single">
                                        <input
                                            type="text"
                                            name="name"
                                            id="name"
                                            class="@error('name') is-invalid @enderror"
                                            value="{{ old('name') }}"
                                            autocomplete="off"
                                            autofocus
                                            placeholder="{{ __('Full Name') }}"
                                            required
                                        >
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-single">
                                        <input
                                            type="email"
                                            name="email"
                                            id="email"
                                            value="{{ old('email') }}"
                                            autocomplete="off"
                                            class="@error('email') is-invalid @enderror"
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
                                            type="text"
                                            name="username"
                                            class="@error('username') is-invalid @enderror"
                                            id="username"
                                            value="{{ old('username') }}"
                                            autocomplete="off"
                                            placeholder="{{ __('Username') }}"
                                            pattern="[a-zA-Z0-9_]+" title="Only letters, numbers, and underscores are allowed"
                                            required
                                        >
                                        <span id="usernameDuplicateError" class="invalid-feedback d-none" role="alert">
                                            Username already exists.
                                        </span>
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="input-single">
                                        <select id="user-country" name="country" data-placeholder="{{ __('Country') }}"
                                                required>
                                            @foreach (config('countries') as $value)
                                                <option value="{{ $value }}"
                                                        @if (config('settings.default_country') == $value) selected @endif>{{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-single">
                                        <input
                                            type="number"
                                            class="@error('phone_number') is-invalid @enderror"
                                            name="phone_number"
                                            value="{{ old('phone_number') }}"
                                            autocomplete="off" autofocus
                                            id="phone_number"
                                            placeholder="{{ __('Phone Number') }}"
                                            required
                                        >
                                        @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="input-single">
                                        <input
                                            type="password"
                                            name="password"
                                            class="@error('password') is-invalid @enderror"
                                            id="password"
                                            placeholder="password"
                                            autocomplete="off"
                                            required
                                        >
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="input-single">
                                        <input
                                            type="password"
                                            name="password_confirmation"
                                            id="password-confirm"
                                            placeholder="{{ __('Confirm Password') }}"
                                            autocomplete="off"
                                            required
                                        >
                                    </div>
                                    <div class="group-radio">
                                        <input type="checkbox" name="agreement" id="agreement" {{ old('remember') ? 'checked' : '' }} required>
                                        <label for="createInCheck">
                                            {{ __('By continuing, I agree with your') }} <a href="{{ route('terms') }}">{{ __('Terms and Conditions') }}</a><a href="{{ route('privacy') }}">{{ __('Privacy Policies') }}</a>
                                        </label
                                        >
                                    </div>
                                    <div class="form-cta">
                                        <button type="submit" id="signUpBtn" aria-label="post comment" class="btn btn--ocotonary">
                                            {{ __('Sign Up') }}
                                        </button>
                                        <p>
                                            Have an account?
                                            <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- ==== / authentication end ==== -->
        @else
            <h5 class="text-center pt-9">{{ __('New user registration is disabled currently') }}</h5>
        @endif
    @endif
@endsection

@section('js')
    <script>
        $("#username").change(function() {
            var username = $(this).val();
            if (username) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('check.username.exists') }}',
                    data: {
                        username: username
                    },
                    success: function(user_exists) {
                        console.log(user_exists);
                        if (user_exists == 1) {
                            $('#usernameDuplicateError').removeClass('d-none');
                            $('#username').addClass('is-invalid');
                            $('#signUpBtn').prop('disabled', true);
                        } else {
                            $('#usernameDuplicateError').addClass('d-none');
                            $('#username').removeClass('is-invalid');
                            $('#signUpBtn').removeAttr('disabled');
                        }
                    }
                });
            }
        });
    </script>

    @if (config('services.google.recaptcha.enable') == 'on')
        <!-- Google reCaptcha JS -->
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.google.recaptcha.site_key') }}">
        </script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.google.recaptcha.site_key') }}', {
                    action: 'contact'
                }).then(function(token) {
                    if (token) {
                        document.getElementById('recaptcha').value = token;
                    }
                });
            });
        </script>
    @endif
@endsection
