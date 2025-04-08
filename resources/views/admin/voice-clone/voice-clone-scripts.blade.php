@extends('layouts.app')

@section('css')
    <!-- Data Table CSS -->
    <link href="{{ URL::asset('plugins/datatable/datatables.min.css') }}" rel="stylesheet" />
    <!-- Sweet Alert CSS -->
    <link href="{{ URL::asset('plugins/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('plugins/awselect/awselect.min.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Voice Script') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                            class="fa-solid fa-user-shield mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a
                        href="{{ route('voice.clone.voice.clone.script') }}">
                        {{ __('Voice Script') }}</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
            <a href="{{ route('voice.clone.create.voice.clone.script') }}"
                class="btn btn-primary mt-1">{{ __('Add New Script') }}</a>
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
                    <h3 class="card-title">{{ __('Voice Scripts') }}</h3>
                </div>
                <div class="card-body pt-2">
                    <!-- BOX CONTENT -->
                    <div class="box-content">

                        <!-- DATATABLE -->
                        <table id='voiceScriptsTable' class='table' width='100%'>
                            <thead>
                                <tr>
                                    <th width="8%">{{ __('Language') }}</th>
                                    <th width="8%">{{ __('Date') }}</th>
                                    <th width="10%">{{ __('No. of Scripts') }}</th>
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
    <script src="{{ URL::asset('plugins/awselect/awselect-custom.js') }}"></script>
    <script src="{{ URL::asset('js/awselect.js') }}"></script>
    <!-- Data Tables JS -->
    <script src="{{ URL::asset('plugins/datatable/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {

            "use strict";
            var table = $('#voiceScriptsTable').DataTable({
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
                ajax: "{{ route('voice.clone.voice.clone.script') }}",
                columns: [{
                        data: 'language-code',
                        name: 'language-code',
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
                        data: 'no-of-scripts',
                        name: 'no-of-scripts',
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
            $(document).on('click', '.deleteScriptButton', function(e) {

                e.preventDefault();

                Swal.fire({
                    title: '{{ __('Confirm Script Deletion') }}',
                    text: '{{ __('Warning! This action will delete language scripts permanently') }}',
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
                            url: '{{ route('voice.clone.delete.voice.clone.script') }}',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                if (data == 'success') {
                                    Swal.fire('{{ __('Voice Script Deleted') }}',
                                        '{{ __('Voice Script has been successfully deleted') }}',
                                        'success');
                                    $("#voiceScriptsTable").DataTable().ajax.reload();
                                } else {
                                    Swal.fire('{{ __('Delete Failed') }}',
                                        '{{ __('There was an error while deleting this voice script') }}',
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
