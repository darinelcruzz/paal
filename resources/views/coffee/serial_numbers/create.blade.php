@extends('coffee.root')

@push('pageTitle', 'Números de serie | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar número(s) de serie" color="warning">

            {!! Form::open(['method' => 'POST', 'route' => 'coffee.serial_number.store']) !!}

                <div class="row">
                    <div class="col-md-6">
                        {!! Field::number('purchase_id', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Field::date('purchased_at', date('Y-m-d'), ['label' => 'Fecha de entrada','tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                    </div>
                </div>

                <seriable-products-list></seriable-products-list>

                <hr>

                {!! Form::submit('AGREGAR', ['class' => 'btn btn-warning pull-right']) !!}

            {!! Form::close() !!}

            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="warning">
                <seriable-products color="warning" company="coffee"></seriable-products>
            </solid-box>
        </div>
    </div>

@endsection
