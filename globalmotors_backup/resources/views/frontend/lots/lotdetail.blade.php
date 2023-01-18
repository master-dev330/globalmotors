@extends('frontend.layout.header')

<style type="text/css">
  
.card-item-vertical {
    overflow: hidden;
}
.card-item-vertical .card-img-top img
{
    height: 100%;
    object-fit: cover;
}
.card-img-top img {
    width: 100% ;
}

.card-item {
    border-radius: 12px;
    border: 0;
    background: #fff;
}
.card-item-vertical .card-img-top {
    padding: 0;
}
.card-item-vertical .card-img-top {
    max-width: 390px;
}
.card-item .card-img-top {
    border-radius: 12px 12px 0 12px;
    overflow: hidden;
}
.card-item-vertical .card-img-wrap {
    height: 100%;
}
.card-item-vertical .card-title {
    color: #2d2c86;
     padding-right: 0px !important; 
}
.card-img-wrap {
    border-radius: 12px;
    overflow: hidden;
}
.card-img-wrap {
    position: relative;
}
.all-card-photos {
    margin-top: 20px;
}
.all-card-photos {
    position: absolute;
    bottom: 15px;
    left: 10px;
}

element.style {
}
.all-card-photos {
    left: inherit;
    right: 20px;
    bottom: 20px;
}
.all-card-photos {
    margin-top: 20px;
}
.all-card-photos {
    position: absolute;
   /* bottom: 15px;
    left: 10px;*/
}
.all-card-photos{
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    text-transform: uppercase;
    color: #000;
    font-weight: 600;
}
.card-item-vertical .card-content {
    padding: 30px 30px 30px 70px;
}
.card-item-vertical .card-content {
    width: 100%;
}
.card-content {
    /*padding: 20px;*/
    position: relative;
}
.card-info-rate {
    background: rgba(0, 119, 255, .05);
    max-width: 230px;
    width: 100%;
}
.card-info-rate.auction-close-wrap{
    background-color: rgba(223, 0, 16, .05);
}
.card-title a
{
  color: #000;
}
.color_black span 
{
    color: #000;
    font-weight: bold;
}
.details-list__label
{
    font-size: 15px;
}
.card-block .details-list__item span
{
    font-size: 15px;
}
.details-list__item
{
    margin-bottom: 8px;
}
.card-info-rate-price p
{
    color: #1D1C62;
}

.label-green
{
    width: 25px;
    height: 25px;
    background: #30CE55;
    color: #fff;
    font-size: 12px;
    border-radius: 50%;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
}
.catalog-filters .ss-multi-selected,.catalog-filter-item-group .card-personal.h-50px,.card-price-tab.sidebar-nav{
    border-radius: 10px;
}
.label-green 
{
    cursor: pointer;
    display: flex;
}
.label-red
{
    width: 25px;
    height: 25px;
    background: #B32828;
    color: #fff;
    font-size: 12px;
    border-radius: 50%;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
}
.label-red 
{
    cursor: pointer;
    display: flex;
}
.label-blue
{
    width: 25px;
    height: 25px;
    background: #0465C7;
    color: #fff;
    font-size: 12px;
    border-radius: 50%;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
}
.label-blue
{
    cursor: pointer;
    display: flex;
}
.linkfocus
{
    background:#0077FF !important;
}
.catalog-paginate ul a:hover
{
    background:#0077FF !important;
}
.popover-header
{
    background-color: #fff;
    border-bottom: 0px;
    color: #30CE55;
}
.empty-message-block {
    color: #888da3;
    padding: 60px 0 36px;
    text-align: center;
}.empty-message-block .icon-xl.gray {
    color: #888da3;
}.empty-message-block .icon-xl {
    display: inline-block;
    font-size: 48px;
}.empty-message-block .title {
    display: block;
    font-size: 32px;
    line-height: 38px;
    margin: 30px 0 21px;

}*, :after, :before {
    box-sizing: border-box;
}
.empty-message-block p {
    display: inline-block;
    font-size: 18px;
    line-height: 32px;
    max-width: 615px;
}
p:last-child {
    margin: 0;
}
.btn-info.disabled, .btn-info:disabled{
    background-color: #f2f2f2 !important;
}
.breadcrumb-item+.breadcrumb-item::before{content: ">" !important; }

@media only screen and (max-width:1400px) {
    .card-item-vertical .card-img-top{
        max-width: 325px;
    }
}
</style>


