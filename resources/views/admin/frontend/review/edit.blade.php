@extends('layouts.app')

@section('css')
    <!-- Data Table CSS -->
    <link href="{{ URL::asset('plugins/awselect/awselect.min.css') }}" rel="stylesheet" />
    <style>
        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            text-align: center;
        }

        .rating input {
            display: none;
        }

        .rating label {
            display: inline-block;
            padding: 5px;
            font-size: 40px;
            cursor: pointer;
            color: #ccc;
        }

        .rating label:hover,
        .rating label:hover~label,
        .rating input:checked~label {
            color: #fdd835;
        }

        .rating label:before {
            content: '★';
        }
    </style>
@endsection

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Edit Customer Review') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                            class="fa fa-globe mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ url('#') }}">
                        {{ __('Frontend Management') }}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.settings.review') }}">
                        {{ __('Reviews Manager') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('#') }}">
                        {{ __('Edit Customer Review') }}</a></li>
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
                    <h3 class="card-title">{{ __('Edit Customer Review') }}</h3>
                </div>
                <div class="card-body pt-5">
                    <form id="" action="{{ route('admin.settings.review.update', [$id->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row mt-2">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Customer Name') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $id->name }}" required>
                                    </div>
                                    @error('name')
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Designation') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="designation" name="designation"
                                            value="{{ old('designation', $id->designation) }}" required placeholder="CEO">
                                    </div>
                                    @error('designation')
                                        <p class="text-danger">{{ $errors->first('designation') }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Customer Avatar') }}</h6>
                                    <div class="input-group file-browser">
                                        <input type="text" class="form-control border-right-0 browse-file"
                                            placeholder="Image File Name" disabled readonly>
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
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Company Name') }}</h6>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                            value="{{ old('company_name', $id->company_name) }}" required>
                                    </div>
                                    @error('company_name')
                                        <p class="text-danger">{{ $errors->first('company_name') }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Company Logo') }}</h6>
                                    <div class="input-group file-browser">
                                        <input type="text" class="form-control border-right-0 browse-file"
                                            placeholder="Image File Name" disabled readonly>
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary special-btn">
                                                {{ __('Browse') }} <input type="file" name="company_logo"
                                                    style="display: none;">
                                            </span>
                                        </label>
                                    </div>
                                    @error('company_logo')
                                        <p class="text-danger">{{ $errors->first('company_logo') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Rating') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <div id="audio-format" role="radiogroup">
                                        <span id="ogg-format">
                                            <div class="radio-control">
                                                <div class="rating">
                                                    <input type="radio" id="star5" name="rating" value="5"
                                                        @checked($id->rating == 5)><label for="star5"></label>
                                                    <input type="radio" id="star4" name="rating" value="4"
                                                        @checked($id->rating == 4)><label for="star4"></label>
                                                    <input type="radio" id="star3" name="rating" value="3"
                                                        @checked($id->rating == 3)><label for="star3"></label>
                                                    <input type="radio" id="star2" name="rating" value="2"
                                                        @checked($id->rating == 2)><label for="star2"></label>
                                                    <input type="radio" id="star1" name="rating" value="1"
                                                        @checked($id->rating == 1)><label for="star1"></label>
                                                </div>
                                            </div>
                                        </span>
                                    </div>
                                    @error('text')
                                        <p class="text-danger">{{ $errors->first('text') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="input-box">
                                    <h6>{{ __('Review Text') }} <span class="text-required"><i
                                                class="fa-solid fa-asterisk"></i></span></h6>
                                    <textarea class="form-control" name="text" rows="12" id="richtext" required>{{ $id->text }}</textarea>
                                    @error('text')
                                        <p class="text-danger">{{ $errors->first('text') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- ACTION BUTTON -->
                        <div class="border-0 text-right mb-2 mt-1">
                            <a href="{{ route('admin.settings.review') }}"
                                class="btn btn-cancel mr-2">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END SUPPORT REQUEST -->
@endsection

@section('js')
    <!-- Awselect JS -->
    <script src="{{ URL::asset('plugins/awselect/awselect.min.js') }}"></script>
    <script src="{{ URL::asset('js/awselect.js') }}"></script>
    <!-- File Uploader -->
    <script src="{{ URL::asset('js/file-upload.js') }}"></script>
@endsection
