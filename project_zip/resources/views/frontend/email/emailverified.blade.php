@extends('frontend.layout.header')

@section('content')

<div class="container">
	<div class="card emailverified mt-5 ml-5 mr-5 mb-5">
		<div class="card-body row">
			<div class="col-md-6 email_verify">
				<h2 class="text-uppercase">{{$data}}</h2>
				<p>Your Account is successfully activated</p>
				<div class="row">
					<div class="col-md-6">
						@if(Auth::check())
						<a href="{{url(app()->getLocale().'/userdashboard')}}" class="btn btn-block">Dashboard</a>
						@else
						<a href="{{url(app()->getLocale().'/login')}}" class="btn btn-block">@lang('register_page.login')</a>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="verify_image">
					<img src="https://cs.copart.com/v1/AUTH_svc.pdoc00001/LPP231/545150dc53b94da39b7b463e7617eefc_hrs.jpg" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</div>
@endsection