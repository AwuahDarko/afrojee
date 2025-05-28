@extends('frontend.layouts.app')

@section('title')
Welcome Lorem ipsum
@endsection

@section('content')
@include('frontend.partials.hero')
@include('frontend.partials.products')
@include('frontend.partials.who')
@include('frontend.partials.tobuy')
@include('frontend.partials.ourClients')
@include('frontend.partials.faq2')
@include('frontend.partials.reachout')
@include('frontend.partials.newsletter')


@endsection