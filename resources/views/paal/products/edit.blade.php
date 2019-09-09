@extends('paal.root')

@push('pageTitle')
    Productos | Editar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Editar producto" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => ['paal.product.update', $product]]) !!}
                
                @if($product->category == 'MBE')

                    {!! Field::text('description', $product->description, ['tpl' => 'withicon'], ['icon' => 'comments']) !!}

                    {!! Field::select('family', $families, $product->family, 
                        ['tpl' => 'withicon', 'empty' => 'Seleccione una familia'], 
                        ['icon' => 'group']) 
                    !!}

                @else


                    {!! Field::text('description', $product->description, ['tpl' => 'withicon'], ['icon' => 'comments']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('family', 
                                $families, 
                                $product->family, 
                                ['tpl' => 'withicon', 'empty' => 'Seleccione una familia'], 
                                ['icon' => 'group']) 
                            !!}  
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('is_summable', ['No', 'Sí'], $product->is_summable, 
                                ['tpl' => 'withicon', 'empty' => '¿Se suma?', 'label' => '¿Se suma?'], 
                                ['icon' => 'plus']) 
                            !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('code', $product->code, ['tpl' => 'withicon'], ['icon' => 'code']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('barcode', $product->barcode, ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('category', 
                                ['ACCESORIOS' => 'ACCESORIOS', 'BARRAS' => 'BARRAS', 'EQUIPOS' => 'EQUIPOS', 'INSUMOS' => 'INSUMOS', 'SERVICIOS' => 'SERVICIOS', 'REFACCIONES' => 'REFACCIONES', 'OTROS' => 'OTROS'],
                                [$product->category],
                                ['tpl' => 'withicon', 'empty' => 'Seleccione una categoría', 'v-model' => 'product_family', 'v-on:change' => 'reset'], 
                                ['icon' => 'tag']) 
                            !!}  
                        </div>
                        <div v-if="product_family == 'SERVICIOS'" class="col-md-6">
                            {!! Field::number('retail_price', $product->retail_price, ['label' => 'Precio', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                        </div>
                        <div v-if="product_family != '' && product_family != 'SERVICIOS'" class="col-md-6">
                            {!! Field::select('options', 
                                [1 => 'Precio en dólares', 2 => 'Aplica descuento', 3 => 'Ninguna'], 
                                null, ['tpl' => 'withicon', 'empty' => 'Seleccione una opción', 'v-model.number' => 'product_option'], ['icon' => 'list-ul']) 
                            !!} 
                        </div>
                    </div>
                    
                    <div v-if="product_option == 1">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::number('retail_price', $product->retail_price, ['label' => 'Precio en dólares', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                            </div>
                        </div>
                    </div>

                    <div v-if="product_option == 2">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::number('retail_price', $product->retail_price, ['label' => 'Precio', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('iva', [1 => 'Sí', 0 => 'No'], $product->iva, ['tpl' => 'withicon', 'empty' => '¿Aplica I.V.A.?'], ['icon' => 'hand-holding-usd']) !!}
                            </div>
                        </div>
                    </div>

                    <div v-if="product_option == 3">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::number('retail_price', $product->retail_price, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::number('wholesale_price', $product->wholesale_price, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'money']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::number('wholesale_quantity', $product->wholesome_quantity, ['tpl' => 'withicon', 'min' => '0'], ['icon' => 'question']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('iva', [1 => 'Sí', 0 => 'No'], $product->iva, ['tpl' => 'withicon', 'empty' => '¿Aplica I.V.A.?'], ['icon' => 'hand-holding-usd']) !!}
                            </div>
                        </div>
                    </div>

                    @endif

                    <button type="submit" class="btn btn-primary pull-right">Editar</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection