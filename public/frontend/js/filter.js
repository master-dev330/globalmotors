document.addEventListener("DOMContentLoaded", function() {



  // $('.home-slider').slick({

 //        infinite: true,

 //        autoplay:true,

 //        slidesToShow: 1,

 //        dots: false,

 //        autoplaySpeed: 6000,

 //        pauseOnHover: true,

 //        lazyLoad: 'progressive',

 //        arrows: true,

 //        adaptiveHeight: true,

 //        prevArrow: '<a href="" class="arrow-slider prev-arrow"><i class="fal fa-chevron-left"></i></a>',

 //        nextArrow: '<a href="" class="arrow-slider next-arrow"><i class="fal fa-chevron-right"></i></a>'

 //    });



    // $('.js-select').select2();



  $('.card-slider').slick({

        infinite: false,

        slidesToShow: 3,

        slidesToScroll: 2,

        dots: false,



        pauseOnHover: true,

        lazyLoad: 'progressive',

        arrows: true,

        adaptiveHeight: true,

        appendArrows: $('.card-slider-arrows'),

        prevArrow: '<a href="" class="arrow-slider prev-arrow"><i class="fal fa-chevron-left"></i></a>',

        nextArrow: '<a href="" class="arrow-slider next-arrow"><i class="fal fa-chevron-right"></i></a>',

        responsive: [

        {

            breakpoint: 1200,

            settings: {

                slidesToShow: 2,

                slidesToScroll: 2,

            }

        },

        {

            breakpoint: 480,

            settings: {

                slidesToShow: 1,

                slidesToScroll: 1

            }

        }

    ]

    });







  function setProgress(index) {

        const calc = ((index + 2) / ($slider.slick('getSlick').slideCount)) * 100;



        $progressBar

            .css('background-size', `${calc}% 100%`)

            .attr('aria-valuenow', calc);



        // $progressBarLabel.text(`${calc.toFixed(2)}% completed`);

    }



    const $slider = $('.card-slider');

    const $progressBar = $('.progress');// const $progressBarLabel = $('.slider__label');



    $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {

        setProgress(nextSlide);

    });



    setProgress(0);





const year = document.querySelectorAll('[data-year]');

year.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {

      console.log(info.value);

         var yearfrom=info.value;
           if (yearfrom=='Any') {
            yearfrom=1972;
           }
         var currentTime = new Date();

         var year = currentTime.getFullYear();

         var yearcontent='';

         for (var i = yearfrom; i <= year; i++) {

           yearcontent+="<option value="+i+">"+i+"</option>";

         }

          $('#year_to').html('');

          $('#year_to').append(yearcontent);
           $("input[name=pagination]").val(1);
      filter();



    }

  });

});



const yearto = document.querySelectorAll('[data-yearto]');

yearto.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);
      filter();

    }

  });

});



const brand = document.querySelectorAll('[data-brand]');

brand.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {

      console.log(info);

         var id=info.value;

    var lang=$('input[name=lang]').val();


         $.ajax({

                type: "get",

                url: "/"+lang+"/getbrandmodels/"+id,

                success: function(data) {

                  console.log(data);

                   $('#model').html('');

                  $('#model').append(data);

                }

            });
           $("input[name=pagination]").val(1);
      filter();

    }

  });

});



const make = document.querySelectorAll('[data-make]');

make.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {

      var id=new Array();

      info.forEach((info, i) => {

          id[i]=info.value;

       });

    var _token=$('input[name=_token]').val();



      var formdata={'id':id,_token:_token};

    var lang=$('input[name=lang]').val();



      $.ajax({

                type: "post",

                url: "/"+lang+"/getmultiplemodel",

                data:formdata,

                success: function(data) {

                  console.log(data);

                   // $('#multiplemodel').html('');

                  $('#multiplemodel').html(data);

                }

            });
           $("input[name=pagination]").val(1);
      filter();

      



      }

  });

});



const selects = document.querySelectorAll('[data-select]');

selects.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {

      console.log(info);

    

    }

  });

});



const auction = document.querySelectorAll('[data-auction]');

auction.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);
      filter();

    

    }

  });

});

const type = document.querySelectorAll('[data-type]');

type.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);
      filter();

    

    }

  });

});



const multiplemodel = document.querySelectorAll('[data-multiplemodel]');

