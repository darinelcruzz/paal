@extends('coffee.root')

@push('pageTitle')
    Egresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar egreso" color="danger" button>
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.egress.store', 'enctype' => 'multipart/form-data']) !!}

                    {!! Field::select('provider_id', $providers, null,
                        ['tpl' => 'withicon', 'empty' => 'Seleccione un proveedor'],
                        ['icon' => 'truck'])
                    !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::date('buying_date', Date::now(), ['tpl' => 'withicon'], ['icon' => 'shopping-cart']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('folio', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>

                    <label>Factura</label>

                    <div class="row">
                        <div class="col-md-6">
                            <file-upload fname="pdf_bill" ext="pdf"></file-upload>
                        </div>
                        <div class="col-md-6">
                            <file-upload fname="xml" ext="xml"></file-upload>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::date('emission', Date::now(), ['tpl' => 'withicon'], ['icon' => 'shopping-cart']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::date('expiration', Date::now(), ['tpl' => 'withicon'], ['icon' => 'dollar']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('amount', ['tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'money']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('iva', ['tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'bank']) !!}
                        </div>
                    </div>

                    <hr>
                    <input type="hidden" name="company" value="coffee">
                    {!! Form::submit('Agregar', ['class' => 'btn btn-danger pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
