@extends('paal.root')

@push('pageTitle', 'Cheques | Editar')

@section('content')

    <div class="row">

        <div class="col-md-4">

            <solid-box title="Editar cheque" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => ['paal.check.update', $check], 'enctype' => 'multipart/form-data']) !!}

                    {!! Field::number('folio', $check->folio, 
                        ['tpl' => 'withicon'], 
                        ['icon' => 'barcode']) 
                    !!}
                        
                    {!! Field::date('charged_at', $check->charged_at, ['label' => 'Fecha', 'tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                    
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

    </div>

@endsection
