@extends('mbe.root')

@push('pageTitle', 'Clientes | Editar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Editar cliente" color="success" button>

                {!! Form::open(['method' => 'POST', 'route' => ['mbe.client.update', $client]]) !!}

                    {!! Field::text('name', $client->name, ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                    
                    {!! Field::text('rfc', $client->rfc, ['tpl' => 'withicon', 'label' => 'R.F.C.'], ['icon' => 'barcode']) !!}

                    <input type="hidden" name="email" value="ejemplo@dominio.com">
                    <input type="hidden" name="company" value="mbe">

                    <hr>

                    <button type="submit" class="btn btn-success pull-right">GUARDAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
