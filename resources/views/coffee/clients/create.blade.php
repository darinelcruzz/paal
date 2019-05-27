@extends('coffee.root')

@push('pageTitle')
    Clientes | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar cliente" color="danger" button>

                {!! Form::open(['method' => 'POST', 'route' => 'coffee.client.store']) !!}

                    {!! Field::text('name', ['tpl' => 'withicon'], ['icon' => 'user']) !!}
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('rfc', ['tpl' => 'withicon', 'label' => 'R.F.C.'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('email', ['tpl' => 'withicon'], ['icon' => 'at']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('city', ['label' => 'Ciudad/Municipio', 'tpl' => 'withicon'], ['icon' => 'map']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('state', ['tpl' => 'withicon'], ['icon' => 'globe']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('postcode', ['tpl' => 'withicon'], ['icon' => 'envelope']) !!}
                        </div>
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-danger pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection