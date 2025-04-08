@extends('layouts.app')

@section('css')
    <!-- Data Table CSS -->
    <link href="{{ URL::asset('plugins/datatable/datatables.min.css') }}" rel="stylesheet" />
    <!-- Sweet Alert CSS -->
    <link href="{{ URL::asset('plugins/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0"> {{ __('Career Manager') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                            class="fa fa-globe mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ url('#') }}">
                        {{ __('Frontend Management') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('#') }}">
                        {{ __('Career Manager') }}</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
            <a href="{{ route('admin.settings.careers.create') }}"
                class="btn btn-primary mt-1">{{ __('Create New Job') }}</a>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xm-12">
            <div class="card border-0">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Careers List') }}</h3>
                </div>
                <div class="card-body pt-2">
                    <!-- SET DATATABLE -->
                    <table id='careersTable' class='table' width='100%'>
                        <thead>
                            <tr>
                                <th width="7%">{{ __('Created Date') }}</th>
                                <th width="10%">{{ __('Category') }}</th>
                                <th width="10%">{{ __('Job Position') }}</th>
                                <th width="10%">{{ __('Status') }}</th>
                                <th width="15%">{{ __('Image') }}</th>
                                <th width="5%">{{ __('Actions') }}</th>
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
    <script src="{{ URL::asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {

            "use strict";

            // INITILIZE DATATABLE
            var table = $('#careersTable').DataTable({
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                responsive: true,
                colReorder: true,
                "order": [
                    [1, "desc"]
                ],
                language: {
                    "emptyTable": "<div>No jobs created yet</div>",
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
                serverSide: true,
                ajax: "{{ route('admin.settings.careers.index') }}",
                columns: [{
                        data: 'created-on',
                        name: 'created-on',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'job_category',
                        name: 'job_category',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'job_position',
                        name: 'job_position',
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
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            table.on('init', function() {
                if (table.rows().count() === 0) {
                    $('.dataTables_paginate').hide();
                    $('.dataTables_info').hide();
                    $('.dataTables_length').hide();
                }
            }).draw();


            // DELETE REVIEW
            $(document).on('click', '.deleteCareerButton', function(e) {

                e.preventDefault();

                Swal.fire({
                    title: '{{ __('Confirm Job Deletion') }}',
                    text: '{{ __('It will permanently delete this job posting') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('Delete') }}',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append("id", $(this).attr('id'));
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'post',
                            url: 'career/delete',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                if (data == 'success') {
                                    Swal.fire('{{ __('Job Deleted') }}',
                                        '{{ __('Job has been successfully deleted') }}',
                                        'success');
                                    var table = $("#careersTable").DataTable().ajax
                                        .reload();
                                } else {
                                    Swal.fire('{{ __('Delete Failed') }}',
                                        '{{ __('There was an error while deleting this job') }}',
                                        'error');
                                }
                            },
                            error: function(data) {
                                Swal.fire('Oops...', 'Something went wrong!', 'error')
                            }
                        })
                    }
                })
            });

        });
    </script>
@endsection
