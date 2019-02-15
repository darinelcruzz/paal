@extends('paal.root')

@push('pageTitle')
    Proveedores | Editar
@endpush

@section('content')

	<div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar proveedor" color="primary" button>
                {!! Form::open(['method' => 'POST', 'route' => 'paal.provider.update']) !!}

                    {!! Field::text('social', $provider->social, ['tpl' => 'withicon'], ['icon' => 'truck']) !!}
                    {!! Field::text('name', $provider->name, ['label' => 'Nombre comercial', 'tpl' => 'withicon'], ['icon' => 'comment']) !!}
                    {!! Field::text('address', $provider->address, ['tpl' => 'withicon'], ['icon' => 'map-signs']) !!}
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('city', $provider->city, ['tpl' => 'withicon'], ['icon' => 'globe']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('postcode', $provider->postcode, ['tpl' => 'withicon'], ['icon' => 'paper-plane']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('rfc', $provider->rfc, ['label' => 'R.F.C.', 'tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('email', $provider->email, ['label' => 'Correo', 'tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('type',
                            	['cv' => 'Costo/Venta', 'gg' => 'Gastos generales'], $provider->type,
                            	['empty' => 'Seleccione tipo', 'tpl' => 'withicon'], ['icon' => 'object-ungroup'])
                            !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('company',
                            	['coffee' => 'Coffee Depot', 'mbe' => 'Mailboxes E', 'both' => 'Ambas'], $provider->company,
                            	['empty' => 'Seleccione empresa', 'tpl' => 'withicon'], ['icon' => 'trademark'])
                            !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('contact', $provider->contact, ['label' => 'Contacto', 'tpl' => 'withicon'], ['icon' => 'user']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('phone', $provider->phone, ['label' => 'Teléfono', 'tpl' => 'withicon'], ['icon' => 'phone']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('amount', $provider->amount, ['label' => 'Importe', 'tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'money']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('bills', $provider->bills, ['label' => '# Facturas', 'tpl' => 'withicon'], ['icon' => 'file-invoice']) !!}
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{ $provider->id }}">
                    <input type="hidden" name="status" value="activo">
                    {!! Form::submit('Modificar', ['class' => 'btn btn-primary pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
