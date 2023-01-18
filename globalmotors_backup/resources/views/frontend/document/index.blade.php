@extends('frontend.layout.header')

@section('content')

<section class="section-main section-cabinet pb-70">

		<div class="">

			<div class="row">

				<div class="col-md-5 col-lg-3">

					@include('frontend.dashboard.sidebar')

				</div>

				<div class="col-md-7 col-lg-9">

					<div class="row">

						<div class="col-md-12">

							<div class="card card-white">

                                <div class="card-body pb-5">

                                    <h4 class="card-title h4-style text-left">@lang('account.document_management')</h4>

                                    <span class="font-small">@lang('account.upload_photo')</span>

                                    <div class="card-tabs mt-4 select-styled">

					                    <form action="{{url(app()->getLocale().'/savedocument')}}" method="post" enctype="multipart/form-data">

                                            {{ csrf_field() }}


					                      	<div class="row">

					                      		<div class="col-md-12">

					                      			<label for="">@lang('account.document_type')</label>

			                       		<select class="slim-select-2"  name="document_type" data-select data-placeholder="Document type" data-option-id={{isset($data['results']->document_type)?$data['results']->document_type:""}}>

										   <option data-placeholder="true"></option>

											<option {{$data['results']->document_type=="Identity document"?"Selected":''}} value="Identity document">Identity document</option>

											<option {{$data['results']->document_type=="The passport"?"Selected":''}} value="The passport">The passport</option>

										    <option {{$data['results']->document_type=="Driver's license"?"Selected":''}} value="Driver's license">Driver's license</option>

											<option {{$data['results']->document_type=="Other"?"Selected":''}} value="Other">Other</option>

									           </select>

					                      		</div>

					                      		<input type="hidden" name="document_type" >

					                      	</div>	
					                      	<div class="row">
					                      		<div class="col-md-12">
					                      			<div class="drop-wrapp">
					                      			<div class="drop">
												    <div class="cont">
												      <i class="fa fa-cloud-upload"></i>
												      <div class="tit">
												        @lang('account.drag')
												      </div>
												      <div class="desc">
												         @lang('account.file_here')
												      </div>
												      <div class="browse">
												         @lang('account.select')
												      </div>
												    </div>
												    <output id="list"></output>
												    <input id="files" multiple="true" name="document" type="file" />
												  </div>
					                      		</div>
					                      		</div>
					                      	</div>
											<input type="hidden" name="document_upload_date">
											<div class="profile-submit">
												<button type="submit" class="btn btn-dark-blue btn-w-short"> @lang('account.save')</button>
											</div>
                                          @if(!empty($data['results']->document))
	 										<div class="row mt-4 ml-2">
		 										<div class="col-md-12">
		                                       <a href="{{url(isset($data['results']->document)?$data['results']->document:'')}}" target="_blank">@lang('account.view') {{isset($data['results']->document_type)?$data['results']->document_type:''}} @lang('account.document') </a>
		                                        </div>
		 										<div class="col-md-12 mt-4">
		 											<h5><b>@lang('account.document_status')</b></h5>
		 												@if($data['results']->document_status=="Pending")
														 <div class="alert alert-warning mt-4">
															<a href="#" class="close mt-3" data-dismiss="alert" aria-label="close" title="close">×</a>
															<img src="/public/frontend/images/icon/file-icon.png" alt="">
														  <span class="ml-2" style="color: black;"><b>{{isset($data['results']->document_status)?$data['results']->document_status:''}} </b> <span style="margin-left:100px">{{ date('d-M-y H:i:s', strtotime(isset($data['results']->document_upload_date)?$data['results']->document_upload_date:'')) }}</span><br> <a class="ml-4" style="font-size: initial" href="{{url(isset($data['results']->document)?$data['results']->document:'')}}" target="_blank">{{isset($data['results']->document_type)?$data['results']->document_type:''}} @lang('account.document')</a>
														  </span>
												       </div>
									                    @elseif($data['results']->document_status=="Rejected")
														<div class="alert alert-danger mt-4">
															<a href="#" class="close mt-3" data-dismiss="alert" aria-label="close" title="close">×</a>
															<img src="/public/frontend/images/icon/file-icon.png" alt="">
														  <span class="ml-2" style="color: black;"><b>{{isset($data['results']->document_status)?$data['results']->document_status:''}} </b> <span style="margin-left:100px">{{ date('d-M-y H:i:s', strtotime(isset($data['results']->document_upload_date)?$data['results']->document_upload_date:'')) }}</span><br> <a class="ml-4" style="font-size: initial" href="{{url(isset($data['results']->document)?$data['results']->document:'')}}" target="_blank">{{isset($data['results']->document_type)?$data['results']->document_type:''}} @lang('account.document')</a>
														  </span>
														</div>
									                    @else
														<div class="alert alert-success mt-4">
															<a href="#" class="close mt-3" data-dismiss="alert" aria-label="close" title="close">×</a>
															<img src="/public/frontend/images/icon/file-icon.png" alt="">
														  <span class="ml-2" style="color: black;"><b>{{isset($data['results']->document_status)?$data['results']->document_status:''}} </b> <span style="margin-left:100px">{{ date('d-M-y H:i:s', strtotime(isset($data['results']->document_upload_date)?$data['results']->document_upload_date:'')) }}</span><br> <a class="ml-4" style="font-size: initial" href="{{url(isset($data['results']->document)?$data['results']->document:'')}}" target="_blank">{{isset($data['results']->document_type)?$data['results']->document_type:''}} @lang('account.document')</a>
														  </span>
														</div>
									                 @endif
		 										</div>
	                                        </div>
                                          @endif
                                            @if (!empty($data['results']->admin_remarks))
	 										<div class="row mt-4 ml-2">
		 										<div class="col-md-12 mt-4">
		 											<h5><b>@lang('account.admin_remarks') :</b></h5><span >{{isset($data['results']->admin_remarks)?$data['results']->admin_remarks:''}}</span>
		 										</div>
	                                        </div>
                                            @endif      
					                      

					                      </form>

                                    </div>

                                </div>

                            </div>

						</div>



					</div>

				</div>

			</div>

		</div>

	</section>

@endsection	


@section('js')

<script type="text/javascript">
 $(document).ready(function(){
	$('.doc').closest('.dropdown-has-child').find('.dropdown-toggle').addClass('active');
	$('.doc').closest('.dropdown-has-child').find('.dropdown-menu-child').slideDown();
    $('.doc').addClass('activetab');
 }); 
</script>

@endsection