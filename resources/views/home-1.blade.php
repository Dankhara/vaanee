@extends('layouts.guest')

@section('css')
    <link href="{{URL::asset('plugins/swiper/swiper.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('plugins/slick/slick.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('plugins/slick/slick-theme.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('plugins/awselect/awselect.min.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('plugins/audio-player/green-audio-player.css') }}" rel="stylesheet" />
    <link href="{{URL::asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('plugins/aos/aos.css')}}" rel="stylesheet" />
@endsection

@section('content')

    <section id="main-wrapper">

        <div class="h-100vh justify-center min-h-screen" id="main-background">

            <div class="container-fluid" >

                <div class="central-banner">
                    <div class="row text-center">
                        <div class="col-md-6 col-sm-12 pt-6 pl-9" data-aos="fade-left" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                            <div class="text-container">

                                <div class="d-flex pl-8" id="responsive-title">
                                    <div><h1 class="mr-3">{{ __('AI Powered') }} </h1></div>
                                    <div><h1 id="typed"></h1></div>
                                </div>
                                <div><h1> {{ __('Advanced Converter') }}</h1></div>

                                <p class="fs-20 mb-7">{{ __('Create a professional voiceover and transcripts in real time') }} <p>
                            </div>

                            @if (config('tts.frontend.status') == 'on')

                                <div class="container">

                                    <div class="row justify-content-md-center">

                                        <div class="col-md-9" data-aos="fade-up" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">

                                            <div class="card border-0" id="frontend-player">
                                                <div class="card-body p-5">
                                                    <form id="synthesize-text-form" action="{{ route('tts.voiceover') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="row" id="frontend-language-select">
                                                            <div class="col-md-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <select id="languages" name="language" data-placeholder="{{ __('Pick Your Language') }}:" data-callback="language_select">
                                                                        @foreach ($languages as $language)
                                                                            <option value="{{ $language->language_code }}" data-img="{{ URL::asset($language->language_flag) }}" @if (config('tts.default_language') == $language->language_code) selected @endif> {{ $language->language }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-sm-12">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <select id="voices" name="voice" data-placeholder="{{ __('Choose Your Voice') }}:" data-callback="voice_select">
                                                                            @foreach ($voices as $voice)
                                                                                <option value="{{ $voice->voice_id }}"
                                                                                        id="{{ $voice->voice_id }}"
                                                                                        data-img="{{ URL::asset($voice->avatar_url) }}"
                                                                                        data-id="{{ $voice->voice_id }}"
                                                                                        data-lang="{{ $voice->language_code }}"
                                                                                        data-type="{{ $voice->voice_type }}"
                                                                                        data-gender="{{ $voice->gender }}"
                                                                                        data-voice="{{ $voice->voice }}"
                                                                                        data-url="{{ URL::asset($voice->sample_url) }}"
                                                                                        @if (config('tts.user_neural') == 'disable')
                                                                                        data-usage= "@if ((config('tts.frontend.neural') == 'disable') && ($voice->voice_type == 'neural')) avoid-clicks @endif"
                                                                                        @endif
                                                                                        @if (config('tts.default_voice') == $voice->voice_id) selected @endif
                                                                                        data-class="@if (config('tts.default_language') !== $voice->language_code) remove-voice @endif">
                                                                                    {{ $voice->voice }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">

                                                            <div class="col-md-12">
                                                                <div class="input-box mb-0" id="textarea-box">
                                                                    <textarea class="form-control" name="textarea" id="textarea" rows="7" placeholder="{{ __('Select your Language and Voice') }}... {{ __('Enter your text here to synthesize') }}... " required></textarea>
                                                                </div>

                                                                <div id="textarea-settings">
                                                                    <div class="character-counter">
                                                                        <span><em class="jQTAreaCount"></em>/<em class="jQTAreaValue"></em></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mt-5 text-center" id="waveform-box">

                                                            <div class="col-md-12 no-gutters">
                                                                <div id="waveform"></div>
                                                                <div id="wave-timeline"></div>
                                                            </div>

                                                            <div id="controls" class="mt-4 mb-3">
                                                                <button id="backwardBtn" class="result-play result-play-sm mr-2"><i class="fa fa-backward"></i></button>
                                                                <button id="playBtn" class="result-play result-play-sm mr-2"><i class="fa fa-play"></i></button>
                                                                <button id="stopBtn" class="result-play result-play-sm mr-2"><i class="fa fa-stop"></i></button>
                                                                <button id="forwardBtn" class="result-play result-play-sm mr-2"><i class="fa fa-forward"></i></button>
                                                            </div>
                                                        </div>

                                                        <div class="card-footer border-0 text-center mb-0 pt-0 pb-0">
                                                            <span id="processing"><img src="{{ URL::asset('/img/svgs/processing.svg') }}" alt=""></span>
                                                            <button type="button" class="btn btn-primary main-action-button special-action-button mr-2" id="frontend-listen-text">{{ __('Listen') }}</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div> <!-- END CONTAINER -->

                            @endif

                        </div>

                        <div class="col-md-6 col-sm-12" data-aos="fade-right" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                            <div class="image-container ">
                                <img id="special-image-margin" src="{{ URL::asset('img/files/main-banner.svg') }}" alt="">
                            </div>
                            @if (config('tts.vendor_logos') == 'show')
                                <div class="vendors">
                                    <h6 data-aos="fade-up" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">{{ __('Powered By') }}</h6>
                                    <span class="mr-3"><img src="{{ URL::asset('img/csp/aws-sm.png') }}" data-aos="fade-up" data-aos-delay="600" data-aos-once="true" data-aos-duration="1000" alt=""></span>
                                    <span class="mr-3"><img src="{{ URL::asset('img/csp/azure-sm.png') }}" data-aos="fade-up" data-aos-delay="700" data-aos-once="true" data-aos-duration="1000" alt=""></span>
                                    <span class="mr-3"><img src="{{ URL::asset('img/csp/gcp-sm.png') }}" data-aos="fade-up" data-aos-delay="800" data-aos-once="true" data-aos-duration="1000" alt=""></span>
                                    <span><img src="{{ URL::asset('img/csp/ibm-sm.png') }}" data-aos="fade-up" data-aos-delay="900" data-aos-once="true" data-aos-duration="1000" alt=""></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- SECTION - FEATURES
    ========================================================-->
    @if (config('frontend.features_section') == 'on')
        <section id="features-wrapper">

            <div class="container mt-9">

                <div class="row text-center pt-6 mb-8">
                    <div class="col-md-12 title">
                        <h6><span>{{ __('Cloud Text & Speech') }}</span> {{ __('Benefits') }}</h6>
                        <p>{{ __('Enjoy the full flexibility of the platform with ton of features') }}</p>
                    </div>
                </div>


                <!-- LIST OF SOLUTIONS -->
                <div class="row d-flex" id="solutions-list">

                    <div class="col-md-4 col-sm-12">
                        <!-- SOLUTION -->
                        <div class="col-sm-12 mb-6">


                            <div class="solution" data-aos="zoom-in" data-aos-delay="1000" data-aos-once="true" data-aos-duration="1000">

                                <div class="solution-content">

                                    <div class="solution-logo mb-3">
                                        <img src="{{ URL::asset('img/files/01.png') }}" alt="">
                                    </div>

                                    <h5>{{ __('Voiceover and Soundstudio Features') }}</h5>

                                    <p>Lorem ipsum dolor sit amet est consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                </div>

                            </div>

                        </div> <!-- END SOLUTION -->

                        <!-- SOLUTION -->
                        <div class="col-sm-12 mb-6">

                            <div class="solution" data-aos="zoom-in" data-aos-delay="1500" data-aos-once="true" data-aos-duration="1500">

                                <div class="solution-content">

                                    <div class="solution-logo mb-3">
                                        <img src="{{ URL::asset('img/files/09.png') }}" alt="">
                                    </div>

                                    <h5>{{ __('Enhanced SSML Features') }}</h5>

                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                </div>

                            </div>

                        </div> <!-- END SOLUTION -->

                        <!-- SOLUTION -->
                        <div class="col-sm-12 mb-6">

                            <div class="solution" data-aos="zoom-in" data-aos-delay="2000" data-aos-once="true" data-aos-duration="2000">

                                <div class="solution-content">

                                    <div class="solution-logo mb-3">
                                        <img src="{{ URL::asset('img/files/06.png') }}" alt="">
                                    </div>

                                    <h5>{{ __('Most Comprehensive Security') }}</h5>

                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                </div>

                            </div>

                        </div> <!-- END SOLUTION -->
                    </div>

                    <div class="col-md-4 col-sm-12 mt-7">
                        <!-- SOLUTION -->
                        <div class="col-sm-12 mb-6">

                            <div class="solution" data-aos="zoom-in" data-aos-delay="1000" data-aos-once="true" data-aos-duration="1000">

                                <div class="solution-content">

                                    <div class="solution-logo mb-3">
                                        <img src="{{ URL::asset('img/files/05.png') }}" alt="">
                                    </div>

                                    <h5>{{ __('Move than 900 Voices') }}</h5>

                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                </div>

                            </div>

                        </div> <!-- END SOLUTION -->


                        <!-- SOLUTION -->
                        <div class="col-sm-12 mb-6">

                            <div class="solution" data-aos="zoom-in" data-aos-delay="1500" data-aos-once="true" data-aos-duration="1500">

                                <div class="solution-content">

                                    <div class="solution-logo mb-3">
                                        <img src="{{ URL::asset('img/files/03.png') }}" alt="">
                                    </div>

                                    <h5>{{ __('More than 140 Languages and Dialects') }}</h5>

                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                </div>

                            </div>

                        </div> <!-- END SOLUTION -->


                        <!-- SOLUTION -->
                        <div class="col-sm-12 mb-6">

                            <div class="solution" data-aos="zoom-in" data-aos-delay="2000" data-aos-once="true" data-aos-duration="2000">

                                <div class="solution-content">

                                    <div class="solution-logo mb-3">
                                        <img src="{{ URL::asset('img/files/04.png') }}" alt="">
                                    </div>

                                    <h5>{{ __('Various Supported Audio Formats') }}</h5>

                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                </div>

                            </div>

                        </div> <!-- END SOLUTION -->
                    </div>

                    <div class="col-md-4 col-sm-12 d-flex">

                        <div class="feature-text">
                            <div>
                                <h4><span class="text-primary">{{ config('app.name') }}</span>{{ __(' Accurately convert text to speech and speech to text') }}</h4>
                            </div>

                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quibusdam? Illum ad eius, molestiae placeat dicta quae, ab nihil omnis obcaecati reiciendis recusandae, voluptatem eos molestias aliquam saepe tenetur optio? Consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati.</p>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea et, error quisquam corporis, architecto minus doloremque aut facere itaque culpa eos molestias nulla reiciendis animi dolores, quod sunt illum.</p>
                        </div>

                    </div>

                </div> <!-- END LIST OF SOLUTIONS -->


            </div>

        </section>
    @endif


    <!-- SECTION - USE CASES
        ========================================================-->
    @if (config('frontend.cases_section') == 'on')
        <section id="cases-wrapper">

            <div class="container pt-6">

                <div class="row text-center mb-8">
                    <div class="col-md-12 title">
                        <h6>{{ __('Virtually') }} <span>{{ __('Unlimited') }}</span> {{ __('Use Cases') }}</h6>
                        <p>{{ __('Create and transcribe any type of audio content as you prefer') }}</p>
                    </div>
                </div>

                <div class="row">

                    @if ($case_exists)

                        <div class="blog-slider" data-aos="zoom-out" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">
                            <div class="blog-slider__wrp swiper-wrapper">

                                @foreach ($cases as $case)
                                    <div class="blog-slider__item swiper-slide">
                                        <div class="blog-slider__img">
                                            <img src="{{ URL::asset($case->image_url) }}" alt="">
                                        </div>
                                        <div class="blog-slider__content">
                                            <div class="blog-slider__title">{{ $case->title }}</div>
                                            <div class="blog-slider__text">{!! $case->text !!}</div>
                                            <div class="audio-box">
                                                <!-- VOICE AUDIO FILE -->
                                                <div class="voice-player">
                                                    <div class="text-center player">
                                                        <audio class="voice-audio" preload="none">
                                                            <source src="{{ URL::asset($case->audio_url) }}" type="audio/mpeg">
                                                        </audio>
                                                    </div>
                                                </div><!-- END VOICE AUDIO FILE -->
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <div class="blog-slider__pagination"></div>

                        </div>

                    @else
                        <div class="row text-center">
                            <div class="col-sm-12 mt-6 mb-6">
                                <h6 class="fs-12 font-weight-bold text-center">{{ __('No use cases were published yet') }}</h6>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </section>
    @endif


    <!-- SECTION - BANNER
        ========================================================-->
    <section id="flags-wrapper">
        <div class="container-fluid" id="flags-bg">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="row mb-7">
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/za.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/ae.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/bg.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/es.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/cn.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/cz.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/dk.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/nl.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/au.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/gb.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/us.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/ph.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/fi.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/fr.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/ca.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/de.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/gr.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/in.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/hu.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/is.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/id.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/it.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/jp.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/kr.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/lv.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/my.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/no.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/pl.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/br.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/pt.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/ro.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/ru.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/rs.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/sk.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/se.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="flag-img">
                                <img src="{{ URL::asset('img/flags/th.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 pl-9 d-flex align-items-center" id=flags-minify>
                    <div class="flags-info" data-aos="fade-left" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">
                        <h4>{{ __('More than') }} <span>900</span> {{ __('voices across') }}<br><span>140</span> {{ __('languages and dialects') }}</h4>
                        <p>{{ __('The list of languages is constantly updated. In addition') }}, <br> {{ __('the synthesis of existing languages is constantly being') }} <br>updated and improved.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- SECTION - CUSTOMER FEEDBACKS
    ========================================================-->
    @if (config('frontend.reviews_section') == 'on')
        <section id="feedbacks-wrapper">

            <div class="container pt-9 text-center">


                <!-- SECTION TITLE -->
                <div class="row mb-8">

                    <div class="title">
                        <h6>{{ __('Hear from our') }} <span>{{ __('Customers') }}</span></h6>
                        <p>{{ __('We guarantee that you will be one of our happy customers as well') }}</p>
                    </div>

                </div> <!-- END SECTION TITLE -->

                @if ($review_exists)

                    <div class="row" id="feedbacks">

                        @foreach ($reviews as $review)
                            <div class="feedback" data-aos="zoom-in" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">
                                <!-- MAIN COMMENT -->
                                <p class="comment"><sup><span class="fa fa-quote-left"></span></sup> {{ $review->text }} <sub><span class="fa fa-quote-right"></span></sub></p>

                                <!-- COMMENTER -->
                                <div class="feedback-image d-flex">
                                    <div>
                                        <img src="{{ URL::asset($review->image_url) }}" alt="Feedback" class="rounded-circle-frontend"><span class="small-quote fa fa-quote-left"></span>
                                    </div>

                                    <div class="pt-3">
                                        <p class="feedback-reviewer">{{ $review->name }}</p>
                                        <p class="fs-12">{{ $review->position }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- ROTATORS BUTTONS -->
                    <div class="offers-nav">
                        <a class="offers-prev"><i class="fa fa-chevron-left"></i></a>
                        <a class="offers-next"><i class="fa fa-chevron-right"></i></a>
                    </div>

                @else
                    <div class="row text-center">
                        <div class="col-sm-12 mt-6 mb-6">
                            <h6 class="fs-12 font-weight-bold text-center">{{ __('No customer reviews were published yet') }}</h6>
                        </div>
                    </div>
                @endif



            </div> <!-- END CONTAINER -->

        </section> <!-- END SECTION CUSTOMER FEEDBACK -->
    @endif


    <!-- SECTION - PARTNERS
        ========================================================-->
    <section id="partner-wrapper">

        <div class="container">

            <!-- SECTION TITLE -->
            <div class="row mb-7 text-center">

                <div class="title">
                    <h6>{{ __('Trusted by') }} <span>{{ __('Creators') }}</span> {{ __('Around the World') }}</h6>
                    <p class="mb-0">{{ __('Be among the many that trust us') }}</p>
                </div>

            </div> <!-- END SECTION TITLE -->

            <div class="row" id="partners">

                <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">
                    <div class="partner-image d-flex">
                        <div>
                            <img src="{{ URL::asset('img/files/c1.png') }}" alt="partner">
                        </div>
                    </div>
                </div>

                <div class="partner" data-aos="flip-down" data-aos-delay="700" data-aos-once="true" data-aos-duration="1000">
                    <div class="partner-image d-flex">
                        <div>
                            <img src="{{ URL::asset('img/files/c2.png') }}" alt="partner">
                        </div>
                    </div>
                </div>

                <div class="partner" data-aos="flip-down" data-aos-delay="900" data-aos-once="true" data-aos-duration="1000">
                    <div class="partner-image d-flex">
                        <div>
                            <img src="{{ URL::asset('img/files/c7.png') }}" alt="partner">
                        </div>
                    </div>
                </div>

                <div class="partner" data-aos="flip-down" data-aos-delay="1100" data-aos-once="true" data-aos-duration="1000">
                    <div class="partner-image d-flex">
                        <div>
                            <img src="{{ URL::asset('img/files/c5.png') }}" alt="partner">
                        </div>
                    </div>
                </div>

                <div class="partner" data-aos="flip-down" data-aos-delay="1300" data-aos-once="true" data-aos-duration="1000">
                    <div class="partner-image d-flex">
                        <div>
                            <img src="{{ URL::asset('img/files/c6.png') }}" alt="partner">
                        </div>
                    </div>
                </div>

                <div class="partner" data-aos="flip-down" data-aos-delay="1500" data-aos-once="true" data-aos-duration="1000">
                    <div class="partner-image d-flex">
                        <div>
                            <img src="{{ URL::asset('img/files/c7.png') }}" alt="partner">
                        </div>
                    </div>
                </div>

                <div class="partner" data-aos="flip-down" data-aos-delay="1700" data-aos-once="true" data-aos-duration="1000">
                    <div class="partner-image d-flex">
                        <div>
                            <img src="{{ URL::asset('img/files/c2.png') }}" alt="partner">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section> <!-- END SECTION BANNER -->


    <!-- SECTION - PRICING
    ========================================================-->
    @if (config('frontend.pricing_section') == 'on')
        <section id="prices-wrapper">

            <div class="container pt-9">

                <!-- SECTION TITLE -->
                <div class="row text-center">

                    <div class="title">
                        <h6>{{ __('Various') }} <span>{{ __('Subscription') }}</span> {{ __('Plans') }}</h6>
                        <p>{{ __('Most competitive prices are guaranteed') }}</p>
                    </div>

                </div> <!-- END SECTION TITLE -->

                <div class="row">
                    <div class="card-body">

                        @if ($monthly || $yearly || $prepaid)

                            <div class="tab-menu-heading text-center">
                                <div class="tabs-menu">
                                    <ul class="nav">
                                        @if ($prepaid)
                                            @if (config('payment.payment_option') == 'prepaid' || config('payment.payment_option') == 'both')
                                                <li><a href="#prepaid" class="@if (!$monthly && !$yearly && $prepaid) active @else '' @endif" data-bs-toggle="tab"> {{ __('Prepaid Plans') }}</a></li>
                                            @endif
                                        @endif
                                        @if ($monthly)
                                            @if (config('payment.payment_option') == 'subscription' || config('payment.payment_option') == 'both')
                                                <li><a href="#monthly_plans" class="@if (($monthly && $prepaid && $yearly) || ($monthly && !$prepaid && !$yearly) || ($monthly && $prepaid && !$yearly) || ($monthly && !$prepaid && $yearly)) active @else '' @endif" data-bs-toggle="tab"> {{ __('Monthly Plans') }}</a></li>
                                            @endif
                                        @endif
                                        @if ($yearly)
                                            @if (config('payment.payment_option') == 'subscription' || config('payment.payment_option') == 'both')
                                                <li><a href="#yearly_plans" class="@if (!$monthly && !$prepaid && $yearly) active @else '' @endif" data-bs-toggle="tab"> {{ __('Yearly Plans') }}</a></li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </div>


                            <div class="tabs-menu-body">
                                <div class="tab-content">

                                    @if ($prepaid)
                                        @if (config('payment.payment_option') == 'prepaid' || config('payment.payment_option') == 'both')
                                            <div class="tab-pane @if ((!$monthly && $prepaid) && (!$yearly && $prepaid)) active @else '' @endif" id="prepaid">

                                                @if ($prepaids->count())

                                                    <h6 class="font-weight-normal fs-12 text-center mb-6">{{ __('Top up your subscription with more credits or start with Prepaid Plans credits only') }}</h6>

                                                    <div class="row justify-content-md-center">

                                                        @foreach ( $prepaids as $prepaid )
                                                            <div class="col-lg-3 col-md-6 col-sm-12" data-aos="fade-up">
                                                                <div class="price-card pt-2 mb-7">
                                                                    <div class="card border-0 p-4 pl-5">
                                                                        <div class="plan prepaid-plan">
                                                                            <div class="plan-title">{{ $prepaid->plan_name }} <span class="prepaid-currency-sign">{{ $prepaid->currency }}</span><span class="plan-cost">{{ number_format((float)$prepaid->price, 2) }}</span><span class="prepaid-currency-sign">{!! config('payment.default_system_currency_symbol') !!}</span></div>
                                                                            @if ($prepaid->characters > 0)
                                                                                <p class="fs-12 mt-2 @if($prepaid->minutes > 0) mb-0 @endif">{{ __('Characters Included') }}: <span class="ml-2 font-weight-bold text-primary">{{ number_format($prepaid->characters) }}</span></p>
                                                                            @endif
                                                                            @if ($prepaid->minutes > 0)
                                                                                <p class="fs-12 @if($prepaid->characters == 0) mt-2 @endif">{{ __('Minutes Included') }}: <span class="ml-2 font-weight-bold text-primary">{{ number_format($prepaid->minutes) }}</span></p>
                                                                            @endif
                                                                            <div class="text-center action-button mt-2 mb-2">
                                                                                <a href="{{ route('user.prepaid.checkout', $prepaid->id) }}" class="btn btn-cancel">{{ __('Purchase') }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                @else
                                                    <div class="row text-center">
                                                        <div class="col-sm-12 mt-6 mb-6">
                                                            <h6 class="fs-12 font-weight-bold text-center">{{ __('No Pre-Paid plans were set yet') }}</h6>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        @endif
                                    @endif

                                    @if ($monthly)
                                        @if (config('payment.payment_option') == 'subscription' || config('payment.payment_option') == 'both')
                                            <div class="tab-pane @if (($monthly && $prepaid) || ($monthly && !$prepaid) || ($monthly && !$yearly)) active @else '' @endif" id="monthly_plans">

                                                @if ($monthly_subscriptions->count())

                                                    <h6 class="font-weight-normal fs-12 text-center mb-6">{{ __('Subscribe to our Monthly Subscription Plans and enjoy ton of benefits') }}</h6>

                                                    <div class="row justify-content-md-center">

                                                        @foreach ( $monthly_subscriptions as $subscription )
                                                            <div class="col-lg-3 col-md-6 col-sm-12" data-aos="fade-up">
                                                                <div class="pt-2 mb-7 prices-responsive">
                                                                    <div class="card border-0 p-4 pl-5 pr-5 pt-7 price-card @if ($subscription->featured) price-card-border @endif">
                                                                        @if ($subscription->featured)
                                                                            <span class="plan-featured">{{ __('Most Popular') }}</span>
                                                                        @endif
                                                                        <div class="plan">
                                                                            <div class="plan-title text-center">{{ $subscription->plan_name }}</div>
                                                                            <p class="fs-12 text-center mb-3">{{ $subscription->primary_heading }}</p>
                                                                            <p class="plan-cost text-center mb-0"><span class="plan-currency-sign"></span>{!! config('payment.default_system_currency_symbol') !!}{{ number_format((float)$subscription->price, 2) }}</p>
                                                                            <p class="fs-12 text-center mb-3">{{ $subscription->currency }} / {{ __('Month') }}</p>
                                                                            <div class="text-center action-button mt-2 mb-5">
                                                                                <a href="{{ route('user.plan.subscribe', $subscription->id) }}" class="btn btn-primary">{{ __('Subscribe Now') }}</a>
                                                                            </div>
                                                                            <p class="fs-12 text-center mb-3">{{ $subscription->secondary_heading }}</p>
                                                                            <ul class="fs-12 pl-3">
                                                                                @foreach ( (explode(',', $subscription->plan_features)) as $feature )
                                                                                    @if ($feature)
                                                                                        <li><i class="fa-solid fa-circle-small fs-10 text-muted"></i> {{ $feature }}</li>
                                                                                    @endif
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                @else
                                                    <div class="row text-center">
                                                        <div class="col-sm-12 mt-6 mb-6">
                                                            <h6 class="fs-12 font-weight-bold text-center">{{ __('No Subscriptions plans were set yet') }}</h6>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endif

                                    @if ($yearly)
                                        @if (config('payment.payment_option') == 'subscription' || config('payment.payment_option') == 'both')
                                            <div class="tab-pane @if (($yearly && $prepaid) && ($yearly && !$prepaid) && ($yearly && !$monthly)) active @else '' @endif" id="yearly_plans">

                                                @if ($yearly_subscriptions->count())

                                                    <h6 class="font-weight-normal fs-12 text-center mb-6">{{ __('Subscribe to our Yearly Subscription Plans and enjoy ton of benefits') }}</h6>

                                                    <div class="row justify-content-md-center">

                                                        @foreach ( $yearly_subscriptions as $subscription )
                                                            <div class="col-lg-3 col-md-6 col-sm-12" data-aos="fade-up">
                                                                <div class="pt-2 mb-7 prices-responsive">
                                                                    <div class="card border-0 p-4 pl-5 pr-5 pt-7 price-card @if ($subscription->featured) price-card-border @endif">
                                                                        @if ($subscription->featured)
                                                                            <span class="plan-featured">{{ __('Most Popular') }}</span>
                                                                        @endif
                                                                        <div class="plan">
                                                                            <div class="plan-title text-center">{{ $subscription->plan_name }}</div>
                                                                            <p class="fs-12 text-center mb-3">{{ $subscription->primary_heading }}</p>
                                                                            <p class="plan-cost text-center mb-0"><span class="plan-currency-sign"></span>{!! config('payment.default_system_currency_symbol') !!}{{ number_format((float)$subscription->price, 2) }}</p>
                                                                            <p class="fs-12 text-center mb-3">{{ $subscription->currency }} / {{ __('Year') }}</p>
                                                                            <div class="text-center action-button mt-2 mb-4">
                                                                                <a href="{{ route('user.plan.subscribe', $subscription->id) }}" class="btn btn-primary">{{ __('Subscribe Now') }}</a>
                                                                            </div>
                                                                            <p class="fs-12 text-center mb-3">{{ $subscription->secondary_heading }}</p>
                                                                            <ul class="fs-12 pl-3">
                                                                                @foreach ( (explode(',', $subscription->plan_features)) as $feature )
                                                                                    @if ($feature)
                                                                                        <li><i class="fa-solid fa-circle-small fs-10 text-muted"></i> {{ $feature }}</li>
                                                                                    @endif
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>

                                                @else
                                                    <div class="row text-center">
                                                        <div class="col-sm-12 mt-6 mb-6">
                                                            <h6 class="fs-12 font-weight-bold text-center">{{ __('No Subscriptions plans were set yet') }}</h6>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endif

                                </div>
                            </div>

                        @else
                            <div class="row text-center">
                                <div class="col-sm-12 mt-6 mb-6">
                                    <h6 class="fs-12 font-weight-bold text-center">{{ __('No Subscriptions Plans were set yet') }}</h6>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

            </div>

        </section>
    @endif


    <!-- SECTION - BLOGS
        ========================================================-->
    @if (config('frontend.blogs_section') == 'on')
        <section id="blog-wrapper">

            <div class="container pt-4 text-center">


                <!-- SECTION TITLE -->
                <div class="row mb-8">

                    <div class="title w-100">
                        <h6>{{ __('Latest Community') }} <span>{{ __('Blogs') }}</span></h6>
                        <p>{{ __('Check out our blogs about text synthesizing and audio transcription') }}</p>
                    </div>

                </div> <!-- END SECTION TITLE -->

            @if ($blog_exists)

                <!-- BLOGS -->
                    <div class="row" id="blogs">
                        @foreach ( $blogs as $blog )
                            <div class="blog" data-aos="zoom-in" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">
                                <div class="blog-box">
                                    <div class="blog-img">
                                        <a href="{{ route('blogs.show', $blog->url) }}"><img src="{{ URL::asset($blog->image) }}" alt="Blog Image"></a>
                                    </div>
                                    <div class="blog-info">
                                        <h6 class="blog-date text-left text-muted mt-3 pt-1 mb-4"><span class="mr-2">{{ $blog->created_by }}</span> | <i class="mdi mdi-alarm mr-2"></i>{{ date('j F Y', strtotime($blog->created_at)) }}</h6>
                                        <h5 class="blog-title fs-16 text-left mb-3">{{ $blog->title }}</h5>
                                        <p class="blog-date fs-12 text-muted text-left mb-3">{{ $blog->excerpt() }}</p>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <!-- ROTATORS BUTTONS -->
                    <div class="blogs-nav">
                        <a class="blogs-prev"><i class="fa fa-chevron-left"></i></a>
                        <a class="blogs-next"><i class="fa fa-chevron-right"></i></a>
                    </div>

                @else
                    <div class="row text-center">
                        <div class="col-sm-12 mt-6 mb-6">
                            <h6 class="fs-12 font-weight-bold text-center">{{ __('No blog articles were published yet') }}</h6>
                        </div>
                    </div>
                @endif

            </div> <!-- END CONTAINER -->

        </section> <!-- END SECTION BLOGS -->
    @endif


    <!-- SECTION - FAQ
        ========================================================-->
    @if (config('frontend.faq_section') == 'on')
        <section id="faq-wrapper">
            <div class="container pt-7">

                <div class="row text-center mb-8 mt-7">
                    <div class="col-md-12 title">
                        <h6>{{ __('Frequently Asked') }} <span>{{ __('Questions') }}</span></h6>
                        <p>{{ __('Got questions? We have you covered.') }}</p>
                    </div>
                </div>

                <div class="row justify-content-md-center">

                    @if ($faq_exists)

                        <div class="col-md-10">

                            @foreach ( $faqs as $faq )

                                <div id="accordion" data-aos="fade-left" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                                    <div class="card">
                                        <div class="card-header" id="heading{{ $faq->id }}">
                                            <h5 class="mb-0">
                                                <span class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="false" aria-controls="collapse-{{ $faq->id }}">
                                                    {{ $faq->question }}
                                                </span>
                                            </h5>
                                        </div>

                                        <div id="collapse-{{ $faq->id }}" class="collapse" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordion">
                                            <div class="card-body">
                                                {!! $faq->answer !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>


                    @else
                        <div class="row text-center">
                            <div class="col-sm-12 mt-6 mb-6">
                                <h6 class="fs-12 font-weight-bold text-center">{{ __('No FAQ answers were published yet') }}</h6>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </section> <!-- END SECTION FAQ -->
    @endif


    <!-- SECTION - CONTACT US
        ========================================================-->
    @if (config('frontend.contact_section') == 'on')
        <section id="contact-wrapper">

            <div class="container pt-9">

                <!-- SECTION TITLE -->
                <div class="row mb-8 text-center">

                    <div class="title w-100">
                        <h6><span>{{ __('Contact') }}</span> {{ __('With Us') }}</h6>
                        <p>{{ __('Reach out to us for additional information') }}</p>
                    </div>

                </div> <!-- END SECTION TITLE -->


                <div class="row">

                    <div class="col-md-6 col-sm-12" data-aos="fade-left" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                        <img class="w-70" src="{{ URL::asset('img/files/about.svg') }}" alt="">
                    </div>

                    <div class="col-md-6 col-sm-12" data-aos="fade-right" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                        <form id="" action="{{ route('contact') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row justify-content-md-center">
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-box mb-4">
                                        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="off" placeholder="{{ __('First Name') }}" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-box mb-4">
                                        <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" autocomplete="off" placeholder="{{ __('Last Name') }}" required>
                                        @error('lastname')
                                        <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-md-center">
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-box mb-4">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off"  placeholder="{{ __('Email Address') }}" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-box mb-4">
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="off"  placeholder="{{ __('Phone Number') }}" required>
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-md-center">
                                <div class="col-md-12 col-sm-12">
                                    <div class="input-box">
                                        <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="10" required placeholder="{{ __('Message') }}"></textarea>
                                        @error('message')
                                        <p class="text-danger">{{ $errors->first('message') }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="recaptcha" id="recaptcha">

                            <div class="row justify-content-md-center text-center">
                                <!-- ACTION BUTTON -->
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary special-action-button">{{ __('Send Message') }}</button>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </section>

        <!-- SECTION - INFO BANNER
        ========================================================-->
        <div class="container" id="responsive-info">
            <div class="row justify-content-md-center" data-aos="zoom-out-up">
                <div class="col-md-8">
                    <div class="row text-center position-relative action-call-wrapper">

                        <div id="action-call" class=""></div>

                        <div class="col-md-12 action-content">
                            <h4 class="mb-2">{{ __('Get Started Today') }}</h4>
                            <p class="mb-2">{{ __('You will receive free credits upon registration') }}</p>

                            <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Sign Up Now') }}</a>
                            <p class="fs-10 mt-2 mb-0">{{ __('No credit card required') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('js')
    <script src="{{ URL::asset('plugins/audio-player/green-audio-player.js') }}"></script>
    <script src="{{URL::asset('plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{URL::asset('plugins/typed/typed.min.js')}}"></script>
    <script src="{{ URL::asset('js/audio-player.js') }}"></script>
    <script src="{{ URL::asset('js/wavesurfer.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/wavesurfer/wavesurfer.cursor.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/wavesurfer/wavesurfer.timeline.min.js') }}"></script>
    <script src="{{URL::asset('plugins/slick/slick.min.js')}}"></script>
    <script src="{{URL::asset('plugins/jqtarea/plugin-jqtarea.min.js')}}"></script>
    <script src="{{URL::asset('plugins/awselect/awselect-custom.js')}}"></script>
    <script src="{{URL::asset('js/awselect.js')}}"></script>
    <script src="{{URL::asset('plugins/swiper/swiper.min.js')}}"></script>
    <script src="{{URL::asset('plugins/aos/aos.js')}}"></script>
    <script src="{{URL::asset('js/frontend.js')}}"></script>

    <script type="text/javascript">
        $(function () {

            $(document).ready(function(){
                $("#textarea").jQTArea({
                    setLimit: {{ $max_chars }},
                    setExt: "W",
                    setExtR: true
                });
            });

            var typed = new Typed('#typed', {
                strings: ['<h1><span>{{ __('Text to Speech') }}</span></h1>', '<h1><span>{{ __('Speech to Text') }}</span></h1>'],
                typeSpeed: 40,
                backSpeed: 40,
                backDelay: 2000,
                loop: true,
                showCursor: false,
            });

            AOS.init();

        });
    </script>

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







