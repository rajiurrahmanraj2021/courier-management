@extends($theme.'layouts.user')
@section('page_title',__('Shipment List'))

@push('extra_styles')
	<link href="{{ asset('assets/dashboard/css/flatpickr.min.css') }}" rel="stylesheet">
@endpush

@section('content')
	<div class="container-fluid">
		<div class="main row">
			<div class="col-12">
				<div class="dashboard-heading">
					<div class="">
						<h2 class="mb-0">@lang('Shipment List')</h2>
						<nav aria-label="breadcrumb" class="ms-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a
										href="{{ route('user.dashboard') }}">@lang('Dashboard')</a></li>
								<li class="breadcrumb-item"><a href="#">@lang('Shipment List')</a></li>
							</ol>
						</nav>
					</div>
				</div>

				<div class="search-bar profile-setting">
					<form action="{{ route('user.transaction.search') }}" method="get">
						@include($theme.'user.shipments.searchForm')
					</form>
				</div>


				<div class="card" id="switcherContent">
					<div class="card-body">
						<div class="main_switcher d-flex justify-content-between">
							<div class="switcher">
								<a href="{{ route('user.shipmentList', ['shipment_status' => $status, 'shipment_type' => 'operator-country']) }}">
									<button class="@if(lastUriSegment() == 'operator-country') active @endif">@lang(optional(basicControl()->operatorCountry)->name)</button>
								</a>
								<a href="{{ route('user.shipmentList', ['shipment_status' => $status, 'shipment_type' => 'internationally']) }}">
									<button class="@if(lastUriSegment() == 'internationally') active @endif">@lang('Internationally')</button>
								</a>
							</div>

							<div class="mt-3">
								<a href="{{ route('user.ticket.create') }}" class="view_cmn_btn2">
									<i class="fal fa-plus-circle"></i> @lang('Create Shipment')
								</a>
							</div>
						</div>

						<div class="table-parent table-responsive">
							<table class="table table-striped">
								<thead>
								<tr>
									<th scope="col"
										class="custom-text">@lang('SL.')</th>
									<th scope="col"
										class="custom-text">@lang('Shipment Id')</th>
									<th scope="col"
										class="custom-text">@lang('Shipment Type')</th>
									<th scope="col"
										class="custom-text">@lang('Sender Branch')</th>
									<th scope="col"
										class="custom-text">@lang('Receiver Branch')</th>
									<th scope="col"
										class="custom-text">@lang('From State')</th>
									<th scope="col"
										class="custom-text">@lang('To State')</th>
									<th scope="col"
										class="custom-text">@lang('Total Cost')</th>
									<th scope="col"
										class="custom-text">@lang('Shipment Date')</th>
									<th scope="col"
										class="custom-text">@lang('Status')</th>
									<th scope="col"
										class="custom-text">@lang('Action')</th>
								</tr>
								</thead>
								<tbody>
								@forelse($allShipments as $key => $shipment)
									<tr>
										<td data-label="SL."> {{ ++$key }} </td>
										<td data-label="Shipment Id"> {{ $shipment->shipment_id }} </td>
										<td data-label="Shipment Type"> {{ $shipment->shipment_type }} </td>
										<td data-label="Sender Branch"> @lang(optional($shipment->senderBranch)->branch_name) </td>
										<td data-label="Receiver Branch"> @lang(optional($shipment->receiverBranch)->branch_name) </td>
										<td data-label="From State"> @lang(optional($shipment->fromState)->name) </td>
										<td data-label="To State"> @lang(optional($shipment->toState)->name) </td>
										<td data-label="Total Cost"> {{ $basic->currency_symbol }}{{ $shipment->total_pay }} </td>

										<td data-label="Shipment Date"> {{ customDate($shipment->shipment_date) }} </td>

										<td data-label="Status">
											@if($shipment->status == 1)
												<span
													class="badge text-bg-info">@lang('In Queue')</span>
											@elseif($shipment->status == 2)
												<span
													class="badge text-bg-warning">@lang('Dispatch')</span>
											@elseif($shipment->status == 3)
												<span
													class="badge text-bg-primary">@lang('Upcoming')</span>
											@elseif($shipment->status == 4)
												<span
													class="badge text-bg-success">@lang('Received')</span>
											@elseif($shipment->status == 5)
												<span
													class="badge text-bg-danger">@lang('Delivered')</span>
											@endif
										</td>

										<td data-label="@lang('Action')">
											<a class="dropdown-item btn-outline-primary btn-sm"
											   href="{{ route('viewShipment', ['id' => $shipment->id, 'segment' => $status, 'shipment_type' => 'operator-country']) }}"><i
													class="fa fa-eye mr-2"
													aria-hidden="true"></i> @lang('Details')
											</a>
											<div class="btn-group">
												<button type="button"
														class="btn btn-primary btn-sm dropdown-toggle"
														data-toggle="dropdown"
														aria-haspopup="true"
														aria-expanded="false">
													@lang('Options')
												</button>
												<div class="dropdown-menu">

													<a class="dropdown-item btn-outline-primary btn-sm"
													   href="{{ route('viewShipment', ['id' => $shipment->id, 'segment' => $status, 'shipment_type' => 'operator-country']) }}"><i
															class="fa fa-eye mr-2"
															aria-hidden="true"></i> @lang('Details')
													</a>

													@if(adminAccessRoute(config('permissionList.Manage_Shipments.Shipment_List.permission.edit')))
														<a class="dropdown-item btn-outline-primary btn-sm"
														   href="{{ route('editShipment', ['id' => $shipment->id, 'shipment_identifier' => $shipment->shipment_identifier, 'segment' => $status, 'shipment_type' => 'operator-country']) }}"><i
																class="fa fa-edit mr-2"
																aria-hidden="true"></i> @lang('Edit')
														</a>
													@endif

													<a data-target="#deleteShipment"
													   data-toggle="modal"
													   data-route="{{route('deleteShipment', $shipment->id)}}"
													   href="javascript:void(0)"
													   class="dropdown-item btn-outline-primary btn-sm deleteShipment"><i
															class="fas fa-trash mr-2"></i> @lang('Delete')
													</a>

												</div>
											</div>
										</td>
									</tr>
								@empty
									<tr>
										<th colspan="100%"
											class="text-center">@lang('No data found')</th>
									</tr>
								@endforelse
								</tbody>
							</table>
						</div>
						<nav aria-label="Page navigation example">
							<ul class="pagination justify-content-center">
								{{ $allShipments->appends($_GET)->links() }}
							</ul>
						</nav>
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection

@push('extra_scripts')
	<script src="{{ asset('assets/dashboard/js/flatpickr.js') }}"></script>
@endpush

@section('scripts')
	<script>
		'use strict'
		$('.from_date').on('change', function () {
			$('.to_date').removeAttr('disabled');
		});

		$(document).ready(function () {
			$(".flatpickr").flatpickr({
				wrap: true,
				altInput: true,
				dateFormat: "Y-m-d H:i",
			});

			$(".flatpickr").flatpickr({
				wrap: true,
				altInput: true,
				dateFormat: "Y-m-d H:i",
			});
		})

	</script>
@endsection
