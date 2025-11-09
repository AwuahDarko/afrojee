@extends('frontend.layouts.app')
<!-- <script>
    const appCurrency = @json(app_currency());
</script> -->
@section('title')
Afrojee - Hair care products
@endsection

@section('content')
@include('frontend.partials.hero')
@include('frontend.partials.products')
{{-- @include('frontend.partials.who') --}}
@include('frontend.partials.tobuy')
{{-- @include('frontend.partials.ourClients')--}}
@include('frontend.partials.faq2')
@include('frontend.partials.reachout')

@endsection
