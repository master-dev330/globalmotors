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

                                    <h4 class="card-title">@lang('deposit.deposit')</h4>

                                    <a class="btn btn-primary d-none" href="{{url(app()->getLocale().'/admin/user')}}">@lang('deposit.add_user')</a>

                                </div>

                                <div class="card-datatable p-2">

                                    <table class="table dynamic_table font-weight-bold">

                                        <thead>

                                             <tr role="row">

		                                        <th>@lang('deposit.sr_no')</th>

		                                        <th>@lang('deposit.transction_no')</th>

                                                <th>Date & Time</th>

		                                         <th>@lang('deposit.user_name')</th>

                                                 <th>@lang('deposit.payment_method')</th>

		                                         <th>@lang('deposit.amount')</th>

		                                        <th>@lang('deposit.status')</th>

		                                        <th>@lang('deposit.action')</th>

                                   			 </tr>

                                        </thead>

                                        <tbody>

                                           @foreach($data['results'] as $key=>$value)

                                   		 <tr>

                                        <td> {{$key+1}}</td>

                                        <td><a href="{{$value->transaction_no}}">{{$value->transaction_no}}</td>

                                        <td><?=date("d, m, Y",strtotime($value->created_at));?></td>

                                        <td>{{$value->user->name}}</td>

                                        <td>{{$value->payment_method}}</td>

                                        <td>${{isset($value->amount) ? $value->amount : ''}}</td>

                                             <td> @if($value->status=="Pending")

                                                <span class="badge adge-pill badge-light-warning btnstatus pointerclass">{{$value->status }}</span>

                                                  @elseif($value->status=="Paid")
                                                  <span class="badge adge-pill badge-light-success btnstatus pointerclass">{{$value->status }}</span>
                                                 @elseif($value->status=="Cancel")
                                                 <span  class="badge adge-pill badge-light-danger btnstatus pointerclass">{{$value->status}}</span>
                                                 @endif
                                             </td>
                                             <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{url(app()->getLocale().'/admin/depositdetail/'.$value->id)}}">
                                                        <i data-feather="file-text" class="mr-50"></i>
                                                        <span>@lang('deposit.detail')</span>
                                                    </a>
                                                    <a class="dropdown-item" href="{{url(app()->getLocale().'/admin/depositedit/'.$value->id)}}">
                                                        <i data-feather="edit" class="mr-50"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                    @if($value->status=="Pending")
                                                    <a id="rejected-status-btn" data-amount={{$value->amount}} data-id={{$value->id}} data-user_id={{$value->user_id}} data-status="Cancel" data-target="#confirm-reject" data-toggle="modal"  data-href="{{url(app()->getLocale().'/admin/deletedeposit/'.$value->id)}}" data-toggle="modal" class="dropdown-item btnstatus" data-status="Cancel" data-id="{{$value->id}}" href="javascript:void(0);">
                                                        <i data-feather="x" class="mr-50"></i>
                                                        <span>Cancel</span>
                                                    </a>
                                                    <a id="approved-status-btn" data-amount={{$value->amount}} data-id={{$value->id}} data-user_id={{$value->user_id}} data-status="Paid" data-toggle="modal" data-target="#confirm-approve"  data-href="{{url(app()->getLocale().'/admin/deletedeposit/'.$value->id)}}" data-toggle="modal" class="dropdown-item btnstatus" data-status="Paid" data-id="{{$value->id}}" href="javascript:void(0);">
                                                        <i data-feather="dollar-sign" class="mr-50"></i>
                                                        <span>Paid</span>
                                                    </a>
                                                     @elseif($value->status=="Paid")
                                                      <a id="rejected-status-btn" data-amount={{$value->amount}} data-id={{$value->id}} data-user_id={{$value->user_id}} data-status="Cancel"  data-target="#confirm-reject" data-toggle="modal" data-href="{{url(app()->getLocale().'/admin/deletedeposit/'.$value->id)}}" data-toggle="modal" class="dropdown-item btnstatus" data-status="Cancel" data-id="{{$value->id}}" href="javascript:void(0);">
                                                        <i data-feather="x" class="mr-50"></i>
                                                        <span>Cancel</span>
                                                    </a>
                                                        <a id="pending-status-btn" data-id={{$value->id}} data-toggle="modal" data-status="Pending"  data-target="#confirm-approve" data-href="{{url(app()->getLocale().'/admin/deletedeposit/'.$value->id)}}" data-toggle="modal" class="dropdown-item btnstatus" data-status="Pending" data-id="{{$value->id}}" href="javascript:void(0);">
                                                        <i data-feather="trending-up" class="mr-50"></i>
                                                        <span>Pending</span>
                                                    </a>
                                                    @elseif($value->status=="Cancel")
                                                     <a id="pending-status-btn" data-id={{$value->id}} data-toggle="modal" ata-status="Pending" data-target="#confirm-approve" data-href="{{url(app()->getLocale().'/admin/deletedeposit/'.$value->id)}}" data-toggle="modal" class="dropdown-item btnstatus" data-status="Pending" data-id="{{$value->id}}" href="javascript:void(0);">
                                                        <i data-feather="trending-up" class="mr-50"></i>
                                                        <span>Pending</span>
                                                    </a>
                                                     <a id="approved-status-btn" data-amount={{$value->amount}} data-id={{$value->id}} data-user_id={{$value->user_id}} data-status="Paid" data-toggle="modal" data-target="#confirm-approve"  data-href="{{url(app()->getLocale().'/admin/deletedeposit/'.$value->id)}}" data-toggle="modal" class="dropdown-item btnstatus" data-status="Paid" data-id="{{$value->id}}" href="javascript:void(0);">
                                                        <i data-feather="dollar-sign" class="mr-50"></i>
                                                        <span>Paid</span>
                                                    </a>
                                                    @endif
                                                    <a data-href="{{url(app()->getLocale().'/admin/deletedeposit/'.$value->id)}}"   data-toggle="modal" data-target="#confirm-delete" class="dropdown-item" href="javascript:void(0);">
                                                        <i data-feather="trash" class="mr-50"></i>
                                                        <span>@lang('deposit.delete')</span>
                                                    </a>
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
                            <form action="{{url(app()->getLocale().'/admin/depositstatus')}}" method="post">
                               {{ csrf_field() }}
                                <input class="form-control" name="id" type="hidden" value="">
                                <input class="form-control" name="amount" type="hidden" value="">
                                <input type="hidden" name="status" value="">

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
                    <form action="{{url(app()->getLocale().'/admin/depositstatus')}}" id="rejected-form" method="post">
                       {{ csrf_field() }}
                       <input class="form-control" name="id" type="hidden" value="">
                                <input class="form-control" name="amount" type="hidden" value="">
                                <input type="hidden" name="status" value="">
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

     <div class="modal right fade" id="purchased" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">@lang('deposit.purchased_history')<span class="modal-title"></span> </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">@lang('deposit.cross')</span>

                </button>

            </div>

            <div class="modal-div">

            </div>

        </div>

    </div>

