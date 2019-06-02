@extends('coffee.root')

@push('pageTitle')
    Egresos | Editar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            <solid-box title="Modificar folio" color="danger" button>
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.egress.update', $egress]]) !!}

                    {!! Field::text('folio', $egress->folio, ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}

                    <hr>

                    {!! Form::submit('MODIFICAR', ['class' => 'btn btn-danger pull-right']) !!}
                    
                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection