<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Butik Shop</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js"></script>
</head>
<body>
    <h1>Express Payment</h1>

    <div id="dropin-container"></div>
    <button id="submit-button">Request payment method</button>
    <script>
        var button = document.querySelector('#submit-button');

        braintree.dropin.create({
            authorization: 'sandbox_8hc4ttnw_8t2hkkd3nn7yqncp',
            container: '#dropin-container'
        }, function (createErr, instance) {
            button.addEventListener('click', function () {
                instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
                    $.get('{{ route('butik.payment.handle') }}', {payload}, function (response) {
                        if (response.success) {
                            alert('Payment successfull!');
                        } else {
                            alert('Payment failed');
                        }
                    }, 'json');
                });
            });
        });
    </script>
</body>
</html>