multiplemodel.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);
      filter();

    

    }

  });

});

const fueltype = document.querySelectorAll('[data-fueltype]');

fueltype.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);

      filter();

    

    }

  });

});

const engine = document.querySelectorAll('[data-engine]');

engine.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);

      filter();

    

    }

  });

});

const transmission = document.querySelectorAll('[data-transmission]');

transmission.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);

      filter();

    

    }

  });

});

const damage = document.querySelectorAll('[data-damage]');

damage.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);

      filter();

    

    }

  });

});


const bodytype = document.querySelectorAll('[data-bodytype]');

bodytype.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);

      filter();

    

    }

  });

});

const location = document.querySelectorAll('[data-location]');

location.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);

      filter();

    

    }

  });

});

const area = document.querySelectorAll('[data-area]');

area.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);

      filter();

    

    }

  });

});

const document_type = document.querySelectorAll('[data-document_type]');

document_type.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {
           $("input[name=pagination]").val(1);

      filter();

    

    }

  });

});



const sort = document.querySelectorAll('[data-sort]');

sort.forEach(el => {

   const placeholder = el.getAttribute('data-placeholder');

   const hasSearch = el.hasAttribute('data-has-search');

   const isMultiple = el.hasAttribute('multiple');

  const instance = new SlimSelect({

    select: el,

    placeholder: placeholder,

    showSearch: isMultiple || hasSearch,

    onChange: (info) => {

      $('input[name=sort]').val(info.value);
           $("input[name=pagination]").val(1);

      filter();

    

    }

  });

});



$(document).on('keyup','.number',function(){
           $("input[name=pagination]").val(1);

  filter();

});

$(document).on('change','.date',function(){
           $("input[name=pagination]").val(1);

  filter();

});



$(document).on('change','.buynowcheck',function(){
           $("input[name=pagination]").val(1);

  filter();

});



$(document).on('change','.excludeacution',function(){
           $("input[name=pagination]").val(1);

  filter();

});



