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

                                    <h4 class="card-title">@lang('deposit.View_Return_deposits')</h4>

                                </div>

                                <div class="card-datatable p-2">

                                    <table class="table dynamic_table font-weight-bold">

                                        <thead>

                                             <tr role="row">

		                                        <th>@lang('deposit.sr_no')</th>

		                                         <th>@lang('deposit.amount')</th>

                                                 <th>@lang('deposit.Reason')</th>

		                                        <th>@lang('deposit.status')</th>

		                                        <th>@lang('deposit.action')</th>

                                   			 </tr>

                                        </thead>

                                        <tbody>

                                           @foreach($data['results'] as $key=>$value)

                                   		 <tr>

                                        <td> {{$key+1}}</td>

                                        <td>{{$value->amount}}</td>

                                        <td>{{Str::words(strip_tags($value->reason), 15) }}</td>

                                        <td> @if($value->status=="Pending")
                                                <span data-id="{{$value->id}}" data-deposit-id="{{$value->deposit_id}}" data-status="{{$value->status=='Pending' ? 'Approved' : 'Pending'}}" class="badge adge-pill badge-light-warning btnstatus pointerclass">{{$value->status }}</span>
                                                  @elseif($value->status=="Approved")
                                                  <span data-id="{{$value->id}}" data-deposit-id="{{$value->deposit_id}}" data-status="{{$value->status=='Pending' ? 'Approved' : 'Pending'}}"  class="badge adge-pill badge-light-success btnstatus pointerclass">{{$value->status }}</span>
                                                 @endif
                                             </td>
                                             <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if($value->status=="Pending")
                                                    <a data-href="{{url(app()->getLocale().'/admin/deletereturndeposit/'.$value->id)}}" data-toggle="modal" class="dropdown-item btnstatus" data-deposit-id="{{$value->deposit_id}}" data-status="Approved" data-id="{{$value->id}}" href="javascript:void(0);">
                                                        <i data-feather="dollar-sign" class="mr-50"></i>
                                                        <span>@lang('deposit.Approved')</span>
                                                    </a>
                                                     @elseif($value->status=="Approved")
                                                        <a data-href="{{url(app()->getLocale().'/admin/deletereturndeposit/'.$value->id)}}" data-deposit-id="{{$value->deposit_id}}" data-toggle="modal" class="dropdown-item btnstatus" data-status="Pending" data-id="{{$value->id}}" href="javascript:void(0);">
                                                        <i data-feather="trending-up" class="mr-50"></i>
                                                        <span>@lang('deposit.Pending')</span>
                                                    </a>
                                                    @endif
                                                    <a data-href="{{url(app()->getLocale().'/admin/deletereturndeposit/'.$value->id)}}"  data-toggle="modal" data-target="#confirm-delete" class="dropdown-item" href="javascript:void(0);">
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

            $('.returndeposit').addClass('active');

            $(document).on('click','.btnstatus',function () {

                var id=$(this).attr('data-id');

                var deposit_id=$(this).attr('data-deposit-id');

                var status=$(this).attr('data-status');

                var formdata={'id':id,'status':status,'deposit_id':deposit_id};
                 
                var token = $('input[name=_token]').val();

                var current=$(this);

                Swal.fire({

                    title: 'Are you sure?',

                    text: "You want to update the deposit status?",

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonText: 'Yes, confirm it!',

                    customClass: {

                        confirmButton: 'btn btn-primary',

                        cancelButton: 'btn btn-outline-danger ml-1'

                    },

                    buttonsStyling: false

                }).then(function (result) {

                    if (result.value) {

                        $.ajax({

                            type:'POST',

                            headers: {'X-CSRF-TOKEN': token},

                            dataType:'json',

                            data:formdata,

                            url: '{{url(app()->getLocale().'/admin/returndepositstatus')}}',

                            success: function(response){

                                current.attr('data-status',status);

                                if(response.status==1){

                                    if(status=='Approved'){

                                        current.attr('data-status','Pending');

                                        current.removeClass('badge-light-warning');

                                        current.addClass('badge-light-primary');
                                        location.reload();
                                        

                                    }else if(status=='Pending'){

                                        current.attr('data-status','Approved');

                                        current.removeClass('badge-light-primary');

                                        current.addClass('badge-light-warning');
                                        location.reload();


                                    }
                                    current.html(status);

                                    Swal.fire({

                                        icon: 'success',

                                        title: 'Updated!',

                                        text: 'User status has been updated.',

                                        customClass: {

                                            confirmButton: 'btn btn-success'

                                        }

                                    });

                                }

                            }

                        });



                    }

                });

            });

            $(document).on('click','.purchased',function () {

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

        });

    </script>

@endsection

