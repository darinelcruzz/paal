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
                        <div class="col-md-8">
                            {!! Field::select('family', 
                                ['ACCESORIOS' => 'ACCESORIOS', 'BARRAS' => 'BARRAS', 'EQUIPOS' => 'EQUIPOS', 'INSUMOS' => 'INSUMOS', 'SERVICIOS' => 'SERVICIOS', 'REFACCIONES' => 'REFACCIONES', 'OTROS' => 'OTROS'], 
                                null, ['tpl' => 'withicon', 'empty' => 'Seleccione una familia'], ['icon' => 'group']) 
                            !!}  
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