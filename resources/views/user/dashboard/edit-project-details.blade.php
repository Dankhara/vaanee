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
    <style>
        .form-control:disabled,
        .form-control[readonly] {
            /* /* color: #4a4c4e; */
            /* font-weight: 700;  */
            background: #efeded !important;
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
                <li class="breadcrumb-item active" aria-current="page"><a href="#"> {{ __('Edit Project') }}</a></li>
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
                        {{ __('Project Details') }}</h3>
                </div>
                <div class="card-body pt-5">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 pr-5 pr-minify">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12 pr-0 pr-minify">
                                            <div class="input-box">
                                                <h6 class="task-heading">{{ __('Enter Project Title') }}</h6>
                                                <input placeholder="Enter Project Title" id="project_title"
                                                    class="form-control" name="project_title" required disabled
                                                    value="{{ $project->project_name ?? '' }}" />
                                                <input type="hidden" name="project_type" value="video" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 pr-5 pr-minify">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12 pr-0 pr-minify">
                                            <div class="input-box">
                                                <h6 class="task-heading">{{ __('Select Model') }}</h6>
                                                <select id="project-video-model" name="model"
                                                    data-placeholder="{{ __('Select Model') }}:" class="form-control"
                                                    required disabled>
                                                    <option value="">{{ __('--Select Model--') }}</option>
                                                    @foreach ($models as $item)
                                                        <option value="{{ $item }}" @selected(($project->modal ?? '') === $item)>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($projectType == 'video')
                            <div class="col-md-6 col-sm-12 pr-5 pr-minify">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-12 pr-0 pr-minify">
                                                <div class="input-box">
                                                    <h6 class="task-heading">{{ __('Video Output') }}</h6>
                                                    <div id="audio-format" role="radiogroup">
                                                        <span id="mp3-format">
                                                            <div class="radio-control">
                                                                <input type="checkbox" name="format" class="input-control"
                                                                    id="youtube" value="youtube"
                                                                    onclick="handleCheckboxChange('youtube')" disabled>
                                                                <label for="youtube" class="label-control">YouTube</label>
                                                            </div>
                                                        </span>
                                                        <span id="wav-format">
                                                            <div class="radio-control">
                                                                <input type="checkbox" name="format" class="input-control"
                                                                    id="vlippr" value="vlippr"
                                                                    onclick="handleCheckboxChange('vlippr')" disabled>
                                                                <label for="vlippr" class="label-control"
                                                                    id="vlippr-label">Vlippr</label>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 pr-5 pr-minify">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-12 pr-0 pr-minify">
                                                <div class="input-box">
                                                    <h6 class="task-heading">{{ __('Download') }}</h6>
                                                    <div id="audio-format" role="radiogroup">
                                                        <span id="ogg-format">
                                                            <div class="radio-control">
                                                                <input type="radio" name="downloadable"
                                                                    class="input-control" id="downloadYes" value="yes"
                                                                    checked required>
                                                                <label for="downloadYes" class="label-control"
                                                                    id="download-label-yes">Yes</label>
                                                                <input type="radio" name="downloadable"
                                                                    class="input-control" id="downloadNo" value="no"
                                                                    required>
                                                                <label for="downloadNo" class="label-control"
                                                                    id="download-label-no">No</label>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div id="videoDubMetaDataDiv">
                <div class="card border-0 video-step-two">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid fa-photo-film-music mr-2 text-primary"></i>
                            {{ __('Upload File') }}</h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 border" style="border-width: 5px!important;">
                                @if (isset($project->video_url) && $project->video_url)
                                    <video controls src="{{ $project->video_url }}" width="100%"></video>
                                @else
                                    <div class="row">
                                        <form id="video-form" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-12 col-sm-12">
                                                <!-- CONTAINER FOR AUDIO FILE UPLOADS-->
                                                <div id="upload-container">

                                                    <!-- DRAG & DROP MEDIA FILES -->
                                                    <div class="select-file">
                                                        <input type="file" name="filepond" id="filepond"
                                                            class="filepond" accept=".mp4, .mkv" required />
                                                    </div>
                                                    @error('filepond')
                                                        <p class="text-danger">{{ $errors->first('filepond') }}</p>
                                                    @enderror
                                                </div> <!-- END CONTAINER FOR AUDIO FILE UPLOADS-->
                                            </div>
                                            <div class="col-md-12 col-sm-12 text-center">
                                                <div class="dropdown">
                                                    <span id="processing"><img
                                                            src="{{ URL::asset('/img/svgs/upload.svg') }}"
                                                            alt=""></span>
                                                    <button
                                                        class="btn btn-special create-project file-buttons pl-5 pr-5 mr-4"
                                                        type="button" id="upload-video"
                                                        data-tippy-content="{{ __('Upload Background File') }}">{{ __('Upload File') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8 col-sm-12 upload-video-metadata">
                                <form id="upload-video-metadata" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 pr-5 pr-minify">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-12 pr-0 pr-minify">
                                                            <div class="input-box">
                                                                <h6 class="task-heading">{{ __('Title') }}</h6>
                                                                <input placeholder="Title" id="title"
                                                                    class="form-control video-title" name="title"
                                                                    disabled required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-12 pr-0 pr-minify">
                                                            <div class="input-box">
                                                                <h6 class="task-heading">{{ __('Select Model') }}</h6>
                                                                <select id="audio-video-model" name="model"
                                                                    data-placeholder="{{ __('Select Model') }}:"
                                                                    class="form-control" disabled>
                                                                    @foreach ($models as $item)
                                                                        @if ($project->modal == $item)
                                                                            <option value="{{ $item }}" selected>
                                                                                {{ $item }}</option>
                                                                        @else
                                                                            <option value="{{ $item }}" disabled>
                                                                                {{ $item }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-box">
                                                                <h6 class="task-heading">{{ __('Source language') }}</h6>
                                                                @foreach ($models as $item)
                                                                    <div class="audio-model-lang {{ $item }}">
                                                                        <select class="audio-video-language form-control"
                                                                            name="source"
                                                                            data-placeholder="{{ __('Source language') }}:"
                                                                            disabled required>
                                                                            @foreach (cache($item) as $lang)
                                                                                <option value="{{ $lang }}">
                                                                                    {{ $lang }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6">
                                                            <div class="input-box">
                                                                <h6 class="task-heading">{{ __('Type of language') }}</h6>
                                                                <div id="audio-format" role="radiogroup">
                                                                    <div class="radio-control">
                                                                        <input type="radio" name="language"
                                                                            class="input-control" id="single-audio"
                                                                            value="single-language" checked disabled
                                                                            required>
                                                                        <label for="single-audio"
                                                                            class="label-control">Single
                                                                            Language</label>
                                                                    </div>
                                                                    <div class="radio-control">
                                                                        <input type="radio" name="language"
                                                                            class="input-control" id="multiple-audio"
                                                                            value="multiple-language" disabled required>
                                                                        <label for="multiple-audio"
                                                                            class="label-control">Multiple
                                                                            Language</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12 pl-5 mb-3 pl-minify">
                                            <div class="row">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="row">
                                                            <div class="col-md-12 pr-0 pr-minify">
                                                                <div class="input-box">
                                                                    <h6 class="task-heading">{{ __('Description') }}</h6>
                                                                    <textarea placeholder="Description" id="description" class="form-control video-description" name="description"
                                                                        disabled></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="input-box">
                                                        <h6 class="task-heading">{{ __('Type of speaker') }}</h6>
                                                        <div id="type-of-speaker" role="radiogroup">
                                                            <div class="radio-control">
                                                                <input type="radio" name="speaker"
                                                                    class="input-control" id="single-speaker"
                                                                    value="single-speaker" checked disabled
                                                                    style="background-color: #007BFF;
                                                                color: #FFF;
                                                                transition: all 0.2s;">
                                                                <label for="single-speaker" class="label-control">Single
                                                                    Speaker</label>
                                                            </div>
                                                            <div class="radio-control">
                                                                <input type="radio" name="speaker"
                                                                    class="input-control" id="multiple-speaker"
                                                                    value="multiple-speaker" disabled>
                                                                <label for="multiple-speaker"
                                                                    class="label-control">Multiple
                                                                    Speaker</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 mt-2">
                                                    <div class="input-box">
                                                        <h6 class="task-heading">{{ __('Choose Your Voice') }}</h6>
                                                        <select id="voicesq" name="voice"
                                                            data-placeholder="{{ __('Choose Your Voice') }}:"
                                                            data-callback="voice_select" class="form-control" disabled>
                                                            <option>Sample voice1</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-4 pl-minify">
                                        </div>
                                        <div class="col-md-12 col-sm-8 pl-minify">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12" id="audio-format-minify">
                                                    <div class="input-box">
                                                        <h6 class="task-heading">{{ __('Target language') }}</h6>
                                                        <div class="single-target-language">
                                                            @foreach ($models as $item)
                                                                <div class="audio-model-lang {{ $item }} row">
                                                                    @foreach (cache($item) as $lang)
                                                                        <div class="col-md-4 col-sm-4">
                                                                            <div class="form-group">
                                                                                <label class="custom-switch">
                                                                                    <input type="radio"
                                                                                        value="{{ $lang }}"
                                                                                        name="single_target_language"
                                                                                        class="custom-switch-input"
                                                                                        disabled>
                                                                                    <span
                                                                                        class="custom-switch-indicator"></span>
                                                                                    <span
                                                                                        class="custom-switch-description">{{ $lang }}</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="multiple-target-language">
                                                            @foreach ($models as $item)
                                                                <div class="audio-model-lang {{ $item }} row">
                                                                    @foreach (cache($item) as $lang)
                                                                        <div class="col-md-4 col-sm-4">
                                                                            <div class="form-group">
                                                                                <label class="custom-switch">
                                                                                    <input type="checkbox"
                                                                                        value="{{ $lang }}"
                                                                                        name="multi_target_language[]"
                                                                                        class="custom-switch-input language-custom-switch-input"
                                                                                        disabled="true">
                                                                                    <span
                                                                                        class="custom-switch-indicator"></span>
                                                                                    <span
                                                                                        class="custom-switch-description">{{ $lang }}</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 col-sm-12 text-right">
                                <div class="input-box mb-4">
                                    <span id="processing"><img src="{{ URL::asset('/img/svgs/processing.svg') }}"
                                            alt=""></span>
                                    <button class="btn btn-special create-project file-buttons pl-6 pr-6 video-button-next"
                                        type="button" id="vidoe-meta-data">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 video-step-three">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-photo-film-music mr-2 text-primary"></i>
                        {{ __('Video Dub Studio') }}</h3>
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
    <script src="{{ URL::asset('js/vaanee-studio-manager.js') }}"></script>
    <!-- Awselect JS -->
    <script src="{{ URL::asset('plugins/awselect/awselect.min.js') }}"></script>
    <script src="{{ URL::asset('js/awselect.js') }}"></script>
    @if (isset($project->video_url) && $project->video_url)
        <script>
            // localStorage.setItem('id', data.response.id);
            localStorage.setItem('s3_url', '{{ $project->video_url }}');
            $('#audio-video-model').prop("disabled", false);
            $('input:radio[name=language]').prop("disabled", false);
            $('.audio-video-language').prop("disabled", false);
            $('.video-title').prop("disabled", false);
            $('.video-description').prop("disabled", false);
            $('input:radio[name=single_target_language]').prop(
                "disabled", false);
            $('.language-custom-switch-input').prop("disabled", false);
        </script>
    @endif
    <script type="text/javascript">
        $(function() {

            "use strict";
            // $('.video-step-two').css('display', 'block');
            $('.video-step-three').css('display', 'none');

            // user.video.create-project
            $('.multiple-target-language').hide();
            $('input:radio[name=language]').change(function() {
                if ($(this).val() == 'single-language') {
                    $('.multiple-target-language').hide();
                    $('.single-target-language').show();
                }
                if ($(this).val() == 'multiple-language') {
                    $('.single-target-language').hide();
                    $('.multiple-target-language').show();
                }
            });

            $('.model_2').hide();
            $('#audio-video-model').on('change', function() {
                $('.audio-model-lang').hide();
                $('.' + $(this).val()).show();
            });

            $('#project-btn').click(function(e) {
                e.preventDefault();
                var form = document.getElementById("project-title-form");
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return false;
                }
                var formData = new FormData(form);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('user.video.create-project') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#project-btn').html('');
                        $('#project-btn').addClass('merge-processing');
                        $('#project-btn').prop('disabled', true);
                        $('#processing').show().clone().appendTo('#project-btn');
                        $('#processing').hide();
                        $('#project-btn').html('Next');
                    },
                    complete: function() {
                        $('#project-btn').prop('disabled', false);
                        $('#project-btn').removeClass('merge-processing');
                        $('#processing', '#project-btn').empty().remove();
                        $('#processing').hide();
                        $('#project-btn').html('Next');
                    },
                    success: function(data) {
                        $("#videoDubMetaDataDiv").css("display", "block");
                        localStorage.removeItem('project_id');
                        localStorage.removeItem('current_step');
                        localStorage.setItem('project_id', data.response.project_id);
                        localStorage.setItem('current_step', data.response.current_step);
                        // $('.video-step-one').css('display', 'none');
                        $('#project-btn').css('display', 'none');
                        $('.video-step-three').css('display', 'none');
                        $('.video-step-two').css('display', 'block');
                        var selectedModel = $("#project-video-model").val();
                        $('#audio-video-model').val(selectedModel);
                        $('#audio-video-model option').prop('disabled', function() {
                            return $(this).val() !== selectedModel;
                        });
                        $('.audio-model-lang').hide();
                        $('.' + selectedModel).show();
                        var formElements = document.getElementById('project-title-form')
                            .elements;
                        Array.from(formElements).forEach(element => element.disabled = true);
                        Swal.fire({
                            text: 'Project details saved successfully.',
                            // icon: 'success',
                            timer: 2000, // Time in milliseconds (3 seconds in this example)
                            // showConfirmButton: false // Hide the "OK" button
                        });
                    },
                    error: function(data) {
                        // if (data.responseJSON['error']) {
                        Swal.fire('Text to Speech Notification', data.responseJSON['error'],
                            'warning');
                        // }
                    }
                });
            });
            let video_metadata_id = '{{ $project->video_metadata_id }}';
            let video_url = '{{ $project->video_url }}';
            $('#vidoe-meta-data').click(function(e) {
                e.preventDefault();
                var form = document.getElementById("upload-video-metadata");
                if (!form.reportValidity()) {
                    return;
                }
                localStorage.getItem('id');
                localStorage.getItem('s3_url');
                var formData = new FormData(form);
                if (video_metadata_id && video_url) {
                    formData.append('id', video_metadata_id);
                    formData.append('s3_url', video_url);
                } else {
                    formData.append('id', localStorage.getItem('id'));
                    formData.append('s3_url', localStorage.getItem('s3_url'));
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('user.video.upload.meta-data') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#vidoe-meta-data').html('');
                        $('#vidoe-meta-data').addClass('merge-processing');
                        $('#vidoe-meta-data').prop('disabled', true);
                        $('#processing').show().clone().appendTo('#vidoe-meta-data');
                        $('#processing').hide();
                        $('#vidoe-meta-data').html('Next');
                    },
                    complete: function() {
                        $('#vidoe-meta-data').prop('disabled', false);
                        $('#vidoe-meta-data').removeClass('merge-processing');
                        $('#processing', '#vidoe-meta-data').empty().remove();
                        $('#processing').hide();
                        $('#vidoe-meta-data').html('Next');
                    },
                    success: function(data) {
                        console.log(data);
                        $('.video-step-one').css('display', 'none');
                        $('.video-step-three').css('display', 'none');
                        $('.video-step-four').css('display', 'none');
                        $('.video-step-two').css('display', 'block');
                        Swal.fire(
                            'Your project has been submitted successfully! You can check in my project.'
                        ).then((result) => {
                            // Check if the user clicked "OK" or closed the alert
                            if (result.isConfirmed || result.isDismissed) {
                                // Reload the page
                                location.href = '/account/projects';
                            }
                        });

                    },
                    error: function(data) {
                        // if (data.responseJSON['error']) {
                        Swal.fire('Text to Speech Notification', data.responseJSON['error'],
                            'warning');
                        // }
                    }
                });
            });

            let duration = 0;
            $('#upload-video').click(function(e) {
                e.preventDefault();
                var max_available_characters = {{ auth()->user()->available_chars }};
                var char_per_second = {{ config('tts.characters_multiplier_per_second') }};
                var video_dub_studio_multiplier =
                    {{ $project->project_type == 'video' ? config('tts.video_dub_studio_multiplier') : config('tts.audio_dub_studio_multiplier') }};
                var characters_required_for_upload = 0;
                var inputAudio = [];
                if (pond.getFiles().length !== 0) {
                    pond.getFiles().forEach(function(file) {
                        inputAudio.push(file);
                    });
                }
                // var form = document.getElementById("video-form");
                var formData = new FormData();
                formData.append('video', inputAudio[0].file);
                formData.append('project_id', localStorage.getItem('project_id'));
                formData.append('current_step', localStorage.getItem('current_step'));
                var fileInput = inputAudio[0].file;
                const mediaElement = document.createElement(fileInput.type.startsWith('audio') ? 'audio' :
                    'video');
                mediaElement.preload = 'metadata';
                const getDuration = () => new Promise((resolve) => {
                    mediaElement.onloadedmetadata = () => {
                        resolve(mediaElement.duration);
                    };
                });
                mediaElement.src = URL.createObjectURL(fileInput);
                getDuration().then((duration) => {
                    characters_required_for_upload = duration * char_per_second *
                        video_dub_studio_multiplier;
                    if (characters_required_for_upload > max_available_characters) {
                        Swal.fire('Insufficient Credits',
                            'You do not have the sufficient character balance for uploading your file.',
                            'warning');
                        return;
                    }
                    formData.append('characters_required_for_upload',
                        characters_required_for_upload);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: '{{ route('user.video.upload') }}',
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('#upload-video').html('');
                            $('#upload-video').addClass('merge-processing');
                            $('#upload-video').prop('disabled', true);
                            $('#processing').show().clone().appendTo('#upload-video');
                            $('#processing').hide();
                        },
                        complete: function() {
                            $('#upload-video').prop('disabled', false);
                            $('#upload-video').removeClass('merge-processing');
                            $('#processing', '#upload-video').empty().remove();
                            $('#processing').hide();
                            $('#upload-video').html('Upload Files');
                        },
                        success: function(data) {
                            localStorage.removeItem('id');
                            localStorage.removeItem('s3_url');
                            localStorage.setItem('id', data.response.id);
                            localStorage.setItem('s3_url', data.response.s3_url);
                            $('#audio-video-model').prop("disabled", false);
                            $('input:radio[name=language]').prop("disabled", false);
                            $('.audio-video-language').prop("disabled", false);
                            $('.video-title').prop("disabled", false);
                            $('.video-description').prop("disabled", false);

                            $('input:radio[name=single_target_language]').prop(
                                "disabled", false);
                            $('.language-custom-switch-input').prop("disabled", false);
                            Swal.fire('Video uploaded successfully.');
                        },
                        error: function(data) {
                            // if (data.responseJSON['error']) {
                            Swal.fire('Text to Speech Notification', data.responseJSON[
                                    'error'],
                                'warning');
                            // }
                        }
                    });
                });
            });
        });
    </script>
    <script>
        function handleCheckboxChange(checkboxId) {
            // Get the checkboxes
            var youtubeCheckbox = document.getElementById('youtube');
            var vlipprCheckbox = document.getElementById('vlippr');

            // Uncheck the other checkbox when one is checked
            if (checkboxId === 'youtube' && youtubeCheckbox.checked) {
                vlipprCheckbox.checked = false;
            } else if (checkboxId === 'vlippr' && vlipprCheckbox.checked) {
                youtubeCheckbox.checked = false;
            }
        }
    </script>
@endsection
