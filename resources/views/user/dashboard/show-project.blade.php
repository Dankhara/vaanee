@extends('layouts.app')
@section('css')
    <!-- Green Audio Player CSS -->
    <link href="{{ URL::asset('plugins/audio-player/green-audio-player.css') }}" rel="stylesheet" />
    <style>
        .lang-btn {
            border-radius: 35px;
            background: #007bFF;
            color: white;
            font-size: 10px;
        }

        .lang-btn:hover {
            background: black;
            color: white;
        }

        .d-flex.justify-content-between {
            cursor: pointer;
        }

        .active-lng {
            background: green !important;
            color: white !important;
        }
    </style>
@endsection

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Project Details') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i
                            class="fa-solid fa-boxes-packing mr-2 fs-12"></i>{{ __('User') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.projects') }}">
                        {{ __('Project') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#"> {{ __('View Result') }}</a></li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden border-0">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">{{ __('Project Details') }} </h3>
                    <div><i class="fa fa-refresh refresh-video-audio" onclick="window.location.reload();"></i></div>
                </div>
                <div class="card-body pt-5 mb-5">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12">
                            <h6 class="font-weight-bold mb-1">{{ __('Project Name') }}: </h6>
                            <span class="fs-14 font-weight-bold">{{ $project->project_name ?? 'N/A' }}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <h6 class="font-weight-bold mb-1">{{ __('Project Type') }} </h6>
                            <span class="fs-14">{{ $project->project_type ?? 'N/A' }}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <h6 class="font-weight-bold mb-1">{{ __('Model') }}: </h6>
                            <span class="fs-14">{{ $project->modal ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="row pt-4">
                        <div class="col-lg-4 col-md-4 col-12">
                            <h6 class="font-weight-bold mb-1">{{ __('Video Title') }}: </h6>
                            <span class="fs-14">{{ $project->title ?? 'N/A' }}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <h6 class="font-weight-bold mb-1">{{ __('Video Description') }}: </h6>
                            <span class="fs-14">{{ $project->description ?? 'N/A' }}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <h6 class="font-weight-bold mb-1">{{ __('Source Language') }}: </h6>
                            <span class="fs-14">{{ $project->source_lang ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-lg-4 col-md-4 col-12">
                            <h6 class="font-weight-bold mb-1">{{ __('Created Date') }}: </h6>
                            <span class="fs-14 font-weight-bold">
                                @isset($project->created_on)
                                    {{ date('d-m-Y', strtotime($project->created_on)) ?? '' }}
                                @else
                                    N/A
                                @endisset
                            </span>
                        </div>
                        {{-- <div class="col-lg-4 col-md-4 col-12">
                            <h6 class="font-weight-bold mb-1">{{ __('Project Type') }} </h6>
                            <span class="fs-14">{{ $project->project_type ?? '' }}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <h6 class="font-weight-bold mb-1">{{ __('Model') }}: </h6>
                            <span class="fs-14">{{ $project->modal ?? '' }}</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden border-0">
                @if (isset($project->processed_video_url) && $project->processed_video_url)
                    <video id="my-videojs-player" class="video-js vjs-big-play-centered" controls preload="auto"
                        data-setup='{}'
                        style="width: 100%;height:287px;border-image: url('./frame-light.png');">
                        <source src="{{ $project->processed_video_url ?? '' }}" type="application/x-mpegURL">
                        </source>
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a
                            web browser that
                            <a href="https://videojs.com/html5-video-support/" target="_blank">
                                supports HTML5 video
                            </a>
                        </p>
                    </video>
                @elseif (isset($project->processed_audio_url) && $project->processed_audio_url)
                    <div class="card-body pt-5 mb-5">
                        @foreach($project->processed_audio_url as $audio_lang => $audio_url)
                        <p>{{ $audio_lang }}</p>
                        <div class="row">
                            <div class="col-1" style="padding-top: 10px;">
                                <span style="cursor: pointer;" class="play-button"><i data-lang="{{ $audio_lang }}" class="fa fa-play video-button"
                                        style="font-size:36px;"></i></span>
                            </div>
                            <div class="col-11">
                                <div id="lang_audio_{{ $audio_lang }}" class="video-waveform-english" style="padding-bottom: 22px;"></div>
                            </div>
                        </div>
                        <!-- <audio controls>
                            <source src="{{ $audio_url }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio> -->
                        @endforeach
                    </div>
                @else
                    @isset($project->project_type)
                        @if ($project->project_type == 'video')
                            <div class="card-header d-inline border-0"
                                style="margin-top: 5rem !important;margin-bottom: 5rem !important;">
                                <div>
                                    <h3 class="card-title fs-24 font-weight-800">{{ __('Processing Video...') }}</h3>
                                </div>
                                <div class="progress mb-4">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning zip-bar"
                                        role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card-header d-inline border-0"
                                style="margin-top: 5rem !important;margin-bottom: 5rem !important;">
                                <div>
                                    <h3 class="card-title fs-24 font-weight-800">{{ __('Processing Audio...') }}</h3>
                                </div>
                                <div class="progress mb-4">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning zip-bar"
                                        role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endisset
                @endif
            </div>
        </div>
    </div>
    @php
        $firstAudio = '';
    @endphp
    {{-- <div class="row">
        <div class="col-lg-12 col-md-12 col-xm-12">
            @php
                $firstAudio = '';
            @endphp
            @if (isset($project->audio_url))
                @php
                    $audioes = $project->audio_url;
                    $firstAudio = '';
                @endphp
                <div class="card overflow-hidden border-0" style="padding: 15px;">
                    <div class="d-flex flex-row" style="padding-bottom: 35px;">
                        <div class="p-2 mt-2"><b>Languages : </b></div>
                        @foreach ($audioes as $key => $item)
                            @if ($loop->first)
                                @php
                                    $firstAudio = $item;
                                @endphp
                            @endif
                            <div class="p-2"><button
                                    class="btn btn-light form-control lang-btn @if ($loop->first) active-lng @endif"
                                    data-value="{{ config('lang.' . $key) }}" data-url="{{ $item ?? '' }}"
                                    style="width: 139px;height: 39px;">{{ config('lang.' . $key) }}</button></div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-1" style="padding-left: 64px;padding-top: 10px;">
                            <span style="cursor: pointer;" class="play-button"><i class="fa fa-play video-button"
                                    style="font-size:36px;"></i></span>
                        </div>
                        <div class="col-11">
                            <div id="lang_audio" class="video-waveform-english" style="padding-bottom: 22px;"></div>
                        </div>
                    </div>
                </div>
            @endif


        </div>
    </div> --}}
@endsection

@section('js')
    <!-- Link Share JS -->
    <script src="{{ URL::asset('js/link-share.js') }}"></script>
    <!-- Green Audio Player JS -->
    <!-- <script src="{{ URL::asset('plugins/audio-player/green-audio-player.js') }}"></script> -->
    <!-- <script src="{{ URL::asset('js/audio-player.js') }}"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/video.js/dist/video-js.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/video.js/dist/video.min.js"></script>
    <script src="https://unpkg.com/wavesurfer.js@7/dist/wavesurfer.min.js"></script>
    <script src="https://unpkg.com/wavesurfer.js@7/dist/plugins/timeline.min.js"></script>
    <script type="text/javascript">
        $(function() {

            'use strict';
            // var audio = '';

            const defaultTimeline = WaveSurfer.Timeline.create({
                height: 10,
                insertPosition: 'beforebegin',
                timeInterval: 0.5,
                primaryLabelInterval: 10,
                style: {
                    fontSize: '10px',
                    color: '#FFFFFF',
                },
            });

            var wavesurferContainers = {};

            @if(isset($project->processed_audio_url) && $project->processed_audio_url)
                @foreach($project->processed_audio_url as $audio_lang => $audio_url)
                        var wt = WaveSurfer.create({
                        container: '#lang_audio_{{ $audio_lang }}',
                        waveColor: '#20AEF1',
                        progressColor: '#383351',
                        height: 60,
                        hideScrollbar: true,
                        url: '{{ $audio_url }}',
                        minPxPerSec: 0,
                        xhr: {
                            cache: "default",
                            mode: "no-cors",
                            method: "GET"
                        },
                        plugins: [defaultTimeline]
                    }); 
                    wavesurferContainers['{{ $audio_lang }}'] = wt;
                @endforeach
            @endif

            $('.video-button').click(function() {
                if ($(this).hasClass('fa-play') === true) {
                    $(this).removeClass('fa-play');
                    $(this).addClass('fa-pause');
                } else {
                    $(this).removeClass('fa-pause');
                    $(this).addClass('fa-play');
                }
                wavesurferContainers[$(this).attr('data-lang')].playPause()
            });
        });
    </script>
@endsection
