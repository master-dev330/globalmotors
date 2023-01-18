@extends('layout.header')
@section('css')


<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/plugins/forms/form-validation.css')}}">
@endsection
@section('breadcrumb')
    <h2 class="content-header-title float-left mb-0">Parser Management</h2>
    <div class="breadcrumb-wrapper">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/admin/home')}}">Parser</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{$data['page_title']}}</a>
            </li>
        </ol>
    </div>
@endsection
@section('content')
    <div class="content-body">
    <section id="basic-input">
                            <div class="card">
                                <div class="card-body">
                                           <form action="{{ url(app()->getLocale().'/admin/manualparser') }}" class="" id="form_submit" method="post">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                       <div class="col-md-3">
                                                            <div class="form-group m-form__group">
                                                                <label>Year</label>
                                                                <select name="year" class="form-control" >
                                                                    <option value="">Select</option>
                                                                      @foreach(range(date('Y'), date('Y')-50) as $y)
                                                                    <option value="{{$y}}">{{$y}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-3">
                                                            <div class="form-group m-form__group">
                                                                <label>Type</label>
                                                                <select name="type" class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option >iaai</option>
                                                                    <option >copart</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    <div class="col-md-3 col-12">

                                                        <div class="form-group">

                                                            <label>@lang('lot.vechile_type')</label>

                                                            <select class="form-control" name="vehicle_type" data-option-id="{{(isset($data['results']->vehicle_type) ? $data['results']->vehicle_type : '')}}" required>

                                                                <option value="">Select</option>

                                                                <option value="AM">Automobile</option>

                                                                <option value="ATV">ATV</option>

                                                                <option value="BT">Boat</option>

                                                                <option value="BUS">Bus, minibus</option>

                                                                <option value="IEQ">Industrial equipment</option>

                                                                <option value="JSK"> Jet ski</option>

                                                                <option value="MC">Motorcycle</option>
 
                                                                <option value="RVE">Recreational vehicle</option>

                                                                <option value="SNM">Snowmobile</option>

                                                                <option value="TL">Trailer</option>

                                                                <option value="TR">Truck</option>

                                                                <option value="OTR">Other</option>

                                                            </select>

                                                        </div>

                                                    </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group m-form__group">
                                                                <label>Page</label>
                                                                <select name="page" class="form-control">
                                                                    <option value="">Select</option>
                                                                    @for ($i = 1; $i <=50 ; $i++)
                                                                    <option value="{{$i}}">{{$i}}</option>
                                                                    @endfor

                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                            <input class="form-control" name="id" type="hidden" value="">
                                               <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1"> @lang('roles.save_change')</button>
                                               <a href="{{url(app()->getLocale().'/admin/roles')}}" class="btn btn-outline-secondary">@lang('roles.back')</a>
                                            </input>
                                            </input>
                                        </form>
                                </div>
                            </div>


 </section>
</div>
@endsection
@section('js')

    <script src="{{asset('/app-assets/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        $('.usermgt').addClass('sidebar-group-active');
        $('.parser').addClass('active');
        $('#form_submit').validate({
            rules: {
                'year': {
                    required: true
                },
                'type': {
                    required: true
                },
                'page': {
                    required: true
                },
            }
        });
    </script>
    @endsection
