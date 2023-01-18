@extends('layout.header')

@section('css')

<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/colors.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">



<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">



@endsection

@section('content')

    {{ csrf_field() }}

    <section id="basic-datatable">

                    <div class="row">

                        <div class="col-12">

                            <div class="card">

                                <div class="card-header border-bottom">

                                    <h4 class="card-title">@lang('bids.bids')</h4>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="filter_bids" style="padding: 20px 20px;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Start Date</label>
                                                        <input type="date" class="form-control " id="start-date" name="startdate" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>End Date</label>
                                                        <input type="date" class="form-control" id="end-date" name="enddate" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Filter</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-datatable p-2">

                                    <table class="table dynamic_table  font-weight-bold filter_bids">

                                        <thead>

                                             <tr role="row">

		                                        <th>@lang('bids.sr_no')</th>

		                                        <th>@lang('bids.lot_number')</th>

		                                        <th>@lang('bids.auction')</th>

		                                        <th>@lang('bids.user_name')</th>

		                                        <th>@lang('bids.minimum_price')</th>

                                                <th>@lang('bids.bid_amount')</th>

                                                <th>@lang('bids.status')</th>

		                                        <th>@lang('bids.action')</th>

                                   			 </tr>

                                        </thead>

                                        <tbody>

                                           @foreach($data['results'] as $key=>$value)

                                   		 <tr>

                                            <td> {{$key+1}}</td>

                                            <td>{{isset($value->lotname->lot_no)?$value->lotname->lot_no:''}}</td>

                                            <td>{{isset($value->auction->title)?$value->auction->title:''}}</td>

                                            <td>{{isset($value->user->name) ? $value->user->name : ''}}</td>

                                            <td>{{$value->min_price}}</td>

                                            <td>{{$value->bid_amount}}</td>

                                            <td>

                                                 @if($value->status=="Approved")

                                                    <span class="badge badge-pill badge-light-primary mr-1 pointer btnstatus">{{$value->status}}</span>

                                                 @elseif($value->status=="Rejected")

                                                    <span class="badge badge-pill badge-light-danger mr-1 pointer btnstatus">{{$value->status}}</span>
                                                 @elseif($value->status=="Pending")

                                                    <span class="badge badge-pill badge-light-warning mr-1 pointer btnstatus">{{$value->status}}</span>

                                                 @endif

                                             </td>

                                             <td>

                                            <div class="dropdown">

                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">

                                                    <i data-feather="more-vertical"></i>

                                                </button>
                                               
                                                <div class="dropdown-menu">
                                                    @if($value->status!="Approved")
                                                    <a data-id="{{$value->id}}" data-user_id={{$value->user_id}} data-lot_id="{{$value->lot_id}}" data-status="Approved" data-toggle="modal" data-target="#confirm-approve" id="approved-status-btn"  class="dropdown-item">

                                                        <i data-feather="check" class="mr-50"></i>
                                
                                                        <span>@lang('bids.approve_bids')</span>

                                
                                                        </a>
                                                    @endif
                                                    @if($value->status!="Pending")
                                                     <a data-href="{{url(app()->getLocale().'/admin/prndingbid/'.$value->id)}}"   data-toggle="modal" data-target="#confirm-save" class="dropdown-item" href="javascript:void(0);">

                                                        <i data-feather="check" class="mr-50"></i>

                                                        <span>@lang('bids.pending_bids')</span>

                                                    </a>
                                                    @endif
                                                    @if($value->status!="Rejected")
                                                    <a data-id="{{$value->id}}" data-user_id={{$value->user_id}} data-lot_id="{{$value->lot_id}}" data-status="Rejected" data-toggle="modal" data-target="#confirm-reject" id="rejected-status-btn" class="dropdown-item">
                                                        <i data-feather="check" class="mr-50"></i>
                                                        <span>@lang('users.Rejected')</span>
                                                    </a>
                                                    @endif
                                                    <a data-href="{{url(app()->getLocale().'/admin/deletebid/'.$value->id)}}"   data-toggle="modal" data-target="#confirm-delete" class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="trash" class="mr-50"></i>
                                                        <span>@lang('users.delete')</span>
                                                     </a>
                                                    @if ($value->status=='Approved')

                                                     <a class="d-none" href="{{url(app()->getLocale().'/admin/makeinvoice/'.$value->id)}}" class="dropdown-item" >

                                                        <i data-feather="file-text" class="mr-50"></i>

                                                        <span>@lang('bids.make_invoice')</span>

                                                    </a>

                                                    @endif



                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                    @endforeach



                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>
          <div class="modal fade" id="confirm-approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">

                    <div class="modal-dialog" role="document">
                
                        <div class="modal-content">
                           
                            <div class="modal-header">
                
                                <h5 class="modal-title" id="exampleModalLabel">Confirm Save</h5>
                
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                
                                    <span aria-hidden="true">×</span>
                
                                </button>
                
                            </div>
                
                        <div class="modal-body">
                            <form action="{{url(app()->getLocale().'/admin/bidstatus')}}" method="post">
                               {{ csrf_field() }}
                                <input class="form-control" name="id" type="hidden" value="">
                                <input class="form-control" name="lot_id" type="hidden" value="">
                                <input class="form-control" name="user_id" type="hidden" value="">


                                <input type="hidden" name="status" value="">

                                <div class="row">
                                    <div class="col-md-12">
            
                                        <div class="form-group m-form__group">
            
                                        <label>Add Email Details</label>
            
                                        <textarea type="text" name="details" rows="5" class="form-control m-input m-input--square"></textarea>
            
                                        </div>
            
                                    </div>
                            </div>
                            <div class="modal-footer">
                
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
                                <button type="Submit" class="btn btn-primary">Confrim</button>
                
                            </div>
                            </form>
                            </div>
                
                
                        </div>
                
                    </div>
                
                </div>
    <div class="modal fade" id="confirm-reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: red !important">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Save</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="rejected-form" method="post">
                       {{ csrf_field() }}
                        <input class="form-control" name="id" type="hidden" value="">
                        <input class="form-control" name="lot_id" type="hidden" value="">
                        <input class="form-control" name="user_id" type="hidden" value="">
                        <input type="hidden" name="status" value="">
                        <div class="row">
                            <div class="col-md-12">
    
                                <div class="form-group m-form__group">
    
                                <label>Add Email Details</label>
    
                                <textarea type="text" name="details" rows="5" class="form-control m-input m-input--square"></textarea>
    
                                </div>
    
                            </div>
                    </div>
                    <div class="modal-footer">
        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
                        <button type="Submit" class="btn btn-primary">Confrim</button>
        
                    </div>
                    </form>
                    </div>
        
        
                </div>

            </div>
        </div>
    </div>
 @include('includes.delete')
 @include('includes.save')

