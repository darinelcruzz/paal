@extends('paal.root')

@push('pageTitle')
    Productos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-4">
            <solid-box title="Agregar producto" color="primary" button>

                {!! Form::open(['method' => 'POST', 'route' => 'paal.product.store']) !!}

                    {!! Field::text('description', ['tpl' => 'withicon'], ['icon' => 'comment-o']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('code', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('family', ['tpl' => 'withicon'], ['icon' => 'group']) !!}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('retail_price', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('wholesale_price', 0, ['tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'money']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            {!! Field::number('wholesale_quantity', 0, ['tpl' => 'withicon', 'min' => '0'], ['icon' => 'question']) !!}
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection