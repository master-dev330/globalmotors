@extends('frontend.layout.header')
<style>
  .btn-register{
    opacity: 50% !important;
  }
.breadcrumb-item+.breadcrumb-item::before{content: ">" !important; }
</style>
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
@section('content')
@if(count($data['search']) > 0)
  @php 
  $hide_content="";
  @endphp
  @else
  @php 
    $hide_content="d-none";
  @endphp
  @endif
<section class="section-catalog section-main">
  <div class="row ml-2">
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  @if(isset($_GET['brand']))
    <li class="breadcrumb-item" aria-current="page">
    <a href="{{url(app()->getLocale().'/lotsearch')}}?vehicletype={{$data['vehicletypeinfo']}}">
      {{$data['vehicletypeinfo']}}
    </a></li>

    <li class="breadcrumb-item active" aria-current="page">
    <a href="{{url(app()->getLocale().'/lotsearch')}}?brand={{$data['brandinfo']->id}}">
      {{$data['brandinfo']->name}}
    </a></li>
  @elseif(isset($_GET['vehicletype']))
     <li class="breadcrumb-item" aria-current="page">
    <a href="{{url(app()->getLocale().'/lotsearch')}}?vehicletype={{$data['vehicletype']}}">
      {{$_GET['vehicletype']}}
    </a></li>
  @elseif(isset($_GET['model']))
    <li class="breadcrumb-item" aria-current="page">
    <a href="{{url(app()->getLocale().'/lotsearch')}}?vehicletype={{$data['vehicletypeinfo']}}">
      {{$data['vehicletypeinfo']}}
    </a></li>
    <li class="breadcrumb-item" aria-current="page">
    <a href="{{url(app()->getLocale().'/lotsearch')}}?brand={{$data['brandinfo']->id}}">
      {{$data['brandinfo']->name}}
    </a></li>
    <li class="breadcrumb-item active" aria-current="page">
    <a href="{{url(app()->getLocale().'/lotsearch')}}?model={{$data['modelinfo']->id}}&make={{$data['brandinfo']->id}}">
      {{$data['modelinfo']->name}}
    </a></li>
    @else
      <li class="breadcrumb-item active" aria-current="page">
    <a href="">
     Search
    </a></li>
  @endif

  </ol>
</nav>
  </div> 
		<div class="">

			<div class="row">

				@include('frontend.search.side_filter')

				<div class="col-lg-8 col-xl-9">
          <div class="tags_div">
            
          @include("frontend.search.tag")
          </div>
					
          <div class="row row-paginate">

						<div class="col-lg-12 col-xl-3 d-none">

							<h3>@lang('lotdetail.sort')</h3>

							<select class="slim-select" data-select class="single">

								<option value="value1">6</option>

								<option value="value2">18</option>

								<option value="value3">36</option>

							</select>

						</div>

						<div class="col-lg-12 col-xl-3 filter-fields {{$hide_content}}">

							<h3>@lang('lotdetail.sort')</h3>

							<select class="slim-select" data-sort class="single">

								<option >Select</option>

								<option value="lot.created_at|asc">Lot created date 🠑</option>

								<option value="lot.created_at|desc">Lot creation date 🠓</option>

								<option value="lot.starting_price|desc">Lot Price 🠓</option>

								<option value="lot.starting_price|asc">Lot Price 🠑</option>

							</select>

						</div>


						<div class="col-lg-12 col-xl-8 links ml-auto toppagination">
           {{--    <h3 class="text-center ml-5"><b class="text-center ml-5">Page {{$data['offset']}} of {{round($data['total']/env('PER_PAGE'))}} </b></h3> --}}

							@include("frontend.search.links")
						</div>

					</div>

					<div class="col-lg-12 col-xl-8 text-center spinner d-none m-auto">

					<div class="lds-spinner" style="margin-top: 25%;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
				  </div>
					<div class="filter_div">
					@include("frontend.search.main_section")
					</div>
          
          <div class="row filter-fields {{$hide_content}}">
            <div class="col-12 links">
              @include("frontend.search.links")
            </div>
          </div>
				</div>

			</div>

		</div>

		

	</section>



	@endsection



@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('frontend/js/filter.js')}}" ></script>

	<script type="text/javascript">

       $(document).ready(function(){

      
        $(document).on('click','.all-card-photos ',function(){
           $(this).parents('.lightgallery').find('.lot-img').trigger('click');
});
        $(document).on('click','.pagination2 ',function(){
          var dataclass=$(this).attr('data-class');
          var search= '{{isset($_POST['search'])?$_POST['search']:""}}';
          // alert(dataclass);
          var _token = $("input[name=_token]").val();

         	var page=$(this).attr('data-page');
          $("input[name=page]").val(page);
          filter();
          return false;
          $('.catalog-paginate').find('.pagination').removeClass('linkfocus');

          $(this).addClass('linkfocus');

        	var formdata={'pageno':page, _token:_token};         

          $.ajax({

                type: "post",

                url:"{{url(app()->getLocale().'/searchpagination')}}",

                data:formdata,

                dataType:'json',

                success: function(data) {

                  // console.log(data.response);

                   // $('#multiplemodel').html('');

                  $('.filter_div').html(data.response);
                    timecounter();

                }

            });

        });

    $(document).on('click','.add_bookmark',function(){

     var user_id=$(this).parents('.card').find(".book_mark").attr('data-id');

     var _token = $("input[name=_token]").val();

     var lot_id=$(this).parents('.card').find(".book_mark").attr('data-lot');

     var bookmark=$(this).parents('.card').find(".book_mark").attr('data-bookmark');

     // console.log(bookmark,lot_id,user_id)

     var currentvalue= $(this);

     var formdata={'user_id':user_id,'lot_id':lot_id,"bookmark":bookmark, _token:_token};

     // console.log("fomrdata",formdata)

        $.ajax({

                type: "post",

                url: "{{url(app()->getLocale().'/savebookmark') }}",

                data: formdata,

                dataType:'json',

                success: function(data) {

                 console.log(data.response);

                 if(bookmark==0){

                 currentvalue.attr('data-bookmark',1);

                 currentvalue.parents('.card').find(".book_mark").addClass('active');
                  Swal.fire('Bookmark Successfully Added.')

                 }else{

                 	 currentvalue.attr('data-bookmark',0);

                    currentvalue.parents('.card').find(".book_mark").removeClass('active');
                    Swal.fire('Removed From Bookmark Successfully.')
                 }

                }

            });

    });

   $(document).on('click','.next',function(){

    var current = parseFloat($('.linkfocus').html());
    var middle = $(this).attr('data-middle');
    var link = current+1;
    var mid = middle+1;
    $('.toppagination .link'+link).trigger('click');

  });
 
    $(document).on('click','.previous',function(){

      var current = parseFloat($('.linkfocus').html());
      var link = current-1;

      $('.toppagination .link'+link).trigger('click');


  });

    $(function () { 
    $(".number").popover({
        trigger: 'hover',
    });  
});
       
       

});

	</script>

@endsection	