@endsection

@section('js')

<script src="{{asset('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>



<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}">



    <script type="text/javascript">
   
        $(document).ready(function() {

            $('.dynamic_table').DataTable();
            $('.dynamic_table').on( 'draw.dt', function () {
                feather.replace();
            });

            // $('.cars').addClass('sidebar-group-active');

            $('.bids').addClass('active');

            $(document).on('submit','#filter_bids',function (e) {

                e.preventDefault();
                var token = $('input[name=_token]').val();
                var formdata = $(this).serialize();

                $.ajax({

                        type:'POST',

                        headers: {'X-CSRF-TOKEN': token},

                        dataType:'json',

                        data:formdata,

                        url: '{{url(app()->getLocale().'/admin/filter_bids')}}',

                        success: function(data){

                            $('.filter_bids').html(data.response);

                        }

                    });

            });

     $(document).on("click","#approved-status-btn",function(){
		var bid_id = $(this).attr('data-id');
		$("input[name=id]").val(bid_id);
        var lot_id = $(this).attr('data-lot_id');
		$("input[name=lot_id]").val(lot_id);
        var user_id = $(this).attr('data-user_id');
		$("input[name=user_id]").val(user_id);
        var bid_status = $(this).attr('data-status');
		$("input[name=status]").val(bid_status);
	});
    $(document).on("click","#rejected-status-btn",function(){
		var bid_id = $(this).attr('data-id');
		$("input[name=id]").val(bid_id);
        var lot_id = $(this).attr('data-lot_id');
		$("input[name=lot_id]").val(lot_id);
        var user_id = $(this).attr('data-user_id');
		$("input[name=user_id]").val(user_id);
        var bid_status = $(this).attr('data-status');
		$("input[name=status]").val(bid_status);
	});
    $(document).on("submit","#rejected-form",function(e){
		e.preventDefault();
		var _token = $("input[name=_token]").val();
		var formdata=$('#rejected-form').serialize();
        console.log('reject bid',formdata);
		$.ajax({
			type: "post",
			url:"{{url(app()->getLocale().'/admin/bidstatus')}}",
			data:formdata,
			success: function(data) {
			$('#confirm-reject').modal('hide');
            window.location.reload();
			}
		});
	});
});

 
    </script>

@endsection

