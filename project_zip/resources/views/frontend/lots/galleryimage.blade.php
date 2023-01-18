
  <p class="imglist" >
  <a data-fancybox-trigger="preview" href="javascript:;">
    <img src="{{url($data['lot']->feature_image)}}" height="500px" width="724px" />
  </a>
@foreach($data['lot_images'] as $key=>$value)
  <a href="{{url($value->images)}}" data-fancybox="preview" data-width="1500" data-height="1000">
    <img src="{{url($value->images)}}" height="100px" width="100px" />
  </a>
 @endforeach
</a>


  <script type="text/javascript">
    // Fancybox Config
$('[data-fancybox="gallery"]').fancybox({
  buttons: [
    "slideShow",
    "thumbs",
    "zoom",
    "fullScreen",
    "share",
    "close"
  ],
  loop: false,
  protect: true
});

  </script>

