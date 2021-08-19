@extends('sanson.root')

@push('pageTitle')
    Productos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar producto" color="info" button>

                {!! Form::open(['method' => 'POST', 'route' => 'sanson.product.store']) !!}

                    {!! Field::text('description', ['tpl' => 'withicon'], ['icon' => 'comments']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('code', ['label' => 'Clave/Modelo', 'tpl' => 'withicon'], ['icon' => 'code']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('barcode', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('family', 
                                ['EQUIPOS SANSON' => 'EQUIPOS SANSON', 'REFACCIONES SANSON' => 'REFACCIONES SANSON', 'RHINO' => 'RHINO', 'IMBERA' => 'IMBERA', 'MIGSA' => 'MIGSA'], 
                                null, 
                                ['label' => 'Marca', 'tpl' => 'withicon', 'empty' => 'Elija marca'], 
                                ['icon' => 'tag']) 
                            !!}  
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('iva', ['No', 'Sí'], 0, ['tpl' => 'withicon', 'empty' => '¿Aplica I.V.A.?'], ['icon' => 'hand-holding-usd']) !!}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('retail_price', 0, ['label' => 'Precio', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('dollars', ['No', 'Sí'], 0, ['tpl' => 'withicon', 'empty' => '¿Precio es en dólares?'], ['icon' => 'question']) 
                            !!} 
                        </div>
                    </div>

                    <input type="hidden" name="company" value="SANSON">
                    <input type="hidden" name="is_variable" value="1">

                    <button type="submit" class="btn btn-info pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
