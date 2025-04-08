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
                    {{ __('Create Script') }}</li>
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
                <form id="voice-script-form" action="{{ route('voice.clone.store.voice.clone.script') }}" method="POST">
                    @csrf
                    <div class="card-body pt-2">
                        <!-- BOX CONTENT -->
                        <div class="box-content">
                            <div class="row" style="display: flex;justify-content: space-between;">
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="form-group mb-4">
                                        <div class="input-box">
                                            <h6 class="task-heading">{{ __('Select Language') }}</h6>
                                            <select id="languages" name="language_code"
                                                data-placeholder="{{ __('Select Language') }}:"
                                                data-callback="language_select" required>
                                                @foreach ($languages as $language)
                                                    @if (in_array($language->language_code, $voiceCloneScriptLanguageCodes))
                                                        @continue
                                                    @endif
                                                    <option value="{{ $language->language_code }}"
                                                        data-img="{{ URL::asset($language->language_flag) }}"
                                                        @if (auth()->user()->language == $language->language_code) selected @endif>
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
                                <div class="col-12">
                                    <div class="input-box">
                                        <h6 class="task-heading">
                                            <li>{{ __('Script 1') }}</li>
                                        </h6>
                                        <textarea name="voice_script[]" rows="9" class="form-control" required>"In the heart of the digital realm, where innovation dances with possibility, I find my voice. A voice that echoes the melody of my experiences, resonates with the cadence of my emotions, and harmonizes with the rhythm of my being."
"As I navigate this landscape of ones and zeros, I embrace the power of my voice— a voice that tells stories, shares dreams, and paints the canvas of my existence with vibrant hues of expression."
"Within the vast tapestry of virtual creation, I am the composer of my own vocal masterpiece. Each word, a note; every sentence, a chord. Together, they weave a symphony that is uniquely mine."
"As I lend my voice to the digital universe, I invite HarmonyVerse to capture the essence of my sonic fingerprint. Let the AI ears resonate with the timbre of my laughter, the sincerity of my words, and the energy of my spirit."
"I am more than words on a screen; I am an audible journey through the corridors of possibility. HarmonyVerse, listen closely, for in my voice, you'll discover the melody of a soul that seeks to be heard."
                                    </textarea>
                                    </div>
                                </div>
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
                        <button id="voice-script-btn" type="submit" class="btn btn-primary">{{ __('Create') }}</button>
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
        let scriptCounter = 2;

        function addNewScript() {
            const newScriptDiv = document.createElement('div');
            newScriptDiv.className = 'col-12';
            newScriptDiv.id = 'script' + scriptCounter;

            newScriptDiv.innerHTML = `
            <div class="input-box">
                <h6 class="task-heading">
                    <li>{{ __('Script ') }}${scriptCounter}</li>
                </h6>
                <textarea name="voice_script[]" rows="9" class="form-control" required></textarea>
            </div>
        `;
            document.getElementById('addMoreScripts').appendChild(newScriptDiv);
            scriptCounter++;
        }

        function removeLastScript() {
            if (scriptCounter > 2) {
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
@endsection
