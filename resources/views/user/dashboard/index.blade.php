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
@endsection

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('My Dashboard') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i
                            class="fa-solid fa-chart-tree-map mr-2 fs-12"></i>{{ __('User') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ url('#') }}"> {{ __('My Dashboard') }}</a>
                </li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card border-0" id="dashboard-background">
                <div class="widget-user-image overflow-hidden mx-auto mt-5"><img alt="User Avatar" class="rounded-circle"
                        src="@if (auth()->user()->profile_photo_path) {{ asset(auth()->user()->profile_photo_path) }} @else {{ URL::asset('img/users/avatar.jpg') }} @endif">
                </div>
                <div class="card-body text-center">
                    <div>
                        <h4 class="mb-1 mt-1 font-weight-800 fs-16">{{ auth()->user()->name }}</h4>
                        <h6 class="text-muted fs-12">{{ auth()->user()->job_role }}</h6>
                        <a href="{{ route('user.dashboard.edit') }}" class="btn btn-primary mt-2 mr-1"><i
                                class="fa-solid fa-id-badge fs-11 mr-1"></i> {{ __('Update Profile') }}</a>
                        <a href="{{ route('user.dashboard.edit.defaults') }}" class="btn btn-primary mt-2"><i
                                class="fa-sharp fa-solid fa-language fs-11 mr-1"></i> {{ __('Change Defaults') }}</a>
                    </div>
                </div>
            </div>

            <div class="card border-0">
                <div class="card-body pt-0">
                    <h4 class="card-title mb-4 mt-4">{{ __('Personal Details') }}</h4>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td class="py-2 px-0 border-top-0">
                                        <span class="font-weight-semibold w-50">{{ __('Full Name') }} </span>
                                    </td>
                                    <td class="py-2 px-0 border-top-0">{{ auth()->user()->name }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Email') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->email }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('User Status') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ ucfirst(auth()->user()->status) }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('User Group') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ ucfirst(auth()->user()->group) }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Registered On') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->created_at }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Last Updated On') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->updated_at }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Referral ID') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->referral_id }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Job Role') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->job_role }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Company') }}</span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->company }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Website') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->website }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Address') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->address }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Postal Code') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->postal_code }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('City') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->city }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Country') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->country }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Phone') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ auth()->user()->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Voiceover Language') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ $voiceover_language[0]['language'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Voiceover Voice') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ $voiceover_voice[0]['voice'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ __('Transcribe Language') }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ $transcribe_language[0]['language'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @unlessrole('voice-artist')
                <div class="card border-0">
                    <div class="card-body pt-0">
                        <h4 class="card-title mb-4 mt-4"><i class="fa-sharp fa-solid fa-waveform-lines mr-4 text-info"></i>
                            {{ __('My Voice Profile') }}</h4>
                        @if ($user_voice_profile_script_found <= 0)
                            <div class="mb-4">
                                <span
                                    class="fs-12 text-muted">{{ __('Unleash Your Unique Sound with Our AI Harmony') }}</span>
                            </div>
                            <a href="{{ route('user.record.user.voice') }}" class="d-block btn btn-primary mt-2 mr-1">
                                <i class="fa-sharp fa-solid fa-waveform-lines mr-1"></i> {{ __('Start') }}
                            </a>
                        @else
                            <div class="mb-4 d-flex">
                                <span class="fs-12 text-muted">{{ __('Score') }} &emsp;</span>
                                <h4 class="text-primary fw-bold">{{ rand(50, 100) }}</h4>
                            </div>
                            <div class="mb-4">
                                <div class="progress mb-2" style="width: {{ rand(75, 100) }}%;background:#3BC9F3;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ rand(30, 45) }}%;background:#6666B3!important;" aria-valuenow="15"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ rand(30, 45) }}%;" aria-valuenow="30" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="progress mb-2" style="width: {{ rand(75, 100) }}%;background:#3BC9F3;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ rand(30, 45) }}%;background:#6666B3!important;" aria-valuenow="15"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ rand(30, 45) }}%;" aria-valuenow="30" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="progress mb-2" style="width: {{ rand(75, 100) }}%;background:#3BC9F3;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ rand(30, 45) }}%;background:#6666B3!important;" aria-valuenow="15"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ rand(30, 45) }}%;" aria-valuenow="30" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="progress mb-2" style="width: {{ rand(75, 100) }}%;background:#3BC9F3;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ rand(30, 45) }}%;background:#6666B3!important;" aria-valuenow="15"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ rand(30, 45) }}%;" aria-valuenow="30" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="progress mb-2" style="width: {{ rand(75, 100) }}%;background:#3BC9F3;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ rand(30, 45) }}%;background:#6666B3!important;" aria-valuenow="15"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ rand(30, 45) }}%;" aria-valuenow="30" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                            <a href="{{ route('user.record.user.voice') }}" class="d-block btn btn-primary mt-2 mr-1">
                                <i class="fa-sharp fa-solid fa-waveform-lines mr-1"></i> {{ __('Improve Score') }}
                            </a>
                        @endif

                    </div>

                </div>
            @endunlessrole
        </div>

        <div class="col-xl-8 col-lg-8 col-md-12">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="card overflow-hidden border-0">
                                <div class="card-body d-flex">
                                    <div class="usage-info w-100">
                                        <p class=" mb-0 fs-12 font-weight-bold">{{ __('Standard Characters Used') }}</p>
                                        <p class=" mb-3 fs-10 text-muted">({{ __('Current Month') }})</p>
                                        <h2 class="mb-2 number-font fs-20">
                                            {{ number_format($user_data_month['total_standard_chars'][0]['data']) }}</h2>
                                    </div>
                                    <div class="usage-icon w-100 text-right">
                                        <i class="fa-solid fa-chart-simple-horizontal"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="card overflow-hidden border-0">
                                <div class="card-body d-flex">
                                    <div class="usage-info w-100">
                                        <p class=" mb-0 fs-12 font-weight-bold">{{ __('Neural Characters Used') }}</p>
                                        <p class=" mb-3 fs-10 text-muted">({{ __('Current Month') }})</p>
                                        <h2 class="mb-2 number-font fs-20">
                                            {{ number_format($user_data_month['total_neural_chars'][0]['data']) }}</h2>
                                    </div>
                                    <div class="usage-icon w-100 text-right">
                                        <i class="fa-solid fa-chart-tree-map"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="card overflow-hidden border-0">
                                <div class="card-body d-flex">
                                    <div class="usage-info w-100">
                                        <p class=" mb-0 fs-12 font-weight-bold">{{ __('Minutes Used') }}</p>
                                        <p class=" mb-3 fs-10 text-muted">({{ __('Current Month') }})</p>
                                        <h2 class="mb-2 number-font fs-20">
                                            {{ number_format((float) $user_data_month['total_minutes'][0]['data'] / 60, 2) }}
                                        </h2>
                                    </div>
                                    <div class="usage-icon w-100 text-right">
                                        <i class="fa-solid fa-hourglass-clock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="card overflow-hidden border-0">
                                <div class="card-body d-flex">
                                    <div class="usage-info w-100">
                                        <p class=" mb-0 fs-12 font-weight-bold">{{ __('Audio Files Transcribed') }}</p>
                                        <p class=" mb-3 fs-10 text-muted">({{ __('Current Month') }})</p>
                                        <h2 class="mb-2 number-font fs-20">
                                            {{ number_format($user_data_month['total_audio_files'][0]['data']) }}</h2>
                                    </div>
                                    <div class="usage-icon w-100 text-right">
                                        <i class="fa-solid fa-folder-music"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @unlessrole('voice-artist')
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card mb-5 border-0">
                            <div class="card-header d-inline border-0">
                                <div>
                                    <h3 class="card-title fs-16 mt-3 mb-4"><i
                                            class="fa-solid fa-box-open mr-4 text-info"></i>{{ __('Subscription ') }}</h3>
                                </div>
                                @if ($user_subscription == '')
                                    <div>
                                        <h3 class="card-title fs-24 font-weight-800">{{ __('Active Forever') }}</h3>
                                    </div>
                                    <div class="mb-1">
                                        <span class="fs-12 text-muted">{{ __('No Subscription ') }} /
                                            {!! config('payment.default_system_currency_symbol') !!}0.00 {{ __('Per Month') }}</span>
                                    </div>
                                @else
                                    <div>
                                        <h3 class="card-title fs-24 font-weight-800">
                                            @if ($user_subscription->pricing_plan == 'monthly')
                                                {{ __('Monthly Subscription') }}
                                            @else
                                                {{ __('Yearly Subscription') }}
                                            @endif
                                        </h3>
                                    </div>
                                    <div class="mb-1">
                                        <span class="fs-12 text-muted">{{ $user_subscription->plan_name }}
                                            {{ __('Plan') }} / {!! config('payment.default_system_currency_symbol') !!}{{ $user_subscription->price }}
                                            @if ($user_subscription->pricing_plan == 'monthly')
                                                {{ __('Per Month') }}
                                            @else
                                                {{ __('Per Year') }}
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="fs-12 text-muted">{{ __('Total ') }} {{ number_format($characters) }}
                                        {{ __('of') }} @if ($total_characters > 0)
                                            {{ number_format($total_characters) }}
                                        @else
                                            0
                                        @endif
                                        <span class="font-weight-bold text-warning">{{ __('Characters') }}</span>
                                        {{ __('Available') }}. {{ __('You have ') }} @if (auth()->user()->synthesize_tasks == -1)
                                            <span class="font-weight-bold text-warning">{{ __('unlimited') }}</span>
                                        @else
                                            <span
                                                class="font-weight-bold text-warning">{{ auth()->user()->synthesize_tasks }}</span>
                                        @endif {{ __(' synthesize tasks for current month') }}.</span>
                                </div>
                                <div class="progress mb-4">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning subscription-bar"
                                        role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $progress['characters'] }}%"></div>
                                </div>
                                <div class="mb-3">
                                    <span class="fs-12 text-muted">{{ __('Total ') }} {{ number_format($minutes) }}
                                        {{ __('of') }} @if ($total_minutes > 0)
                                            {{ number_format($total_minutes) }}
                                        @else
                                            0
                                        @endif <span
                                            class="font-weight-bold text-primary">{{ __('Minutes') }}</span>
                                        {{ __('Available') }}</span>
                                </div>
                                <div class="progress mb-4">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated zip-bar"
                                        role="progressbar" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $progress['minutes'] }}%"></div>
                                </div>
                                @if ($subscription)
                                    <div class="mb-3">
                                        <span class="fs-12 text-muted">{{ __('Subscription renewal date ') }}:
                                            {{ $subscription->active_until }} </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endunlessrole
                {{-- @unlessrole('voice-artist') --}}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card overflow-hidden border-0">
                        <div class="card-header d-inline border-0">
                            <div>
                                <h3 class="card-title fs-16 mt-3 mb-4"><i
                                        class="fa-solid fa-box-open mr-4 text-info"></i>My Projects
                                </h3>
                            </div>
                        </div>
                        <div class="card-body d-flex">
                            <div class="usage-info w-100">
                                <p class=" mb-0 fs-12 font-weight-bold">Total Projects</p>
                                <p class=" mb-3 fs-10 text-muted"></p>
                                <h2 class="mb-2 number-font fs-20">
                                    <a href="{{ route('user.projects') }}">{{ $count_projects ?? 0 }}</a>
                                </h2>
                            </div>
                            <div class="usage-icon w-100 text-right">
                                <i class="fa-solid fa-chart-simple-horizontal"></i>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @endunlessrole --}}
                @unlessrole('voice-artist')
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card mb-5 border-0">
                            <div class="card-header d-inline border-0">
                                <h3 class="card-title fs-16 mt-3 mb-4"><i
                                        class="fa-sharp fa-solid fa-waveform-lines mr-4 text-info"></i>{{ __('Text to Speech Usage') }}
                                    <span class="text-muted">({{ __('Current Year') }})</span>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-5 mt-2">
                                    <div class="col-xl-3 col-12 ">
                                        <p class=" mb-1 fs-12">{{ __('Total Standard Characters Used') }}</p>
                                        <h3 class="mb-0 fs-20 number-font">
                                            {{ number_format($user_data_year['total_standard_chars'][0]['data']) }}</h3>
                                    </div>
                                    <div class="col-xl-3 col-12 ">
                                        <p class=" mb-1 fs-12">{{ __('Total Neural Characters Used') }}</p>
                                        <h3 class="mb-0 fs-20 number-font">
                                            {{ number_format($user_data_year['total_neural_chars'][0]['data']) }}</h3>
                                    </div>
                                    <div class="col-xl-3 col-12 ">
                                        <p class=" mb-1 fs-12">{{ __('Total Audio Files Created') }}</p>
                                        <h3 class="mb-0 fs-20 number-font">
                                            {{ number_format($user_data_year['total_audio_files'][0]['data']) }}</h3>
                                    </div>
                                    <div class="col-xl-3 col-12 ">
                                        <p class=" mb-1 fs-12">{{ __('Total Listen Mode Results') }}</p>
                                        <h3 class="mb-0 fs-20 number-font">
                                            {{ number_format($user_data_year['total_listen_modes'][0]['data']) }}</h3>
                                    </div>
                                </div>
                                <div class="chartjs-wrapper-demo">
                                    <canvas id="chart-user-chars" class="h-330"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card mb-5 border-0">
                            <div class="card-header d-inline border-0">
                                <h3 class="card-title fs-16 mt-3 mb-4"><i
                                        class="fa-sharp fa-solid fa-microphone-lines mr-4 text-info"></i>{{ __('Speech To Text Usage') }}
                                    <span class="text-muted">({{ __('Current Year') }})</span>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-5 mt-2">
                                    <div class="col-md col-sm-12 ">
                                        <p class=" mb-1 fs-12">{{ __('Total Minutes Used') }}</p>
                                        <h3 class="mb-0 fs-20 number-font">
                                            {{ number_format((float) $user_data_year['total_minutes'][0]['data'] / 60, 2) }}
                                        </h3>
                                    </div>
                                    <div class="col-md col-sm-12 ">
                                        <p class=" mb-1 fs-12">{{ __('Words Generated') }}</p>
                                        <h3 class="mb-0 fs-20 number-font">
                                            {{ number_format($user_data_year['total_words'][0]['data']) }}</h3>
                                    </div>
                                    <div class="col-md col-sm-12 ">
                                        <p class=" mb-1 fs-12">{{ __('Audio Files Transcribed') }}</p>
                                        <h3 class="mb-0 fs-20 number-font">
                                            {{ number_format($user_data_year['total_file_transcribe'][0]['data']) }}</h3>
                                    </div>
                                    <div class="col-md col-sm-12 ">
                                        <p class=" mb-1 fs-12">{{ __('Recordings Transcribed') }}</p>
                                        <h3 class="mb-0 fs-20 number-font">
                                            {{ number_format($user_data_year['total_recording_transcribe'][0]['data']) }}</h3>
                                    </div>
                                    <div class="col-md col-sm-12 ">
                                        <p class=" mb-1 fs-12">{{ __('Live Transcribe Results') }}</p>
                                        <h3 class="mb-0 fs-20 number-font">
                                            {{ number_format($user_data_year['total_live_transcribe'][0]['data']) }}</h3>
                                    </div>
                                </div>
                                <div class="chartjs-wrapper-demo">
                                    <canvas id="chart-user-minutes" class="h-330"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endunlessrole
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
    <script src="{{ URL::asset('plugins/chart/chart.min.js') }}"></script>

    <script src="{{ URL::asset('plugins/audio-player/green-audio-player.js') }}"></script>
    <script src="{{ URL::asset('js/audio-player.js') }}"></script>
    <!-- Flipclock JS -->
    <script src={{ URL::asset('plugins/flipclock/moment.min.js') }}></script>
    <script src={{ URL::asset('plugins/flipclock/popper.min.js') }}></script>
    <script src={{ URL::asset('plugins/flipclock/flipclock.min.js') }}></script>
    <script src={{ URL::asset('plugins/flipclock/recorder.js') }}></script>
    <!-- Data Tables JS -->
    <script src="{{ URL::asset('plugins/datatable/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ URL::asset('js/results.js') }}"></script>
    <!-- Awselect JS -->
    <script src="{{ URL::asset('plugins/awselect/awselect-custom.js') }}"></script>
    <script src="{{ URL::asset('js/transcribe-record.js') }}"></script>
    <script src="{{ URL::asset('js/awselect.js') }}"></script>
    <script>
        $(function() {

            'use strict';

            var standardData = JSON.parse(`<?php echo $chart_data['standard_chars']; ?>`);
            var standardDataset = Object.values(standardData);
            var neuralData = JSON.parse(`<?php echo $chart_data['neural_chars']; ?>`);
            var neuralDataset = Object.values(neuralData);
            let delayed2;

            var ctxChars = document.getElementById('chart-user-chars');
            new Chart(ctxChars, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        label: '{{ __('Standard Characters Used') }}',
                        data: standardDataset,
                        backgroundColor: '#1e1e2d',
                        borderWidth: 1,
                        borderRadius: 20,
                        barPercentage: 0.5,
                        fill: true
                    }, {
                        label: '{{ __('Neural Characters Used') }}',
                        data: neuralDataset,
                        backgroundColor: '#007bff',
                        borderWidth: 1,
                        borderRadius: 20,
                        barPercentage: 0.5,
                        fill: true
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                        labels: {
                            display: false
                        }
                    },
                    responsive: true,
                    animation: {
                        onComplete: () => {
                            delayed2 = true;
                        },
                        delay: (context) => {
                            let delay = 0;
                            if (context.type === 'data' && context.mode === 'default' && !delayed2) {
                                delay = context.dataIndex * 50 + context.datasetIndex * 5;
                            }
                            return delay;
                        },
                    },
                    scales: {
                        y: {
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                font: {
                                    size: 11
                                },
                                stepSize: 100000,
                            },
                            grid: {
                                color: '#ebecf1',
                                borderDash: [3, 2]
                            }
                        },
                        x: {
                            stacked: true,
                            ticks: {
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                color: '#ebecf1',
                                borderDash: [3, 2]
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            cornerRadius: 10,
                            xPadding: 10,
                            yPadding: 10,
                            backgroundColor: '#000000',
                            titleColor: '#FF9D00',
                            yAlign: 'bottom',
                            xAlign: 'center',
                        },
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });


            var fileData = JSON.parse(`<?php echo $chart_data['file_minutes']; ?>`);
            var fileDataset = Object.values(fileData);
            var recordData = JSON.parse(`<?php echo $chart_data['record_minutes']; ?>`);
            var recordDataset = Object.values(recordData);
            var liveData = JSON.parse(`<?php echo $chart_data['live_minutes']; ?>`);
            var liveDataset = Object.values(liveData);

            var ctxMinutes = document.getElementById('chart-user-minutes');
            new Chart(ctxMinutes, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        label: '{{ __('Audio Transcribe Minutes') }}',
                        data: fileDataset,
                        backgroundColor: '#007bff',
                        borderWidth: 1,
                        borderRadius: 20,
                        barPercentage: 0.5,
                        fill: true
                    }, {
                        label: '{{ __('Recording Transcribe Minutes') }}',
                        data: recordDataset,
                        backgroundColor: '#1e1e2d',
                        borderWidth: 1,
                        borderRadius: 20,
                        barPercentage: 0.5,
                        fill: true
                    }, {
                        label: '{{ __('Live Transcribe Minutes') }}',
                        data: liveDataset,
                        backgroundColor: '#FFAB00',
                        borderWidth: 1,
                        borderRadius: 20,
                        barPercentage: 0.5,
                        fill: true
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                        labels: {
                            display: false
                        }
                    },
                    responsive: true,
                    animation: {
                        onComplete: () => {
                            delayed2 = true;
                        },
                        delay: (context) => {
                            let delay = 0;
                            if (context.type === 'data' && context.mode === 'default' && !delayed2) {
                                delay = context.dataIndex * 50 + context.datasetIndex * 5;
                            }
                            return delay;
                        },
                    },
                    scales: {
                        y: {
                            stacked: true,
                            ticks: {
                                beginAtZero: true,
                                font: {
                                    size: 11
                                },
                                stepSize: 50,
                            },
                            grid: {
                                color: '#ebecf1',
                                borderDash: [3, 2]
                            }
                        },
                        x: {
                            stacked: true,
                            ticks: {
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                color: '#ebecf1',
                                borderDash: [3, 2]
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            cornerRadius: 10,
                            xPadding: 10,
                            yPadding: 10,
                            backgroundColor: '#000000',
                            titleColor: '#FF9D00',
                            yAlign: 'bottom',
                            xAlign: 'center',
                        },
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });

        });


        $("#store-voice-over").on("submit", (function(e) {

            "use strict";

            e.preventDefault();

            var form = $(this);
            var formData = new FormData(this);

            var audiofile = new Blob([audioStream], {
                type: "audio/wav"
            });
            formData.append("audiofile", audiofile);
            formData.append("audiolength", audioLengthRecorded);
            formData.append("extension", 'wav');
            formData.append("taskType", 'record');

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
                    $('#transcribe').html('');
                    $('#transcribe').prop('disabled', true);
                    $('#processing').show().clone().appendTo('#transcribe');
                    $('#processing').hide();
                    $('#transcribe').html('Submit');
                },
                complete: function() {
                    $('#transcribe').prop('disabled', false);
                    $('#processing', '#transcribe').empty().remove();
                    $('#processing').hide();
                    $('#transcribe').html('Submit');
                },
                success: function(response) {
                    Swal.fire('Audio Created',
                        '{{ __('New Audio has been successfully created') }}', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function(response) {
                    if (response.responseJSON['error']) {
                        $('#notificationModal').modal('show');
                        $('#notificationMessage').text(response.responseJSON['error']);
                    }

                    $('#transcribe').prop('disabled', false);
                    $('#transcribe').html('Submit');
                }

            }).done(function(response) {
                $("#resultTable").DataTable().ajax.reload();
                $("#recordings").slideUp();
                $('#transcribe').html('Submit');
                audioStream = '';
            })


        }));
    </script>
@endsection
