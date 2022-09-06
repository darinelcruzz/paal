@extends('paal.root')

@push('pageTitle', 'Egresos | Caja chica')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Agregar cheque" color="primary" button>
                {!! Form::open(['method' => 'POST', 'route' => 'paal.check.store', 'enctype' => 'multipart/form-data']) !!}

                    {!! Field::number('folio', $last_folio + 1, 
                        ['tpl' => 'withicon'], 
                        ['icon' => 'barcode']) 
                    !!}
                        
                    {!! Field::date('charged_at', Date::now(), ['label' => 'Fecha', 'tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Cheque</label><br>
                            <file-upload color="danger" bname="PDF" fname="pdf" ext="pdf"></file-upload>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary pull-right" onclick="submitForm(this);">Agregar</button>

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-7">
            <solid-box title="Cheques" color="primary" button>
                
                <table class="table table-striped table-bordered table-hover table-condensed spanish-simple">
                    <thead>
                        <tr>
                            <th style="width: 25%;">F. Pago</th>
                            <th style="width: 5%;"><i class="fa fa-cogs"></i></th>
                            <th style="width: 5%; text-align: center;">Folio</th>
                            <th style="width: 5%;">Facturas</th>
                            <th style="width: 25%; text-align: center;">Origen</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($checks as $check)
                            <tr>
                                <td>{{ fdate($check->charged_at, 'd/m/y', 'Y-m-d') }}</td>
                                <td style="width: 5%;">
                                    <dropdown color="primary" icon="cogs">
                                        <ddi to="{{ route('paal.egress.register.create', $check) }}" icon="plus" text="Agregar factura"></ddi>
                                        <ddi to="{{ Storage::url($check->pdf) }}" icon="file-pdf" text="PDF" target="_blank"></ddi>
                                        <ddi to="{{ route('paal.check.show', $check) }}" icon="eye" text="Detalles"></ddi>
                                        <ddi to="{{ route('paal.check.edit', $check) }}" icon="edit" text="Editar"></ddi>
                                    </dropdown>
                                </td>
                                <td style="width: 10%; text-align: center;">{{ $check->folio }}</td>
                                <td style="text-align: center; width: 5%;">{{ $check->egresses->count() }}</td>
                                <td style="text-align: center;"><label class="label label-{{ $check->company == 'coffee' ? 'warning': 'primary' }}">{{ $check->company == 'coffee' ? 'COCINAS': 'LOGÍSTICA' }}</label></td>
                                <td style="text-align: right;">{{ number_format($check->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </solid-box>
        </div>
    </div>

@endsection
