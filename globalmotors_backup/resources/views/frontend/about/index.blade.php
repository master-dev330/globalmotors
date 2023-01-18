@extends('frontend.layout.header')
@section ('css')
<style type="text/css">
	.textarea{
		width: 100%;
    border: 0;
    height: 100px;
    background: #f2f2f2;
    padding: 10px 20px;
	}

</style>
@endsection

@section('content')
  

	<div class="container">
			<div class="about__wrapper" style="margin-top: 50px;">
				<h2 class="h2-style">@lang('about.about_us')</h2>

				<p>@lang('about.text')</p>


		</div>

	</div>


@endsection

@section('js')

@endsection





