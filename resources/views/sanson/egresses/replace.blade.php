@extends('coffee.root')

@push('pageTitle')
    Egresos | Reemplazar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            <solid-box title="Subir el archivo correcto" color="danger" button>
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.egress.replace', $egress], 'enctype' => 'multipart/form-data']) !!}

                    <div class="row">
                        
                        <div class="col-md-6">
                            <label>FACTURA</label><br>
                            <file-upload bname="SELECCIONAR ARCHIVO" fname="pdf_bill" ext="pdf" color="warning"></file-upload>
                        </div>
                    </div>

                    <hr>

                    {!! Form::submit('GUARDAR', ['class' => 'btn btn-danger pull-right']) !!}
                    
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection