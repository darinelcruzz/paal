@extends('coffee.root')

@push('pageTitle', 'Productos | Modificar precio')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="PRODUCTO" color="danger">

                {!! Form::open(['method' => 'POST', 'route' => ['coffee.product.update', $product]]) !!}

                    {!! Field::text('description', $product->description, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'comments']) !!}


                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('family', $product->family, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'group']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('category', $product->category, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'tag']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('code', $product->code, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'code']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('barcode', $product->barcode, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'barcode']) !!}
                        </div>
                    </div>

                    @if ($product->wholesale_quantity > 0)
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::number('retail_price', $product->retail_price, 
                                    ['tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'tag']) 
                                !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::number('wholesale_price', $product->wholesale_price, 
                                    ['tpl' => 'withicon', 'step' => '0.01'], ['icon' => 'tags']) 
                                !!}
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                {!! Field::number('retail_price', $product->retail_price, 
                                    ['tpl' => 'withicon', 'step' => '0.01', 'label' => 'Precio'], ['icon' => 'usd']) 
                                !!}
                            </div>
                        </div>
                    @endif

                    <hr>

                    <button type="submit" class="btn btn-danger pull-right">
                        <i class="fa fa-check"></i>&nbsp;&nbsp; MODIFICAR
                    </button>

                    <a href="{{ route('coffee.product.index') }}" class="btn btn-default pull-left">
                        <i class="fa fa-backward"></i> &nbsp;&nbsp;<b>ATRÁS</b>
                    </a>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

    @include('sweet::alert')

@endsection
