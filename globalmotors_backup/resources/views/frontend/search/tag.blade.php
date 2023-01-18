<div class="row">
						<div class="col-md-12">
							<div class="catalog-tag">
								{{-- <a href="javascript:void(0)" data-val="COPART" class="tag">COPART<i class="fal fa-times"></i></a>
								<a href="javascript:void(0)" data-val="IAAI" class="tag">IAAI<i class="fal fa-times"></i></a> --}}
                                
                                @if (isset($data['brand']) && !empty($data['brand']))
								@foreach ($data['brand'] as $brand)
									{{-- expr --}}
								<a href="javascript:void(0)" data-val="{{$brand}}" class="tag">{{$brand}}<i class="fal fa-times"></i></a>
								@endforeach
								
								@endif

								@if (isset($data['type']) && !empty($data['type']))
								@foreach ($data['type'] as $element)
									{{-- expr --}}
								<a href="javascript:void(0)" data-val="{{$element}}" class="tag">{{$element}}<i class="fal fa-times"></i></a>
								@endforeach
								
								@endif

								@if (isset($data['makename']) && !empty($data['makename']))
								@foreach ($data['makename'] as $makename)
									{{-- expr --}}
								<a href="javascript:void(0)" data-val="{{$makename->name}}" class="tag">{{$makename->name}}<i class="fal fa-times"></i></a>
								@endforeach
								
								@endif

								@if (isset($data['modelname']) && !empty($data['modelname']))
								@foreach ($data['modelname'] as $modelname)
									{{-- expr --}}
								<a href="javascript:void(0)" data-val="{{$modelname->name}}" class="tag">{{$modelname->name}}<i class="fal fa-times"></i></a>
								@endforeach
								
								@endif

								@if (isset($data['fuel_type']) && !empty($data['fuel_type']))
								@foreach ($data['fuel_type'] as $fuel_type)
									{{-- expr --}}
								<a href="javascript:void(0)" data-val="{{$fuel_type}}" class="tag">{{$fuel_type}}<i class="fal fa-times"></i></a>
								@endforeach
								
								@endif

								@if (isset($data['transmission']) && !empty($data['transmission']))
								@foreach ($data['transmission'] as $transmission)
									{{-- expr --}}
								<a href="javascript:void(0)" data-val="{{$transmission}}" class="tag">{{$transmission}}<i class="fal fa-times"></i></a>
								@endforeach
								
								@endif

								@if (isset($data['document_type']) && !empty($data['document_type']))
								@foreach ($data['document_type'] as $document_type)
									{{-- expr --}}
								<a href="javascript:void(0)" data-val="{{$document_type}}" class="tag">{{$document_type}}<i class="fal fa-times"></i></a>
								@endforeach
								
								@endif

								@if (isset($data['damage']) && !empty($data['damage']))
								@foreach ($data['damage'] as $damage)
									{{-- expr --}}
								<a href="javascript:void(0)" data-val="{{$damage}}" class="tag">{{$damage}}<i class="fal fa-times"></i></a>
								@endforeach
								
								@endif

								@if (isset($data['body_type']) && !empty($data['body_type']))
								@foreach ($data['body_type'] as $body_type)
									{{-- expr --}}
								<a href="javascript:void(0)" data-val="{{$body_type}}" class="tag">{{$body_type}}<i class="fal fa-times"></i></a>
								@endforeach
								
								@endif
								@if ( (isset($data['type']) && !empty($data['type'])) || (isset($data['modelname']) && !empty($data['modelname'])) || (isset($data['fuel_type']) && !empty($data['fuel_type'])) )
									{{-- expr --}}
                                 <a href="{{url(app()->getLocale().'/lotsearch')}}" >Reset All<i class="fal fa-times"></i></a>
								@endif

								{{-- <a href="" class="show_more">5+<i class="fal fa-chevron-down"></i></a> --}}
							</div>
						</div>
</div>