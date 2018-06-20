@extends('mailboxes.root')

@push('pageTitle')
    Egresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Agregar egreso" color="success" button>
                {!! Form::open(['method' => 'POST', 'route' => 'mbe.egress.store', 'enctype' => 'multipart/form-data']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('provider_id', $providers, null,
                                ['tpl' => 'withicon', 'label' => 'Proveedor','empty' => 'Seleccione un proveedor'],
                                ['icon' => 'truck'])
                            !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('complement', [1 => 'Sí', 0 => 'No'], null,
                                ['tpl' => 'withicon','empty' => '¿Hay complemento?', 'label' => 'Complemento', 'v-model' => 'complement'],
                                ['icon' => 'plus'])
                            !!}
                        </div>
                    </div>

                    <div v-if="complement == '1'" class="row">
                        <div class="col-md-4">
                            {!! Field::date('complement_date', Date::now(), 
                                ['tpl' => 'withicon', 'label' => 'Fecha complemento'], ['icon' => 'calendar']) 
                            !!}
                        </div>
                        <div class="col-md-4">
                            {!! Field::number('complement_amount', 0,
                                ['tpl' => 'withicon', 'step' => '0.01', 'label' => 'Monto complemento', 'min' => '0'], 
                                ['icon' => 'money']) 
                            !!}
                        </div>
                        <div class="col-md-2 col-md-offset-1"><br>
                            <file-upload fname="pdf_complement" ext="pdf"></file-upload>
                        </div>
                    </div>

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
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <file-upload fname="pdf_bill" ext="pdf"></file-upload>
                        </div><div class="col-md-4"></div>
                        <div class="col-md-2">
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
                            {!! Field::number('amount', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'money']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('iva', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'bank']) !!}
                        </div>
                    </div>

                    <hr>
                    <input type="hidden" name="company" value="mbe">
                    <button type="submit" class="btn btn-success pull-right" onclick="submitForm(this);">Agregar</button>

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
