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
            <h4 class="page-title mb-0">{{ __('Transcribe Projects') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i
                            class="fa-solid fa-boxes-packing mr-2 fs-12"></i>{{ __('User') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.dashboard') }}">
                        {{ __('My Dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('user.projects') }}">
                        {{ __('Projects') }}</a></li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label><strong>Status :</strong></label>
                        <select id='status' class="form-control" style="width: 200px">
                            <option value="">--Select Status--</option>
                            <option value="draft">Draft</option>
                            <option value="active">Active</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label><strong>Project Type :</strong></label>
                        <select id='project_type' class="form-control" style="width: 200px">
                            <option value="">--Select Project Type--</option>
                            <option value="video">Video</option>
                            <option value="audio">Audio</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body pt-2">
                    <!-- SET DATATABLE -->
                    <table id='projectDatatable' class='table' width='100%'>
                        <thead>
                            <tr>
                                <th width="1%"></th>
                                <th width="2%">{{ __('Project Name') }}</th>
                                <th width="2%">{{ __('Project Type') }}</th>
                                <th width="2%">{{ __('Date') }}</th>
                                <th width="4%">{{ __('Status') }}</th>
                                <th width="4%">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table> <!-- END SET DATATABLE -->
                </div>
            </div>
        </div>
    </div>
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

            // INITILIZE DATATABLE
            table = $('#projectDatatable').DataTable({
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                responsive: {
                    details: {
                        type: 'column'
                    }
                },
                colReorder: true,
                language: {
                    "emptyTable": "<div><img id='no-results-img' src='{{ URL::asset('img/files/no-result.png') }}'><br>{{ __('No project created yet') }}</div>",
                    search: "<i class='fa fa-search search-icon'></i>",
                    lengthMenu: '_MENU_ ',
                    paginate: {
                        first: '<i class="fa fa-angle-double-left"></i>',
                        last: '<i class="fa fa-angle-double-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>',
                        next: '<i class="fa fa-angle-right"></i>',
                    },
                },
                pagingType: 'full_numbers',
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user.projects') }}",
                    data: function(d) {
                        d.status = $('#status').val(),
                            d.type = $('#project_type').val()
                    }
                },
                columns: [{
                        "className": 'details-control',
                        "orderable": false,
                        "searchable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    {
                        data: 'project_name',
                        name: 'project_name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'project_type',
                        name: 'project_type',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'created_on',
                        name: 'created_on',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            $('#status').change(function() {
                table.draw();
            });
            $('#project_type').change(function() {
                table.draw();
            });
            // if (table.data().count() === 0) {
            //     console.log(table.data().count());
            //     $('.dataTables_paginate').hide();
            //     $('.dataTables_info').hide();
            //     $('.dataTables_length').hide();
            // }
            table.on('init', function() {
                if (table.rows().count() === 0) {
                    $('.dataTables_paginate').hide();
                    $('.dataTables_info').hide();
                    $('.dataTables_length').hide();
                }
            }).draw();
        });
    </script>
@endsection
