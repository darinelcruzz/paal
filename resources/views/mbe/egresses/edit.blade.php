@extends('mbe.root')

@push('pageTitle')
    Egresos | Editar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            <solid-box title="Modificar folio" color="success" button>
                {!! Form::open(['method' => 'POST', 'route' => ['mbe.egress.update', $egress]]) !!}

                    {!! Field::text('folio', $egress->folio, ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}

                    <hr>

                    {!! Form::submit('MODIFICAR', ['class' => 'btn btn-success pull-right']) !!}
                    
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection