@extends('sanson.root')

@push('pageTitle', 'Egresos | Editar')

@section('content')

    <div class="row">

        <div class="col-md-3">

            <solid-box title="Modificar folio" color="info" button>

                {!! Form::open(['method' => 'POST', 'route' => ['sanson.egress.update', $egress]]) !!}

                    {!! Field::text('folio', $egress->folio, ['tpl' => 'withicon'], ['icon' => 'barcode']) !!} <hr>

                    {!! Form::submit('MODIFICAR', ['class' => 'btn btn-info pull-right']) !!}
                    
                {!! Form::close() !!}

            </solid-box>

        </div>

    </div>

@endsection