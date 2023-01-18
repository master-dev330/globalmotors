
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.6.1/slimselect.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.2.1/dist/sweetalert2.all.min.js"></script>
		<script src="{{ asset('frontend/js/app.js')}}" ></script>
		<script src="{{ asset('frontend/js/intlTelInput.min.js')}}" ></script>
		<script src="{{ asset('frontend/js/lightgallery.min.js')}}" ></script>
		<script src="{{ asset('frontend/countdown/moment.js')}}" ></script>
		<script src="{{ asset('frontend/countdown/moment_data.js')}}" ></script>
		<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js" integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		
<script type="text/javascript">
	var loader=document.getElementById('cover-spin');
     
     window.addEventListener('load',function(){
       loader.style.display="none";
     });
function success(icon,title,text){
	Swal.fire({
		icon: icon,
		title: title,
		text: text,
	});
	}
	 
	 $(document).ready(function(){
		$('img').lazyload();

	});

	$(document).ready(function(){

    var form = $('.d-inline').attr('action');
    $(".d-inline").attr("action", "https://www.globalmotorshub.com/en/resendemail");
    var content=``;
    content +=`
    <h1>Dashboard</h1>
    <p>Before proceeding, please check your email for a verification link. If you did not receive the email</p>
    <a href="https://www.globalmotorshub.com/en/resendemail">click here to request another</a>
    `;
    $('.bg-light').after('<div id="link" class="p-5"></div>')
    $('.bg-light').remove();
    $('#link').append(content);
      $(document).on('click','.searchbutton',function(){
        var searchinput=$('input[name=search]').val();
        if(searchinput==''){
        alert('Write something before proceeding');
        return false;
        }
      });

		  $(document).on('click','.language ',function(){
		  	// alert(document.location.pathname);
		  	var href=$(this).attr('data-href');
		  	var lang=$(this).attr('data-lang');
		  	// var main_url=document.location.href;
		  	// let text = document.location.pathname.split('/');
     //        var url= main_url.replace(text[2], lang);
     //        location.href=url;
            $.ajax({
                type: "get",
                url: "{{url('/test') }}/"+lang,
                success: function(data) {
                	var main_url=document.location.href;
		  	let text = document.location.pathname.split('/');
            var url= main_url.replace(text[2], lang);
            location.href=url;
                }
            });

     });
                         <?php
                           $lang='en';
                            if(Session::has('lang')):
                            	$lang=Session::get('lang');
                            	?>
                                changeLanguageByButtonClick('{{$lang}}');
                             <?php  endif;?>
   
   }); 
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}

function changeLanguageByButtonClick(language) {
  // var language = document.getElementById("language").value;
  var selectField = document.querySelector("#google_translate_element select");
  for(var i=0; i < selectField.children.length; i++){
    var option = selectField.children[i];
    // find desired langauge and change the former language of the hidden selection-field 
    if(option.value==language){
       selectField.selectedIndex = i;
       // trigger change event afterwards to make google-lib translate this side
       selectField.dispatchEvent(new Event('change'));
       break;
    }
  }
  }

</script>


		
		


