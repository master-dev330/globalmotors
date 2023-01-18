@extends('layout.header')

@section('css')

<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<style>
.table-responsive {
    display: table !important;
}
</style>
@endsection

@section('content')

                <section id="basic-datatable">

                    <div class="row">

                        <div class="col-12">

                            <div class="card">

                                <div class="card-header border-bottom">

                                    <h4 class="card-title">@lang('ground_shipping.ground_shipping')</h4>

                                    <a class="btn btn-primary" href="{{url(app()->getLocale().'/admin/addground_shipping')}}">@lang('ground_shipping.add_ground_shipping')</a>

                                </div>

                                <div class="card-datatable p-2">

                                    <table class="table dynamic_table  font-weight-bold table-responsive">

                                        <thead>

                                            <tr>
                                              <th>@lang('ground_shipping.sr_no')</th>
                                              <th>@lang('ground_shipping.name')</th>
                                              <th>@lang('ground_shipping.fee')</th>
                                              <th>@lang('ground_shipping.action')</th>
                                            </tr>

                                        </thead>

                                       <tbody>
                                            @foreach($data['results'] as $key=>$row)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$row->name}}</td>
                                                <td>{{$row->fee}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{url(app()->getLocale().'/admin/addground_shipping/'.$row->id)}}">
                                                                <i data-feather="edit-2" class="mr-50"></i>
                                                                <span>@lang('ground_shipping.edit')</span>
                                                            </a>
                                                            <a data-href="{{url(app()->getLocale().'/admin/deletegroundshipping/'.$row->id)}}"  data-toggle="modal" data-target="#confirm-delete" class="dropdown-item" href="javascript:void(0);">
                                                                <i data-feather="trash" class="mr-50"></i>
                                                                <span>@lang('ground_shipping.delete')</span>
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

@include('includes.delete')

@endsection

@section('js')

<script src="{{asset('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('.groundshipmgt').addClass('sidebar-group-active');

        $('.ground_shipping').addClass('active');

        $('.dynamic_table').DataTable();

        $('.dynamic_table').on( 'draw.dt', function () {
            feather.replace();
        });

    });

</script>



@endsection

