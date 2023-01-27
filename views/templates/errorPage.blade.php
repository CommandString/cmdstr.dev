@extends('templates.basic')

@section('head')
<link rel="stylesheet" href="/assets/css/errorPage.css">
<script src="/assets/js/errorPage.js"></script>
<title>@yield('header')</title>
@endsection

@section('body')
<div class="ui inverted red segment">
    <h1 class="ui centered massive header">
        @yield('header')
        <div class="sub header">
            @yield('sub-header')
        </div>
    </h1>
</div>
@endsection