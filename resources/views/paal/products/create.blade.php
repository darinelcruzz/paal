@extends('paal.root')

@push('pageTitle')
    Productos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Agregar producto" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => 'paal.product.store']) !!}

                    {!! Field::text('description', ['tpl' => 'withicon'], ['icon' => 'comment-o']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('code', ['tpl' => 'withicon'], ['icon' => 'code']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('barcode', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('family', 
                                ['ACCESORIOS' => 'ACCESORIOS', 'BARRAS' => 'BARRAS', 'EQUIPOS' => 'EQUIPOS', 'INSUMOS' => 'INSUMOS', 'SERVICIOS' => 'SERVICIOS', 'REFACCIONES' => 'REFACCIONES', 'OTROS' => 'OTROS'], 
                                null, ['tpl' => 'withicon', 'empty' => 'Seleccione una familia'], ['icon' => 'group']) 
                            !!}  
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('options', 
                                [1 => 'Precio en dólares', 2 => 'Aplica descuento', 3 => 'Ninguna'], 
                                null, ['tpl' => 'withicon', 'empty' => 'Seleccione una opción', 'v-model.number' => 'product_option'], ['icon' => 'money']) 
                            !!} 
                        </div>
                    </div>
                    
                    <div v-if="product_option == 1">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::number('retail_price', 0, ['label' => 'Precio en dólares', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                            </div>
                        </div>
                    </div>

                    <div v-if="product_option == 2">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::number('retail_price', 0, ['label' => 'Precio', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('iva', [1 => 'Sí', 0 => 'No'], null, ['tpl' => 'withicon', 'empty' => '¿Aplica I.V.A.?'], ['icon' => 'money']) !!}
                            </div>
                        </div>
                    </div>

                    <div v-if="product_option == 3">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::number('retail_price', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::number('wholesale_price', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'money']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::number('wholesale_quantity', 0, ['tpl' => 'withicon', 'min' => '0'], ['icon' => 'question']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('iva', [1 => 'Sí', 0 => 'No'], null, ['tpl' => 'withicon', 'empty' => '¿Aplica I.V.A.?'], ['icon' => 'money']) !!}
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection