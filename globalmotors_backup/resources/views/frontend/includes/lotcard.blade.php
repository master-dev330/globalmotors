<div class="card card-item card-item-vertical lotlist" data-time="{{strtotime($value->start_date)}}">
	<div class="card-img-top">
		<div class="card-img-wrap">
			<main class="lightgallery">
				 <a class="lot-img" href="{{url(isset($value->lotname->feature_image)?$value->lotname->feature_image:'')}}">
			<img src="{{url(isset($value->lotname->feature_image)?$value->lotname->feature_image:'') }}">
		</a>
			<div class="all-card-photos"><a href="{{url(app()->getLocale().'/lotdetail/'.$value->lot_id)}}">@lang('betting.photo')</a></div>
			 @foreach(isset($value->lotname->gallery ) ? $value->lotname->gallery:[] as $lotimages)
                        <a  class="lot-img d-none" href="{{url($lotimages->images)}}">
                          <img src="{{url($lotimages->images)}}" class="product-image" alt="">
                        </a> 
             @endforeach
			</main>
		</div>
	</div>
	<div class="card-content">
		<div class="text-right"><span class="book_mark fas fa-bookmark {{check_bookmark(Auth::user()->id,$value->lot_id)==1?"active":''}} add_bookmark" data-lot="{{$value->lot_id}}" data-id="{{isset(Auth::user()->id)?Auth::user()->id:''}}" data-bookmark="{{check_bookmark(Auth::user()->id,$value->lot_id)==1?1:0}} "></span></div>
		<div class="card-block">
			<h4 class="card-title"><img src="{{url(isset($value->lotname->brand_logo)?$value->lotname->brand_logo:'')}}" alt=""><a href="{{url(app()->getLocale().'/lotdetail/'.$value->lot_id)}}">{{isset($value->lotname->lot_title) ? $value->lotname->lot_title:'' }}</a></h4>
			<div class="char-card">
				<p><span>@lang('betting.lot')</span>{{isset($value->lotname->lot_no) ? $value->lotname->lot_no:''}} - <strong>@lang('betting.start_up')</strong></p>
				<p><span>@lang('betting.vin')</span>{{isset($value->lotname->vin) ? $value->lotname->vin :''}}</p>
			</div>
		</div>
		<div class="card-footer-vertical">
			<div class="card-footer-info">
				<span>@lang('betting.auction_date')</span>
				<p>{{get_date_month($value->auction->start_date)}}</p>
			</div>
			<div class="card-footer-info">
				<span>@lang('betting.damage')</span>
				<p>{{isset($value->lotname->primary_damage) ? $value->lotname->primary_damage:''}},{{isset($value->lotname->secondary_damage)?$value->lotname->secondary_damage:''}} </p>
			</div>
			<div class="card-footer-info">
				<span>@lang('betting.mileage')</span>
				<p>{{isset($value->lotname->mileage) ? $value->lotname->mileage:''}} @lang('betting.miles')</p>
			</div>
		</div>
	</div>
	<div class="card-info-rate">
		@if($value->status=="Approved") <!--Purchased -->
		<div class="card-info-rate-title">
			@lang('betting.auction_won')
		</div>
		@elseif($value->status=="Rejected")  <!-- Rejected -->
		<div class="card-info-rate-title">
			<h2>@lang('betting.bid_rejected')</h2>
		</div>
		@elseif($value->status=="Canceled") <!-- Canceled -->
		<div class="card-info-rate-title">
			<h2>@lang('betting.lot_cancel')</h2>
		</div>
		@elseif($value->status=="Pending") <!-- Canceled -->
		<div class="card-info-rate-title">
			<h2>Bid Pending</h2>
		</div>
		@else
		<div class="card-info-rate-timer countdown">
		</div>
		@endif
		<div class="card-info-rate-price">
			<p>${{check_starting_price($value,$value->lot_id)}} USD</p>
			<span> @lang('betting.current_rate')</span>
		</div>
		<div class="card-btn">
			<a href="{{url(app()->getLocale().'/lotsearch')}}?brand={{isset($value->lotname->make_id)?$value->lotname->make_id:''}}" class="btn btn-dark-blue">@lang('betting.search_similar')</a>
		</div>
		@if($value->status=="Pending") <!--Purchased -->
		<div class="card-btn">
			<a href="javascript:void(0)" data-id="{{$value->id}}" data-amount="{{$value->bid_amount}}" data-toggle="modal" data-target="#Return-deposit" class="btn btn-dark-blue bg-success mt-2 change-bid">@lang('betting.ChangeBid')</a>
		</div>
		<div class="card-btn">
			<a href="javascript:void(0)" data-id="{{$value->id}}" value="Cancel" class="btn btn-dark-blue bg-secondary mt-2 mb-2 btn-cancel">@lang('betting.CancelBid')</a>
		</div>
		@endif
	</div>
</div>