@extends('templates.errorPage')

@section('header')
404 - Not Found
@endsection

@section('sub-header')
<b>{{ $uri }}</b> does not exist on this website!
@endsection