@extends('paal.root')

@push('pageTitle', 'Egresos | Gastos Extra')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <solid-box title="AGREGAR {{ $provider->name }}" color="primary" button>
                {!! Form::open(['method' => 'POST', 'route' => 'paal.egress.return.store', 'enctype' => 'multipart/form-data']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('provider_name',
                                ['tpl' => 'withicon', 'label' => 'Nombre', 'ph' => 'ejemplo: Vips'],
                                ['icon' => 'trademark'])
                            !!}
                        </div>  
                        <div class="col-md-6">
                            {!! Field::date('emission', Date::now(), ['label' => 'Fecha', 'tpl' => 'withicon'], ['icon' => 'shopping-cart']) !!}
                        </div>                     
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('category_id', $categories, 10, ['tpl' => 'withicon', 'empty' => 'Seleccione una opción', 'disabled'], ['icon' => 'project-diagram']) !!}
                            <input type="hidden" name="category_id" value="10">
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('group_id', $groups, null, ['tpl' => 'withicon', 'empty' => 'Seleccione una opción'], ['icon' => 'object-ungroup']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('amount', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'money']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('iva', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'percentage']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('method', ['check' => 'Cheque', 'transfer' => 'Transferencia', 'automatic' => 'Domiciliación'], null, ['tpl' => 'withicon', 'empty' => 'Método de pago'], ['icon' => 'question']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('folio', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>                        
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <label>Archivos</label><br>
                            <file-upload color="danger" bname="PDF" fname="pdf_bill" ext="pdf"></file-upload>
                            <file-upload color="primary" bname="XML" fname="xml" ext="xml"></file-upload>
                        </div>
                    </div>

                    <hr>
                    <input type="hidden" name="company" value="coffee">
                    <input type="hidden" name="expiration" value="0">
                    <input type="hidden" name="provider_id" value="{{ $provider->id }}">
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
