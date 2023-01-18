<div class="row lotgrid">

    @foreach($data['lot_images'] as $value)

	<div class="col-lg-2 mr-1 images">

		 <button class="btn btn-primary add_photo" data-id="{{isset($value->id) ? $value->id:''}}">

            <i data-feather="edit-2" class="mr-50"></i>

          </button> 

          <a class="btn btn-danger removeimg text-white" data-lot_id="{{isset($value->lot_id) ? $value->lot_id:''}}" data-path="{{isset($value->images) ? $value->images :''}}" data-id="{{isset($value->id) ? $value->id:''}}"   >

            <i data-feather="trash" class="mr-50"></i>

          </a>

		<img src="{{url(isset($value->images)) ? $value->images:''}}" alt="test" width="200px" height="200px">

		 <label> {{isset($value->title) ? $value->title:''}}</label>

	</div>

	@endforeach

</div>