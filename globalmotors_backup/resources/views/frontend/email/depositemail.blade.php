<div class="invoce-document printinvoice ml-auto">

    <h2>@lang('payment.invoice')</h2>

    <div class="">

        @if($data['deposits']->payment_method=='Bank Transfer')

            {{-- expr --}}

        <p><strong>@lang('payment.wire_instruction')</strong></p>

        <table>

            <tr>

                <td><strong>@lang('payment.bank_name')</strong></td>

                <td>{{get_settings()->bank_name}}</td>

            </tr>

            <tr>

                <td><strong>@lang('payment.bank_address')</strong></td>

                <td>{{get_settings()->bank_address}}</td>

            </tr>

            <tr>

                <td><strong>@lang('payment.swift')</strong></td>

                <td>{{get_settings()->swift}}</td>

            </tr>

            <tr>

                <td><strong>@lang('payment.routing')</strong></td>

                <td>{{get_settings()->routing_no}}</td>

            </tr>

            <tr>

                <td><strong>@lang('payment.accounting')</strong></td>

                <td>{{get_settings()->account_no}}</td>

            </tr>

            <tr>

                <td></td>

                <td></td>

            </tr>

            <tr>

                <td><strong>@lang('payment.beneficary_name')</strong></td>

                <td>{{get_settings()->beneficiary_name}}</td>

            </tr>

        </table>

        @elseif($data['deposits']->payment_method=='Credit Card')

        <table>

            <tr>

                <td><strong>@lang('payment.card_number')</strong></td>

                <td>{{$data['deposits']->card_number}}</td>

            </tr>

            <tr>

                <td><strong>@lang('payment.cvc')</strong></td>

                <td>{{$data['deposits']->cvc}}</td>

            </tr>

            <tr>

                <td><strong>@lang('payment.swift')</strong></td>

                <td>{{$data['deposits']->card_expiry}}</td>

            </tr>

            

            <tr>

                <td><strong>@lang('payment.beneficary_name')</strong></td>

                <td>{{Auth::user()->name}}</td>

            </tr>

        </table>

        @endif



        <hr>

        <div class="row document-row mb-4" style="display: flex">

            <div class="col-md-4" style="width: 150px">

                <p><strong>@lang('payment.date')</strong></p>

                <p>{{$data['deposits']->created_at->format('Y-m-d')}}</p>

            </div>

            <div class="col-md-4" style="width: 150px">

                <p><strong>@lang('payment.invoice_no')</strong></p>

                <p>{{$data['deposits']->transaction_no}}</p>

            </div>

            <div class="col-md-4" style="width: 150px">

                <p><strong>@lang('payment.invoice_to')</strong></p>

                <p>{{Auth::user()->name}}<br>

                    {{Auth::user()->email}}</p>

            </div>

        </div>

        <br>

        <br>

        <div class="document-row space-between d-flex" style="display: flex !important">

            <p style="width: 300px"><strong>@lang('payment.description')</strong></p>

            <p><strong>@lang('payment.amount')</strong></p>

        </div>

        <hr>
        
        <div class="document-row space-between d-flex" style="display: flex !important">

            <p class="color-red" style="width: 300px;color:red"><strong>@lang('payment.security_deposit')</strong></p>

            <p class="color-red" style="color: red"><strong>${{$data['deposits']->amount}} USD</strong></p>

        </div>

        <hr>

        <div class="document-row space-between d-flex" style="display: flex !important">

            <p class="color-red" style="width: 300px; color:red"><strong>@lang('payment.wire_fee')</strong></p>

            <p class="color-red" style="color: red"><strong>$@lang('payment.price') USD</strong></p>

        </div>
        <hr>

        <div class="document-row flex-end d-flex" style="display: flex !important"> 

            <p style="width: 300px"><strong>@lang('payment.subtotal')</strong></p>

            <p class="color-red" style="color: red"><strong>${{$data['deposits']->amount}} USD</strong></p>

        </div>

        

        <div class="document-row flex-end d-flex" style="display: flex !important">

            <p style="width: 300px"><strong>@lang('payment.total')</strong></p>
            @php
                $bank_comission = 25;
                $deposit = $data['deposits']->amount;
                $total = $deposit + 25;											
            @endphp
            <p class="color-red" style="color: red"><strong>$<span class="total"><?php echo $total?></span> USD</strong></p>


        </div>
        <div class="document-row flex-end d-flex mt-5">
        
        <p style="text-align: center"><img src="{{url('/public/images/stamp.jpg')}}" width="100px"></p>
        </div>

    </div>

</div>
