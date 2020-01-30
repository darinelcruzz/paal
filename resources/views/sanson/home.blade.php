@extends('sanson.root')

@push('pageTitle')
    San-Son | Inicio
@endpush

@push('headerTitle')
    Bienvenido(a), {{ auth()->user()->name }}
@endpush

@section('content')

	<h1>&nbsp;</h1>

	<div align="center">
    	<img width="80%" src="{{ asset('/img/sanson.png') }}">
    </div>

@endsection
