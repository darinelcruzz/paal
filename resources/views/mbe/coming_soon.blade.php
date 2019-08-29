@extends('mbe.root')

@push('pageTitle')
    PENDIENTE
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12" align="center">
            <h3><em>ESTAMOS TRABAJANDO</em></h3>
            <img src="{{ asset('img/gancho.png') }}" alt="En construcción" width="30%">
        </div>
    </div>

@endsection