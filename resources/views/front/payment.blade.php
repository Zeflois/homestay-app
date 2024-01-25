@extends('front.layout.app')

@section('main_content')

<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $global_page_data->payment_heading }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 checkout-left mb_30">


                @php
                $arr_cart_room_id = array();
                $i=0;
                foreach(session()->get('cart_room_id') as $value) {
                    $arr_cart_room_id[$i] = $value;
                    $i++;
                }
                $arr_cart_checkin_date = array();
                $i=0;
                foreach(session()->get('cart_checkin_date') as $value) {
                    $arr_cart_checkin_date[$i] = $value;
                    $i++;
                }
                $arr_cart_checkout_date = array();
                $i=0;
                foreach(session()->get('cart_checkout_date') as $value) {
                    $arr_cart_checkout_date[$i] = $value;
                    $i++;
                }
                $arr_cart_adult = array();
                $i=0;
                foreach(session()->get('cart_adult') as $value) {
                    $arr_cart_adult[$i] = $value;
                    $i++;
                }
                $arr_cart_children = array();
                $i=0;
                foreach(session()->get('cart_children') as $value) {
                    $arr_cart_children[$i] = $value;
                    $i++;
                }
                $total_price = 0;
                for($i=0;$i<count($arr_cart_room_id);$i++)
                {
                    $room_data = DB::table('rooms')->where('id',$arr_cart_room_id[$i])->first();                            
                    $d1 = explode('/',$arr_cart_checkin_date[$i]);
                    $d2 = explode('/',$arr_cart_checkout_date[$i]);
                    $d1_new = $d1[2].'-'.$d1[1].'-'.$d1[0];
                    $d2_new = $d2[2].'-'.$d2[1].'-'.$d2[0];
                    $t1 = strtotime($d1_new);
                    $t2 = strtotime($d2_new);
                    $diff = ($t2-$t1)/60/60/24;
                    $total_price = $total_price+($room_data->price*$diff);
                }
                @endphp
                        
                <h4>Make Payment</h4>
                <select name="payment_method" class="form-control select2" id="paymentMethodChange" autocomplete="off">
                    <option value="">Select Payment Method</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Stripe">Stripe</option>
                    <option value="Midtrans">Midtrans</option>
                </select>

                <div class="paypal mt_20" id="paypalContainer" style="display: none;">
                    <h4>Pay with PayPal</h4>
                    <form method="POST" action="{{route('paypal',$total_price)}}">
                        @csrf
                        <!-- Add other form fields and PayPal-related inputs here -->
                         <button class="btn btn-primary" type="submit"><i class="fa fa-paypal" aria-hidden="true"></i> Paypal</button>
                    </form>
                </div>

                <div class="paypal mt_20" id="midtransButton" style="display: none;">
                    <h4>Pay with Midtrans</h4>
                    <form method="POST" id="payment-form" action="{{route('midtransAction')}}">
                        <input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
                            <input type="hidden" name="result_type" id="result-type" value="">
                            <input type="hidden" name="result_data" id="result-data" value="">
                        <!-- Add other form fields and PayPal-related inputs here -->
                         <button class="btn btn-primary" id="pay-button"><i class="fa fa-usd" aria-hidden="true"></i> Pay</button>
                        </form>
                </div>

                <div class="stripe mt_20" id="stripePayment"  style="display: none;">
                    <h4>Pay with Stripe</h4>
                    @php
                    $cents = $total_price*100;
                    $customer_email = Auth::guard('customer')->user()->email;
                    $stripe_publishable_key = 'pk_test_51LT28GF67T3XLjgLXbAMW8YNgvDyv6Yrg7mB6yHJhfmWgLrAL79rSBPvxcbKrsKtCesqJmxlOd259nMrNx4Qlhoa00zX7rOhOq';
                    @endphp
                    <form action="{{ route('payment',$total_price) }}" method="post">
                        @csrf
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ $stripe_publishable_key }}"
                            data-amount="{{ $cents }}"
                            data-name="{{ env('APP_NAME') }}"
                            data-description=""
                            data-image="{{ asset('stripe.png') }}"
                            data-currency="usd"
                            data-email="{{ $customer_email }}"
                        >
                        </script>
                    </form>
                </div>

            </div>
            <div class="col-lg-4 col-md-4 checkout-right">
                <div class="inner">
                    <h4 class="mb_10">Billing Details</h4>
                    <div id="billing_name">
                        Name: {{ session()->get('billing_name') }}
                    </div>
                    <div id="billing_email">
                        Email: {{ session()->get('billing_email') }}
                    </div>
                    <div id="billing_phone">
                        Phone: {{ session()->get('billing_phone') }}
                    </div>
                    <div>
                        Country: {{ session()->get('billing_country') }}
                    </div>
                    <div>
                        Address: {{ session()->get('billing_address') }}
                    </div>
                    <div>
                        State: {{ session()->get('billing_state') }}
                    </div>
                    <div>
                        City: {{ session()->get('billing_city') }}
                    </div>
                    <div>
                        Zip: {{ session()->get('billing_zip') }}
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 checkout-right">
                <div class="inner">
                    <h4 class="mb_10">Cart Details</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                @php
                                $arr_cart_room_id = array();
                                $i=0;
                                foreach(session()->get('cart_room_id') as $value) {
                                    $arr_cart_room_id[$i] = $value;
                                    
                                    $i++;
                                }

                                $arr_cart_checkin_date = array();
                                $i=0;
                                foreach(session()->get('cart_checkin_date') as $value) {
                                    $arr_cart_checkin_date[$i] = $value;
                                    $i++;
                                }

                                $arr_cart_checkout_date = array();
                                $i=0;
                                foreach(session()->get('cart_checkout_date') as $value) {
                                    $arr_cart_checkout_date[$i] = $value;
                                    $i++;
                                }

                                $arr_cart_adult = array();
                                $i=0;
                                foreach(session()->get('cart_adult') as $value) {
                                    $arr_cart_adult[$i] = $value;
                                    $i++;
                                }

                                $arr_cart_children = array();
                                $i=0;
                                foreach(session()->get('cart_children') as $value) {
                                    $arr_cart_children[$i] = $value;
                                    $i++;
                                }

                                $total_price = 0;
                                for($i=0;$i<count($arr_cart_room_id);$i++)
                                {
                                    $room_data = DB::table('rooms')->where('id',$arr_cart_room_id[$i])->first();
                                    @endphp

                                    <tr>
                                        <td id="detailsCheckout">
                                            {{ $room_data->name }}
                                            <br>
                                            ({{ $arr_cart_checkin_date[$i] }} - {{ $arr_cart_checkout_date[$i] }})
                                            <br>
                                            Adult: {{ $arr_cart_adult[$i] }}, Children: {{ $arr_cart_children[$i] }}
                                        </td>
                                        <td class="p_price">
                                            @php
                                                $d1 = explode('/',$arr_cart_checkin_date[$i]);
                                                $d2 = explode('/',$arr_cart_checkout_date[$i]);
                                                $d1_new = $d1[2].'-'.$d1[1].'-'.$d1[0];
                                                $d2_new = $d2[2].'-'.$d2[1].'-'.$d2[0];
                                                $t1 = strtotime($d1_new);
                                                $t2 = strtotime($d2_new);
                                                $diff = ($t2-$t1)/60/60/24;
                                                echo '$'.$room_data->price*$diff;
                                            @endphp
                                        </td>
                                    </tr>
                                    @php
                                    $total_price = $total_price+($room_data->price*$diff);
                                }
                                @endphp                                
                                <tr>
                                    <td><b>Total:</b></td>
                                    <td class="p_price" id="total_price"><b>{{ $total_price }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Get references to the relevant elements
    const paymentMethodDropdown = document.getElementById("paymentMethodChange");
    const paypalContainer = document.getElementById("paypalContainer");
    const midtransButton = document.getElementById("midtransButton");
    const stripePayment = document.getElementById("stripePayment");

    // Add an event listener to the dropdown
    paymentMethodDropdown.addEventListener("change", function () {
        const selectedOption = paymentMethodDropdown.value;

        // Show the PayPal container if "PayPal" is selected, otherwise hide it
        if (selectedOption === "PayPal") {
            $('#midtransButton').hide()
            $('#stripePayment').hide()
            $('#paypalContainer').show()

            
        } else if (selectedOption === "Midtrans") {
            $('#midtransButton').show()
            $('#stripePayment').hide()
            $('#paypalContainer').hide()
        } else {
            $('#midtransButton').hide()
            $('#stripePayment').show()
            $('#paypalContainer').hide()
        }
    });
</script>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-N1_eqAQYQiqIvdpc"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript">
        $('#pay-button').click(function(event) {
                event.preventDefault();
                $(this).attr("disabled", "disabled");
                // console.log($('#nilai').val().replace("Rp.", '').replace(",", '').replace(".", ''));
                $.ajax({
                    method: "POST",
                    url: '/payment/midtransPayment',
                    cache: false,
                    data: {
                        _token: $('#_token').val(),
                        billing_name: $('#billing_name').text().replace("Name: ", ''),
                        billing_phone: $('#billing_phone').text().replace("Phone: ", ''),
                        billing_email: $('#billing_email').text().replace("Email: ", ''),
                        detailsCheckout: $('#detailsCheckout').text(),
                        total: $('#total_price').text(),
                        // total: $('#total_price').val().replace("Rp.", '').replace(",", '').replace(".", ''),

                    },
                    success: function(data) {
                        //location = data;
                        console.log('token = ' + data);

                        var resultType = document.getElementById('result-type');
                        var resultData = document.getElementById('result-data');

                        function changeResult(type, data) {
                            $("#result-type").val(type);
                            $("#result-data").val(JSON.stringify(data));
                            //resultType.innerHTML = type;
                            //resultData.innerHTML = JSON.stringify(data);
                        }
                        snap.pay(data, {

                            onSuccess: function(result) {
                                changeResult('success', result);
                                console.log(result.status_message);
                                console.log(result);
                                $("#payment-form").submit();
                            },
                            onPending: function(result) {
                                changeResult('pending', result);
                                console.log(result.status_message);
                                $("#payment-form").submit();
                            },
                            onError: function(result) {
                                changeResult('error', result);
                                console.log(result.status_message);
                                $("#payment-form").submit();
                            }
                        });
                    }
                });
            
        });
    </script>
@endsection