@extends('layouts.guest')

@section('css')
@endsection

@section('content')

    <!-- ==== banner start ==== -->
    <section class="section banner-one bg-img" data-background="assets/images/banner/banner-one-bg.png">
        <div class="container">
            <div class="row items-gap align-items-center">
                <div class="col-12 col-md-10 col-lg-6">
                    <div class="banner-one__content">
                        <p class="h6">
                            <span>AI Voice</span>
                            Generator and Text to Speech
                        </p>
                        <h1 class="h1">Your Complete Generative Voice AI Toolkit</h1>
                        <div class="section__content-cta">
                            <a href="register.html" class="btn btn--primary">
                                start free now
                            </a
                            >
                            <a href="contact-us.html" class="btn btn--secondary">
                                request A Demo
                            </a
                            >
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="banner-one__thumb text-start text-lg-end">
                        <img src="assets/images/banner/banner-one-thumb.png" alt="Image" class="wow fadeInUp">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== / banner end ==== -->

    <!-- ==== overview start ==== -->
    <div class="overview">
        <div class="container">
            <div class="row items-gap">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="overview__single wow fadeInUp" data-wow-duration="600ms">
                        <img src="assets/images/icons/overview-one.png" alt="Image">
                        <p class="h6">Text-to-Speech</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="overview__single wow fadeInUp" data-wow-duration="600ms" data-wow-delay="200ms">
                        <img src="assets/images/icons/overview-two.png" alt="Image">
                        <p class="h6">Speech-to-Speech</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="overview__single wow fadeInUp" data-wow-duration="600ms" data-wow-delay="400ms">
                        <img src="assets/images/icons/overview-three.png" alt="Image">
                        <p class="h6">Neural Editing</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="overview__single wow fadeInUp" data-wow-duration="600ms" data-wow-delay="600ms">
                        <img src="assets/images/icons/overview-four.png" alt="Image">
                        <p class="h6">Language Dubbing</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==== / overview end ==== -->
    <!-- ==== voice start ==== -->
    <section class="section voice">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section__header--secondary">
                        <div class="row align-items-center items-gap">
                            <div class="col-12 col-lg-8">
                                <h2 class="h2 wow fadeInUp">
                                    There's a voice for every need
                                </h2>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="cmn-pagination voice-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="voice__slider">
                        <div class="voice__slider-single voice-bg-one">
                            <div class="voice__slider-single-thumb">
                                <img src="assets/images/voice/one.png" alt="Image">
                            </div>
                            <div class="voice__slider-single-content">
                                <h5 class="h5">product designer</h5>
                                <div class="voice__slider-single-content-play">
                                    <button aria-label="play audio" class="play-track">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                    <audio class="player" src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
                                </div>
                            </div>
                        </div>
                        <div class="voice__slider-single voice-bg-two">
                            <div class="voice__slider-single-thumb">
                                <img src="assets/images/voice/two.png" alt="Image">
                            </div>
                            <div class="voice__slider-single-content">
                                <h5 class="h5">educator</h5>
                                <div class="voice__slider-single-content-play">
                                    <button aria-label="play audio" class="play-track">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                    <audio class="player" src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
                                </div>
                            </div>
                        </div>
                        <div class="voice__slider-single voice-bg-three">
                            <div class="voice__slider-single-thumb">
                                <img src="assets/images/voice/three.png" alt="Image">
                            </div>
                            <div class="voice__slider-single-content">
                                <h5 class="h5">digital markerter</h5>
                                <div class="voice__slider-single-content-play">
                                    <button aria-label="play audio" class="play-track">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                    <audio class="player" src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
                                </div>
                            </div>
                        </div>
                        <div class="voice__slider-single voice-bg-four">
                            <div class="voice__slider-single-thumb">
                                <img src="assets/images/voice/four.png" alt="Image">
                            </div>
                            <div class="voice__slider-single-content">
                                <h5 class="h5">corporate couch</h5>
                                <div class="voice__slider-single-content-play">
                                    <button aria-label="play audio" class="play-track">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                    <audio class="player" src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
                                </div>
                            </div>
                        </div>
                        <div class="voice__slider-single voice-bg-five">
                            <div class="voice__slider-single-thumb">
                                <img src="assets/images/voice/five.png" alt="Image">
                            </div>
                            <div class="voice__slider-single-content">
                                <h5 class="h5">podcaster</h5>
                                <div class="voice__slider-single-content-play">
                                    <button aria-label="play audio" class="play-track">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                    <audio class="player" src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
                                </div>
                            </div>
                        </div>
                        <div class="voice__slider-single voice-bg-six">
                            <div class="voice__slider-single-thumb">
                                <img src="assets/images/voice/six.png" alt="Image">
                            </div>
                            <div class="voice__slider-single-content">
                                <h5 class="h5">customer call</h5>
                                <div class="voice__slider-single-content-play">
                                    <button aria-label="play audio" class="play-track">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                    <audio class="player" src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
                                </div>
                            </div>
                        </div>
                        <div class="voice__slider-single voice-bg-one">
                            <div class="voice__slider-single-thumb">
                                <img src="assets/images/voice/one.png" alt="Image">
                            </div>
                            <div class="voice__slider-single-content">
                                <h5 class="h5">product designer</h5>
                                <div class="voice__slider-single-content-play">
                                    <button aria-label="play audio" class="play-track">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                    <audio class="player" src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
                                </div>
                            </div>
                        </div>
                        <div class="voice__slider-single voice-bg-two">
                            <div class="voice__slider-single-thumb">
                                <img src="assets/images/voice/two.png" alt="Image">
                            </div>
                            <div class="voice__slider-single-content">
                                <h5 class="h5">educator</h5>
                                <div class="voice__slider-single-content-play">
                                    <button aria-label="play audio" class="play-track">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                    <audio class="player" src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== / voice end ==== -->
    <!-- ==== clone start ==== -->
    <section class="section clone pt-0">
        <div class="container">
            <div class="row items-gap align-items-center">
                <div class="col-12 col-lg-6">
                    <div class="clone__thumb wow fadeInUp" data-wow-duration="600ms" data-background="assets/images/clone-arrow.png, assets/images/clone-bg.png">
                        <div class="clone__thumb-single">
                            <i class="fa-solid fa-signal"></i>
                            <div class="thumb">
                                <img src="assets/images/clone-thumb.png" alt="Image">
                            </div>
                            <div class="content">
                                <p>The Upstairs</p>
                                <p>Matraman</p>
                            </div>
                            <div class="voice__slider-single-content-play">
                                <button aria-label="play audio" class="play-track">
                                    <i class="fa-solid fa-play"></i>
                                </button>
                                <audio class="player" src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
                            </div>
                            <span class="tag">Original voice</span>
                        </div>
                        <div class="text-end">
                            <div class="clone__thumb-single">
                                <i class="fa-solid fa-signal"></i>
                                <div class="thumb">
                                    <img src="assets/images/clone-thumb.png" alt="Image">
                                </div>
                                <div class="content">
                                    <p>The Upstairs</p>
                                    <p>Matraman</p>
                                </div>
                                <div class="voice__slider-single-content-play">
                                    <button aria-label="play audio" class="play-track">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                    <audio class="player" src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"></audio>
                                </div>
                                <span class="tag">Original voice</span>
                            </div>
                        </div>
                        <div class="anime">
                            <img src="assets/images/anime-one.png" alt="Image" class="anime-one">
                            <img src="assets/images/anime-two.png" alt="Image" class="anime-two">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="clone__content section__content">
                        <h2 class="h2 wow fadeInUp">Pitch Perfect Voice Clones</h2>
                        <div class="paragraph wow fadeInUp" data-wow-duration="600ms">
                            <p class="fw-5 text-lg">
                                Resemble's AI voice generator lets you create realistic
                                human-like voiceovers in seconds.
                            </p>
                            <p>
                                Create a spot-on match of the voice you like with Murf.
                                Customize the voice by adjusting pitch, tone, speed, and
                                more to produce life-like narration for your content. Make
                                modifications to your script anytime during the creative
                            </p>
                        </div>
                        <ul class="wow fadeInUp">
                            <li>
                                <i class="fa-solid fa-check"></i>
                                Emotions
                            </li>
                            <li>
                                <i class="fa-solid fa-check"></i>
                                Speech-To-Speech
                            </li>
                            <li>
                                <i class="fa-solid fa-check"></i>
                                Localize
                            </li>
                        </ul>
                        <div class="section__content-cta wow fadeInUp" data-wow-duration="600ms">
                            <a href="contact-us.html" class="btn btn--tertiary">
                                request A Demo
                            </a
                            >
                            <a href="about-us.html" class="btn btn--quaternary">
                                About Us
                            </a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== / clone end ==== -->
    <!-- ==== sponsor start ==== -->
    <div class="sponsor">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sponsor__inner wow fadeInUp" data-wow-duration="600ms" data-background="assets/images/sponsor/sponsor-bg.png">
                        <div class="section__header">
                            <h4 class="h4">Trusted by users and teams of all sizes</h4>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="sponsor__slider">
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/bose.png" alt="Image">
                                    </div>
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/amazon.png" alt="Image">
                                    </div>
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/microsoft.png" alt="Image">
                                    </div>
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/netflix.png" alt="Image">
                                    </div>
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/samsung.png" alt="Image">
                                    </div>
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/toyota.png" alt="Image">
                                    </div>
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/bose.png" alt="Image">
                                    </div>
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/amazon.png" alt="Image">
                                    </div>
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/microsoft.png" alt="Image">
                                    </div>
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/netflix.png" alt="Image">
                                    </div>
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/samsung.png" alt="Image">
                                    </div>
                                    <div class="sponsor__slider-item">
                                        <img src="assets/images/sponsor/toyota.png" alt="Image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==== / sponsor end ==== -->
    <!-- ==== tour start ==== -->
    <section class="section tour">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-6">
                    <div class="section__header wow fadeInUp" data-wow-duration="600ms">
                        <h2 class="h2">Take a quick tour of techAI</h2>
                        <p class="max-5">
                            Watch this video to learn all about our AI voice technology
                            and how to use it in your products
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tour__content wow fadeInUp" data-wow-duration="600ms" data-before-image="assets/images/frame.png">
                        <video
                            muted
                            loop
                            autoplay
                            controls
                        >
                            <source src="assets/images/video/video.mp4" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tour__content-cta wow fadeInUp" data-wow-duration="600ms">
                        <div class="trust">
                            <div class="review">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <p class="fw-7">Rated Excellent on Trustpilot</p>
                        </div>
                        <div class="action">
                            <a href="register.html" class="btn btn--primary">
                                start free now
                            </a
                            >
                        </div>
                        <img src="assets/images/frame-two.png" alt="Image" class="frame">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== / tour end ==== -->
    <!-- ==== case start ==== -->
    @if (config('frontend.cases_section') == 'on')
        <section class="section case-sec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section__header--secondary">
                        <div class="row align-items-center items-gap">
                            <div class="col-12 col-lg-8">
                                <h2 class="h2 wow fadeInUp" data-wow-duration="600ms">
                                    tech AI Use Cases
                                </h2>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="case-pagination cmn-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if ($case_exists)
                        @foreach ($cases as $case)
                            <div class="case__slider">
                            <div class="case__slider-single" data-background="{{ URL::asset($case->image_url) }}">
                                <div class="thumb">
                                    <i class="tech-camera"></i>
                                </div>
                                <div class="content">
                                    <h5 class="h5">{{ $case->title }}</h5>
                                    <p>
                                        {!! $case->text !!}
                                    </p>
                                    <a href="{{ URL::asset($case->audio_url) }}">
                                        View Details
                                        <i class="fa-solid fa-angles-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="row text-center">
                            <div class="col-sm-12 mt-6 mb-6">
                                <h6 class="fs-12 font-weight-bold text-white text-center">{{ __('No use cases were published yet') }}</h6>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- ==== case start ==== -->
    <!-- ==== broadcast start ==== -->
    <section class="section broadcast pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12 fix-scroll">
                    <div class="broadcast__inner wow fadeInUp" data-wow-duration="600ms" data-background="assets/images/broadcast-bg.png">
                        <div class="row align-items-center items-gap-two">
                            <div class="col-12 col-xl-8 col-xxl-7">
                                <div class="section__content broadcast__inner-content">
                                    <h2 class="h2">Commercial & broadcast rights</h2>
                                    <div class="paragraph">
                                        <p>
                                            Your text to speech synthesized audio files are
                                            securely stored in the cloud. You can also create
                                            drafts and convert the text to audio at a later time.
                                            Clear, consistent, and professional voices for
                                            marketing, explainer, product, and YouTube videos.
                                        </p>
                                    </div>
                                    <div class="section__content-cta">
                                        <a href="contact-us.html" class="btn btn--secondary">
                                            request A Demo
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-5">
                                <div class="broadcast__thumb text-xl-center">
                                    <img src="assets/images/broadcast-thumb.png" alt="Image">
                                </div>
                            </div>
                        </div>
                        <div class="anime">
                            <img src="assets/images/anime-three.png" alt="Image" class="anime-one">
                            <img src="assets/images/anime-two.png" alt="Image" class="anime-two">
                        </div>
                    </div>
                    <div class="broadcast__inner wow fadeInUp" data-wow-duration="600ms" data-background="assets/images/broadcast-bg.png">
                        <div class="row align-items-center items-gap-two">
                            <div class="col-12 col-xl-4 col-xxl-5">
                                <div class="broadcast__thumb text-xl-center">
                                    <img src="assets/images/broadcast-thumb-two.png" alt="Image">
                                </div>
                            </div>
                            <div class="col-12 col-xl-8 col-xxl-7">
                                <div class="section__content broadcast__inner-content">
                                    <h2 class="h2">Team Access for Collaboration</h2>
                                    <div class="paragraph">
                                        <p>
                                            Your text to speech synthesized audio files are
                                            securely stored in the cloud. You can also create
                                            drafts and convert the text to audio at a later time.
                                            Clear, consistent, and professional voices for
                                            marketing, explainer, product, and YouTube videos.
                                        </p>
                                    </div>
                                    <div class="section__content-cta">
                                        <a href="register.html" class="btn btn--secondary">
                                            sign up now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="anime">
                            <img src="assets/images/anime-three.png" alt="Image" class="anime-one">
                            <img src="assets/images/anime-two.png" alt="Image" class="anime-two">
                        </div>
                    </div>
                    <div class="broadcast__inner wow fadeInUp" data-wow-duration="600ms" data-background="assets/images/broadcast-bg.png">
                        <div class="row align-items-center items-gap-two">
                            <div class="col-12 col-xl-8 col-xxl-7">
                                <div class="section__content broadcast__inner-content">
                                    <h2 class="h2">Insanely Powerfull. Easy to use</h2>
                                    <div class="paragraph">
                                        <p>
                                            Your text to speech synthesized audio files are
                                            securely stored in the cloud. You can also create
                                            drafts and convert the text to audio at a later time.
                                            Clear, consistent, and professional voices for
                                            marketing, explainer, product, and YouTube videos.
                                        </p>
                                    </div>
                                    <div class="section__content-cta">
                                        <a href="contact-us.html" class="btn btn--secondary">
                                            request A Demo
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-xl-4 col-xxl-5">
                                <div class="broadcast__thumb text-xl-center">
                                    <img src="assets/images/broadcast-thumb-three.png" alt="Image">
                                </div>
                            </div>
                        </div>
                        <div class="anime">
                            <img src="assets/images/anime-three.png" alt="Image" class="anime-one">
                            <img src="assets/images/anime-two.png" alt="Image" class="anime-two">
                        </div>
                    </div>
                    <div class="broadcast__inner wow fadeInUp" data-wow-duration="600ms" data-background="assets/images/broadcast-bg.png">
                        <div class="row align-items-center items-gap-two">
                            <div class="col-12 col-xl-4 col-xxl-5">
                                <div class="broadcast__thumb text-xl-center">
                                    <img src="assets/images/broadcast-thumb-four.png" alt="Image">
                                </div>
                            </div>
                            <div class="col-12 col-xl-8 col-xxl-7">
                                <div class="section__content broadcast__inner-content">
                                    <h2 class="h2">Life-like Voice clones. As Real</h2>
                                    <div class="paragraph">
                                        <p>
                                            Your text to speech synthesized audio files are
                                            securely stored in the cloud. You can also create
                                            drafts and convert the text to audio at a later time.
                                            Clear, consistent, and professional voices for
                                            marketing, explainer, product, and YouTube videos.
                                        </p>
                                    </div>
                                    <div class="section__content-cta">
                                        <a href="register.html" class="btn btn--secondary">
                                            sign up now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="anime">
                            <img src="assets/images/anime-three.png" alt="Image" class="anime-one">
                            <img src="assets/images/anime-two.png" alt="Image" class="anime-two">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== / broadcast end ==== -->
    <!-- ==== faq start ==== -->
    @if (config('frontend.faq_section') == 'on')
        <section class="section faq pb-0">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-xl-6">
                        <div class="section__header">
                            <h2 class="h2">frequently ask questions</h2>
                        </div>
                    </div>
                </div>
                @if ($faq_exists)
                    <div class="row justify-content-center">
                        <div class="col-12 col-xl-10">
                            <div class="accordion" id="accordion">
                                @foreach ( $faqs as $faq )
                                    <div class="accordion-item wow fadeInUp" data-wow-duration="600ms" data-wow-delay="900ms">
                                        <h5 class="accordion-header" id="heading{{ $faq->id }}">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse-{{ $faq->id }}"
                                                aria-expanded="false"
                                                aria-controls="collapse-{{ $faq->id }}"
                                            >
                                                {{ $faq->question }}
                                            </button>
                                        </h5>
                                        <div
                                            id="collapse-{{ $faq->id }}"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $faq->id }}"
                                            data-bs-parent="#accordion"
                                        >
                                            <div class="accordion-body">
                                                <p>
                                                    {!! $faq->answer !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row text-center">
                        <div class="col-sm-12 mt-6 mb-6">
                            <h6 class="fs-12 font-weight-bold text-white text-center">{{ __('No FAQ answers were published yet') }}</h6>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif
    <!-- ==== / faq end ==== -->

    <!-- ==== language start ==== -->
    <section class="section language pb-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-8">
                    <div class="section__header">
                        <h2 class="h2">AI Voices every language in the world</h2>
                        <p>
                            Generate realistic Text to Speech (TTS) audio using our online
                            AI Voice Generator and the best synthetic voices. Instantly
                            convert text in to natural-sounding speech and download as MP3
                            and WAV audio files.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="language__slider">
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/canada.png" alt="Image">
                </div>
                <p class="fw-5">canada english</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/usa.png" alt="Image">
                </div>
                <p class="fw-5">USA English</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/uk.png" alt="Image">
                </div>
                <p class="fw-5">british english</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/irish.png" alt="Image">
                </div>
                <p class="fw-5">irish english</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/turkish.png" alt="Image">
                </div>
                <p class="fw-5">turkish</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/italy.png" alt="Image">
                </div>
                <p class="fw-5">italian</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/french.png" alt="Image">
                </div>
                <p class="fw-5">french</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/japan.png" alt="Image">
                </div>
                <p class="fw-5">japanese</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/china.png" alt="Image">
                </div>
                <p class="fw-5">chinese</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/india.png" alt="Image">
                </div>
                <p class="fw-5">hindi</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/bangladesh.png" alt="Image">
                </div>
                <p class="fw-5">bengali</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/malay.png" alt="Image">
                </div>
                <p class="fw-5">malay</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/filipine.png" alt="Image">
                </div>
                <p class="fw-5">filipino</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/portugal.png" alt="Image">
                </div>
                <p class="fw-5">Portuguese</p>
            </div>
            <div class="language__slider-single">
                <div class="thumb">
                    <img src="assets/images/flag/australia.png" alt="Image">
                </div>
                <p class="fw-5">Australia</p>
            </div>
        </div>
        <div dir="rtl">
            <div class="language__slider-rtl">
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/canada.png" alt="Image">
                    </div>
                    <p class="fw-5">canada english</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/usa.png" alt="Image">
                    </div>
                    <p class="fw-5">USA English</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/uk.png" alt="Image">
                    </div>
                    <p class="fw-5">british english</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/irish.png" alt="Image">
                    </div>
                    <p class="fw-5">irish english</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/turkish.png" alt="Image">
                    </div>
                    <p class="fw-5">turkish</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/italy.png" alt="Image">
                    </div>
                    <p class="fw-5">italian</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/french.png" alt="Image">
                    </div>
                    <p class="fw-5">french</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/japan.png" alt="Image">
                    </div>
                    <p class="fw-5">japanese</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/china.png" alt="Image">
                    </div>
                    <p class="fw-5">chinese</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/india.png" alt="Image">
                    </div>
                    <p class="fw-5">hindi</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/bangladesh.png" alt="Image">
                    </div>
                    <p class="fw-5">bengali</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/malay.png" alt="Image">
                    </div>
                    <p class="fw-5">malay</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/filipine.png" alt="Image">
                    </div>
                    <p class="fw-5">filipino</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/portugal.png" alt="Image">
                    </div>
                    <p class="fw-5">Portuguese</p>
                </div>
                <div class="language__slider-single">
                    <div class="thumb">
                        <img src="assets/images/flag/australia.png" alt="Image">
                    </div>
                    <p class="fw-5">Australia</p>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== / language end ==== -->

    <!-- ==== review start ==== -->
    @if (config('frontend.reviews_section') == 'on')
        <section class="section review">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-8">
                    <div class="section__header wow fadeInUp" data-wow-duration="600ms">
                        <h2 class="h2">our Customer Reviews</h2>
                    </div>
                </div>
            </div>
            <div class="row items-gap">
                @if ($review_exists)
                    @foreach ($reviews as $review)
                        <div class="col-12 col-lg-6">
                            <div class="review__single wow fadeInUp" data-wow-duration="600ms">
                                <div class="review-head">
                                    <div class="review__icons">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <img src="{{ asset('assets/images/review/icon-one.png') }}" alt="Image">
                                </div>
                                <div class="review-content">
                                    <p class="fw-7">
                                        {{ $review->text }}
                                    </p>
                                </div>
                                <div class="review-meta">
                                    <div class="thumb">
                                        <img src="{{ URL::asset($review->image_url) }}" alt="Image">
                                    </div>
                                    <div class="content">
                                        <p class="h6">{{ $review->name }}</p>
                                        <p>{{ $review->position }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row text-center">
                        <div class="col-sm-12 mt-6 mb-6">
                            <h6 class="fs-12 font-weight-bold text-center text-white">{{ __('No customer reviews were published yet') }}</h6>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    @endif
    <!-- ==== / review end ==== -->

    <!-- ==== cta start ==== -->
    <section class="section cta bg-img ctaa" data-background="assets/images/cta-bg.png">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-6">
                    <div class="section__header m-0 text-center wow fadeInUp" data-wow-duration="600ms">
                        <h2 class="h2">
                            Start creating a custom voice for your brand today
                        </h2>
                        <div class="form-cta">
                            <a href="{{ route('register') }}" class="btn btn--quinary">
                                create free AI voice Over
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== / cta end ==== -->

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







