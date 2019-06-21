@extends('coffee.root')

@push('pageTitle')
    Egresos | Pagar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-4">
            <solid-box title="Detalles del pago" color="danger" button>
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.egress.settle', 'enctype' => 'multipart/form-data']) !!}

                    {!! Field::date('payment_date', Date::now(), ['tpl' => 'withicon'], ['icon' => 'dollar']) !!}

                    {!! Field::select('method', ['check' => 'Cheque', 'transfer' => 'Transferencia', 'automatic' => 'Domiciliación'], null,
                        ['tpl' => 'withicon', 'empty' => 'Seleccione método'], ['icon' => 'credit-card']) 
                    !!}

                    {!! Field::text('mfolio', ['label' => 'Folio', 'tpl' => 'withicon', 'ph' => 'XXXXXX'], ['icon' => 'barcode']) !!}

                    <hr>
                    <input type="hidden" name="id" value="{{ $egress->id }}">

                    {!! Form::submit('Pagar', ['class' => 'btn btn-danger pull-right']) !!}
                    
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection