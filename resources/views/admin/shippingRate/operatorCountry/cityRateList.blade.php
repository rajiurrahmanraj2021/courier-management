@extends('admin.layouts.master')
@section('page_title')
	@lang(optional(basicControl()->operatorCountry)->name. ' Shipping Rate List')
@endsection

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1> @lang(optional(basicControl()->operatorCountry)->name. ' Shipping Rate List') </h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="{{ route('admin.home') }}">@lang("Dashboard")</a></div>
					<div class="breadcrumb-item">@lang("Shipping Rates")</div>
					<div class="breadcrumb-item">@lang(optional(basicControl()->operatorCountry)->name)</div>
				</div>
			</div>
		</section>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card mb-4 card-primary shadow-sm">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h4>@lang('All Shipping Rate')</h4>
							@if(adminAccessRoute(config('permissionList.Shipping_Rates.Operator_Country_Rate.permission.add')))
								<a href="{{route('createShippingRateOperatorCountry')}}"
								   class="btn btn-sm btn-outline-primary add"><i
										class="fas fa-plus-circle"></i> @lang('Add Shipping Rate')</a>
							@endif
						</div>

						<div class="card-body">
							<div class="switcher">
								<a href="{{ route('operatorCountryRate', 'state') }}">
									<button
										class="@if(lastUriSegment() == 'state') active @endif">@lang('State List')</button>
								</a>
								<a href="{{ route('operatorCountryRate', 'city') }}">
									<button
										class="@if(lastUriSegment() == 'city') active @endif">@lang('City List')</button>
								</a>
								<a href="{{ route('operatorCountryRate', 'area') }}">
									<button
										class="@if(lastUriSegment() == 'area') active @endif"> @lang('Area List')</button>
								</a>
							</div>

							{{-- Table --}}
							<div class="row justify-content-md-center mt-4">
								<div class="col-lg-12">
									<div class="card mb-4 card-primary shadow">
										<div
											class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
											<h6 class="m-0 font-weight-bold text-primary">@lang($title)</h6>
										</div>

										<div class="card-body">
											<div class="table-responsive">
												<table
													class="table table-striped table-hover align-items-center table-flush"
													id="data-table">
													<thead class="thead-light">
													<tr>
														<th scope="col">@lang('Parcel Type')</th>
														<th scope="col">@lang('Shipping City')</th>
														<th scope="col">@lang('Action')</th>
													</tr>
													</thead>

													<tbody>
													@forelse($shippingRateList as $key => $cityList)

														<tr>
															<td data-label="Parcel Type"> @lang(optional($cityList->parcelType)->parcel_type) </td>
															<td data-label="@lang('Shipping City')">
																<a href="{{ route('operatorCountryShowRate', ['city-list', $cityList->parcel_type_id]) }}"
																   class="text-decoration-underline">({{ $cityList->getTotalCity($cityList->parcel_type_id) }})</a>
															</td>
															<td data-label="@lang('Action')">
																<a href="{{ route('operatorCountryShowRate', ['city-list', $cityList->parcel_type_id]) }}"
																   class="btn btn-outline-primary btn-sm"
																   title="@lang('Show')"><i class="fa fa-eye"
																							aria-hidden="true"></i> @lang('Show')
																</a>
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
											<div
												class="card-footer d-flex justify-content-center">{{ $shippingRateList->links() }}</div>
										</div>
									</div>
								</div>
							</div>
							{{-- Table --}}
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
