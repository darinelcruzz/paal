@extends('mbe.root')

@push('pageTitle')
    Egresos | Reposición
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <solid-box title="Agregar reposición" color="success" button>
                {!! Form::open(['method' => 'POST', 'route' => 'mbe.egress.return.store', 'enctype' => 'multipart/form-data']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('returned_to', $users + [0 => 'Gastos Extra', 1 => 'Traspaso'], 2,
                                ['tpl' => 'withicon', 'label' => 'Reponer a', 'empty' => '¿A quién se repone?'],
                                ['icon' => 'user'])
                            !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('provider_name',
                                ['tpl' => 'withicon', 'label' => 'Nombre', 'ph' => 'ejemplo: Vips'],
                                ['icon' => 'trademark'])
                            !!}
                        </div>                       
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('folio', ['tpl' => 'withicon', 'ph' => 'XXXXX'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::date('emission', Date::now(), ['tpl' => 'withicon'], ['icon' => 'shopping-cart']) !!}
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
                            <label>Archivos</label><br>
                            <file-upload color="danger" bname="PDF" fname="pdf_bill" ext="pdf"></file-upload>
                            <template v-if="provider.xml_required == 1">
                                <file-upload color="primary" bname="XML" fname="xml" ext="xml"></file-upload>
                            </template>
                        </div>
                    </div>

                    <hr>
                    <input type="hidden" name="company" value="mbe">
                    <input type="hidden" name="expiration" value="0">
                    <button type="submit" class="btn btn-success pull-right" onclick="submitForm(this);">Agregar</button>

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
