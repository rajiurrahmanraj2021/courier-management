@extends($theme.'layouts.user')
@section('page_title',__('View Shipment'))

@section('content')
	<div class="container-fluid main-content">
		<div class="main row">
			<div class="col-12">
				<div class="dashboard-heading">
					<div class="">
						<h2 class="mb-0">@lang('Shipment Details')</h2>
						<nav aria-label="breadcrumb" class="ms-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a
										href="{{ route('user.dashboard') }}">@lang('Dashboard')</a></li>
								<li class="breadcrumb-item"><a href="#">@lang('Shipment Details')</a></li>
							</ol>
						</nav>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body shadow">
								<div class="d-flex justify-content-between align-items-center">
									<h6 class="card-title">@lang("Shipment Details")</h6>

									<div>
										<a href="{{route('user.shipmentList', ['shipment_status' => $status, 'shipment_type' => $shipment_type])}}"
										   class="btn btn-sm  view_cmn_btn mr-2">
											<span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
										</a>
										<button class="btn btn-success btn-sm view_cmn_btn3" id="shipmentDetailsPrint"><i
												class="far fa-check-circle "></i> @lang('Print')
										</button>
									</div>
								</div>
								<hr>
								<div class="p-4 card-body shadow" id="shipmentDetails">
									<div class="row">
										<div class="col-md-6 border-end">
											<ul class="list-style-none shipment-view-ul">
												<li class="my-2 border-bottom pb-3">
												<span class="fw-bold text-dark custom-text"> <i
														class="fas fa-fingerprint mr-2 text-orange"></i> @lang("Shipment Id"): <small
														class="float-end custom-text"> #{{ $singleShipment->shipment_id }} </small></span>

												</li>

												<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="fas fa-shipping-fast mr-2 text-primary"></i> @lang("Shipment Type") : <span
													class="fw-normal">@lang($singleShipment->shipmentTypeFormat())</span></span>
												</li>

												<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="far fa-calendar-alt mr-2 text-success"></i> @lang("Shipment Date") : <span
													class="fw-normal">{{ customDate($singleShipment->shipment_date) }}</span></span>
												</li>

												<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="far fa-calendar-alt mr-2 text-purple"></i> @lang("Estimate Delivery Date") : <span
													class="fw-normal">{{ customDate($singleShipment->delivery_date) }}</span></span>
												</li>

												<li class="my-3 d-flex align-items-center">
												<span class="fw-bold text-dark"><i
														class="fas fa-user-plus mr-2 text-primary"></i> @lang('Sender : ')</span>
													<span class="fw-normal">@lang(optional($singleShipment->sender)->name)</span></span>
												</li>

												<li class="my-3 d-flex align-items-center">
												<span class="fw-bold text-dark"> <i
														class="fas fa-user-minus mr-2 text-orange "></i> @lang('Receiver :')</span>
													<span class="fw-normal">@lang(optional($singleShipment->receiver)->name)</span>

												</li>

												@if($singleShipment->shipment_type == 'condition')
													<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="fas fa-check-circle mr-2 text-primary"></i> @lang("Receive Amount") : <span
													class="font-weight-medium">{{ $basic->currency_symbol }}{{ $singleShipment->receive_amount }}</span></span>
													</li>
												@endif

												<li class="my-3 d-flex align-items-center">
												<span class="fw-bold text-dark"> <i
														class="fas fa-tree mr-2 text-purple"></i> @lang('Sender Branch') : </span>
													<span class="fw-normal">@lang(optional($singleShipment->senderBranch)->branch_name)</span>
												</li>

												<li class="my-3 d-flex align-items-center">
												<span class="fw-bold text-dark"> <i
														class="fas fa-tree mr-2 text-info"></i> @lang('Receiver Branch') : </span>
													<span class="fw-normal">@lang(optional($singleShipment->receiverBranch)->branch_name)</span>
												</li>


												@if($singleShipment->from_country_id != null)
													<li class="my-3">
                                            <span class="fw-bold text-dark"> <i
													class="fas fa-map-marker-alt mr-2 text-primary"></i> @lang("From Country") : <span
													class="fw-normal">@lang(optional($singleShipment->fromCountry)->name)</span></span>
													</li>
												@endif

												@if($singleShipment->from_state_id != null)
													<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="fas fa-map-marker-alt mr-2 text-primary"></i> @lang("From State") : <span
													class="fw-normal">@lang(optional($singleShipment->fromState)->name)</span></span>
													</li>
												@endif

												@if($singleShipment->from_city_id != null)
													<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="fas fa-map-marker-alt mr-2 text-danger"></i> @lang("From City") : <span
													class="fw-normal">@lang(optional($singleShipment->fromCity)->name)</span></span>
													</li>
												@endif

												@if($singleShipment->from_area_id != null)
													<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="fas fa-map-marker-alt mr-2 text-success"></i> @lang("From Area") : <span
													class="fw-normal">@lang(optional($singleShipment->fromArea)->name)</span></span>
													</li>
												@endif

												@if($singleShipment->to_country_id != null)
													<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="fas fa-map-marker-alt mr-2 text-cyan"></i> @lang("To Country") : <span
													class="fw-normal">@lang(optional($singleShipment->toCountry)->name)</span></span>
													</li>
												@endif

												@if($singleShipment->to_state_id != null)
													<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="fas fa-map-marker-alt mr-2 text-success "></i> @lang("To State") : <span
													class="fw-normal">@lang(optional($singleShipment->toState)->name)</span></span>
													</li>
												@endif

												@if($singleShipment->to_city_id != null)
													<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="fas fa-map-marker mr-2 text-purple"></i> @lang("To City") : <span
													class="fw-normal">@lang(optional($singleShipment->toCity)->name)</span></span>
													</li>
												@endif

												@if($singleShipment->to_area_id != null)
													<li class="my-3">
                                            <span class="fw-bold text-dark"> <i
													class="fas fa-location-arrow mr-2 text-primary"></i> @lang("To Area") : <span
													class="fw-normal">@lang(optional($singleShipment->toArea)->name)</span></span>
													</li>
												@endif

												<li class="my-3">
                                            <span class="fw-bold text-dark">  <i
													class="fas fa-search-dollar  mr-2 text-orange"></i> @lang("Payment Type") : <span
													class="fw-normal">@lang($singleShipment->payment_type)</span></span>
												</li>

												<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="fas fa-money-check-alt  mr-2 text-primary"></i> @lang('Payment Status') :
                                                @if($singleShipment->payment_status == 1)
													<p class="badge text-bg-success">@lang('Paid')</p>
												@else
													<p class="badge text-bg-warning">@lang('Unpaid')</p>
												@endif
                                            </span>
												</li>

												<li class="my-3">
                                            <span class="fw-bold text-dark"><i
													class="fas fa-shipping-fast mr-2 text-warning"></i> @lang('Shipment Status') :
												@if($singleShipment->status == 1)
													<p class="badge text-bg-info">@lang('In Queue')</p>
												@elseif($singleShipment->status == 2)
													<p class="badge text-bg-warning">@lang('Dispatch')</p>
												@elseif($singleShipment->status == 3)
													<p class="badge text-bg-primary">@lang('Upcoming')</p>
												@elseif($singleShipment->status == 4)
													<p class="badge text-bg-success">@lang('Received')</p>
												@elseif($singleShipment->status == 5)
													<p class="badge text-bg-danger">@lang('Delivered')</p>
												@endif
                                            </span>
												</li>
											</ul>
										</div>


										<div class="col-md-6 ">
											<ul class="list-style-none shipment-view-ul">
												<li class="my-2 border-bottom pb-3">
												<span class="fw-bold text-dark"> <i
														class="fas fa-cart-plus mr-2 text-primary"></i> @lang('Parcel Information')</span>
												</li>

												@if($singleShipment->packing_services != null)
													<li class="my-3">
                                            <span class="custom-text"><i
													class="fas fa-check-circle mr-2 text-success"></i>  @lang('Packing Service')

                                            </span>
													</li>

													<table class="table table-bordered">
														<thead>
														<tr>
															<th scope="col">@lang('Package')</th>
															<th scope="col">@lang('Variant')</th>
															<th scope="col">@lang('Price')</th>
															<th scope="col">@lang('Quantity')</th>
															<th scope="col">@lang('Cost')</th>
														</tr>
														</thead>
														<tbody>
														@php
															$totalPackingCost = 0;
														@endphp
														@foreach($singleShipment->packing_services as $packing_service)

															<tr>
																<td data-label="Package">{{ $singleShipment->packageName($packing_service['package_id'])  }}</td>
																<td data-label="Variant">{{ $singleShipment->variantName($packing_service['variant_id']) }}</td>
																<td data-label="Price">{{ $basic->currency_symbol }}{{ $packing_service['variant_price'] }}</td>
																<td data-label="Quantity">{{ $packing_service['variant_quantity'] }}</td>
																<td data-label="Cost">{{ $basic->currency_symbol }}{{ $packing_service['package_cost'] }}</td>
																@php
																	$totalPackingCost += $packing_service['package_cost'];
																@endphp
															</tr>
														@endforeach

														<tr>
															<th colspan="4" class="text-right">@lang('Total Price')</th>
															<td>{{ $basic->currency_symbol }}{{ number_format($totalPackingCost, 2) }}</td>
														</tr>
														</tbody>
													</table>
												@endif

												@if($singleShipment->parcel_information != null)
													<li class="my-3">
													<span class="custom-text"><i
															class="fas fa-check-circle mr-2 text-success"></i>  @lang('Parcel Details')</span>
													</li>

													<table class="table table-bordered">
														<thead>
														<tr>
															<th scope="col">@lang('Parcel Name')</th>
															<th scope="col">@lang('Quantity')</th>
															<th scope="col">@lang('Parcel Type')</th>
															<th scope="col">@lang('Total Unit')</th>
															<th scope="col">@lang('Cost')</th>
														</tr>
														</thead>
														<tbody>
														@php
															$totalParcelCost = 0;
														@endphp
														@foreach($singleShipment->parcel_information as $parcel_information)
															<tr>
																<td data-label="Parcel Name">{{ $parcel_information['parcel_name'] }}</td>
																<td data-label="Quantity">{{ $parcel_information['parcel_quantity'] }}</td>
																<td data-label="Parcel Type">{{ $singleShipment->parcelType($parcel_information['parcel_type_id'])  }}</td>
																<td data-label="Total Unit">{{ $parcel_information['total_unit'] }} {{ $singleShipment->parcelUnit($parcel_information['parcel_unit_id']) }}
																</td>
																<td data-label="Cost">{{ $basic->currency_symbol }}{{ $parcel_information['parcel_total_cost'] }}</td>
																@php
																	$totalParcelCost += $parcel_information['parcel_total_cost'];
																@endphp
															</tr>
														@endforeach

														<tr>
															<th colspan="4" class="text-right">@lang('Total Price')</th>
															<td>{{ $basic->currency_symbol }}{{ number_format($totalParcelCost, 2) }}</td>
														</tr>
														</tbody>
													</table>
												@else
													<li class="my-3">
													<span class="custom-text"><i
															class="fas fa-check-circle mr-2 text-success"></i>  @lang('Parcel Details')</span>
													</li>
													<table class="table table-bordered mb-5">
														<tbody>
														<tr>
															<td>@lang($singleShipment->parcel_details)</td>
														</tr>
														</tbody>
													</table>
												@endif


												@if(sizeof($singleShipment->shipmentAttachments) != 0)
													<li class="my-3">
													<span class="custom-text"><i
															class="fas fa-check-circle mr-2 text-success"></i>  @lang('shipment Attachments')</span>
													</li>

													<div class="row">

														<div class="col-sm-12">
															<div class="card">
																<div class="card-body">
																	<div class="row shipmentAttachments">
																		@foreach($singleShipment->shipmentAttachments as $attachment)
																			<div class="col-md-4">
																				<div class="imgWrap mb-3">
																					<img class="card-img-top"
																						 src="{{ getFile($attachment->driver, $attachment->image) }}"
																						 alt="Card image cap">
																				</div>
																			</div>
																		@endforeach
																	</div>
																</div>
															</div>
														</div>
													</div>
												@endif


												<li class="mt-4 border-bottom pb-3">
												<span class="fw-bold text-dark"> <i
														class="fas fa-credit-card mr-2 text-primary"></i> @lang('Payment Calculation')</span>
												</li>

												<li class="my-3 ">
                                            <span class="custom-text"><i
													class="fas fa-dollar-sign mr-2 text-warning"></i>  @lang('Discount') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->discount_amount)</span>

                                            </span>
												</li>

												<li class="my-3">
                                            <span class="custom-text"> <i
													class="fas fa-dollar-sign mr-2 text-primary"></i> @lang('Sub Total') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->sub_total)</span>

                                            </span>
												</li>
												@if($singleShipment->shipment_type == 'pickup')
													<li class="my-3">
                                            <span class="custom-text"><i
													class="fas fa-dollar-sign mr-2 text-success"></i>  @lang('Pickup Cost') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->pickup_cost)</span>

                                            </span>
													</li>

													<li class="my-3">
                                            <span class="custom-text"><i
													class="fas fa-dollar-sign mr-2 text-danger"></i>  @lang('Supply Cost') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->supply_cost)</span>

                                            </span>
													</li>
												@endif

												<li class="my-3">
                                            <span class="custom-text"><i
													class="fas fa-dollar-sign mr-2 text-purple"></i>  @lang('Shipping Cost') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->shipping_cost)</span>

                                            </span>
												</li>

												<li class="my-3">
                                            <span class="custom-text"><i
													class="fas fa-dollar-sign mr-2 text-orange"></i>  @lang('Tax') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->tax)</span>

                                            </span>
												</li>

												<li class="my-3">
                                            <span class="custom-text"><i class="fas fa-dollar-sign mr-2 text-info"></i>  @lang('Insurance') :
												<span
													class="font-weight-medium">{{ $basic->currency_symbol }}@lang($singleShipment->insurance)</span>

                                            </span>
												</li>

												<li class="my-3">
                                            <span class="custom-text"><i
													class="fas fa-dollar-sign mr-2 text-primary"></i>  @lang('Payable Amount') :
												<span
													class="custom-text text-warning">{{ $basic->currency_symbol }}@lang($singleShipment->total_pay)</span>
                                            </span>
												</li>
											</ul>
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

@section('scripts')
	<script>
		'use strict'
		$(document).on('click', '#shipmentDetailsPrint', function () {
			let allContents = document.getElementById('body').innerHTML;
			let printContents = document.getElementById('shipmentDetails').innerHTML;
			document.getElementById('body').innerHTML = printContents;
			window.print();
			document.getElementById('body').innerHTML = allContents;
		})

		$(document).on('click', '.confirmButton,f.returnButton', function () {
			let submitUrl = $(this).data('route');
			$('#confirmForm').attr('action', submitUrl)
		})
	</script>
@endsection
