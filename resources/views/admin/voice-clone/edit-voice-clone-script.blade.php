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
                <li class="breadcrumb-item"><a href="{{ route('voice.clone.voice.clone.script') }}">
                        {{ __('Voice Script') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('Edit Script') }}</li>
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
                {{-- <div class="card-header">
                    <h3 class="card-title">{{ __('Cloning Results') }}</h3>
                </div> --}}
                <form id="voice-script-form"
                    action="{{ route('voice.clone.update.voice.clone.script', $VoiceCloneScriptLanguage->id) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="card-body pt-2">
                        <!-- BOX CONTENT -->
                        <div class="box-content">
                            <div class="row" style="display: flex;justify-content: space-between;">
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="form-group mb-4">
                                        <div class="input-box">
                                            <h6 class="task-heading">{{ __('Language') }}</h6>
                                            <select id="languages" data-placeholder="{{ __('Selected Language') }}:"
                                                data-callback="language_select" disabled>
                                                @foreach ($languages as $language)
                                                    @continue($VoiceCloneScriptLanguage->language_code != $language->language_code)
                                                    <option value="{{ $language->language_code }}"
                                                        data-img="{{ URL::asset($language->language_flag) }}" selected>
                                                        {{ $language->language }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-box">
                                        <h6 class="task-heading">{{ __('Voice Scripts') }}</h6>
                                    </div>
                                </div>
                                @foreach ($VoiceCloneScriptLanguage->voice_clone_script_language_scripts as $voice_clone_script_language_script)
                                    <div class="col-12">
                                        <div class="input-box">
                                            <h6 class="task-heading">
                                                <li>{{ __('Script ') . $loop->iteration }} <a class="deleteScript"
                                                        href="#"
                                                        id="{{ $voice_clone_script_language_script->id }}"><i
                                                            class="fa-solid fa-trash table-action-buttons delete-action-button"
                                                            title="Delete language script"></i></a></li>
                                            </h6>
                                            <textarea name="voice_script[{{ $loop->iteration }}]" rows="9" class="form-control" required>{{ $voice_clone_script_language_script->voice_script }}</textarea>
                                        </div>
                                    </div>
                                    <input type="hidden"
                                        name="voice_clone_script_language_script_id[{{ $loop->iteration }}]"
                                        value="{{ $voice_clone_script_language_script->id }}">
                                @endforeach
                                <div id="addMoreScripts">

                                </div>
                            </div>
                        </div> <!-- END BOX CONTENT -->
                        <div class="row">
                            <div class="col-12 text-center">
                                <button id="addNewScript" type="button"
                                    class="btn btn-primary">{{ __('Add Script') }}</button>
                                <button id="removeScript" type="button"
                                    class="btn btn-cancel">{{ __('Remove Script') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 text-right mb-2 pr-0">
                        <a href="{{ route('voice.clone.voice.clone.script') }}"
                            class="btn btn-cancel mr-2">{{ __('Return') }}</a>
                        <button id="voice-script-btn" type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END USERS LIST DATA TABEL -->
@endsection

@section('js')
    <script src="{{ URL::asset('plugins/awselect/awselect-custom.js') }}"></script>
    <script src="{{ URL::asset('js/awselect.js') }}"></script>
    <script src="{{ URL::asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script>
        let scriptCounter = {{ count($VoiceCloneScriptLanguage->voice_clone_script_language_scripts) + 1 }};
        let minValue = {{ count($VoiceCloneScriptLanguage->voice_clone_script_language_scripts) + 1 }};

        function addNewScript() {
            const newScriptDiv = document.createElement('div');
            newScriptDiv.className = 'col-12';
            newScriptDiv.id = 'script' + scriptCounter;

            newScriptDiv.innerHTML = `
            <div class="input-box">
                <h6 class="task-heading">
                    <li>{{ __('Script ') }}${scriptCounter}</li>
                </h6>
                <textarea name="voice_script[${scriptCounter}]" rows="9" class="form-control" required></textarea>
            </div>
            <input type="hidden" name="voice_clone_script_language_script_id[${scriptCounter}]" value="">
        `;
            document.getElementById('addMoreScripts').appendChild(newScriptDiv);
            scriptCounter++;
        }

        function removeLastScript() {
            if (scriptCounter > minValue) {
                scriptCounter--;
                const lastScriptId = 'script' + scriptCounter;
                const lastScriptDiv = document.getElementById(lastScriptId);
                lastScriptDiv.parentNode.removeChild(lastScriptDiv);
            }
        }
        document.getElementById('addNewScript').addEventListener('click', addNewScript);
        document.getElementById('removeScript').addEventListener('click', removeLastScript);
    </script>
    <script>
        $('#voice-script-form').submit(function(e) {
            $('#voice-script-btn').html('Saving...');
            $('#voice-script-btn').addClass('merge-processing');
            $('#voice-script-btn').prop('disabled', true);

        });
    </script>
    <script>
        $(document).on('click', '.deleteScript', function(e) {

            e.preventDefault();

            Swal.fire({
                title: '{{ __('Confirm Script Deletion') }}',
                text: '{{ __('Warning! This action will delete language script permanently') }}',
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
                        url: '{{ route('voice.clone.delete.voice.clone.language.script') }}',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data == 'success') {
                                Swal.fire('{{ __('Language Script Deleted') }}',
                                    '{{ __('Language Script has been successfully deleted') }}',
                                    'success');
                                window.location.reload();
                            } else {
                                Swal.fire('{{ __('Delete Failed') }}',
                                    '{{ __('There was an error while deleting this language script') }}',
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
    </script>
@endsection
