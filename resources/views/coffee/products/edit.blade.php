@extends('coffee.root')

@push('pageTitle', 'Productos | Modificar precio')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="PRODUCTO" color="warning">

                {!! Form::open(['method' => 'POST', 'route' => ['coffee.product.update', $product]]) !!}

                    {!! Field::text('description', $product->description, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'comments']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('code', $product->code, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'code']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('barcode', $product->barcode, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            {!! Field::select('type', ['EQUIPO' => 'EQUIPO', 'VARIOS' => 'VARIOS'], $product->type,
                                ['tpl' => 'withicon', 'empty' => 'Elija tipo', 'disabled'],
                                ['icon' => 'cube'])
                            !!}
                        </div>
                        <div class="col-md-4">
                            {!! Field::text('category', $product->category, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'tag']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Field::text('family', $product->family, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'group']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            {!! Field::number('retail_price', $product->retail_price, ['label' => 'Precio', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'money']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Field::select('iva', ['No', 'Sí'], $product->iva, ['label' => '¿Aplicar IVA?', 'tpl' => 'withicon', 'empty' => '¿Aplicar IVA?'], ['icon' => 'hand-holding-usd']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Field::select('dollars', ['No', 'Sí'], $product->dollars, ['label' => '¿En dólares?', 'tpl' => 'withicon', 'empty' => '¿Precio es en dólares?'], ['icon' => 'question'])
                            !!}
                        </div>
                    </div>

                    @if ($product->wholesale_quantity > 0)
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::number('wholesale_price', $product->wholesale_price,
                                    ['label' => 'Precio mayoreo', 'tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'tags'])
                                !!}
                            </div>
                            <div class="col-md-6">
                            {!! Field::number('wholesale_quantity', $product->wholesale_quantity, ['label' => 'Cantidad mayoreo (dejar en 0 si no aplica)', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'boxes']) !!}
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            {!! Field::select('status', ['activo' => 'Activo', 'inactivo' => 'Inactivo/descontinuado'], $product->status, ['tpl' => 'withicon', 'label' => 'Estado', 'empty' => 'Elegir'], ['icon' => 'toggle-on']) !!}
                        </div>
                    </div>


                    <hr>

                    <button type="submit" class="btn btn-warning pull-right">
                        <i class="fa fa-check"></i>&nbsp;&nbsp; M O D I F I  C A R
                    </button>

                    <a href="{{ route('coffee.product.index') }}" class="btn btn-default pull-left">
                        <i class="fa fa-backward"></i> &nbsp;&nbsp;<b>ATRÁS</b>
                    </a>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection