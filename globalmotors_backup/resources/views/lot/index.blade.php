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

                                    <h4 class="card-title">{{$data['page_title']}}</h4>

                                    <a class="btn btn-primary" href="{{url(app()->getLocale().'/admin/lot')}}">@lang('lot.add_lot')</a>

                                </div>

                                <div class="card-datatable p-2">

                                    <table class="table dynamic_table table-responsive font-weight-bold table_resposive">

                                        <thead>

                                             <tr role="row">

                                                <th>@lang('lot.sr_no')</th>


                                                <th>@lang('lot.lot_title')</th>

                                                <th>@lang('lot.color')</th>

                                                <th>@lang('lot.body_style')</th>

                                                <th>@lang('lot.engine_type')</th>

                                                <th>@lang('lot.lot_number')</th>

                                                <th>@lang('lot.vechile_type')</th>

                                                <th>@lang('lot.primary_damage')</th>

                                                <th>@lang('lot.secondary_damage')</th>

                                                <th>@lang('lot.status')</th>

                                                <th>@lang('lot.action')</th>

                                             </tr>

                                        </thead>

                                        <tbody>

                                     


                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

 @include('includes.delete')



@endsection





@section('js')

<script src="{{asset('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>



<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}">



    <script type="text/javascript">
          const url="{{url(app()->getLocale())}}";
        $(document).ready(function() {

            $('.dynamic_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 0, "desc" ]],
                ajax: "{{url(app()->getLocale().'/admin/ajaxlots')}}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'lot_title', name: 'lot_title'},
                    {data: 'color', name: 'color'},
                    {data: 'body_style', name: 'body_style'},
                    {data: 'engine_type', name: 'engine_type'},
                    {data: 'lot_no', name: 'lot_no'},
                    {data: 'vehicle_type', name: 'vehicle_type'},
                    {data: 'primary_damage', name: 'primary_damage'},
                    {data: 'primary_damage', name: 'primary_damage'},
                    {data: function(row){
                        if(row.status=="Approved"){

                         return ' <span data-id="'+row.id+'" data-status="'+row.status+'== Active ? Inactive : Active" class="badge badge-pill badge-light-primary mr-1 pointer ">'+row.status+'</span>'

                        }else if(row.status=="UnApproved"){
                            ' <span data-id="'+row.id+'" data-status="" class="badge badge-pill badge-light-warning mr-1 pointer ">'+row.status+'</span>'

                        }else if(row.status=="Canceled"){
                            ' <span data-id="'+row.id+'" data-status="" class="badge badge-pill badge-light-danger mr-1 pointer ">'+row.status+'</span>'

                        }
                    }, name: 'status'},
                    {data: function(row){
                        return '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown"><i data-feather="more-vertical"></i></button>'+
                            '<div class="dropdown-menu">'+
                            ' <a class="dropdown-item" href="'+url+'/admin/lotdetail/'+row.id+'"><i data-feather="file-text" class="mr-50"></i><span>@lang('lot.detail')</span></a>'+
                             ' <a class="dropdown-item" href="'+url+'/admin/lot/'+row.id+'"><i data-feather="edit-2" class="mr-50"></i><span>@lang('lot.edit')</span></a>'+
                             '<a data-href="'+url+'/admin/deletelot/'+row.id+'"   data-toggle="modal" data-target="#confirm-delete" class="dropdown-item" href="javascript:void(0);">'+
                             ' <i data-feather="trash" class="mr-50"></i>'+
                             '  <span>@lang('lot.delete')</span></a>'
                            +'</div>'+
                            '</div>'
                    }, name: 'action', orderable: false, searchable: false},
                ]
            });
            $('.dynamic_table').on( 'draw.dt', function () {
                feather.replace();
            });
            $('.auctmgt').addClass('sidebar-group-active');

            $('.lot').addClass('active');

            $(document).on('click','.btnstatus',function () {

                var id=$(this).attr('data-id');

                var status=$(this).attr('data-status');

                var formdata={'id':id,'status':status};

                var token = $('input[name=_token]').val();

                var current=$(this);

                Swal.fire({

                    title: 'Are you sure?',

                    text: "You want to update the user status?",

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

                            url: '{{url('admin/userstatus')}}',

                            success: function(response){

                                current.attr('data-status',status);

                                if(response.status==1){

                                    if(status=='Active'){

                                        current.attr('data-status','Inactive');

                                        current.removeClass('badge-light-warning');

                                        current.addClass('badge-light-primary');

                                    }else{

                                        current.attr('data-status','Active');

                                        current.removeClass('badge-light-primary');

                                        current.addClass('badge-light-warning');

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

        });

    </script>

@endsection