@section('content')



	<section class="section-main section-main__lot pb-70 ">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="https://globalmotorshub.com/en">Home</a></li>
    @if(!empty($data['lot']->vehicle_type))
    <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/lotsearch')}}?vehicletype={{$data['lot']->vehicle_type}}">{{ $data['lot']->vehicle_type}}</a></li>
    @endif
    @if(isset($data['lot']->make->name))
    <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/lotsearch')}}?brand={{$data['lot']->make_id}}">{{ $data['lot']->make->name}}</a></li>
    @endif
    @if(isset($data['lot']->model->name))

    <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/lotsearch')}}?model={{$data['lot']->model_id}}&make={{$data['lot']->make_id}}">{{ $data['lot']->model->name}}</a></li>
    @endif

    <li class="breadcrumb-item active" aria-current="page">
        {{ $data['lot']->lot_title}}</li>
  </ol>
</nav>
		<div class="container">
      <div class="row">
        <div class="col-xl-5">
          <div class="cart-product-title card1">
           

            <img src="{{asset('uploads/brand/brand-1.jpg')}}" alt="" width="35px">
            @if($data['lot']->vehicleCondition=='wont-start')
                        <span data-trigger="hover" class="card-block__label label-red number p-1" rel="tooltip" title="The vehicle does not start and does not drive." data-content="Auction checked that the vehicle wouldn’t start or wasn’t tested yet. It is the buyer’s responsibility to accept it.
                        " >N</span>
                        @elseif($data['lot']->vehicleCondition=='starts')
                        <span  data-trigger="hover" class="card-block__label label-blue number p-1" rel="tooltip" title="The car starts but does not drive." data-content="
                        Auction verified that the vehicle started, and ran at idle. There is no guarantee that at the time of receiving the vehicle is in starts condition. It is the buyer’s responsibility to accept it
                        ">S</span>
                        @elseif($data['lot']->vehicleCondition=='runs')
                         <span  data-trigger="hover" class="card-block__label label-green number p-1" rel="tooltip" title="The vehicle starts and drives and which may imply that the car can only go one meter forward or one meter back." data-content="At the auction, the vehicle’s state is declared as Run and Drive - moving forward/backwards three feet under its own power. There is no guarantee that at the time of receiving the vehicle is in running condition and you can take it right away on highway. It is the buyer’s responsibility to accept it 
                        ">R</span>
                        @endif
            <h2> {{ $data['lot']->title_year_before}}</h2>
                    <!-- <span class="book_mark active fas fa-bookmark" data-toggle="modal" data-target="#remove-bookmarks"></span> -->
                    @if(Auth::check())
                    <div class="text-right"><span class="book_mark fas fa-bookmark {{isset($data['bookmark']->bookmark) ? 'active' :''}} add_bookmark" data-lot="{{$data['lot']->id}}" data-id="{{isset(Auth::user()->id)?Auth::user()->id:''}}" data-bookmark="{{isset($data['bookmark']->bookmark) ? $data['bookmark']->bookmark:''}}"></span> {{csrf_field()}}</div>
                    @else
                    <div class="text-right" data-toggle="modal" data-target="#loginModal"><span class="book_mark fas fa-bookmark {{isset($data['bookmark']->bookmark) ? 'active' :''}} add_bookmark" data-lot="{{$data['lot']->id}}" data-id="{{isset(Auth::user()->id)?Auth::user()->id:''}}" data-bookmark="{{isset($data['bookmark']->bookmark) ? $data['bookmark']->bookmark:''}}"></span> {{csrf_field()}}</div>
                    @endif
                              <!-- <span class="book_mark fas fa-bookmark active"></span> -->
                    </div>
        </div>
      </div>
			<div class="row">

			@include('frontend.lots.info')

			{{-- <div class="countdown"></div> --}}

			@include('frontend.lots.bet_info')

			@include('frontend.lots.bid_info')

			</div>

		</div>

		

	</section>



<!-- END -->

	@endsection


