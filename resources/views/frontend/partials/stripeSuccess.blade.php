@extends('frontend.layouts.app')

@section('title')
    Successful Payment
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

            <img src="{{ asset('img/checked.png') }}" alt="checked" width="100px" height="100px">
            <div class="card-header">{{ __('common.payment.success.title') }}</div>
            <div class="card-body">
                <h4>{{ __('common.payment.success.thank_you') }}</h4>
                <p>{{ __('common.payment.success.message') }}</p>
                @if (isset($session))
                    <p><strong>{{ __('common.payment.success.amount') }}</strong>  {{ number_format($session->amount_total / 100, 2) }} {{app_currency()}}</p>
                    <p><strong>{{ __('common.payment.success.status') }}</strong> {{ ucfirst($session->payment_status) }}</p>
                @endif
                <a href="{{ route('home') }}" class="mbtn btn-primary">{{ __('common.payment.success.continue') }}</a>
            </div>


        </div>
    </div>
@endsection
