@extends('coffee.root')

@push('pageTitle')
    Coffee Depot | Inicio
@endpush

@push('headerTitle')
    Bienvenido(a), {{ auth()->user()->name }}
@endpush

@section('content')

	<div align="center">
    	<img width="40%" height="20%" src="{{ asset('/img/coffee.png') }}">
    </div>

@endsection