@section('js')
<script src="{{ asset('frontend/js/filter.js')}}" ></script>

	<script type="text/javascript">
            $(function () { 
    $(".number").popover({
        trigger: 'hover',
    });  
});

    function increment() {
      var countValue=document.getElementById('demoInput').value;
    countValue=  parseFloat(countValue)+25
      console.log(countValue);
      document.getElementById('demoInput').value=countValue;
       }

          function decrement() {
         var countValue=document.getElementById('demoInput').value;
    countValue=  parseFloat(countValue)-25
              document.getElementById('demoInput').value=countValue;
         }

     $(document).ready(function() {
      
 $('[data-toggle="popover"]').popover();
     	 $(document).on('submit','#buynow',function (e) {

           // alert('test');

           e.preventDefault();

           var min_price=parseFloat($('input[name="min_price"]').val());

           var bid_amount=parseFloat($('input[name="bid_amount"]').val());

           var lot_id=$('input[name="lot_id"]').val();

           var auction_id=$('input[name="auction_id"]').val();

           var user_id=$('input[name="user_id"]').val();

           // var formdata={"min_price":min_price,'bid_amount':bid_amount,'lot_id':lot_id,'auction_id':auction_id,'user_id':user_id};

           var formdata=$('#buynow').serialize();

           // console.log('bid_amount',bid_amount);

           // console.log('min_price',min_price);



           // console.log(formdata);



      //      if(bid_amount<min_price){

      //      	Swal.fire({

						//   icon: 'error',

						//   title: 'Invalid Bid!',

						//   text: 'Minimun bid must be greater than '+min_price,

						//   // footer: '<a href="">Why do I have this issue?</a>'

						// });

      //      	return null;

      //      }

            $.ajax({

                type: "post",

                url: "{{url(app()->getLocale().'/buynow') }}",

                data: formdata,

                dataType:'json',

                success: function(data) {

                	// console.log(data.response);

                	Swal.fire({

    						  icon: 'success',

    						  title: 'Congratulation!',

    						  text: 'Buy Now Request Send!',

    						  // footer: '<a href="">Why do I have this issue?</a>'

    						})

                // $('.starting_price').html('$'+data.response.bid_amount+" USD");

                // $('input[name="bid_amount"]').val(data.response.bid_amount);

                // $('input[name="min_price"]').val(data.response.bid_amount);

                 $("#modal-rate").modal('hide');

                }

            });





      });



        $(document).on('submit','#bidform',function (e) {

           // alert('test');

           e.preventDefault();
            
           var min_price=parseFloat($('input[name="min_price"]').val());

           var bid_amount=parseFloat($('input[name="bid_amount"]').val());

           var lot_id=$('input[name="lot_id"]').val();

           var auction_id=$('input[name="auction_id"]').val();

           var user_id=$('input[name="user_id"]').val();
           
           var deposit_amount=$('input[name="deposit_amount"]').val();
           // var formdata={"min_price":min_price,'bid_amount':bid_amount,'lot_id':lot_id,'auction_id':auction_id,'user_id':user_id};

           var formdata=$('#bidform').serialize();

           // console.log('bid_amount',bid_amount);

           // console.log('min_price',min_price);



           // console.log(formdata);

           if(bid_amount>deposit_amount){
            Swal.fire({

              icon: 'error',

              title: 'Bid Amount',

              text: 'Bid Amount must be Less  than your deposit amount '+deposit_amount,

              // footer: '<a href="">Why do I have this issue?</a>'

            });

            return null;
           }

           if(bid_amount<=min_price){

            Swal.fire({

              icon: 'error',

              title: 'Invalid Bid!',

              text: 'Minimun bid must be greater than '+min_price,

              // footer: '<a href="">Why do I have this issue?</a>'

            });

            return null;

           }

            $.ajax({

                type: "post",

                url: "{{url(app()->getLocale().'/placebid') }}",

                data: formdata,

                dataType:'json',

                success: function(data) {

                  // console.log(data.response);

                  Swal.fire({

                  icon: 'success',

                  title: 'Congratulation!',

                  text: 'Bid Placed!',

                  // footer: '<a href="">Why do I have this issue?</a>'

                })

                 $('.starting_price').html('$'+data.response.bid_amount+" USD");

                 $('input[name="bid_amount"]').val(data.response.bid_amount);

                 $('input[name="min_price"]').val(data.response.bid_amount);

                 $("#modal-rate").modal('hide');

                }

            });

      });


     	 $.each( $(".lot_timer"), function() {

			$(this).countdown(moment.tz($(this).text(), "Europe/Berlin").toDate(), function (event) {

				$(this).html(event.strftime('%D DAYS %H:%M:%S'));

				if($(this).text()=="00 DAYS 00:00:00")

				{

					// location.reload();

				}

			});

		});
    var eventTime = $('input[name="start_date"]').val();
    var currentTime = '{{$data['auction']->current_date}}';
    var sold = '{{$data['lot']->sold}}';
    // alert(currentTime);
    console.log('sold',sold);
    var leftTime = eventTime - currentTime;//Now i am passing the left time from controller itself which handles timezone stuff (UTC), just to simply question i used harcoded values.
    // alert(eventTime);
    var currentelem=$(this);
    var duration = moment.duration(leftTime, 'seconds');
    var interval = 1000;
    if(duration.asHours() <= 1){
      if(sold>0){
         currentelem.find('.countdown').html('Lot Sold');
         currentelem.find('.countdown').addClass('auction-close');
         currentelem.find('.card-info-rate-timer_wrapper').addClass('auction-close-wrap');
         // currentelem.find('.bidbutton').addClass('bidbutton');
       $('.auction-close').addClass('text-danger ');
       $('.bidbutton').attr('disabled','disabled');
        }else{
         currentelem.find('.countdown').html('Auction Closed');
         currentelem.find('.countdown').addClass('auction-close');
         currentelem.find('.card-info-rate-timer_wrapper').addClass('auction-close-wrap');
         // currentelem.find('.bidbutton').addClass('bidbutton');
         $('.auction-close').addClass('text-danger ');
         $('.bidbutton').attr('disabled','disabled');
       }
      }
    setInterval(function(){
      // Time Out check
      if(duration.asHours() <= 1) {
        clearInterval(duration);
        return 0
        window.location.reload(true); 
         $('.countdown').html('Auction closed');
      }
       //Otherwise
      duration = moment.duration(duration.asSeconds() - 1, 'seconds');
       var time=`<div>`+duration.days()+` <span>Days</span></div>
				<div>`+duration.hours()+` <span>Hours</span></div>
				<div>`+duration.minutes()+` <span>Min</span></div>
				<div>`+duration.seconds()+` <span>Sec</span></div>`;
      $('.countdown').html(time);
    }, interval);
      })
      $('.bid_value').on('change', function() {
          var token = $('input[name=_token]').val();
          var bid_value = $('input[name=bid_value]').val();
          var type = "{{$data['lot']->brand}}";
          var lot_no = "{{$data['lot']->lot_no}}"
          var formdata = {'_token':token,'bid_value':bid_value,'brand':type,'lot_no':lot_no};
          $.ajax({
                type: "POST",

                headers: "{'X-CSRF-TOKEN':_token}",

                url: "{{url(app()->getLocale().'/bid_value')}}",

                data: formdata,

                dataType:'json',

                success: function(data) {

                  $('.copart_fee').html(data.response);
                  $('.tarnsctionfees').html(data.transction_fee);
                  $('.document_fee').html(data.document_fee);
                  var copart_fee = $('.copart_fee').html();
                  var document_fee = $('.document_fee').html();
                  var transction_price = $('.tarnsctionfees').html();
                  var total_price = Number(document_fee) + Number(transction_price) + Number(bid_value) + Number(copart_fee);
                  $('.total_price_fees').html(total_price);

              }
        
           });
        });

        $('.zip_code').addClass('d-none');
        // $('.total_cost_usa').addClass('d-none');
        $('.usa').on('click', function() {

          var delivery_to = $('input[name=usa]:checked').val();

         if(delivery_to=="USA")
         {
          $('.total_cost_price').html('');
            $('.zip_code').removeClass('d-none');
            $('.delivery').addClass('d-none');
            $('.delivery1').addClass('d-none');
         }
         else if(delivery_to=="Others")
         {
          $('.total_cost_price').html('');

            $('.zip_code').addClass('d-none');
            $('.delivery').removeClass('d-none');
            $('.delivery1').removeClass('d-none');
         }
          $('.zip_code_search').on('change', function() {
            var token = $('input[name=_token]').val();
            var zip_code = $('input[name=zip_code]').val();
            var formdata = {'_token':token,'zip_code':zip_code,'type':delivery_to};
            $.ajax({
                  type: "POST",

                  headers: "{'X-CSRF-TOKEN':_token}",

                  url: "{{url(app()->getLocale().'/zip_code_search')}}",

                  data: formdata,

                  dataType:'json',

                  success: function(data) {

                    $('.total_cost_price').html(data.response);

                }
          
             });

           });

          $('.testshipping').on('change', function() {
            var token = $('input[name=_token]').val();
            var id = $('select[name=id]').val();
            var formdata = {'_token':token,'id':id};
            console.log('test',formdata);

            $.ajax({

                  type: "POST",

                  headers: "{'X-CSRF-TOKEN':_token}",

                  url: "{{url(app()->getLocale().'/ground_shipping_search')}}",

                  data: formdata,

                  dataType:'json',

                  success: function(data) {

                    $('.ground_fee').html(data.response);

                    $('.ocean_shipping').html(data.ocean);

                }
          
             });

          });
   
          $('.ocean_data').on('change', function() {
            var token = $('input[name=_token]').val();
            var id = $('select[name=ocean_id]').val();
            var formdata = {'_token':token,'ocean_id':id};

            $.ajax({

                  type: "POST",

                  headers: "{'X-CSRF-TOKEN':_token}",

                  url: "{{url(app()->getLocale().'/ocean_shipping_search')}}",

                  data: formdata,

                  dataType:'json',

                  success: function(data) {

                  $('.ocean_fee').html(data.response);

                  var ground_fee = $('.ground_fee').html();
                  var ocean_fee = $('.ocean_fee').html();

                  var total_ground_fee = Number(ground_fee) + Number(ocean_fee);

                  $('.total_cost_price').html(total_ground_fee);
                }
          
             });

          });

       

       });
	</script>

@endsection	

