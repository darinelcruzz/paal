@extends('paal.root')

@push('pageTitle')
    PAAL | Inicio
@endpush

@push('headerTitle')
    Inicio <small>COMIENZA AQUÍ</small>
@endpush

@section('content')

	<div align="center">
    	<img width="40%" height="20%" src="{{ asset('/img/paal.png') }}">
    </div>
    
@endsection