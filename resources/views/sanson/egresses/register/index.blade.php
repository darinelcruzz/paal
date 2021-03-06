@extends('sanson.root')

@push('pageTitle', 'Egresos | Caja chica')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <solid-box title="Agregar cheque" color="info" button>
                {!! Form::open(['method' => 'POST', 'route' => 'sanson.check.store', 'enctype' => 'multipart/form-data']) !!}

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

                    <input type="hidden" name="company" value="sanson">

                    <button type="submit" class="btn btn-info pull-right" onclick="submitForm(this);">Agregar</button>

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-8">
            <solid-box title="Cheques" color="info" button>
                
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><i class="fa fa-cogs"></i></th>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($checks as $check)
                            <tr>
                                <td>
                                    <dropdown color="info" icon="cogs">
                                        <ddi to="{{ route('sanson.egress.register.create', $check) }}" icon="plus" text="Agregar factura"></ddi>
                                        <ddi to="{{ Storage::url($check->pdf) }}" icon="file-pdf" text="PDF" target="_blank"></ddi>
                                        <ddi to="{{ route('sanson.check.show', $check) }}" icon="eye" text="Detalles"></ddi>
                                        <ddi to="{{ route('sanson.check.edit', $check) }}" icon="edit" text="Editar"></ddi>
                                    </dropdown>
                                </td>
                                <td>{{ $check->folio }}</td>
                                <td>{{ $check->charged_at }}</td>
                                <td>$ {{ number_format($check->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </solid-box>
        </div>
    </div>

@endsection
