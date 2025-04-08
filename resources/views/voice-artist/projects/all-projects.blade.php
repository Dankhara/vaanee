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
            <h4 class="page-title mb-0">{{ __('All Projects') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i
                            class="fa-solid fa-boxes-packing mr-2 fs-12"></i>{{ __('User') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.dashboard') }}">
                        {{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('All Projects') }}</li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card border-0">
                <div class="card-body pt-2">
                    <!-- SET DATATABLE -->
                    <table id='myProjectsDatatable' class='table' width='100%'>
                        <thead>
                            <tr>
                                <th width="1%"></th>
                                <th width="2%">{{ __('Project Name') }}</th>
                                <th width="2%">{{ __('Date') }}</th>
                                <th width="2%">{{ __('Preferred Language') }}</th>
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
            $('#myProjectsDatatable').DataTable();
            // INITILIZE DATATABLE
            // table = $('#myProjectsDatatable').DataTable({
            //     "lengthMenu": [
            //         [25, 50, 100, -1],
            //         [25, 50, 100, "All"]
            //     ],
            //     responsive: {
            //         details: {
            //             type: 'column'
            //         }
            //     },
            //     colReorder: true,
            //     language: {
            //         "emptyTable": "<div><img id='no-results-img' src='{{ URL::asset('img/files/no-result.png') }}'><br>{{ __('Project does not have any transcribe tasks stored yet') }}</div>",
            //         search: "<i class='fa fa-search search-icon'></i>",
            //         lengthMenu: '_MENU_ ',
            //         paginate: {
            //             first: '<i class="fa fa-angle-double-left"></i>',
            //             last: '<i class="fa fa-angle-double-right"></i>',
            //             previous: '<i class="fa fa-angle-left"></i>',
            //             next: '<i class="fa fa-angle-right"></i>'
            //         }
            //     },
            //     pagingType: 'full_numbers',
            //     processing: true,
            //     serverSide: true,
            //     ajax: {
            //         url: "{{ route('user.projects') }}",
            //         data: function(d) {
            //             d.status = $('#status').val(),
            //                 d.type = $('#project_type').val()
            //         }
            //     },
            //     columns: [{
            //             "className": 'details-control',
            //             "orderable": false,
            //             "searchable": false,
            //             "data": null,
            //             "defaultContent": ''
            //         },
            //         {
            //             data: 'project_name',
            //             name: 'project_name',
            //             orderable: true,
            //             searchable: true
            //         },
            //         {
            //             data: 'project_type',
            //             name: 'project_type',
            //             orderable: true,
            //             searchable: true
            //         },
            //         {
            //             data: 'created_on',
            //             name: 'created_on',
            //             orderable: true,
            //             searchable: true
            //         },
            //         {
            //             data: 'status',
            //             name: 'status',
            //             orderable: true,
            //             searchable: true
            //         },
            //         {
            //             data: 'actions',
            //             name: 'actions',
            //             orderable: false,
            //             searchable: false
            //         },
            //     ]
            // });
        });
    </script>
@endsection
