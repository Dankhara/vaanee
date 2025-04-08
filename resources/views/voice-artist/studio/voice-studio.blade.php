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
    <link href="{{ URL::asset('plugins/filepond/filepond.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Studio') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('user.dashboard') }}"><i
                            class="fa-solid fa-chart-tree-map mr-2 fs-12"></i>{{ __('User') }}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ url('#') }}"> {{ __('Studio') }}</a>
                </li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xm-12">
            <div class="card border-0">
                <div class="card-body pt-7 pl-7 pr-7 pb-4" id="tts-body-minify">

                    <form id="store-user-voice-profile-script"
                        action="{{ route('user.upload.user.voice.profile.script') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <div class="input-box">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-sm-12 col-md-5 col-lg-4 col-xl-3">
                                                <h6 class="task-heading" style="margin-top: -10px;">
                                                    {{ __('Default Language') }}</h6>
                                            </div>
                                            <div class="col-sm-12 col-md-7">
                                                <select id="studio-default-language" name="language"
                                                    data-placeholder="{{ __('Default Language') }}:"
                                                    data-callback="language_select" width="100%">
                                                    @foreach ($languages as $language)
                                                        @if (in_array($language->language_code, $default_audio_settings))
                                                            <option value="{{ $language->language_code }}"
                                                                data-img="{{ URL::asset($language->language_flag) }}">
                                                                {{ $language->language }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 border" style="border-width: 5px!important;">
                                <div class="row text-center" style="padding-top: 13px;">
                                    <div class="col-12 ">
                                        <audio controls style="width: 100%">
                                            <source src="your-audio-file.mp3" type="audio/mp3">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 pr-0 pr-minify">
                                                <div class="input-box">
                                                    <h6 class="task-heading">{{ __('Script') }}</h6>
                                                    <textarea name="script" class="form-control" rows="10" id="scriptText" readonly></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="voice_clone_script_language_script_id"
                            id="voice_clone_script_language_script_id">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <div class="input-box">
                                                <div class="row g-3 align-items-center">
                                                    <div class="col-sm-12 col-md-5 col-lg-4 col-xl-3">
                                                        <h6 class="task-heading" style="margin-top: -10px;">
                                                            {{ __('Preferred Lnaguage') }}</h6>
                                                    </div>
                                                    <div class="col-sm-12 col-md-7">
                                                        <select id="studio-preferred-language" name="language"
                                                            data-placeholder="{{ __('Preferred Language') }}:"
                                                            data-callback="language_select" width="100%">
                                                            @foreach ($languages as $language)
                                                                @if (in_array($language->language_code, $preferred_audio_settings))
                                                                    <option value="{{ $language->language_code }}"
                                                                        data-img="{{ URL::asset($language->language_flag) }}">
                                                                        {{ $language->language }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12 border" style="border-width: 5px!important;">
                                <div class="row" style="padding: 10px;">
                                    <div class="col-md-12 col-sm-12">
                                        <!-- CONTAINER FOR AUDIO FILE UPLOADS-->
                                        <div id="upload-container">

                                            <!-- DRAG & DROP MEDIA FILES -->
                                            <div class="select-file">
                                                <input type="file" name="filepond" id="filepond" class="filepond"
                                                    accept=".mp3" required />
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-12 border" style="border-width: 5px!important;">
                                <div class="row text-center" style="padding-top: 13px;">
                                    <div class="col-12 d-flex justify-content-center">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <div id="record-audio">
                                                    <div id="countdown-time">
                                                        <div class="countdown">
                                                            <div class="middle"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div id="record-actions" class="text-center">
                                                    <!-- AUDIO FORMAT-->
                                                    <div id="transcribe-audio-format">{{ __('Audio Format') }}: 1 channel
                                                        PCM
                                                        @
                                                        48kHz</div>
                                                    <!-- RECORDED AUDIO (OUTPUT RESULT)-->
                                                    <div id="recordings" class="text-center green-player">
                                                        <audio id="audio" src=""></audio>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-12">
                                        <div id="record-buttons">
                                            <div>
                                                <div class="form-group">
                                                    <button class="controls active" id="record"><i
                                                            class="fa fa-microphone"></i>{{ __('Record') }}</button>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="form-group">
                                                    <button class="controls is-blocked" id="stop" disabled="true"><i
                                                            class="fa fa-stop-circle"></i>{{ __('Stop') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 text-center mt-3">
                            <span id="processing"><img src="{{ URL::asset('/img/svgs/processing.svg') }}"
                                    alt=""></span>
                            <button type="submit" class="btn btn-primary main-action-button mr-2"
                                id="upload-voice-profile">{{ __('Upload') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var config = {
            routes: {
                zone: "{{ route('user.transcribe.settings') }}"
            }
        };
    </script>
    <!-- Chart JS -->
    {{-- <script src="{{ URL::asset('plugins/chart/chart.min.js') }}"></script> --}}

    <script src="{{ URL::asset('plugins/audio-player/green-audio-player.js') }}"></script>
    <script src="{{ URL::asset('js/audio-player.js') }}"></script>
    <!-- Flipclock JS -->
    <script src={{ URL::asset('plugins/flipclock/moment.min.js') }}></script>
    <script src={{ URL::asset('plugins/flipclock/popper.min.js') }}></script>
    <script src={{ URL::asset('plugins/flipclock/flipclock.min.js') }}></script>
    <script src={{ URL::asset('plugins/flipclock/recorder.js') }}></script>

    <script src={{ URL::asset('plugins/filepond/filepond.min.js') }}></script>
    <script src={{ URL::asset('plugins/filepond/filepond-plugin-file-validate-size.min.js') }}></script>
    <script src={{ URL::asset('plugins/filepond/filepond-plugin-file-validate-type.min.js') }}></script>
    <script src={{ URL::asset('plugins/filepond/filepond.jquery.js') }}></script>
    <!-- Data Tables JS -->
    <script src="{{ URL::asset('plugins/datatable/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ URL::asset('js/results.js') }}"></script>
    <!-- Awselect JS -->
    <script src="{{ URL::asset('plugins/awselect/awselect-custom.js') }}"></script>
    <script src="{{ URL::asset('js/transcribe-record.js') }}"></script>
    <script src="{{ URL::asset('js/awselect.js') }}"></script>
    <script>
        var config = {
            routes: {
                zone: "{{ route('user.transcribe.settings') }}"
            }
        };
    </script>
    <script src="{{ URL::asset('js/transcribe-voice-profile-record.js') }}"></script>
    <script type="text/javascript">
        var pond = FilePond.create(document.querySelector('.filepond'));
        var all_types;
        var maxFileSize;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            type: "GET",
            url: config.routes.zone,

        }).done(function(data) {

            maxFileSize = 2048 + 'MB';

            FilePond.setOptions({

                allowMultiple: false,
                maxFiles: 1,
                allowReplace: true,
                maxFileSize: maxFileSize,
                labelIdle: "Drag & Drop your file or <span class=\"filepond--label-action\">Browse</span><br><span class='restrictions'>[<span class='restrictions-highlight'>" +
                    maxFileSize + "</span>: MP3]</span>",
                required: false,
                instantUpload: false,
                storeAsFile: true,
                acceptedFileTypes: ['audio/*'],
                labelFileProcessingError: (error) => {
                    console.log(error);
                }

            });

        });
    </script>
    <script type="text/javascript">
        $("#languages").change(function() {
            var languageCode = $(this).val();
            if (languageCode) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    type: "GET",
                    url: '{{ route('user.get.language.code.script') }}',
                    data: {
                        language_code: languageCode
                    },
                }).done(function(data) {
                    $("#scriptText").val(data['script']);
                    $("#languageStage").val(data['stage']);
                    $("#voice_clone_script_language_script_id").val(data[
                        'voice_clone_script_language_script_id']);
                });
            }
        });
    </script>
    <script>
        $("#store-user-voice-profile-script").on("submit", (function(e) {
            "use strict";
            e.preventDefault();
            if (!$("#voice_clone_script_language_script_id").val()) {
                Swal.fire('Scripts Completed',
                    '{{ __('Selected language scripts completed. Please choose a different language.') }}',
                    'success');
                return;
            }
            var form = $(this);
            var formData = new FormData(this);

            var audiofile = new Blob([audioStream], {
                type: "audio/wav"
            });
            formData.append("audiofile", audiofile);
            formData.append("audiolength", audioLengthRecorded);
            formData.append("extension", 'wav');
            formData.append("taskType", 'record');
            var inputAudio = [];
            if (pond.getFiles().length !== 0) {
                pond.getFiles().forEach(function(file) {
                    inputAudio.push(file);
                });
            }
            if (inputAudio.length > 0) {
                formData.append('video', inputAudio[0].file);
            }
            console.log(audioLengthRecorded);
            if (inputAudio.length <= 0 && typeof audioLengthRecorded === 'undefined') {
                Swal.fire('Error',
                    '{{ __('Please select a audio file or record audio before uploading.') }}', 'error');
                return;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: form.attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $('#upload-voice-profile').html('');
                    $('#upload-voice-profile').prop('disabled', true);
                    $('#processing').show().clone().appendTo('#upload-voice-profile');
                    $('#processing').hide();
                    $('#upload-voice-profile').html('Submit');
                },
                complete: function() {
                    $('#upload-voice-profile').prop('disabled', false);
                    $('#processing', '#upload-voice-profile').empty().remove();
                    $('#processing').hide();
                    $('#upload-voice-profile').html('Submit');
                },
                success: function(response) {
                    Swal.fire('Profile Created',
                        '{{ __('Voice profile created successfully.') }}', 'success');
                    setTimeout(() => {
                        location.href = '{{ route('user.dashboard') }}';
                    }, 2000);
                },
                error: function(response) {
                    Swal.fire('Error',
                        '{{ __('Something went wrong.Try again.') }}', 'error');

                    $('#upload-voice-profile').prop('disabled', false);
                    $('#upload-voice-profile').html('Submit');
                }

            }).done(function(response) {
                $('#upload-voice-profile').html('Submit');
                audioStream = '';
            })
        }));
    </script>
@endsection
