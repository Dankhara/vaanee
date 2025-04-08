@extends('layouts.app')

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('User Information') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-user-shield mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.user.dashboard') }}"> {{ __('User Management') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.user.list') }}">{{ __('User List') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#"> {{ __('User Information') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection

@section('content')
	<!-- USER PROFILE PAGE -->
	<div class="row">
		<div class="col-xl-3 col-lg-3 col-md-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title">{{ __('Personal Information') }}</h3>
				</div>
				<div class="overflow-hidden p-0">
					<div class="row">
						<div class="col-sm-6 border-right border-bottom text-center">
							<div class="p-2">
								<span class="text-muted fs-12">{{ __('Subscription Characters') }}</span>
								<h5 class="mt-1 mb-1 font-weight-bold text-dark number-font fs-14">{{ number_format($user->available_chars) }}</h5>								
							</div>
						</div>
						<div class="col-sm-6 border-bottom">
							<div class="text-center p-2">
								<span class="text-muted fs-12">{{ __('Prepaid Characters') }}</span>
								<h5 class="mt-1 mb-1 font-weight-bold text-dark number-font fs-14">{{ number_format($user->available_chars_prepaid) }}</h5>								
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 border-right border-bottom text-center">
							<div class="p-2">
								<span class="text-muted fs-12">{{ __('Subscription Minutes') }}</span>
								<h5 class="mt-1 mb-1 font-weight-bold text-dark number-font fs-14">{{ number_format($user->available_minutes) }}</h5>								
							</div>
						</div>
						<div class="col-sm-6 border-bottom">
							<div class="text-center p-2">
								<span class="text-muted fs-12">{{ __('Prepaid Minutes') }}</span>
								<h5 class="mt-1 mb-1 font-weight-bold text-dark number-font fs-14">{{ number_format($user->available_minutes_prepaid) }}</h5>								
							</div>
						</div>
					</div>
				</div>
				<div class="widget-user-image overflow-hidden mx-auto mt-5"><img alt="User Avatar" class="rounded-circle" src="@if($user->profile_photo_path) {{ $user->profile_photo_path }} @else {{ URL::asset('img/users/avatar.jpg') }} @endif"></div>
				<div class="card-body text-center">				
					<div>
						<h4 class="mb-1 mt-1 font-weight-bold fs-16">{{ $user->name }}</h4>
						<h6 class="text-muted fs-12">{{ $user->job_role }}</h6>
						@if ($user_subscription != '')
							<h6 class="text-muted fs-12">{{ __('Subscription Plan') }}: <span class="text-info">{{ $user_subscription->plan_name }}</span></h6>
						@else 
							<h6 class="text-muted fs-12">{{ __('Subscription Plan') }}: <span class="text-info font-weight-bold">{{ __('No Subscription') }}</span></h6>
						@endif
						<a href="{{ route('admin.user.edit', [$user->id]) }}" class="btn btn-primary mt-3 mb-2 mr-2 pl-5 pr-5"><i class="fa-solid fa-pencil mr-1"></i> {{ __('Edit Profile') }}</a>
						<a href="{{ route('admin.user.storage', [$user->id]) }}" class="btn btn-primary mt-3 mb-2"><i class="fa-solid fa-hard-drive mr-1"></i>{{ __('Add Credits') }}</a>
					</div>
				</div>
				
				<div class="card-body pt-0">
					<div class="table-responsive">
						<table class="table mb-0">
							<tbody>
								<tr>
									<td class="py-2 px-0 border-top-0">
										<span class="font-weight-semibold w-50">{{ __('Full Name') }} </span>
									</td>
									<td class="py-2 px-0 border-top-0">{{ $user->name }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Email') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->email }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('User Status') }} </span>
									</td>
									<td class="py-2 px-0">{{ ucfirst($user->status) }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('User Group') }} </span>
									</td>
									<td class="py-2 px-0">{{ ucfirst($user->group) }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Registered On') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->created_at }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Last Updated On') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->updated_at }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Referral ID') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->referral_id }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Job Role') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->job_role }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Company') }}</span>
									</td>
									<td class="py-2 px-0">{{ $user->company }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Website') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->website }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Address') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->address }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Postal Code') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->postal_code }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('City') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->city }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Country') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->country }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Phone') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->phone_number }}</td>
								</tr>
							</tbody>
						</table>
						<div class="border-0 text-right mb-2 mt-2">
							<a href="{{ route('admin.user.list') }}" class="btn btn-primary">{{ __('Return') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-9 col-lg-9 col-md-12">
			<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="card mb-5 border-0">
						<div class="card-header d-inline border-0">
							<div>
								<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-box-open mr-4 text-info"></i>{{ __('Subscription') }}</h3>
							</div>
							@if ($user_subscription == '')
								<div>
									<h3 class="card-title fs-24 font-weight-800">{{ __('Active Forever') }}</h3>
								</div>
								<div class="mb-1">
									<span class="fs-12 text-muted">{{ __('No Subscription') }} / {!! config('payment.default_system_currency_symbol') !!}0.00 {{ __('Per Month') }}</span>
								</div>
							@else
								<div>
									<h3 class="card-title fs-24 font-weight-800">@if ($user_subscription->pricing_plan == 'monthly') {{ __('Monthly Subscription') }} @else {{ __('Yearly Subscription') }} @endif</h3>
								</div>
								<div class="mb-1">
									<span class="fs-12 text-muted">{{ $user_subscription->plan_name }} {{ __('Plan') }} / {!! config('payment.default_system_currency_symbol') !!}{{ $user_subscription->price }} @if ($user_subscription->pricing_plan == 'monthly') {{ __('Per Month') }} @else {{ __('Per Year') }} @endif</span>
								</div>
							@endif
						</div>
						<div class="card-body">
							<div class="mb-3">
								<span class="fs-12 text-muted">{{ __('Total ') }} {{ $characters }} {{ __('of') }} {{ $total_characters }} <span class="font-weight-bold text-warning">{{ __('Characters') }}</span> {{ __('Available') }}</span>
							</div>
							<div class="progress mb-4">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning subscription-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progress['subscription'] }}%"></div>
							</div>
							<div class="mb-3">
								<span class="fs-12 text-muted">{{ __('Total ') }} {{ $characters }} {{ __('of') }} {{ $total_characters }} <span class="font-weight-bold text-primary">{{ __('Minutes') }}</span> {{ __('Available') }}</span>
							</div>
							<div class="progress mb-4">
								<div class="progress-bar progress-bar-striped progress-bar-animated zip-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progress['subscription'] }}%"></div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xl-12 col-md-12 col-12">
					<div class="card mb-5 border-0">							
						<div class="card-header d-inline border-0">
							<div>
								<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-sack-dollar mr-4 text-info"></i>{{ __('User Payments') }} <span class="text-muted">({{ __('Current Year') }})</span></h3>
							</div>
							<div>
								<h3 class="card-title fs-24 font-weight-800">{!! config('payment.default_system_currency_symbol') !!}{{ number_format((float)$user_data_year['total_payments'][0]['data'], 2, '.', '') }}</h3>
							</div>
							<div class="mb-3">
								<span class="fs-12 text-muted">{{ __('Total Payments by the User During Current Year ') }}({{ config('payment.default_system_currency') }})</span>
							</div>
						</div>
						<div class="card-body">
							<div class="chartjs-wrapper-demo">
								<canvas id="chart-user-payments" class="h-330"></canvas>
							</div>
						</div>								
					</div>
				</div>	
				
				<div class="col-xl-12 col-md-12 col-12">
					<div class="card mb-5 border-0">							
						<div class="card-header d-inline border-0">
							<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-sharp fa-solid fa-waveform-lines mr-4 text-info"></i>{{ __('Text to Speech Usage') }} <span class="text-muted">({{ __('Current Year') }})</span></h3>
						</div>
						<div class="card-body">
							<div class="row mb-5 mt-2">	
								<div class="col-xl-3 col-12 ">
									<p class=" mb-1 fs-12">{{ __('Total Standard Characters Used') }}</p>
									<h3 class="mb-0 fs-20 number-font">{{ number_format($user_data_year['total_standard_chars'][0]['data']) }}</h3>
								</div>
								<div class="col-xl-3 col-12 ">
									<p class=" mb-1 fs-12">{{ __('Total Neural Characters Used') }}</p>
									<h3 class="mb-0 fs-20 number-font">{{ number_format($user_data_year['total_neural_chars'][0]['data']) }}</h3>
								</div>
								<div class="col-xl-3 col-12 ">
									<p class=" mb-1 fs-12">{{ __('Total Audio Files Created') }}</p>
									<h3 class="mb-0 fs-20 number-font">{{ number_format($user_data_year['total_audio_files'][0]['data']) }}</h3>
								</div>
								<div class="col-xl-3 col-12 ">
									<p class=" mb-1 fs-12">{{ __('Total Listen Mode Results') }}</p>
									<h3 class="mb-0 fs-20 number-font">{{ number_format($user_data_year['total_listen_modes'][0]['data']) }}</h3>
								</div>
							</div>
							<div class="chartjs-wrapper-demo">
								<canvas id="chart-user-chars" class="h-330"></canvas>
							</div>
						</div>								
					</div>
				</div>

				<div class="col-xl-12 col-md-12 col-12">
					<div class="card mb-5 border-0">							
						<div class="card-header d-inline border-0">
							<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-sharp fa-solid fa-microphone-lines mr-4 text-info"></i>{{ __('Speech To Text Usage') }} <span class="text-muted">({{ __('Current Year') }})</span></h3>
						</div>
						<div class="card-body">
							<div class="row mb-5 mt-2">	
								<div class="col-md col-sm-12 ">
									<p class=" mb-1 fs-12">{{ __('Total Minutes Used') }}</p>
									<h3 class="mb-0 fs-20 number-font">{{ number_format((float)$user_data_year['total_minutes'][0]['data'] / 60, 2) }}</h3>
								</div>
								<div class="col-md col-sm-12 ">
									<p class=" mb-1 fs-12">{{ __('Words Generated') }}</p>
									<h3 class="mb-0 fs-20 number-font">{{ number_format($user_data_year['total_words'][0]['data']) }}</h3>
								</div>
								<div class="col-md col-sm-12 ">
									<p class=" mb-1 fs-12">{{ __('Audio Files Transcribed') }}</p>
									<h3 class="mb-0 fs-20 number-font">{{ number_format($user_data_year['total_file_transcribe'][0]['data']) }}</h3>
								</div>
								<div class="col-md col-sm-12 ">
									<p class=" mb-1 fs-12">{{ __('Recordings Transcribed') }}</p>
									<h3 class="mb-0 fs-20 number-font">{{ number_format($user_data_year['total_recording_transcribe'][0]['data']) }}</h3>
								</div>
								<div class="col-md col-sm-12 ">
									<p class=" mb-1 fs-12">{{ __('Live Transcribe Results') }}</p>
									<h3 class="mb-0 fs-20 number-font">{{ number_format($user_data_year['total_live_transcribe'][0]['data']) }}</h3>
								</div>
							</div>
							<div class="chartjs-wrapper-demo">
								<canvas id="chart-user-minutes" class="h-330"></canvas>
							</div>
						</div>								
					</div>
				</div>	
			</div>			
		</div>
	</div>
	<!-- END USER PROFILE PAGE -->
