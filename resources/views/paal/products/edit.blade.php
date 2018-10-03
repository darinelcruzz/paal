@extends('paal.root')

@push('pageTitle')
    Productos | Editar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Editar producto" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => ['paal.product.update', $product->id]]) !!}

                    {!! Field::text('description', $product->description, ['tpl' => 'withicon'], ['icon' => 'comment-o']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('code', $product->code, ['tpl' => 'withicon'], ['icon' => 'code']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('barcode', $product->barcode, ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            {!! Field::select('family', 
                                ['ACCESORIOS' => 'ACCESORIOS', 'BARRAS' => 'BARRAS', 'EQUIPOS' => 'EQUIPOS', 'INSUMOS' => 'INSUMOS', 'SERVICIOS' => 'SERVICIOS','REFACCIONES' => 'REFACCIONES', 'OTROS' => 'OTROS'], 
                                $product->family, ['tpl' => 'withicon', 'empty' => 'Seleccione una familia'], ['icon' => 'group']) 
                            !!}  
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('retail_price', $product->retail_price, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('wholesale_price', $product->wholesale_price, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'money']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            {!! Field::number('wholesale_quantity', $product->wholesale_quantity, ['tpl' => 'withicon', 'min' => '0'], ['icon' => 'question']) !!}
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary pull-right">EDITAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection