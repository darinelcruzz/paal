@extends('paal.root')

@push('pageTitle')
    Productos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Agregar producto MBE" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => 'paal.product.store']) !!}

                    {!! Field::text('description', ['tpl' => 'withicon'], ['icon' => 'comments']) !!}

                    {!! Field::select('family', $families + (array_key_exists('UPS', $families) ? []: ['UPS' => 'UPS']), null, 
                        ['tpl' => 'withicon', 'empty' => 'Seleccione una familia'], 
                        ['icon' => 'group']) 
                    !!}

                    <input type="hidden" name="category" value="MBE">

                    <button type="submit" class="btn btn-primary pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection