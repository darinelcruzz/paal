@extends('sanson.root')

@push('pageTitle')
    Productos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar producto" color="info" button>

                {!! Form::open(['method' => 'POST', 'route' => ['sanson.product.update', $product]]) !!}

                    {!! Field::text('description', $product->description, ['tpl' => 'withicon'], ['icon' => 'comments']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('code', $product->code, ['label' => 'Clave/Modelo', 'tpl' => 'withicon'], ['icon' => 'code']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('barcode', $product->barcode, ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('family', 
                                ['SANSON' => 'SANSON', 'RHINO' => 'RHINO', 'IMBERA' => 'IMBERA'], 
                                $product->family, 
                                ['label' => 'Marca', 'tpl' => 'withicon', 'empty' => 'Elija marca'], 
                                ['icon' => 'tag']) 
                            !!}  
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('iva', ['No', 'Sí'], $product->iva, ['tpl' => 'withicon', 'empty' => '¿Aplica I.V.A.?'], ['icon' => 'hand-holding-usd']) !!}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('retail_price', $product->retail_price, ['label' => 'Precio', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('dollars', ['No', 'Sí'], $product->dollars, ['tpl' => 'withicon', 'empty' => '¿Precio es en dólares?'], ['icon' => 'question']) 
                            !!} 
                        </div>
                    </div>

                    <input type="hidden" name="company" value="SANSON">

                    <button type="submit" class="btn btn-info pull-right">GUARDAR CAMBIOS</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection