@extends('layouts.app')
@section('css')
    <!-- Data Table CSS -->
    <!-- Awselect CSS -->
    <link href="{{ URL::asset('plugins/awselect/awselect.min.css') }}" rel="stylesheet" />
    <!-- Green Audio Player CSS -->
    <link href="{{ URL::asset('plugins/audio-player/green-audio-player.css') }}" rel="stylesheet" />
    <!-- FilePond CSS -->
    <link href="{{ URL::asset('plugins/filepond/filepond.css') }}" rel="stylesheet" />
    <!-- Sweet Alert CSS -->
    <link href="{{ URL::asset('plugins/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Audio Enhancement') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i
                            class="fa-solid fa-photo-film-music mr-2 fs-12"></i>{{ __('User') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('user.sound.studio') }}">
                        {{ __('Audio Enhancement') }}</a></li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection
@php
    $musics = [];
    $js['row_limit'] = 5;
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card border-0 video-step-one">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-photo-film-music mr-2 text-primary"></i>
                        {{ __('Create New Project') }}</h3>
                </div>
                <div class="card-body pt-5">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <!-- CONTAINER FOR AUDIO FILE UPLOADS-->
                                    <div id="upload-container">

                                        <!-- DRAG & DROP MEDIA FILES -->
                                        <div class="select-file">
                                            <input type="file" name="filepond" id="filepond" class="filepond" />
                                        </div>
                                        @error('filepond')
                                            <p class="text-danger">{{ $errors->first('filepond') }}</p>
                                        @enderror

                                    </div> <!-- END CONTAINER FOR AUDIO FILE UPLOADS-->
                                </div>
                                <div class="col-md-12 col-sm-12 text-center">
                                    <div class="dropdown">
                                        <span id="processing"><img src="{{ URL::asset('/img/svgs/upload.svg') }}"
                                                alt=""></span>
                                        <button class="btn btn-special create-project file-buttons pl-5 pr-5 mr-4"
                                            type="button" id="upload-music"
                                            data-tippy-content="{{ __('Upload Background Music Audio File') }}">{{ __('Upload Music File') }}</button>
                                        <a class="btn btn-special create-project file-buttons pl-5 pr-5"
                                            href="{{ route('user.sound.studio.music.list') }}" id="list-music"
                                            data-tippy-content="{{ __('View All Your Uploaded Background Music Audio Files') }}">{{ __('View Music Files') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 pr-5 pr-minify">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12 pr-0 pr-minify">
                                            <div class="input-box">
                                                <h6 class="task-heading">{{ __('Enter Project Title') }}</h6>
                                                <input placeholder="Enter Project Title" class="form-control"
                                                    name="project_title" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-6 pr-0 pr-minify">
                                            <div class="input-box">
                                                <h6 class="task-heading">{{ __('Source language') }}</h6>
                                                <select id="audio-video-language" name="background-volume"
                                                    data-placeholder="{{ __('Source language') }}:">
                                                    <option value="1.5">{{ __('Hindi') }}</option>
                                                    <option value="2">{{ __('English') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 pr-0 pr-minify">
                                            <div class="input-box">
                                                <h6 class="task-heading">{{ __('Select Model') }}</h6>
                                                <select id="audio-video-model" name="background-volume"
                                                    data-placeholder="{{ __('Select Model') }}:">
                                                    <option value="1.5">{{ __('Single Audio') }}</option>
                                                    <option value="2">{{ __('Multi Audio') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 pl-5 pl-minify">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 mb-4">
                                    <div class="input-box">
                                        <h6 class="task-heading">{{ __('Type of Audio') }}</h6>
                                        <div id="audio-format" role="radiogroup">
                                            <div class="radio-control">
                                                <input type="radio" name="audio" class="input-control" id="single-audio"
                                                    value="single-audio" checked>
                                                <label for="single-audio" class="label-control">Single Audio</label>
                                            </div>
                                            <div class="radio-control">
                                                <input type="radio" name="audio" class="input-control"
                                                    id="multiple-audio" value="multiple-audio">
                                                <label for="multiple-audio" class="label-control">Multiple Audio</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="input-box">
                                        <h6 class="task-heading">{{ __('Type of speaker') }}</h6>
                                        <div id="audio-format" role="radiogroup">
                                            <div class="radio-control">
                                                <input type="radio" name="speaker" class="input-control"
                                                    id="single-speaker" value="single-speaker" checked>
                                                <label for="single-speaker" class="label-control">Single Speaker</label>
                                            </div>
                                            <div class="radio-control">
                                                <input type="radio" name="speaker" class="input-control"
                                                    id="multiple-speaker" value="multiple-speaker">
                                                <label for="multiple-speaker" class="label-control">Multiple
                                                    Speaker</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-12 col-sm-12">
                                <div class="input-box">
                                    <h6 class="task-heading">{{ __('Type of Audio') }}</h6>
                                    <select id="voices" name="voice"
                                        data-placeholder="{{ __('Choose Your Voice') }}:" data-callback="voice_select">
                                        @foreach ($voices as $voice)
                                            <option value="{{ $voice->voice_id }}" id="{{ $voice->voice_id }}"
                                                data-img="{{ URL::asset($voice->avatar_url) }}"
                                                data-id="{{ $voice->voice_id }}" data-lang="{{ $voice->language_code }}"
                                                data-type="{{ $voice->voice_type }}" data-gender="{{ $voice->gender }}"
                                                data-voice="{{ $voice->voice }}"
                                                data-url="{{ URL::asset($voice->sample_url) }}"
                                                @if (config('tts.user_neural') == 'disable') data-usage= "@if (auth()->user()->group == 'user' && $voice->voice_type == 'neural') avoid-clicks @endif"
                                                @endif
                                                @if (auth()->user()->voice == $voice->voice_id) selected @endif
                                                data-class="@if (auth()->user()->language !== $voice->language_code) remove-voice @endif">
                                                {{ $voice->voice }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md-4 col-sm-4 pl-minify">
                        </div>
                        {{-- <div class="col-md-8 col-sm-8 pl-minify">
                            <div class="row">
                                <div class="col-md-12 col-sm-12" id="audio-format-minify">
                                    <div class="input-box">
                                        <h6 class="task-heading">{{ __('Target language') }}</h6>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4">
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="enable-aws"
                                                            class="custom-switch-input"
                                                            @if (config('stt.enable.aws') == 'on') checked @endif>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">{{ __('Hindi') }}</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="enable-aws"
                                                            class="custom-switch-input"
                                                            @if (config('stt.enable.aws') == 'on') checked @endif>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">{{ __('English') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="enable-aws"
                                                            class="custom-switch-input"
                                                            @if (config('stt.enable.aws') == 'on') checked @endif>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">{{ __('Marathi') }}</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="enable-aws"
                                                            class="custom-switch-input"
                                                            @if (config('stt.enable.aws') == 'on') checked @endif>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">{{ __('Bangali') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="enable-aws"
                                                            class="custom-switch-input"
                                                            @if (config('stt.enable.aws') == 'on') checked @endif>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">{{ __('Gujrati') }}</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="enable-aws"
                                                            class="custom-switch-input"
                                                            @if (config('stt.enable.aws') == 'on') checked @endif>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">{{ __('Tamil') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-12 text-right">
                            <div class="input-box mb-4">
                                <span id="processing"><img src="{{ URL::asset('/img/svgs/processing.svg') }}"
                                        alt=""></span>
                                <button class="btn btn-special create-project file-buttons pl-6 pr-6 video-button-next"
                                    type="button" id="merge-button">{{ __('Next') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 video-step-two">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-photo-film-music mr-2 text-primary"></i>
                        {{ __('Video Dub Studio') }}</h3>
                </div>
                <div class="card-body pt-5">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-box">
                                        <select id="audio-video-country" name="background-volume"
                                            data-placeholder="{{ __('Select Language') }}:">
                                            <option value="1.5">{{ __('USA English') }}</option>
                                            <option value="2">{{ __('India') }}</option>
                                        </select>
                                    </div>

                                    <div class="input-box">
                                        <div id="audio-format" role="radiogroup">
                                            <div class="radio-control">
                                                <input type="radio" name="speaker" class="input-control"
                                                    id="single-speaker" value="single-speaker" checked>
                                                <label for="single-speaker" class="label-control">MP3</label>
                                            </div>
                                            <div class="radio-control">
                                                <input type="radio" name="speaker" class="input-control"
                                                    id="multiple-speaker" value="multiple-speaker">
                                                <label for="multiple-speaker" class="label-control">WAV</label>
                                            </div>
                                            <div class="radio-control">
                                                <input type="radio" name="speaker" class="input-control"
                                                    id="single-speaker" value="single-speaker" checked>
                                                <label for="single-speaker" class="label-control">OGG</label>
                                            </div>
                                            <div class="radio-control">
                                                <input type="radio" name="speaker" class="input-control"
                                                    id="multiple-speaker" value="multiple-speaker">
                                                <label for="multiple-speaker" class="label-control">WEBM</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="input-box">
                                        <input placeholder="Enter Project Title" class="form-control"
                                            name="project_title" />
                                    </div>
                                    <div class="input-box">
                                        <select id="audio-video-title" name="background-volume"
                                            data-placeholder="{{ __('Select Language') }}:">
                                            <option value="1.5">{{ __('USA English') }}</option>
                                            <option value="2">{{ __('India') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var config = {
            routes: {
                zone: "{{ route('sound-studio.settings') }}"
            }
        };
    </script>
    <!-- Green Audio Player JS -->
    <script src="{{ URL::asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/audio-player/green-audio-player.js') }}"></script>
    <script src="{{ URL::asset('js/audio-player.js') }}"></script>
    <!-- Data Tables JS -->
    <!-- FilePond JS -->
    <script src={{ URL::asset('plugins/filepond/filepond.min.js') }}></script>
    <script src={{ URL::asset('plugins/filepond/filepond-plugin-file-validate-size.min.js') }}></script>
    <script src={{ URL::asset('plugins/filepond/filepond-plugin-file-validate-type.min.js') }}></script>
    <script src={{ URL::asset('plugins/filepond/filepond.jquery.js') }}></script>
    <script src="{{ URL::asset('js/project-manager.js') }}"></script>
    <!-- Awselect JS -->
    <script src="{{ URL::asset('plugins/awselect/awselect.min.js') }}"></script>
    <script src="{{ URL::asset('js/awselect.js') }}"></script>

    <script type="text/javascript">
        $(function() {

            "use strict";
            $('.video-step-two').css('display', 'none');
            $('.video-button-next').click(function() {
                $('.video-step-one').css('display', 'none');
                $('.video-step-two').css('display', 'block');
            });

        });
    </script>
@endsection