@endsection

@section('js')
	<!-- Chart JS -->
	<script src="{{URL::asset('plugins/chart/chart.min.js')}}"></script>
	<script type="text/javascript">
		$(function() {
	
			'use strict';

			let paymentData = JSON.parse(`<?php echo $chart_data['payments']; ?>`);
			let paymentDataset = Object.values(paymentData);
			let delayed2;

			let ctxPayment = document.getElementById('chart-user-payments');
			new Chart(ctxPayment, {
				type: 'bar',
				data: {
					labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
					datasets: [{
						label: '{{ __('Payments') }} ({{ config('payment.default_system_currency') }}) ',
						data: paymentDataset,
						backgroundColor: '#00c851',
						borderWidth: 1,
						borderRadius: 20,
						barPercentage: 0.5,
						fill: true
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false,
						labels: {
							display: false
						}
					},
					responsive: true,
					animation: {
						onComplete: () => {
							delayed2 = true;
						},
						delay: (context) => {
							let delay = 0;
							if (context.type === 'data' && context.mode === 'default' && !delayed2) {
								delay = context.dataIndex * 50 + context.datasetIndex * 5;
							}
							return delay;
						},
					},
					scales: {
						y: {
							stacked: true,
							ticks: {
								beginAtZero: true,
								font: {
									size: 10
								},
								stepSize: 50,
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						},
						x: {
							stacked: true,
							ticks: {
								font: {
									size: 10
								}
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						},
					},
					plugins: {
						tooltip: {
							cornerRadius: 10,
							xPadding: 10,
							yPadding: 10,
							backgroundColor: '#000000',
							titleColor: '#FF9D00',
							yAlign: 'bottom',
							xAlign: 'center',
						},
						legend: {
							position: 'bottom',
							labels: {
								boxWidth: 10,
								font: {
									size: 10
								}
							}
						}
					}
					
				}
			});


			var standardData = JSON.parse(`<?php echo $chart_data['standard_chars']; ?>`);
			var standardDataset = Object.values(standardData);
			var neuralData = JSON.parse(`<?php echo $chart_data['neural_chars']; ?>`);
			var neuralDataset = Object.values(neuralData);

			var ctxChars = document.getElementById('chart-user-chars');
			new Chart(ctxChars, {
				type: 'bar',
				data: {
					labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
					datasets: [{
						label: '{{ __('Standard Characters Used') }}',
						data: standardDataset,
						backgroundColor: '#1e1e2d',
						borderWidth: 1,
						borderRadius: 20,
						barPercentage: 0.5,
						fill: true
					}, {
						label: '{{ __('Neural Characters Used') }}',
						data: neuralDataset,
						backgroundColor:  '#007bff',
						borderWidth: 1,
						borderRadius: 20,
						barPercentage: 0.5,
						fill: true
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false,
						labels: {
							display: false
						}
					},
					responsive: true,
					animation: {
						onComplete: () => {
							delayed2 = true;
						},
						delay: (context) => {
							let delay = 0;
							if (context.type === 'data' && context.mode === 'default' && !delayed2) {
								delay = context.dataIndex * 50 + context.datasetIndex * 5;
							}
							return delay;
						},
					},
					scales: {
						y: {
							stacked: true,
							ticks: {
								beginAtZero: true,
								font: {
									size: 11
								},
								stepSize: 100000,
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						},
						x: {
							stacked: true,
							ticks: {
								font: {
									size: 11
								}
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						}
					},
					plugins: {
						tooltip: {
							cornerRadius: 10,
							xPadding: 10,
							yPadding: 10,
							backgroundColor: '#000000',
							titleColor: '#FF9D00',
							yAlign: 'bottom',
							xAlign: 'center',
						},
						legend: {
							position: 'bottom',
							labels: {
								boxWidth: 10,
								font: {
									size: 10
								}
							}
						}
					}
				}
			});


			var fileData = JSON.parse(`<?php echo $chart_data['file_minutes']; ?>`);
			var fileDataset = Object.values(fileData);
			var recordData = JSON.parse(`<?php echo $chart_data['record_minutes']; ?>`);
			var recordDataset = Object.values(recordData);
			var liveData = JSON.parse(`<?php echo $chart_data['live_minutes']; ?>`);
			var liveDataset = Object.values(liveData);

			var ctxMinutes = document.getElementById('chart-user-minutes');
			new Chart(ctxMinutes, {
				type: 'bar',
				data: {
					labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
					datasets: [{
						label: '{{ __('Audio Transcribe Minutes') }}',
						data: fileDataset,
						backgroundColor: '#007bff',
						borderWidth: 1,
						borderRadius: 20,
						barPercentage: 0.5,
						fill: true
					}, {
						label: '{{ __('Recording Transcribe Minutes') }}',
						data: recordDataset,
						backgroundColor:  '#1e1e2d',
						borderWidth: 1,
						borderRadius: 20,
						barPercentage: 0.5,
						fill: true
					}, {
						label: '{{ __('Live Transcribe Minutes') }}',
						data: liveDataset,
						backgroundColor:  '#FFAB00',
						borderWidth: 1,
						borderRadius: 20,
						barPercentage: 0.5,
						fill: true
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false,
						labels: {
							display: false
						}
					},
					responsive: true,
					animation: {
						onComplete: () => {
							delayed2 = true;
						},
						delay: (context) => {
							let delay = 0;
							if (context.type === 'data' && context.mode === 'default' && !delayed2) {
								delay = context.dataIndex * 50 + context.datasetIndex * 5;
							}
							return delay;
						},
					},
					scales: {
						y: {
							stacked: true,
							ticks: {
								beginAtZero: true,
								font: {
									size: 11
								},
								stepSize: 50,
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						},
						x: {
							stacked: true,
							ticks: {
								font: {
									size: 11
								} 
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						}
					},
					plugins: {
						tooltip: {
							cornerRadius: 10,
							xPadding: 10,
							yPadding: 10,
							backgroundColor: '#000000',
							titleColor: '#FF9D00',
							yAlign: 'bottom',
							xAlign: 'center',
						},
						legend: {
							position: 'bottom',
							labels: {
								boxWidth: 10,
								font: {
									size: 10
								}
							}
						}
					}
				}
			});
		});
	</script>
@endsection
