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
							<img src="../storage/app/images/noImage.png" alt="{{ $shopAffiliateProudct->title }}">
						</div>
						<div class="csProductTitle">
							{{ $shopAffiliateProudct->title }}
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