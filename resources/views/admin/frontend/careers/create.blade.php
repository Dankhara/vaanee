@extends('layouts.app')

@section('css')
    <!-- RichText CSS -->
    <link href="{{ URL::asset('plugins/richtext/richtext.min.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('New Job Posting') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                            class="fa fa-globe mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ url('#') }}">
                        {{ __('Frontend Management') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.settings.careers.index') }}">
                        {{ __('Careers Manager') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('#') }}">
                        {{ __('New Job Posting') }}</a></li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection

@section('content')
    <!-- SUPPORT REQUEST -->
    <div class="row">
        <div class="col-lg-8 col-md-8 col-xm-12">
            <div class="card overflow-hidden border-0">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Create New Job') }}</h3>
                </div>
                <div class="card-body pt-5">
                    <form id="" action="{{ route('admin.settings.careers.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row mt-2">
                            <div class="col-sm-12 col-md-6">
                                <div class="input-box">
                                    <h6>{{ __('Category') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <div class="form-group">
                                        <select name="job_category" data-placeholder="{{ __('Select Category') }}:"
                                            class="form-control" required>
                                            <option value="">--Select--</option>
                                            <option value="Software Engineer">Software Engineer</option>
                                            <option value="Project Manager">Project Manager</option>
                                            <option value="Sales Manager">Sales Manager</option>
                                            <option value="Content Writer">Content Writer</option>
                                            <option value="Data Analyst">Data Analyst</option>
                                            <option value="UI/UX Designer">UI/UX Designer</option>
                                            <option value="Operations Manager">Operations Manager</option>
                                            <option value="Business Analyst">Business Analyst</option>
                                            <option value="HR Manager">HR Manager</option>
                                            <option value="Financial Analyst">Financial Analyst</option>
                                            <option value="Digital Marketing">Digital Marketing</option>
                                            <option value="Non IT">Non IT</option>
                                            <option value="Functional">Functional</option>
                                            <option value="Other">Other</option>
                                            <option value="Business Development Executive">Business Development Executive
                                            </option>
                                        </select>
                                    </div>
                                    @error('job_category')
                                        <p class="text-danger">{{ $errors->first('job_category') }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class=" col-sm-12 col-md-6">
                                <div class="input-box">
                                    <h6>{{ __('Job Position') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="job_position" name="job_position"
                                            value="{{ old('job_position') }}" required>
                                    </div>
                                    @error('job_position')
                                        <p class="text-danger">{{ $errors->first('job_position') }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Image') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <div class="input-group file-browser">
                                        <input type="text" class="form-control border-right-0 browse-file"
                                            placeholder="Image File Name" disabled readonly required>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary special-btn">
                                                {{ __('Browse') }} <input type="file" name="image"
                                                    style="display: none;">
                                            </span>
                                        </label>
                                    </div>
                                    @error('image')
                                        <p class="text-danger">{{ $errors->first('image') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Job Description') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <textarea class="form-control" name="job_description" rows="12" id="jobDescription" required>{{ old('job_description') }}</textarea>
                                    @error('job_description')
                                        <p class="text-danger">{{ $errors->first('job_description') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Start Date') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <div class="form-group">
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ old('start_date') }}" required>
                                    </div>
                                    @error('start_date')
                                        <p class="text-danger">{{ $errors->first('start_date') }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Last date to apply') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <div class="form-group">
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ old('end_date') }}" required>
                                    </div>
                                    @error('end_date')
                                        <p class="text-danger">{{ $errors->first('end_date') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Salary') }} <span class="text-required"></h6>
                                    <div class="form-group">
                                        <input type="number" class="form-control" id="salary" name="salary"
                                            value="{{ old('salary') }}">
                                    </div>
                                    @error('salary')
                                        <p class="text-danger">{{ $errors->first('salary') }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class=" col-sm-12 col-md-6">
                                <div class="input-box">
                                    <h6>{{ __('Salary Type') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <div class="form-group">
                                        <select name="salary_type" data-placeholder="{{ __('Select Salary Type') }}:"
                                            class="form-control">
                                            <option value="Perweek">Perweek</option>
                                            <option value="Permonth">Permonth</option>
                                            <option value="Lumpsum">Lumpsum</option>
                                        </select>
                                    </div>
                                    @error('salary_type')
                                        <p class="text-danger">{{ $errors->first('salary_type') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Number of Position') }} <span class="text-required"></h6>
                                    <div class="form-group">
                                        <input type="number" step="1" class="form-control" id="no_of_positions"
                                            name="no_of_positions" value="{{ old('no_of_positions') }}">
                                    </div>
                                    @error('no_of_positions')
                                        <p class="text-danger">{{ $errors->first('no_of_positions') }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class=" col-sm-12 col-md-6">
                                <div class="input-box">
                                    <h6>{{ __('Education') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <div class="form-group">
                                        <select name="education" data-placeholder="{{ __('Select Education') }}:"
                                            class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="N/A">N/A</option>
                                            <option value="High School">High School</option>
                                            <option value="Diploma">Diploma</option>
                                            <option value="Associate Degree">Associate Degree</option>
                                            <option value="Bachelor Degree">Bachelor Degree</option>
                                            <option value="Master Degree or Higher">Master Degree or Higher</option>
                                            <option value="PhD">PhD</option>
                                        </select>
                                    </div>
                                    @error('education')
                                        <p class="text-danger">{{ $errors->first('education') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Job Type') }} <span class="text-required"></h6>
                                    <div class="form-group">
                                        <select name="job_type" data-placeholder="{{ __('Select Job Type') }}:"
                                            class="form-control">
                                            <option value="Work From Home">Work From Home</option>
                                            <option value="Fulltime">Fulltime</option>
                                            <option value="Part time">Part time</option>
                                            <option value="Campus Ambassador">Campus Ambassador</option>
                                        </select>
                                    </div>
                                    @error('job_type')
                                        <p class="text-danger">{{ $errors->first('job_type') }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class=" col-sm-12 col-md-6">
                                <div class="input-box">
                                    <h6>{{ __('Duration') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <div class="form-group">
                                        <select name="duration" data-placeholder="{{ __('Select Duration') }}:"
                                            class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="1 month">1 month</option>
                                            <option value="2 months">2 months</option>
                                            <option value="3 months">3 months</option>
                                            <option value="6 months">6 months</option>
                                            <option value="Permanent">Permanent</option>
                                        </select>
                                    </div>
                                    @error('duration')
                                        <p class="text-danger">{{ $errors->first('duration') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- ACTION BUTTON -->
                        <div class="border-0 text-right mb-2 mt-1">
                            <a href="{{ route('admin.settings.careers.index') }}"
                                class="btn btn-cancel mr-2">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END SUPPORT REQUEST -->
@endsection

@section('js')
    <!-- RichText JS -->
    <script src="{{ URL::asset('plugins/richtext/jquery.richtext.min.js') }}"></script>
    <script type="text/javascript">
        $('#jobDescription').richText({

            // text formatting
            bold: true,
            italic: true,
            underline: true,

            // text alignment
            leftAlign: true,
            centerAlign: true,
            rightAlign: true,
            justify: true,

            // lists
            ol: true,
            ul: true,

            // title
            heading: true,

            // fonts
            fonts: true,
            fontList: [
                "Arial",
                "Arial Black",
                "Comic Sans MS",
                "Courier New",
                "Geneva",
                "Georgia",
                "Helvetica",
                "Impact",
                "Lucida Console",
                "Tahoma",
                "Times New Roman",
                "Verdana"
            ],
            fontColor: true,
            fontSize: true,

            // uploads
            imageUpload: true,
            fileUpload: true,

            // media
            videoEmbed: true,

            // link
            urls: true,

            // tables
            table: true,

            // code
            removeStyles: true,
            code: true,

            // colors
            colors: [],

            // dropdowns
            fileHTML: '',
            imageHTML: '',

            // translations
            translations: {
                'title': 'Title',
                'white': 'White',
                'black': 'Black',
                'brown': 'Brown',
                'beige': 'Beige',
                'darkBlue': 'Dark Blue',
                'blue': 'Blue',
                'lightBlue': 'Light Blue',
                'darkRed': 'Dark Red',
                'red': 'Red',
                'darkGreen': 'Dark Green',
                'green': 'Green',
                'purple': 'Purple',
                'darkTurquois': 'Dark Turquois',
                'turquois': 'Turquois',
                'darkOrange': 'Dark Orange',
                'orange': 'Orange',
                'yellow': 'Yellow',
                'imageURL': 'Image URL',
                'fileURL': 'File URL',
                'linkText': 'Link text',
                'url': 'URL',
                'size': 'Size',
                'responsive': 'Responsive',
                'text': 'Text',
                'openIn': 'Open in',
                'sameTab': 'Same tab',
                'newTab': 'New tab',
                'align': 'Align',
                'left': 'Left',
                'center': 'Center',
                'right': 'Right',
                'rows': 'Rows',
                'columns': 'Columns',
                'add': 'Add',
                'pleaseEnterURL': 'Please enter an URL',
                'videoURLnotSupported': 'Video URL not supported',
                'pleaseSelectImage': 'Please select an image',
                'pleaseSelectFile': 'Please select a file',
                'bold': 'Bold',
                'italic': 'Italic',
                'underline': 'Underline',
                'alignLeft': 'Align left',
                'alignCenter': 'Align centered',
                'alignRight': 'Align right',
                'addOrderedList': 'Add ordered list',
                'addUnorderedList': 'Add unordered list',
                'addHeading': 'Add Heading/title',
                'addFont': 'Add font',
                'addFontColor': 'Add font color',
                'addFontSize': 'Add font size',
                'addImage': 'Add image',
                'addVideo': 'Add video',
                'addFile': 'Add file',
                'addURL': 'Add URL',
                'addTable': 'Add table',
                'removeStyles': 'Remove styles',
                'code': 'Show HTML code',
                'undo': 'Undo',
                'redo': 'Redo',
                'close': 'Close'
            },

            // privacy
            youtubeCookies: false,

            // developer settings
            useSingleQuotes: false,
            height: 0,
            heightPercentage: 0,
            id: "",
            class: "",
            useParagraph: false,
            maxlength: 0,
            callback: undefined,
            useTabForNext: false
        });
    </script>
    <!-- Awselect JS -->
    {{-- <script src="{{ URL::asset('plugins/awselect/awselect.min.js') }}"></script>
    <script src="{{ URL::asset('js/awselect.js') }}"></script> --}}
    <!-- File Uploader -->
    <script src="{{ URL::asset('js/file-upload.js') }}"></script>
@endsection
