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
            <h4 class="page-title mb-0">{{ __('Voice Cloning Results') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                            class="fa-solid fa-user-shield mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a
                        href="{{ route('voice.clone.voice.cloning.results') }}">
                        {{ __('Result List') }}</a></li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection

@section('content')
    <!-- USERS LIST DATA TABEL -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xm-12">
            <div class="card border-0">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Cloning Results') }}</h3>
                </div>
                <div class="card-body pt-2">
                    <!-- BOX CONTENT -->
                    <div class="box-content">

                        <!-- DATATABLE -->
                        <table id='profilesTable' class='table' width='100%'>
                            <thead>
                                <tr>
                                    <th width="11%">{{ __('Plan Type') }}</th>
                                    <th width="11%">{{ __('Created On') }}</th>
                                    <th width="15%">{{ __('User') }}</th>
                                    <th width="10%" style="white-space: nowrap;">{{ __('Track ID') }}</th>
                                    <th width="7%">{{ __('Language') }}</th>
                                    <th width="5%">{{ __('Status') }}</th>
                                    <th width="7%"><i class="fa-sharp fa-solid fa-music"></i></th>
                                    <th width="7%"><i class="fa-sharp fa-solid fa-circle-down"></i></th>
                                    <th width="7%">{{ __('Duration') }}</th>
                                    <th width="7%">{{ __('Format') }}</th>
                                    <th width="7%">{{ __('Size') }}</th>
                                    <th width="7%">{{ __('Mode') }}</th>
                                    <th width="8%">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- END DATATABLE -->

                    </div> <!-- END BOX CONTENT -->
                </div>
            </div>
        </div>
    </div>
    <!-- END USERS LIST DATA TABEL -->
@endsection

@section('js')
    <!-- Data Tables JS -->
    <script src="{{ URL::asset('plugins/datatable/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {

            "use strict";
            $('#profilesTable').DataTable();
            var table = $('#profilesTableee').DataTable({
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                responsive: true,
                colReorder: true,
                "order": [
                    [0, "desc"]
                ],
                language: {
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
                ajax: "{{ route('voice.clone.voice.cloning.profiles') }}",
                columns: [{
                        data: 'user',
                        name: 'user',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'custom-group',
                        name: 'custom-group',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'custom-characters',
                        name: 'custom-characters',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'custom-minutes',
                        name: 'custom-minutes',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'custom-country',
                        name: 'custom-country',
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
                        data: 'created-on',
                        name: 'created-on',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'last-seen-on',
                        name: 'last-seen-on',
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

            // DELETE CONFIRMATION
            $(document).on('click', '.deleteUserButton', function(e) {

                e.preventDefault();

                Swal.fire({
                    title: '{{ __('Confirm User Deletion') }}',
                    text: '{{ __('Warning! This action will delete user permanently') }}',
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
                            url: 'delete',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                if (data == 'success') {
                                    Swal.fire('{{ __('User Deleted') }}',
                                        '{{ __('User has been successfully deleted') }}',
                                        'success');
                                    $("#profilesTable").DataTable().ajax.reload();
                                } else {
                                    Swal.fire('{{ __('Delete Failed') }}',
                                        '{{ __('There was an error while deleting this user') }}',
                                        'error');
                                }
                            },
                            error: function(data) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: '{{ __('Something went wrong') }}!'
                                })
                            }
                        })
                    }
                })
            });

        });
    </script>
@endsection
