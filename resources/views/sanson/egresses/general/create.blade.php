@extends('sanson.root')

@push('pageTitle')
    Egresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <solid-box title="Agregar egreso" color="info" button>
                {!! Form::open(['method' => 'POST', 'route' => 'sanson.egress.general.store', 'enctype' => 'multipart/form-data']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            <label><b>Proveedor</b></label><br>
                            <v-select label="name" :options="providers.sanson.general" v-model="provider" placeholder="Seleccione un proveedor...">
                            </v-select>
                            <input type="hidden" name="provider_id" :value="provider.id">
                        </div>
                        <div class="col-md-3">
                            {!! Field::date('emission', Date::now(), ['tpl' => 'withicon'], ['icon' => 'shopping-cart']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::number('expiration', 0, ['tpl' => 'withicon', 'min' => '0'], ['icon' => 'clock-o']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            {!! Field::text('folio', ['tpl' => 'withicon', 'ph' => 'XXXXX'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::number('amount', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'money']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::number('iva', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'bank']) !!}
                        </div>
                        <div class="col-md-3">
                            <label>Archivos factura</label><br>
                            <file-upload color="danger" bname="PDF" fname="pdf_bill" ext="pdf"></file-upload>
                            <template v-if="provider.xml_required == 1">
                                <file-upload color="primary" bname="XML" fname="xml" ext="xml"></file-upload>
                            </template>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label>&nbsp;</label>
                            <div class="input-group">
                                <input type="text" class="form-control" disabled value="¿Complemento?">
                                <span class="input-group-addon">
                                  <input type="checkbox" v-model="complement">
                                </span>
                            </div>
                        </div>
                        <div v-if="provider.name == 'COFFEE DEPOT CHAPULTEPEC'" class="col-md-3">
                            {!! Field::select('type', ['insumos' => 'INSUMOS', 'equipo' => 'EQUIPO'], null, ['tpl' => 'withicon', 'empty' => 'Seleccione tipo'], ['icon' => 'question']) !!}
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div v-if="complement">
                            <div class="col-md-4">
                                {!! Field::number('complement_amount', 0,
                                    ['tpl' => 'withicon', 'step' => '0.01', 'label' => 'Monto', 'min' => '0'], 
                                    ['icon' => 'money']) 
                                !!}
                            </div>
                            <div class="col-md-4">
                                {!! Field::date('complement_date', Date::now(), 
                                    ['tpl' => 'withicon', 'label' => 'Fecha'], ['icon' => 'calendar']) 
                                !!}
                            </div>
                            <div class="col-md-4">
                                <label>Documento complemento</label><br>
                                <file-upload bname="PDF COMPLEMENTO" fname="pdf_complement" ext="pdf" color="warning"></file-upload>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <input type="hidden" name="company" value="sanson">
                    <button type="submit" class="btn btn-info pull-right" onclick="submitForm(this);">Agregar</button>

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-5">
            @if(session()->has('message'))
                 <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> No se pudo agregar</h4>
                    {{ session()->get('message') }}
                </div>
            @endif
        </div>
    </div>

@endsection
