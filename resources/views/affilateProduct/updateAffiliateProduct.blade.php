@extends('app')

@section('content')
	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/affiliateProduct/update') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group">
				<label class="col-md-2 control-label font-weight-bold">Title</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="title" value="{{ $getaffiliateProduct->title }}">
					</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label font-weight-bold">Description</label>
					<div class="col-md-6">
						<textarea name="description">
							@if(!empty($getaffiliateProduct->description))
								{{ $getaffiliateProduct->description }}
							@endif
						</textarea>
					</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label font-weight-bold">MRP</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="mrp" value="{{ $getaffiliateProduct->mrp }}">
					</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label font-weight-bold">Price</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="price" value="{{ $getaffiliateProduct->price }}">
					</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label font-weight-bold">Product URL</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="productUrl" value="{{ $getaffiliateProduct->product_url }}">
					</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label font-weight-bold">Delivery Time</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="deliveryTime" value="{{ $getaffiliateProduct->delviery_time }}">
					</div>
			</div>
			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<div class="checkbox">
						<label class="font-weight-bold">
							<input type="checkbox" name="remember" @if($getaffiliateProduct->is_published) Checked @endif> Published
						</label>
					</div>
				</div>
			</div>

						<div class="form-group">
							<div class="col-md-8 col-md-offset-6">
								<button type="submit" class="btn btn-primary font-weight-bold">Login</button>

								<a class="btn btn-link font-weight-bold" href="{{ url('/password/email') }}">Forgot Your Password?</a>
							</div>
						</div>
					</form>
 @endsection