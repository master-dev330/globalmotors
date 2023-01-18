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

                                </div>

                                <div class="card-datatable p-2">

                                    <form action="{{url(app()->getLocale().'/admin/savedeposit')}}" class="" id="form_submit" method="post">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Transction No</label>
                                                    <input type="text" name="transaction_no" class="form-control" value="{{(isset($data['results']->transaction_no) ? $data['results']->transaction_no : '')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>User Name</label>
                                                    <select name="user_id" class="form-control" data-option-id="{{(isset($data['results']->user_id) ? $data['results']->user_id : '')}}">
                                                        <option>Select User</option>
                                                        @foreach($data['user'] as $key=>$value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Payment Method</label>
                                                    <input type="text" name="payment_method" class="form-control" value="{{(isset($data['results']->payment_method) ? $data['results']->payment_method : '')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Amount</label>
                                                    <input type="text" name="amount" class="form-control" value="{{(isset($data['results']->amount) ? $data['results']->amount : '')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control" name="status" data-option-id="{{(isset($data['results']->status) ? $data['results']->status : '')}}">
                                                        <option value="">Select</option>
                                                        <option value="Paid">Paid</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Approved">Approved</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="id" value="{{(isset($data['results']->id) ? $data['results']->id : '')}}">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

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

        $(document).ready(function() {

            $('.dynamic_table').DataTable();

            $('.dynamic_table').on( 'draw.dt', function () {
                feather.replace();
            });

            $('select[data-option-id]').each(function () {

                $(this).val($(this).data('option-id'));

            });
            // $('.usermgt').addClass('sidebar-group-active');

            $('.deposit').addClass('active');


        });

    </script>

@endsection

