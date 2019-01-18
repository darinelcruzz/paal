@extends('coffee.root')

@push('pageTitle')
    Clientes | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Agregar cliente" color="danger" button>

                {!! Form::open(['method' => 'POST', 'route' => ['coffee.client.update', $client]]) !!}

                    {!! Field::text('name', $client->name, ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                    {!! Field::text('rfc', $client->rfc, ['tpl' => 'withicon', 'label' => 'R.F.C.'], ['icon' => 'barcode']) !!}

                    <hr>
                    
                    <button type="submit" class="btn btn-danger pull-right">MODIFICAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection