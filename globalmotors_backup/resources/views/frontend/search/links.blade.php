						  @php
				              $total_record=$data['total'];
				              $perpage=$data['per_page'];
				              $totla_link=round($total_record/$perpage);
							  $dots = false;
				              @endphp
							<div class="catalog-paginate">
								@if ($totla_link>=1)

								<ul>
									<li><a class="fal fa-angle-left previous" ></a></li>
									@for($i=1; $i<=$totla_link; $i++)
								{{-- 	<li class="pag{{$i}} paglinks" ><a class="pagination pointer link{{$i}} {{$i==1?'linkfocus':'';}}" data-page='{{$i}}' data-class="pag{{$i}}">{{$i}}</a></li> --}}
									@if ($i <= 4 || $i==$totla_link)  
						                 <li class="pag{{$i}} paglinks" ><a class="pagination pointer link{{$i}} {{$i==1?'linkfocus':'';}}" data-page='{{$i}}' data-class="pag{{$i}}"> {{$i}}</a></li>
						                    @php
						                    $dots = true;	
						                    @endphp
						                @elseif ($dots) 
						                    <li class="middledots"><a>&hellip;</a></li>
						                    @php
						                    $dots = false;	
						                    @endphp
						               @endif
                                    @endfor
                                      
                                    {{csrf_field()}}
									<li><a  class="fal fa-angle-right next" id="button_next"></a></li>
								</ul>
								@endif
								
								
							</div>
