  <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">@lang('lotdetail.make_bed')</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true"  class="fal fa-times"></span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <p class="mb-5">@lang('lotdetail.your_bidding')<a href="" class="link-decor-blue">{{$data['lot']->lot_no}}</a> (IAAI, 2018 Jeep Cherokee Latitude).
             @lang('lotdetail.multiple_bid'){{ $data['starting_price']}}  USD @lang('lotdetail.multiple_bids') USD..</p>
			<form action="#" id="bidform">
        {{ csrf_field() }}
				<label for="" class="starting_price">@lang('lotdetail.current_rates'): $ {{$data['starting_price']}} USD</label>
				<div class="group-input calc-input">
					<button class=" btn btn-info" title="Down" onclick="decrement()"><i class="fal fa-minus"></i></button>
					  <input class="counterinput" id=demoInput type="text" placeholder="Place bid" value="{{ $data['starting_price']}}" name="bid_amount" /> 
					  <button class=" btn btn-info" title="Up" onclick="increment()"><i class="fal fa-plus"></i></button>
				</div>
				@if (!Auth::check())
				<a href="{{url(app()->getLocale().'/userregister')}}" class="btn btn-big btn-blue ">@lang('lotdetail.registration')</a>
				@else
				<input  type="hidden" placeholder="value..." name="min_price" value="{{ $data['starting_price']}}" />
				<input  type="hidden" placeholder="value..." name="lot_id" value="{{$data['lot']->id}}" />
				<input  type="hidden" placeholder="value..." name="user_id" value="{{Auth::user()->id}}" />
				<input  type="hidden" placeholder="value..." name="auction_id" value="{{$data['auction']->id}}" />
				<input  type="hidden" placeholder="value..." name="deposit_amount" value="{{bid_amount_limit(Auth::user()->id)}}" />
				     	
       	@if(!empty(Auth::user()->address) &&  Auth::user()->document_status=="Approved" && !empty($data['deposit']->amount)  && $data['deposit']->amount>=600 && !empty(Auth::user()->document))
				     <button  class="btn btn-dark-blue btn-big mb-4 mt-4 bidplace">@lang('lotdetail.place_bid') 
				     </button>
				    
       		 	@elseif(empty(Auth::user()->document))
                  <a href="{{url(app()->getLocale().'/document/'.Auth::user()->id)}}">
                  		 <div class="alert alert-danger mt-3" role="alert">
                    	<span aria-hidden="true"  class="fa fa-exclamation-triangle "></span>
                     @lang('lotdetail.upload_doc') 
                   </div>
                </a>
                 @elseif(isset($data['deposit']->amount) && $data['deposit']->amount <600)
                  <a href="{{ url(app()->getLocale().'/deposit') }}">
                  	 <div class="alert alert-danger mt-3" role="alert">
                    	<span aria-hidden="true"  class="fa fa-exclamation-triangle "></span>
                       @lang('lotdetail.deposit_amount')
                      
                     </div>
                </a>
                 @elseif(isset($data['deposit']->status) && $data['deposit']->status=="Pending")

                   <a href="{{ url(app()->getLocale().'/paymenthistory') }}">
                   	 <div class="alert alert-danger mt-3" role="alert">
                    	<span aria-hidden="true"  class="fa fa-exclamation-triangle "></span>
                      @lang('lotdetail.deposite_status')
                    </div>
                 </a>
                 @elseif(Auth::user()->document_status=="Pending")
                 <a href="{{ url(app()->getLocale().'/document/'.Auth::user()->id) }}">
                    <div class="alert alert-danger mt-3" role="alert">
                    	<span aria-hidden="true"  class="fa fa-exclamation-triangle "></span>
		                 @lang('lotdetail.document_status') 
		               </div>
						</a>
					@elseif(bid_amount_limit(Auth::user()->id)==0)	
                 <a href="{{ url(app()->getLocale().'/deposit') }}">
                  	 <div class="alert alert-danger mt-3" role="alert">
                    	<span aria-hidden="true"  class="fa fa-exclamation-triangle "></span>
                      You don’t have enough money to place a bid. Please <u>make a deposit</u> in your personal cabinet
                      
                     </div>
                </a>
				    @endif
				@endif
			</form>
	      </div>
	       @if (empty(Auth::user()->address))
	      <div class="modal-footer">
               @php
					$user_id=0;
				@endphp
                     @if(Auth::check())
                      @php
                        $user_id=Auth::user()->id;
                      @endphp
                     @endif
	        <div class="modal-footer-block-red">
	        	<p><a href="{{url(app()->getLocale().'/usersettings/'.$user_id.'?'.'type=Address')}}" class="link-decor-blue">@lang('lotdetail.profiles')</a> 
@lang('lotdetail.fill_address')</p>
	        </div>
	      </div>
	       @endif
	    </div>
	    