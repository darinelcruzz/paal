@extends('paal.root')

@push('pageTitle', 'Egresos | Caja Chica')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar factura al cheque {{ $check->folio }}" color="primary" button>
                {!! Form::open(['method' => 'POST', 'route' => ['paal.egress.register.store', $check], 'enctype' => 'multipart/form-data']) !!}

                    <div class="row">
                        <div class="col-md-12">
                            <label><b>Proveedor</b></label><br>
                            <v-select label="name" :options="providers.coffee.register" v-model="provider" placeholder="Seleccione un proveedor...">
                            </v-select>
                            <input type="hidden" name="provider_id" :value="provider.id">
                        </div>
                    </div>
                    <br>
                    <div v-if="provider.name == 'NO DEDUCIBLE'" class="row">
                        <div class="col-md-6">
                            {!! Field::text('provider_name',
                                ['tpl' => 'withicon', 'label' => 'Nombre', 'ph' => 'ejemplo: Vips'],
                                ['icon' => 'trademark'])
                            !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::date('emission', Date::now(), ['label' => 'Fecha', 'tpl' => 'withicon'], ['icon' => 'shopping-cart']) !!}
                        </div>
                        <div v-if="provider.name != 'NO DEDUCIBLE'" class="col-md-6">
                            {!! Field::text('folio', ['tpl' => 'withicon', 'ph' => 'XXXXX'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('category_id', $categories, 8, ['tpl' => 'withicon', 'empty' => 'Seleccione una opción', 'disabled'], ['icon' => 'project-diagram']) !!}
                            <input type="hidden" name="category_id" value="8">
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('group_id', $groups, null, ['tpl' => 'withicon', 'empty' => 'Seleccione una opción'], ['icon' => 'object-ungroup']) !!}
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

                    <div class="row">
                        <div class="col-md-6">
                            <label>Archivos</label><br>
                            <file-upload color="danger" bname="PDF" fname="pdf_bill" ext="pdf"></file-upload>
                    </div>

                    <hr>
                    <input type="hidden" name="company" value="coffee">
                    <input type="hidden" name="expiration" value="0">

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
