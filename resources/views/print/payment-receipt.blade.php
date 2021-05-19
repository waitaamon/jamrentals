<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Receipt</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>
<div class="" style="margin-left: -30px; margin-top: -40px; color: #000000 !important; ">
    <div class="row" style="">
        <div class="col-12">
            <h3 class="h3 font-weight-bolder text-uppercase">Jim Rentals</h3>
            <h4 class="h4 font-weight-bold text-uppercase">Payment Receipt</h4>
        </div>
    </div>
    <div class="mt-4">
        <div class="row">
            <div class="col-12">
                <h5 class="h5 font-weight-bold text-uppercase">RECEIPT NO: &nbsp; <span
                            class="">{{ $payment->code }}</span></h5>
                <h5 class="h5 font-weight-bold text-uppercase">TENANT: &nbsp; <span
                            class="">{{ $payment->tenant->name }}</span></h5>
                <h5 class="h5 font-weight-bold text-uppercase">Building: &nbsp; <span
                            class="">{{ $payment->house->building->name }}</span></h5>
                <h5 class="h5 font-weight-bold text-uppercase">House: &nbsp; <span
                            class="">{{ $payment->house->name }}</span></h5>

                <h4 class="h4 font-weight-bolder text-uppercase my-2 text-under"><u>Payments Details</u></h4>

                <h5 class="h5 font-weight-bold text-uppercase">Date: &nbsp; <span
                            class="">{{ $payment->date_paid->format('d-M-Y') }}</span></h5>
                <h5 class="h5 font-weight-bold text-uppercase">Month: &nbsp; <span
                            class="">{{ $payment->month->format('M-Y') }}</span></h5>
                <h5 class="h5 font-weight-bold text-uppercase">Amount: &nbsp; <span
                            class="">{{ number_format($payment->amount, 2) }}</span></h5>
                <h5 class="h5 font-weight-bold text-uppercase">Balance: &nbsp; <span
                            class="">{{ number_format($payment->balance, 2) }}</span></h5>

            </div>
        </div>
    </div>
    <div class="">
        <div class="row">
            <div class="col-12">
                <p class="font-weight-bold">You were served by: {{ $payment->user->name }}</p>
                <p class="font-weight-bold text-sm">Receipt valid subject to confirmation</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>