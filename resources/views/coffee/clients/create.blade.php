@extends('coffee.root')

@push('pageTitle')
    Clientes | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Agregar cliente" color="danger" button>

                {!! Form::open(['method' => 'POST', 'route' => 'coffee.client.store']) !!}

                    {!! Field::text('name', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                    {!! Field::text('rfc', ['tpl' => 'withicon', 'label' => 'R.F.C.'], ['icon' => 'barcode']) !!}
                    {!! Field::text('email', ['tpl' => 'withicon'], ['icon' => 'at']) !!}

                    <hr>

                    <button type="submit" class="btn btn-danger pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection