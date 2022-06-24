@extends('paal.root')

@push('pageTitle')
    Egresos | Editar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            <solid-box title="Modificar folio" color="primary" button>
                {!! Form::open(['method' => 'POST', 'route' => ['paal.egress.update', $egress]]) !!}

                    {!! Field::text('folio', $egress->folio, ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}

                    <hr>

                    {!! Form::submit('MODIFICAR', ['class' => 'btn btn-primary pull-right']) !!}
                    
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection