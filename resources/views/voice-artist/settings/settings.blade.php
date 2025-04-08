@extends('layouts.app')

@section('css')
    <!-- Sweet Alert CSS -->
    <link href="{{ URL::asset('plugins/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
    <!-- Data Table CSS -->
    <link href="{{ URL::asset('plugins/datatable/datatables.min.css') }}" rel="stylesheet" />
    <!-- Awselect CSS -->
    <link href="{{ URL::asset('plugins/awselect/awselect.min.css') }}" rel="stylesheet" />
    <!-- Flipclock CSS -->
    <link href="{{ URL::asset('plugins/flipclock/flipclock.css') }}" rel="stylesheet" />
    <!-- Green Audio Players CSS -->
    <link href="{{ URL::asset('plugins/audio-player/green-audio-player.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ URL::asset('plugins/filepond/filepond.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Settings') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('user.dashboard') }}"><i
                            class="fa-solid fa-chart-tree-map mr-2 fs-12"></i>{{ __('User') }}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ url('#') }}"> {{ __('Audio Settings') }}</a>
                </li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body pt-7 pl-7 pr-7 pb-4" id="tts-body-minify">
                    <form action="{{ route('voice.artist.save.audio.settings') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-box">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-sm-12 col-md-35 col-lg-3 col-xl-3">
                                                <h6 class="task-heading" style="margin-top: -10px;">
                                                    {{ __('Default Language') }}</h6>
                                            </div>
                                            <div class="col-sm-12 col-md-9">
                                                <select class="form-control" id="default_languages"
                                                    name="default_languages[]"
                                                    data-placeholder="{{ __('Default Language') }}:" width="100%"
                                                    multiple required>
                                                    @foreach ($languages as $language)
                                                        <option value="{{ $language->language_code }}"
                                                            @selected(in_array($language->language_code, $default_audio_settings))>
                                                            {{ $language->language }}</option>
                                                    @endforeach
                                                </select>
                                                {{-- <select id="default_languages" name="language[]"
                                                    data-placeholder="{{ __('Default Language') }}:"
                                                    data-callback="language_select" width="100%" multiple>
                                                    @foreach ($languages as $language)
                                                        <option value="{{ $language->language_code }}"
                                                            data-img="{{ URL::asset($language->language_flag) }}">
                                                            {{ $language->language }}</option>
                                                    @endforeach
                                                </select> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-box">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-sm-12 col-md-35 col-lg-3 col-xl-3">
                                                <h6 class="task-heading" style="margin-top: -10px;">
                                                    {{ __('Preferred Language') }}</h6>
                                            </div>
                                            <div class="col-sm-12 col-md-9">
                                                <select class="form-control" id="preferred-languages"
                                                    name="preferred_language[]"
                                                    data-placeholder="{{ __('Preferred Language') }}:" width="100%"
                                                    multiple required>
                                                    @foreach ($languages as $language)
                                                        <option value="{{ $language->language_code }}"
                                                            @selected(in_array($language->language_code, $preferred_audio_settings))>
                                                            {{ $language->language }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 text-center mt-3">
                            <span id="processing"><img src="{{ URL::asset('/img/svgs/processing.svg') }}"
                                    alt=""></span>
                            <button type="submit"
                                class="btn btn-primary main-action-button mr-2">{{ __('Save Changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#default_languages').select2();
        $('#preferred-languages').select2();
    </script>
@endsection
