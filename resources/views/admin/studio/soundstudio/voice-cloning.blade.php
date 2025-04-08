@extends('layouts.app')

@section('css')
    <!-- Green Audio Player CSS -->
    <link href="{{ URL::asset('plugins/audio-player/green-audio-player.css') }}" rel="stylesheet" />
    	<!-- Data Table CSS -->
	<link href="{{URL::asset('plugins/datatable/datatables.min.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Voice Cloning') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/' . ($page = '#')) }}"><i
                            class="fa-solid fa-boxes-packing mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.studio.dashboard') }}">
                        {{ __('Studio Management') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.sound.studio') }}">
                        {{ __('Sound Studio') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('#') }}">
                        {{ __('Voice Cloning') }}</a></li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden border-0">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Voice Cloning') }}</h3>
                </div>
                <div class="card-body pt-5">
                    <form action="{{ route('admin.studio.create-voice-cloning') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="input-box mb-4">
                                <label for="email"
                                    class="fs-12 font-weight-bold text-md-right">{{ __('Email Address') }}</label>
                                <select class="audio-video-language form-control" name="language"
                                    data-placeholder="{{ __('Source language') }}:">
                                    @foreach ($languages as $lang)
                                        <option value="{{ $lang }}">
                                            {{ $lang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="input-box mb-4">
                                <label for="transcript"
                                    class="fs-12 font-weight-bold text-md-right">{{ __('Enter Voice Transcription') }}</label>
                                <textarea id="transcript" type="text" class="form-control @error('transcript') is-invalid @enderror"
                                    name="transcript" autocomplete="off" placeholder="Enter Voice Transcription Min 30 Words." required></textarea>
                                @error('transcript')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <!-- SAVE CHANGES ACTION BUTTON -->
                        <div class="border-0 text-right mb-2 mt-8">
                            <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
            <div class="card border-0">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Voice Cloning Results') }}</h3>
                </div>
                <div class="card-body pt-2">
                    <!-- SET DATATABLE -->
                    <table id='resultsTable' class='table' width='100%'>
                            <thead>
                                <tr>
                                    <th width="6%">{{ __('Language') }}</th>
                                    <th width="9%">{{ __('Transcript') }}</th>
                                    {{-- <th width="3%">{{ __('Actions') }}</th> --}}
                                </tr>
                            </thead>
                    </table> <!-- END SET DATATABLE -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Link Share JS -->
    <script src="{{ URL::asset('js/link-share.js') }}"></script>
    <!-- Green Audio Player JS -->
    <script src="{{ URL::asset('plugins/audio-player/green-audio-player.js') }}"></script>
    <script src="{{ URL::asset('js/audio-player.js') }}"></script>
    	<!-- Data Tables JS -->
	<script src="{{URL::asset('plugins/datatable/datatables.min.js')}}"></script>
    <script>
        	let table = $('#resultsTable').DataTable({
				"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
				responsive: true,
				"order": [[ 0, "desc" ]],
				language: {
					"emptyTable": "<div><img id='no-results-img' src='{{ URL::asset('img/files/no-result.png') }}'><br>Studio does not have any synthesized results yet</div>",
					search: "<i class='fa fa-search search-icon'></i>",
					lengthMenu: '_MENU_ ',
					paginate : {
						first    : '<i class="fa fa-angle-double-left"></i>',
						last     : '<i class="fa fa-angle-double-right"></i>',
						previous : '<i class="fa fa-angle-left"></i>',
						next     : '<i class="fa fa-angle-right"></i>'
					}
				},
				pagingType : 'full_numbers',
				processing: true,
				serverSide: true,
				ajax: "{{ route('admin.studio.voice-cloning') }}",
				columns: [
					{
						data: 'language',
						name: 'language',
						orderable: true,
						searchable: true
					},
					{
						data: 'transcript',
						name: 'transcript',
						orderable: true,
						searchable: true
					},
					// {
					// 	data: 'actions',
					// 	name: 'actions',
					// 	orderable: false,
					// 	searchable: false
					// },
				]
			});

    </script>
@endsection
