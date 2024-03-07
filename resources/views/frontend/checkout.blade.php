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
                    <div class="checkout-form">
                        <form method="post" action="{{route('checkout.payment', $package->id)}}">
                            @csrf

                            <div class="d-flex mb-4">
                                <div class="w-50">
                                    <h4>Package: {{$package->package_name}}</h4>
                                    <p>@lang('app.premium_job') : {{$package->premium_job}}</p>
                                    <p class="text-success">@lang('app.price') : {!! get_amount($package->price) !!}</p>
                                </div>
                                <div class="text-end w-50">
                                    <label>Name
                                        <input type="text" placeholder="Name" class="form-control" name="name" />
                                    </label>
                                    <label>Email
                                        <input type="text" placeholder="Email" class="form-control" name="email" />
                                    </label>
                                </div>
                            </div>

                            <h4 class="text-muted">Choose your gateway</h4>
                            <div class="checkout-gateways-wrap">
                                <div class="checkout-gateway bg-light p-3 my-3">
                                    <label>

                                        <input type="radio" name="gateway" value="paypal" checked="checked"> @lang('app.paypal')
                                    </label>
                                </div>
                                <div class="checkout-gateway bg-light p-3 my-3">
                                    <label>
                                        <input type="radio" name="gateway" value="stripe"> @lang('app.stripe')
                                    </label>
                                </div>
                                <div class="checkout-gateway bg-light p-3 my-3">
                                    <label>
                                        <input type="radio" name="gateway" value="bank_transfer"> @lang('app.bank_transfer')
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-success btn-lg"><i class="la la-cart-arrow-down"></i> @lang('app.checkout')</button>
                        </form>
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
            $.ajax({
                type: 'POST',
                url: "{{route('checkout.payment', $package->id)}}",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $(".checkout-page").html('<div class="loader" ></div>');
                },
                success: function(data) {
                    $.ajax({
                        type: 'GET',
                        url: "/payment/" + data,
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            $(".checkout-page").html('<div class="loader" ></div>');
                        },
                        success: function(data) {
                            $(".checkout-page").html(data);
                        }
                    });
                }
            });
        })
    })
</script>