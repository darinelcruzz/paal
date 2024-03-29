@extends('paal.root')

@push('pageTitle', 'Egresos | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Agregar egreso" color="primary" button>
                {!! Form::open(['method' => 'POST', 'route' => 'paal.egress.general.store', 'enctype' => 'multipart/form-data']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::date('emission', Date::now(), ['tpl' => 'withicon'], ['icon' => 'shopping-cart']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('expiration', 0, ['tpl' => 'withicon', 'min' => '0'], ['icon' => 'clock-o']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('category_id', $categories, 7, ['tpl' => 'withicon', 'empty' => 'Seleccione una opción', 'disabled'], ['icon' => 'project-diagram']) !!}
                            <input type="hidden" name="category_id" value="7">
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('group_id', $groups, null, ['tpl' => 'withicon', 'empty' => 'Seleccione una opción'], ['icon' => 'object-ungroup']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label><b>Proveedor</b></label><br>
                            <v-select label="name" :options="providers.coffee.general" v-model="provider" placeholder="Seleccione un proveedor...">
                            </v-select>
                            <input type="hidden" name="provider_id" :value="provider.id">
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('folio', ['tpl' => 'withicon', 'ph' => 'XXXXX'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('subtotal', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0', 'v-model.number' => 'ingress_total'], ['icon' => 'usd']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('discount', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0', 'v-model.number' => 'payment_total'], ['icon' => 'percentage']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('iva_type', ['0%' => '0%', '4%' => '4%', '8%' => '8%', '16%' => '16%'], '16%', ['tpl' => 'withicon', 'empty' => 'Seleccione tipo de iva'], ['icon' => 'mouse-pointer']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('iva', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0', 'v-model.number' => 'retainer'], ['icon' => 'hand-holding-usd']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('amount', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0', 'v-bind:value' => 'ingress_total - payment_total + retainer', 'disabled'], ['icon' => 'money']) !!}
                            <input name="amount" type="hidden" :value="ingress_total - payment_total + retainer">
                        </div>
                    </div>

                    <div v-if="provider.type == 'pd'" class="row">
                        <div class="col-md-4">
                            {!! Field::number('coffee', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'mug-hot']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Field::number('MBE', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'truck-loading']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Field::number('sanson', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'blender']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Archivos factura</label><br>
                            <file-upload color="danger" bname="PDF" fname="pdf_bill" ext="pdf"></file-upload>
                            {{-- <template v-if="provider.xml_required == 1">
                                <file-upload color="primary" bname="XML" fname="xml" ext="xml"></file-upload>
                            </template> --}}
                        </div>
                        <div v-if="provider.name == 'COFFEE DEPOT CHAPULTEPEC'" class="col-md-6">
                            {!! Field::select('type', ['insumos' => 'INSUMOS', 'equipo' => 'EQUIPO', 'publicidad' => 'PUBLICIDAD'], null, ['tpl' => 'withicon', 'empty' => 'Seleccione tipo'], ['icon' => 'question']) !!}
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
                        <div v-if="complement" class="col-md-4">
                            {!! Field::date('complement_date', date('Y-m-d'), ['tpl' => 'withicon', 'label' => 'Fecha'], ['icon' => 'calendar']) !!}
                        </div>                   
                        <div v-if="complement" class="col-md-4">
                            {!! Field::number('complement_amount', 0, ['tpl' => 'withicon', 'step' => '0.01', 'label' => 'Monto', 'min' => '0'], ['icon' => 'money']) !!}
                        </div>
                    </div>

                    <div v-if="complement" class="row">
                        <div class="col-md-4">
                            {{-- <label>Documento complemento</label><br> --}}
                            <file-upload bname="PDF" fname="pdf_complement" ext="pdf" color="warning"></file-upload>
                        </div>
                    </div>

                    <hr>
                    <input type="hidden" name="company" value="coffee">
                    <button type="submit" class="btn btn-primary pull-right" onclick="submitForm(this);">Agregar</button>

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
