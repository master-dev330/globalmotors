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
  

	<div class="login-page">
		<div class="login-page-form">
			<div class="login-page-form-wrap">
				<h2 class="h2-style">@lang('contact.contact_us')</h2>

				

			  <form action="#"  method="post" id="contactus">
			  	 {{csrf_field()}}
					<div class="row">
						<div class="col-md-12">
              			<div class="form-group card-input">
 
              				<input type="text" id="input-1" name='name' required placeholder="@lang('contact.name')">
              				<!-- <label for="input-1" class="form-label" >@lang('contact.name')</label> -->
              			</div>
              		</div>
              		<div class="col-md-12">
              			<div class="form-group card-input">
 
              				<input type="text" id="input-1" name='email' required placeholder="@lang('contact.email')">
              				<!-- <label for="input-1" class="form-label" >@lang('contact.email')</label> -->
              			</div>
              		</div>
              		<div class="col-md-12">
              			<div class="form-group card-input">
              				<input type="text " id="input-2"  name='subject' placeholder="@lang('contact.subject')">
              				<!-- <label for="input-2" class="form-label" >@lang('contact.subject')</label> -->
              			</div>
              		</div>
              		<div class="col-md-12">
              			<div class="form-group ">
              				<textarea class="form-group textarea" name="message" placeholder="@lang('contact.message')"></textarea>
              				<!-- <label for="input-3" class="form-label" >@lang('contact.message')</label> -->
              				<span id='message'></span>
              			</div>
              		</div>
            
              	</div>
              	<button type="submit" class="btn btn-register btn-dark-blue">@lang('contact.send_message')</button>
				</form>
			</div>
		</div>

	</div>

@endsection

@section('js')

<script type="text/javascript">
 $(document).ready(function() { 
 

 	$(document).on('submit','#contactus',function (e) {
           e.preventDefault();
 		   var formdata=$('#contactus').serialize();
         
 		   $.ajax({
                type: "post",
                url: "{{url(app()->getLocale().'/sendmessage') }}",
                data: formdata,
                dataType:'json',
                success: function(data) {
                	// console.log(data.response);
                	$("#contactus")[0].reset();
                	success('success','Congratulation!','Message Send!');
      //           	Swal.fire({
						//   icon: 'success',
						//   title: 'Congratulation!',
						//   text: 'Message Send!',
						//   // footer: '<a href="">Why do I have this issue?</a>'
						// });

                }
            });


 	});

 });

</script>
@endsection