</div>

 @include('includes.delete')

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

            // $('.usermgt').addClass('sidebar-group-active');

            $('.deposit').addClass('active');

            $(document).on('click','#purchased',function () {

                var id =$(this).attr('data-id');

              // alert(id);

                $('#purchased').find('.modal-body').html('<p>Loading...</p>');

            $('#purchased').modal('show');

              $.ajax({

                 type:'get',

                 dataType:'json',

                 url: '{{url(app()->getLocale().'/admin/purchasedhistory')}}/'+id,

                  success: function(data){

                  $('#purchased').find('.modal-div').html(data.response);

                            }

                });

             });
   $(document).on("click","#approved-status-btn",function(){
		var id = $(this).attr('data-id');
		$("input[name=id]").val(id);
        var amount = $(this).attr('data-amount');
		$("input[name=amount]").val(amount);
        var status = $(this).attr('data-status');
		$("input[name=status]").val(status);
	});
    $(document).on("click","#rejected-status-btn",function(){
		var id = $(this).attr('data-id');
		$("input[name=id]").val(id);
        var amount = $(this).attr('data-amount');
		$("input[name=amount]").val(amount);
        var status = $(this).attr('data-status');
		$("input[name=status]").val(status);
	});
    $(document).on("click","#pending-status-btn",function(){
        var id = $(this).attr('data-id');
		$("input[name=id]").val(id);
        var status = $(this).attr('data-status');
		$("input[name=status]").val(status);
	});

        });


    </script>

@endsection

