<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body>
    <div class="checkout-page bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id='loader' class="text-center"></div>
                    <div class="checkout-form">
                        <div class="d-flex mb-4" id='data'>
                            <div class="w-50">
                                <h4>Package: {{$package->package_name}}</h4>
                                <p>@lang('app.premium_job') : {{$package->premium_job}}</p>
                                <p class="text-success">@lang('app.price') : {!! get_amount($package->price) !!}</p>
                            </div>
                            <div class="text-end w-50" style="text-align: right;">
                                <input type="text" placeholder="Name" class="form-control mb-4" name="name" />
                                <input type="text" placeholder="Email" class="form-control mb-5" name="email" />
                                <button class="btn btn-success btn-lg" id='checkout'>
                                    <i class="la la-cart-arrow-down"></i> Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>

<script>
    $(document).ready(function() {
        $("#checkout").click(function() {
            if ((!$("input[name='name']").val() || !$("input[name='email']").val())) {
                alert('Please fill the required fields');

                return true;
            }

            $.ajax({
                type: 'POST',
                url: "{{route('checkout.payment', $package->id)}}",
                data: {
                    'name': $("input[name='name']").val(),
                    'email': $("input[name='email']").val()
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $("#loader").html('<div class="loader" ></div>');
                    $(".checkout-form").html('');
                },
                success: function(data) {
                    var paymentMethods = '<h4 class="text-muted">Choose your gateway</h4><div class="payal"></div><div class="checkout-gateways-wrap"><div class="checkout-gateway bg-light p-3 my-3"><label><input type="radio" name="gateway" value="paypal" id="paypal"> @lang("app.paypal")</label></div><div class="checkout-gateway bg-light p-3 my-3"><label><input type="radio" name="gateway" value="stripe" id="stripe"> @lang("app.stripe")</label></div><div class="checkout-gateway bg-light p-3 my-3"><label><input type="radio" name="gateway" value="bank_transfer" id="bank_transfer"> @lang("app.bank_transfer")</label></div></div>';

                    $(".checkout-form").html(paymentMethods);
                    $("#loader").remove();

                    $("#bank_transfer").click(function() {
                        var directPayment = '<form action="/payment/' + data + '/bank-transfer" method="post" id="bankTransferForm" enctype="multipart/form-data"> @csrf <div class="form-group row {{ $errors->has("bank_swift_code")? "has-error":"" }}"><label for="bank_swift_code" class="col-sm-4 control-label">@lang("app.bank_swift_code") <span class="field-required">*</span></label><div class="col-sm-8"><input type="text" class="form-control" id="bank_swift_code" value="{{ old("bank_swift_code") }}" name="bank_swift_code" placeholder="@lang("app.bank_swift_code")">{!! e_form_error("bank_swift_code", $errors) !!}</div></div><div class="form-group row {{ $errors->has("account_number")? "has-error":"" }}"><label for="account_number" class="col-sm-4 control-label">@lang("app.account_number") <span class="field-required">*</span></label><div class="col-sm-8"><input type="text" class="form-control" id="account_number" value="{{ old("account_number") }}" name="account_number" placeholder="@lang("app.account_number")">{!! e_form_error("account_number", $errors) !!}</div></div><div class="form-group row {{ $errors->has("branch_name")? "has-error":"" }}"><label for="branch_name" class="col-sm-4 control-label">@lang("app.branch_name") <span class="field-required">*</span></label><div class="col-sm-8"><input type="text" class="form-control" id="branch_name" value="{{ old("branch_name") }}" name="branch_name" placeholder="@lang("app.branch_name")">{!! e_form_error("branch_name", $errors) !!}</div></div><div class="form-group row {{ $errors->has("branch_address")? "has-error":"" }}"><label for="branch_address" class="col-sm-4 control-label">@lang("app.branch_address") <span class="field-required">*</span></label><div class="col-sm-8"><input type="text" class="form-control" id="branch_address" value="{{ old("branch_address") }}" name="branch_address" placeholder="@lang("app.branch_address")">{!! e_form_error("branch_address", $errors) !!}</div></div><div class="form-group row {{ $errors->has("account_name")? "has-error":"" }}"><label for="account_name" class="col-sm-4 control-label">@lang("app.account_name") <span class="field-required">*</span></label><div class="col-sm-8"><input type="text" class="form-control" id="account_name" value="{{ old("account_name") }}" name="account_name" placeholder="@lang("app.account_name")">{!! e_form_error("account_name", $errors) !!}</div></div><div class="form-group row {{ $errors->has("iban")? "has-error":"" }}"><label for="iban" class="col-sm-4 control-label">@lang("app.iban")</label><div class="col-sm-8"><input type="text" class="form-control" id="iban" value="{{ old("iban") }}" name="iban" placeholder="@lang("app.iban")">{!! e_form_error("iban", $errors) !!}</div></div><div class="form-group row"><div class="offset-sm-4 col-sm-8"><button type="submit" class="btn btn-primary">@lang("app.pay_with_bank_bank_transfer")</button></div></div></form>';

                        $(".payal").html(directPayment);
                    });

                    $("#stripe").click(function() {
                        $.ajax({
                            type: 'GET',
                            url: "/payment/" + data,
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            },
                            beforeSend: function() {
                                $(".payal").html('<div class="loader" ></div>');
                            },
                            success: function(data) {
                                $(".payal").html(data);
                            }
                        });
                    });

                    $("#paypal").click(function() {
                        var transaction_id = data;
                        var paypalForm = '<form action="/payment/' + transaction_id + '/paypal" id="paypalform" method="post"> @csrf <input type="hidden" name="cmd" value="_xclick" /><input type="hidden" name="no_note" value="1" /><input type="hidden" name="lc" value="UK" /><input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" /><button type="submit" class="btn btn-success btn-lg"> <i class="la la-paypal"></i> Paypal</button></form>';

                        $(".payal").html(paypalForm);
                    });
                }
            });
        });
    })
</script>