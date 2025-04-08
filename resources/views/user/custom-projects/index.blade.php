@extends('layouts.app')
@section('css')
    <!-- Data Table CSS -->
    <link href="{{ URL::asset('plugins/datatable/datatables.min.css') }}" rel="stylesheet" />
    <!-- Awselect CSS -->
    <link href="{{ URL::asset('plugins/awselect/awselect.min.css') }}" rel="stylesheet" />
    <!-- Sweet Alert CSS -->
    <link href="{{ URL::asset('plugins/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Custom Projects') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i
                            class="fa-solid fa-boxes-packing mr-2 fs-12"></i>{{ __('User') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ url('/account/custom-projects') }}">
                        {{ __('Custom Projects') }}</a></li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card border-0">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Custom Projects') }}</h3>

                </div>
                <div class="card-body pt-5">
                    <form action="{{ url('account/create-custom-project') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="row">
                                    <div class="col-md-12 pr-0 pr-minify">
                                        <div class="input-box">
                                            <h6 class="task-heading">Enter Custom Project Title</h6>
                                            @if (Session::has('success'))
                                                <input readonly
                                                    value="{{ json_decode($modifiedResponseBody, true)['name'] ?? ''}}" required
                                                    placeholder="Enter Custom Project Title" id="project_title"
                                                    class="form-control" name="custom_project_title"
                                                    data-last-active-input="">
                                            @else
                                                <input required placeholder="Enter Custom Project Title" id="project_title"
                                                    class="form-control" name="custom_project_title"
                                                    data-last-active-input="">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-1">
                                    <div class="col">
                                        @if (!Session::has('success'))
                                            <button
                                                class="btn btn-special create-project file-buttons pl-6 pr-6 video-button-next"
                                                type="submit">Next</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (Session::has('success'))
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card border-0">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Choose Task') }}</h3>

                    </div>
                    <div class="card-body pt-5">
                        @php
                            $tasks = [
                                [
                                    'title' => 'Generate Transcript',
                                    'link' => '/generate-transcript',
                                ],
                                [
                                    'title' => 'Generate Lorem',
                                    'link' => '/generate-transcript',
                                ],
                                [
                                    'title' => 'Generate Ipsum',
                                    'link' => '/generate-transcript',
                                ],
                            ];
                        @endphp

                        <div class="row">
                            @foreach ($tasks as $task)
                                <div class="col-md-4 col-12">
                                    <a href="">
                                        <div class="card">
                                            <div class="card-body" style="height:200px">
                                                <center>
                                                    <img height="100px"
                                                        src="https://img.freepik.com/free-vector/headphone-gadget-cartoon-isolated_1308-153440.jpg?size=626&ext=jpg&ga=GA1.1.34264412.1708646400&semt=sph"
                                                        alt="headphone">
                                                </center>
                                                <br>
                                                <h4 style="text-align:center;align-items:center">{{ $task['title'] }}</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!-- END Delete PROJECT MODAL -->
@endsection

@section('js')
    <!-- Data Tables JS -->
    <script src="{{ URL::asset('plugins/datatable/datatables.min.js') }}"></script>
    <!-- Awselect JS -->
    <script src="{{ URL::asset('plugins/awselect/awselect.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/audio-player/green-audio-player.js') }}"></script>
    <script src="{{ URL::asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ URL::asset('js/audio-player.js') }}"></script>
    <script src="{{ URL::asset('js/awselect.js') }}"></script>
    <script type="text/javascript">
        let table;
        $(function() {

            "use strict";

            $('#default-project').on('click', function() {
                $('#defaultProjectModal').modal('show');
            });

            $('#delete-project').on('click', function() {
                $('#deleteProjectModal').modal('show');
            });

            $('#project-btn').click(function(e) {
                e.preventDefault();

                var form = document.getElementById("project-title-form");
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
                        localStorage.removeItem('project_id');
                        localStorage.removeItem('current_step');
                        localStorage.setItem('project_id', data.response.project_id);
                        localStorage.setItem('current_step', data.response.current_step);
                        // $('.video-step-one').css('display', 'none');
                        $('#project-btn').css('display', 'none');
                        $('.video-step-three').css('display', 'none');
                        $('.video-step-two').css('display', 'block');
                        var selectedModel = $("#project-audio-model").val();
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
        });


        // CHANGE PROJECT NAME
        function changeProjectName(value) {

            $.get("{{ route('user.transcribe.projects.change') }}", {
                    project: value
                },
                function(data) {
                    table = $('#userResultTable').DataTable({
                        "lengthMenu": [
                            [25, 50, 100, -1],
                            [25, 50, 100, "All"]
                        ],
                        responsive: {
                            details: {
                                type: 'column'
                            }
                        },
                        destroy: true,
                        colReorder: true,
                        language: {
                            "emptyTable": "<div><img id='no-results-img' src='{{ URL::asset('img/files/no-result.png') }}'><br>{{ __('Project does not have any transcribe tasks stored yet') }}</div>",
                            search: "<i class='fa fa-search search-icon'></i>",
                            lengthMenu: '_MENU_ ',
                            paginate: {
                                first: '<i class="fa fa-angle-double-left"></i>',
                                last: '<i class="fa fa-angle-double-right"></i>',
                                previous: '<i class="fa fa-angle-left"></i>',
                                next: '<i class="fa fa-angle-right"></i>'
                            }
                        },
                        pagingType: 'full_numbers',
                        processing: true,
                        data: data['data'],
                        columns: [{
                                "className": 'details-control',
                                "orderable": false,
                                "searchable": false,
                                "data": null,
                                "defaultContent": ''
                            },
                            {
                                data: 'created-on',
                                name: 'created-on',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'file_name',
                                name: 'file_name',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'custom-language',
                                name: 'custom-language',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'custom-status',
                                name: 'custom-status',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'single',
                                name: 'single',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'download',
                                name: 'download',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'custom-length',
                                name: 'custom-length',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'format',
                                name: 'format',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'file_size',
                                name: 'file_size',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'words',
                                name: 'words',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'custom-mode',
                                name: 'custom-mode',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'actions',
                                name: 'actions',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });

                }).fail(function() {
                console.log("Error getting datatable results");
            });


            $.get("{{ route('user.transcribe.projects.change.stats') }}", {
                    project: value
                },
                function(data) {
                    document.getElementById('total-results').innerHTML = data['results']['total'];
                    document.getElementById('total-time').innerHTML = (data['time']['total'] / 60).toFixed(2);
                    document.getElementById('total-words').innerHTML = data['words']['total'];
                });

        }
    </script>
@endsection
