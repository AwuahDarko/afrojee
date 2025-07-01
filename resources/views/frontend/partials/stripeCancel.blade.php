@extends('frontend.layouts.app')

@section('title')
    Payment Failed
@endsection

@section('content')
    <style>
        .container {
            width: 60%;
            margin: auto;
            min-height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .mbtn {
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            gap: 5px;
            justify-content: center;

        }

        .card-body p,
        .card-body h4 {
            text-align: center;
        }
    </style>
    <div class="container">
        <div class="success">

            <img src="{{ asset('img/removed.png') }}" alt="failed" width="100px" height="100px">
            <div class="card-header">Payment Failed</div>
            <div class="card-body">
                {{-- <h4>Thank you for your patronage!</h4> --}}
                <p>Your payment failed.</p>
                @if (isset($session))
                    <p><strong>Amount:</strong> ${{ number_format($session->amount_total / 100, 2) }}</p>
                    <p><strong>Payment Status:</strong> {{ ucfirst($session->payment_status) }}</p>
                @endif
                <a href="{{ route('home') }}" class="mbtn btn-primary">Continue</a>
            </div>


        </div>
    </div>
@endsection
