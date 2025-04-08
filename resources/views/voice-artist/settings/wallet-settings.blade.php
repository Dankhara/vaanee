@extends('layouts.app')

@section('css')
    <!-- Sweet Alert CSS -->
    <link href="{{ URL::asset('plugins/sweetalert/sweetalert2.min.css') }}" rel="stylesheet" />
    <!-- Data Table CSS -->
    <link href="{{ URL::asset('plugins/datatable/datatables.min.css') }}" rel="stylesheet" />
    <!-- Awselect CSS -->
    <link href="{{ URL::asset('plugins/awselect/awselect.min.css') }}" rel="stylesheet" />
    <!-- Flipclock CSS -->
    <link href="{{ URL::asset('plugins/flipclock/flipclock.css') }}" rel="stylesheet" />
    <!-- Green Audio Players CSS -->
    <link href="{{ URL::asset('plugins/audio-player/green-audio-player.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Settings') }}</h4>
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('user.dashboard') }}"><i
                            class="fa-solid fa-chart-tree-map mr-2 fs-12"></i>{{ __('User') }}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ url('#') }}"> {{ __('Wallet Settings') }}</a>
                </li>
            </ol>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header">
                    <h3 class="card-title">Payment Methods</h3>
                </div>
                <div class="card-body pt-7 pl-7 pr-7 pb-4" id="tts-body-minify">
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-3">
                            <h3 class="task-heading">{{ __('Payment Details') }}</h3>
                        </div>
                        <div class="col-12 col-md-8 col-lg-9">
                            <div class="row">
                                <div class="col-12 col-md-8 col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12 pr-0 pr-minify">
                                            <div class="input-box">
                                                <h6 class="task-heading">{{ __('Payment Option') }}</h6>
                                                <select id="payment-option" name="country"
                                                    data-placeholder="Select Payment Option" required
                                                    onchange="handlePaymentOptionChange()">
                                                    <option value="bank_account">Bank Account</option>
                                                    <option value="upi">UPI</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="bank-account-div" class="d-none">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-12 pr-0 pr-minify">
                                                        <div class="input-box">
                                                            <h6 class="task-heading">{{ __('Bank Name') }}</h6>
                                                            <input placeholder="Bank Name" id="bank_name"
                                                                class="form-control" name="bank_name" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-12 pr-0 pr-minify">
                                                        <div class="input-box">
                                                            <h6 class="task-heading">{{ __('Account Number') }}</h6>
                                                            <input type="number" placeholder="XXXXXXXXXXXX"
                                                                id="account_number" class="form-control"
                                                                name="account_number" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-12 pr-0 pr-minify">
                                                        <div class="input-box">
                                                            <h6 class="task-heading">{{ __('IFSC Code') }}</h6>
                                                            <input class="form-control" id="ifsc_code" name="ifsc_code"
                                                                placeholder="Ifsc code" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="upi-div" class="d-none">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-12 pr-0 pr-minify">
                                                        <div class="input-box">
                                                            <h6 class="task-heading">{{ __('UPI Id') }}</h6>
                                                            <input placeholder="UPI Id" id="upi_id" class="form-control"
                                                                name="upi_id" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-3">
                            <h3 class="task-heading">{{ __('Email Address') }}</h3>
                        </div>
                        <div class="col-12 col-md-8 col-lg-9">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12 pr-0 pr-minify">
                                                    <div class="input-box">
                                                        <h6 class="task-heading">{{ __('Email') }}</h6>
                                                        <input type="email" placeholder="example@example.com"
                                                            id="email_address" class="form-control" name="email_address"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-3">
                            <h3 class="task-heading">{{ __('Address') }}</h3>
                        </div>
                        <div class="col-12 col-md-8 col-lg-9">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12 pr-0 pr-minify">
                                                    <div class="input-box">
                                                        <input placeholder="Street,city,state" id="address"
                                                            class="form-control" name="address" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 pr-0 pr-minify">
                                                    <div class="input-box">
                                                        <h6 class="task-heading">{{ __('Country') }}</h6>
                                                        <select id="user-country" name="country"
                                                            data-placeholder="Select Your Country" required>
                                                            @foreach (config('countries') as $value)
                                                                <option value="{{ $value }}"
                                                                    @if (config('settings.default_country') == $value) selected @endif>
                                                                    {{ $value }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('plugins/audio-player/green-audio-player.js') }}"></script>
    <script src="{{ URL::asset('js/audio-player.js') }}"></script>
    <!-- Flipclock JS -->
    <script src={{ URL::asset('plugins/flipclock/moment.min.js') }}></script>
    <script src={{ URL::asset('plugins/flipclock/popper.min.js') }}></script>
    <script src={{ URL::asset('plugins/flipclock/flipclock.min.js') }}></script>
    <script src={{ URL::asset('plugins/flipclock/recorder.js') }}></script>

    <!-- Data Tables JS -->
    <script src="{{ URL::asset('plugins/datatable/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ URL::asset('js/results.js') }}"></script>
    <script src="{{ URL::asset('plugins/awselect/awselect-custom.js') }}"></script>
    <script src="{{ URL::asset('js/awselect.js') }}"></script>
    <script>
        function handlePaymentOptionChange() {
            var selectedOption = document.getElementById("payment-option").value;
            var bankAccountDiv = document.getElementById("bank-account-div");
            var upiDiv = document.getElementById("upi-div");
            if (selectedOption === "bank_account") {
                bankAccountDiv.classList.remove("d-none");
                upiDiv.classList.add("d-none");
            } else if (selectedOption === "upi") {
                bankAccountDiv.classList.add("d-none");
                upiDiv.classList.remove("d-none");
            }
        }
    </script>
@endsection
