@extends('coffee.root')

@push('pageTitle')
    Envíos mensuales
@endpush

@section('content')

    <div class="row">

        <div class="col-md-9">

            {!! Form::open(['method' => 'post', 'route' => 'coffee.shipping.monthly']) !!}
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}

            <br>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <big>Estafeta</big>
                            <h3>
                                <small style="color: white">{{ $shippings->where('company', 'estafeta')->count() }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <big>Paquete Express</big>
                            <h3>
                                <small style="color: white">{{ $shippings->where('company', 'paquete express')->count() }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <big>DYPAQ</big>
                            <h3>
                                <small style="color: white">{{ $shippings->where('company', 'dypaq')->count() }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <big>Business Express</big>
                            <h3>
                                <small style="color: white">{{ $shippings->where('company', 'business express')->count() }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <big>Motor Pack</big>
                            <h3>
                                <small style="color: white">{{ $shippings->where('company', 'motor pack')->count() }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <big>Pack Service (AEXA)</big>
                            <h3>
                                <small style="color: white">{{ $shippings->where('company', 'pack service')->count() }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <big>Otros</big>
                            <h3>
                                <small style="color: black">{{ $shippings->where('company', 'otro')->count() }}</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection