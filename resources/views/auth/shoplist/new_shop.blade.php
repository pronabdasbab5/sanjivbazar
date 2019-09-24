@extends('layouts.dapp')

@section('content')
<div class="right_col" role="main">
	<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Add New Shop</h2>
						<a href="{{ route('shoplist') }}" style="float: right; font-weight: bolder; font-size: 18px;">All Shops</a>
						<div class="clearfix"></div>
					</div>
					<div class="x_content"><br />
						<center>
								@if(session()->has('msg'))
									<b>{{ session()->get('msg') }}</b>
								@endif
						</center>
						<!-- Section For New User registration -->
						<form method="POST" autocomplete="off" action="{{ url('newshop') }}" class="form-horizontal form-label-left">
								@csrf

							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Location : <span class="required">*</span></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" name="location" id="location" class="form-control col-md-7 col-xs-12" placeholder="Enter Location" autofocus>
										@error('location')
											{{ $message }}
										@enderror
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Date : <span class="required">*</span></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" value="{{ date('d-m-Y') }}" class="form-control col-md-7 col-xs-12" disabled readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Latitude : <span class="required">*</span></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" name="latitude" id="latitude"  class="form-control col-md-7 col-xs-12" placeholder="Enter Latitude">
										@error('latitude')
											{{ $message }}
										@enderror
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Longitude : <span class="required">*</span></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" name="longitude" id="longitude"  class="form-control col-md-7 col-xs-12" placeholder="Enter Longitude">
										@error('longitude')
											{{ $message }}
										@enderror
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Shop Name : <span class="required">*</span></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" name="shop_name" id="shop_name"  class="form-control col-md-7 col-xs-12" placeholder="Enter Shop Name">
										@error('shop_name')
											{{ $message }}
										@enderror
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Owner Name : <span class="required">*</span></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" name="owner_name" id="owner_name"  class="form-control col-md-7 col-xs-12" placeholder="Enter Owner Name">
										@error('owner_name')
											{{ $message }}
										@enderror
								</div>
							</div>


							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Contact : <span class="required">*</span></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" name="contact" id="contact"  class="form-control col-md-7 col-xs-12" placeholder="Enter Contact">
										@error('contact')
											{{ $message }}
										@enderror
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Status : <span class="required">*</span></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="radio" name="status" value="active" checked> <b>Active</b>
									<input type="radio" name="status" value="deactive"> <b>De-Active</b>
										@error('status')
											{{ $message }}
										@enderror
								</div>
							</div>

							<div class="form-group">
				                <label class="control-label col-md-2 col-sm-2 col-xs-12">Address : <span class="required">*</span></label>
				                <div class="col-md-10 col-sm-10 col-xs-12">

				                  <textarea name="address" id="address" class="form-control col-md-7 col-xs-12"></textarea>
				                    @error('address')
				                        {{ $message }}
				                    @enderror
				                </div>
				            </div>

							<div class="ln_solid"></div>
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
										<button type="submit" name="submit" class="btn btn-success">Create</button>
									</div>
								</div>
						</form>
						<!-- End New User registration -->
						</div>
					</div>
				</div>
			</div>
</div>
@endsection

