@extends('coffee.root')

@push('pageTitle', 'Números de serie | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Agregar número(s) de serie" color="danger">

                @if(!is_array($product))
                    {!! Form::open(['method' => 'POST', 'route' => ['coffee.serial_number.store', $product]]) !!}
                        
                        {!! Field::text('producto', $product->description, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'tags']) !!}

                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        {!! Field::number('purchase_id', ['tpl' => 'withicon', 'min' => '1'], ['icon' => 'truck']) !!}
                        
                        <multiple-inputs color="danger">
                            {!! Field::text('numbers[]', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </multiple-inputs>
                @else
                    {!! Form::open(['method' => 'POST', 'route' => 'coffee.serial_number.store']) !!}
                        
                        {!! Field::select('product_id', $product, null, ['tpl' => 'withicon', 'empty' => 'Seleccione un producto'], ['icon' => 'tags']) !!}
                        
                        {!! Field::number('purchase_id', ['tpl' => 'withicon', 'min' => '1'], ['icon' => 'truck']) !!}
                        
                        <multiple-inputs color="danger">
                            {!! Field::text('numbers[]', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </multiple-inputs>

                @endif

                <hr>

                    {!! Form::submit('AGREGAR', ['class' => 'btn btn-danger pull-right']) !!}

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
