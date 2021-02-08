@extends('coffee.root')

@push('pageTitle', 'Números de serie | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar número(s) de serie" color="danger">

            {!! Form::open(['method' => 'POST', 'route' => 'coffee.serial_number.store']) !!}
                
                {!! Field::date('purchased_at', date('Y-m-d'), ['label' => 'Fecha de entrada','tpl' => 'withicon'], ['icon' => 'calendar']) !!}

                <seriable-products-list></seriable-products-list>

                <hr>

                {!! Form::submit('AGREGAR', ['class' => 'btn btn-danger pull-right']) !!}

            {!! Form::close() !!}

            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="danger">
                <seriable-products color="danger" company="coffee"></seriable-products>
            </solid-box>
        </div>
    </div>

@endsection
