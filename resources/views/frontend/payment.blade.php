<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="stripe-button-container">
        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="{{ get_stripe_key() }}" data-amount="{{ get_stripe_amount($payment->amount) }}" data-email="{{$payment->email}}" data-name="{{ get_option('site_name') }}" data-description="{{ $payment->package_name." Package" }}" data-currency="{{$payment->currency}}" data-locale="auto">
        </script>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>