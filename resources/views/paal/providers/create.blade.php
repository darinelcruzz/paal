@extends('paal.root')

@push('pageTitle')
    Proveedores | Crear
@endpush

@section('content')

	<div class="row">
        <div class="col-md-8">
            <solid-box title="Agregar proveedor" color="primary" button>
                {!! Form::open(['method' => 'POST', 'route' => 'paal.provider.store']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('social', ['tpl' => 'withicon'], ['icon' => 'truck']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('name', ['label' => 'Nombre comercial', 'tpl' => 'withicon'], ['icon' => 'comment']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('address', ['tpl' => 'withicon'], ['icon' => 'map-signs']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('city', ['tpl' => 'withicon'], ['icon' => 'globe']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('postcode', ['tpl' => 'withicon'], ['icon' => 'paper-plane']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('email', ['label' => 'Correo', 'tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('rfc', ['label' => 'R.F.C.', 'tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('company',
                            	['coffee' => 'Coffee Depot', 'mbe' => 'Mailboxes E', 'both' => 'Ambas'], null,
                            	['empty' => 'Seleccione empresa', 'tpl' => 'withicon'], ['icon' => 'trademark'])
                            !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('group',
                            	['of' => 'Oficiales', 'cc' => 'Caja chica', 'rp' => 'Reposición', 'ex' => 'Gastos extras'], null,
                            	['empty' => 'Seleccione grupo', 'tpl' => 'withicon', 'v-model' => 'provider_form.group'], ['icon' => 'object-ungroup'])
                            !!}
                        </div>
                        <div v-if="provider_form.group == 'of'" class="col-md-6">
                            {!! Field::select('type',
                                ['cv' => 'Costo/Venta', 'gg' => 'Gastos generales'], null,
                                ['empty' => 'Seleccione tipo', 'tpl' => 'withicon'], ['icon' => 'object-ungroup'])
                            !!}
                            <input type="hidden" name="is_deductible" value="1">
                        </div>
                        <div v-else-if="provider_form.group == 'cc'" class="col-md-6">
                            {!! Field::select('is_deductible', [1 => 'Sí', 0 => 'No'], null, 
                                ['label' => '¿Es deducible?', 'tpl' => 'withicon', 'empty' => '¿Es deducible?', 'v-model' => 'provider_form.deductible'], 
                                ['icon' => 'minus']) 
                            !!}
                        </div>
                        <div v-else>
                            <input type="hidden" name="is_deductible" value="1">
                            <input type="hidden" name="type" value="gg">
                        </div>
                    </div>

                    <div v-if="provider_form.deductible == '1'" class="row">
                        <div class="col-md-6">
                            {!! Field::select('type',
                                ['cv' => 'Costo/Venta', 'gg' => 'Gastos generales'], null,
                                ['empty' => 'Seleccione tipo', 'tpl' => 'withicon'], ['icon' => 'object-ungroup'])
                            !!}
                        </div>
                    </div>

                    <div v-else>
                        <input type="hidden" name="type" value="gg">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('contact', ['label' => 'Contacto', 'tpl' => 'withicon'], ['icon' => 'user']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('phone', ['label' => 'Teléfono', 'tpl' => 'withicon'], ['icon' => 'phone']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('amount', ['label' => 'Importe', 'tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'money']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('bills', ['label' => '# Facturas', 'tpl' => 'withicon'], ['icon' => 'file-invoice']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('xml_required', [1 => 'Sí', 0 => 'No'], 1, ['label' => '¿XML obligadorio?', 'tpl' => 'withicon', 'empty' => '¿Es requerido?'], ['icon' => 'file']) !!}
                        </div>
                    </div>

                    {!! Form::submit('Agregar', ['class' => 'btn btn-primary pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
