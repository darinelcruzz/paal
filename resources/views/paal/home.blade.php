@extends('paal.root')

@push('pageTitle')
    PAAL | Inicio
@endpush

@push('headerTitle')
    Bienvenido(a), {{ auth()->user()->name }}
@endpush

@section('content')

	<div align="center">
    	<img width="40%" height="20%" src="{{ asset('/img/paal.jpg') }}">
    </div>

@endsection
