@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div>
				@foreach($shopAffiliateProudcts as $shopAffiliateProudct)
				<div class="csproduct">
					<div class="col-md-3 cs-products">
						<div class="clsProductImg">
							<img src="{{ $shopAffiliateProudct->product_image_url }}" alt="{{ $shopAffiliateProudct->product_title }}">
						</div>
						<div class="csProductTitle">
							{{ $shopAffiliateProudct->product_title }}
						</div>
						<div class="col-xs-8 clsProductUrl">
							<a href="{{ $shopAffiliateProudct->product_url }}" class="btn btn-warning">Shop Now</a>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection