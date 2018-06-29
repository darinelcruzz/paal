@extends('coffee.root')

@push('pageTitle')
    Egresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10">
            <solid-box title="Agregar egreso" color="danger" button>
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.egress.store', 'enctype' => 'multipart/form-data']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('provider_id', $providers, null,
                                ['tpl' => 'withicon', 'label' => 'Proveedor','empty' => 'Seleccione un proveedor'],
                                ['icon' => 'truck'])
                            !!}
                        </div>
                        <div class="col-md-4">
                            {!! Field::date('emission', Date::now(), ['tpl' => 'withicon'], ['icon' => 'shopping-cart']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Field::number('expiration', ['tpl' => 'withicon'], ['icon' => 'clock-o']) !!}
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
                        <div class="col-md-3">
                            {!! Field::text('folio', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::number('amount', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'money']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::number('iva', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'bank']) !!}
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label>
                            <div class="input-group">
                                <input type="text" class="form-control" disabled value="¿Complemento?">
                                <span class="input-group-addon">
                                  <input type="checkbox" v-model="complement">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div v-if="complement" class="row">
                        <hr>
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

                    <hr>
                    <input type="hidden" name="company" value="coffee">
                    <button type="submit" class="btn btn-danger pull-right" onclick="submitForm(this);">Agregar</button>

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