$(document).on('change','.excludetrading',function(){
           $("input[name=pagination]").val(1);

  filter();

});

 $(document).on('click','.pagination ',function(){
          var page=$(this).attr('data-page');
            var dataclass=$(this).attr('data-class');
          $('.paglinks').removeClass('active');
      $('.'+dataclass).addClass('active');

        $("input[name=page]").val(page);
        $("input[name=pagination]").val(0);
          $('.catalog-paginate').find('.pagination').removeClass('linkfocus');
        $(this).addClass('linkfocus');
          filter();
});


 $(document).on('click','.paglinks ',function(){
          var orgpage=parseFloat($(this).find('a').attr('data-page'));
          var middledots=$(this).next('li').hasClass('middledots');
          var prevdots=$(this).prev('li').hasClass('firstdots');
          var total=parseFloat($('.paglinks').last('li').find('a').text());

          if(middledots){
              var diff=total-orgpage;
           if(diff >2){
             var nextpage=orgpage+1;
              var link=`<li class="pag`+nextpage+` paglinks"><a class="pagination pointer link`+nextpage+`" data-page="`+nextpage+`" data-class="pag`+nextpage+`"> `+nextpage+`</a></li>`;
              $('.middledots').before(link); //append next link
              var prevpage=orgpage-1;
              var pageone=1;
              link =``;
              for(var i=1; i<prevpage; i++){
              $('.pag'+i).remove(); //removing all previous links 
              }
              $('.firstdots').remove(); //removing all firstdots links 
              link +=`<li class="pag`+pageone+` paglinks"><a class="pagination pointer link`+pageone+`" data-page="`+pageone+`" data-class="pag`+pageone+`"> `+pageone+`</a></li>`;
              link+=` <li class="firstdots"><a>...</a></li>`
              $('.pag'+prevpage).before(link); //appending 1 and dots
              }
              else if(diff<=2){
              $('.pag36').remove();
                var nextpage=orgpage+1;
              var link=`<li class="pag`+nextpage+` paglinks"><a class="pagination pointer link`+nextpage+`" data-page="`+nextpage+`" data-class="pag`+nextpage+`"> `+nextpage+`</a></li>`;
              $('.middledots').before(link);
              $('.middledots').remove()

              }
          }
          else if(prevdots){
              var prevpage=orgpage-1;
              var nextpage=orgpage+2;
              var next_page=orgpage+1;

              var link=`<li class="pag`+prevpage+` paglinks"><a class="pagination pointer link`+prevpage+`" data-page="`+prevpage+`" data-class="pag`+prevpage+`"> `+prevpage+`</a></li>`;
              $('.pag'+orgpage).before(link); //append prev link
              if(prevpage==2){
                $('.firstdots').remove(); 
              }
              var diff=total-orgpage;
              if(diff > 2){
                for(var i=next_page+1; i<total; i++){
                $('.pag'+i).remove(); //removing all next links 
                }
              $('.middledots').remove(); //removing all middledots links 
             var link=` <li class="middledots"><a>...</a></li>`
             $('.pag'+total).before(link); //appending dots beore last element
              }
            }
          else{
            if(!middledots && orgpage  > 4 && !prevdots){
               for(var i=2; i<total; i++){
              $('.pag'+i).remove(); //removing all next links 
            }
              $('.firstdots').remove();
              $('.middledots').remove();
            var prevlinks=total-1;
            var start=total-2;
              for(var i=start; i<total; i++){
              var link=`<li class="pag`+i+` paglinks"><a class="pagination pointer link`+i+`" data-page="`+i+`" data-class="pag`+i+`"> `+i+`</a></li>`;
               $('.pag'+total).before(link); //appending dots beore last element
              }
            $('.pag1').after('<li class="firstdots"><a>...</a></li>'); 
              $('.pag'+orgpage).addClass('active'); 
              $('.pag'+orgpage).find('a').addClass('linkfocus'); 

            }

          
          }
});
 function timecounter(){
    jQuery('.lotlist').each(function() {
    var currentelem=$(this);
    var eventTime = $(this).attr('data-time');
    var currentTime = $(this).attr('data-currunttime');
    var sold = $(this).attr('data-sold');
    
    // var currentTime = '{{strtotime(date('Y-m-d h:i:s'))}}';
    var leftTime = eventTime - currentTime;//Now i am passing the left time from controller itself which 
    var duration = moment.duration(leftTime, 'seconds');
    // console.log(duration.asSeconds());
    var interval = 1000;
    console.log('Hours',duration.asHours());
     if(duration.asHours() <= 1){

       if(sold>0){
         currentelem.find('.countdown').html('Lot Sold');
         currentelem.find('.countdown').addClass('auction-close');
         currentelem.find('.card-info-rate').addClass('auction-close-wrap');
         currentelem.find('.btn-register ').attr('href','javascript:void(0)');
         $('.auction-close').addClass('text-danger ');

        }else{
         currentelem.find('.countdown').html('Auction Closed');
         currentelem.find('.countdown').addClass('auction-close');
         currentelem.find('.card-info-rate').addClass('auction-close-wrap');
         currentelem.find('.btn-register ').attr('href','javascript:void(0)');
        $('.auction-close').addClass('text-danger ');
       }
      }
     setInterval(function(){
      // Time Out check
      if(duration.asHours() <= 1){
        clearInterval(duration);
        return 0;
        // window.location.reload(true); 
      }
      //Otherwise
      duration = moment.duration(duration.asSeconds() - 1, 'seconds');
       var time=`<div>`+duration.days()+` <span>Days</span></div>
        <div>`+duration.hours()+` <span>Hours</span></div>
        <div>`+duration.minutes()+` <span>Min</span></div>
        <div>`+duration.seconds()+` <span>Sec</span></div>`;
        // console.log('eventTime',eventTime);

        // console.log(time);
      currentelem.find('.countdown').html(time);


    }, interval);
  });
    }

 $(document).on('click','.tag ',function(){
  
  var val=$(this).attr("data-val");
  // alert(val);
  $(this).remove();
  
  $('select option:contains("'+val+'")').removeAttr('selected');
  // $('.ss-value-text:contains("'+val+'")').parents('.ss-value').remove();
  $('.ss-value-text:contains("'+val+'")').parents('.ss-value').find('.ss-value-delete').click()

 });



         timecounter();


function filter(){

   $('.spinner').removeClass('d-none');

   $('.filter_div').addClass('d-none');

   $('.filter-fields').addClass('d-none');

    var formdata=$("#filter_form").serialize();

    var lang=$('input[name=lang]').val();
                    $('.filter-fields').addClass('d-none');

 

    console.log('Form ',lang);

     $.ajax({

                type: "post",

                url: "/"+lang+"/multiplefilter",

                data:formdata,

                dataType:'json',

                success: function(data) {

                  console.log(data.status);


                   $('.filter_div').html('');

                   $('.filter_div').html(data.response);
                   $('.tags_div').html(data.tags);

                    $('.label-green').popover();
                   if(data.offset == 0){
                   $('.links').html(data.link);
                   $('.pag1').addClass('active');
                   }
                    if(data.status == 0){
                    $('.filter-fields').addClass('d-none');
                   }
                   else{
                    $('.filter-fields').removeClass('d-none');
                     timecounter();
                   }


                   $('.spinner').addClass('d-none');
                    $('html, body').animate({scrollTop:(100)}, '1000');
                     
                    $('.filter_div').removeClass('d-none');

                    if(data.pagination==1)
                    {
                       $('.pagination.pointer.link1').click();
                    }
                    
                }

            });



}



$('.thumbnail').on('click', function() {

  var clicked = $(this);

  var newSelection = clicked.data('big');

  var $img = $('.product-image').attr("src", newSelection);

  clicked.parent().find('.thumbnail').removeClass('selected');

  clicked.addClass('selected');

  $('.product-image').empty().append($img.hide().fadeIn('fast'));

});



$(".lightgallery").lightGallery();



// new SlimSelect({

//   select: '.slim-select',

//   select: '.slim-select-2'

// });





$('.calc-input button').click(function(e){

    e.preventDefault();

        var button_classes, value = +$('.counter').val();

        button_classes = $(e.currentTarget).prop('class');        

        if(button_classes.indexOf('up_count') !== -1){

            value = (value) + 1;            

        } else {

            value = (value) - 1;            

        }

        value = value < 0 ? 0 : value;

        $('.counter').val(value);

    });  

    $('.counter').click(function(){

        $(this).focus().select();

    });











// // initialize

// telInput.intlTelInput({

//     initialCountry: 'auto',

//     preferredCountries: ['us','gb','br','ru','cn','es','it'],

//     autoPlaceholder: 'aggressive',

//     utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/js/utils.js",

//     geoIpLookup: function(callback) {

//         fetch('https://ipinfo.io/json', {

//             cache: 'reload'

//         }).then(response => {

//             if ( response.ok ) {

//                  return response.json()

//             }

//             throw new Error('Failed: ' + response.status)

//         }).then(ipjson => {

//             callback(ipjson.country)

//         }).catch(e => {

//             callback('us')

//         })

//     }

// })



let telInput = $("#phone1")



// initialize

telInput.intlTelInput({

    initialCountry: 'by',

    preferredCountries: ['ru','by','us','br','cn','es','it'],

    autoPlaceholder: 'aggressive',

    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/js/utils.js"

})



let telInput2 = $("#phone2")



telInput2.intlTelInput({

    initialCountry: 'by',

    preferredCountries: ['ru','by','us','br','cn','es','it'],

    autoPlaceholder: 'aggressive',

    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/js/utils.js"

})





var drop = $("input");

drop.on('dragenter', function (e) {

  $(".drop").css({

    "border": "4px dashed #09f",

    "background": "rgba(0, 153, 255, .05)"

  });

  $(".cont").css({

    "color": "#09f"

  });

}).on('dragleave dragend mouseout drop', function (e) {

  $(".drop").css({

    "border": "3px dashed #DADFE3",

    "background": "transparent"

  });

  $(".cont").css({

    "color": "#8E99A5"

  });

});





function handleFileSelect(evt) {

  var files = evt.target.files; // FileList object



  // Loop through the FileList and render image files as thumbnails.

  for (var i = 0, f; f = files[i]; i++) {



    // Only process image files.

    if (!f.type.match('image.*')) {

      continue;

    }



    var reader = new FileReader();



    // Closure to capture the file information.

    reader.onload = (function(theFile) {

      return function(e) {

        // Render thumbnail.

        var span = document.createElement('span');

        span.innerHTML = ['<img class="thumb" src="', e.target.result,

                          '" title="', escape(theFile.name), '"/>'].join('');

        document.getElementById('list').insertBefore(span, null);

      };

    })(f);



    // Read in the image file as a data URL.

    reader.readAsDataURL(f);

  }

}



$('#files').change(handleFileSelect);











//new js













});

