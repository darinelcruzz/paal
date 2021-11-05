@extends('coffee.root')

@push('pageTitle', 'Productos | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar producto" color="danger" button>

                {!! Form::open(['method' => 'POST', 'route' => 'coffee.product.store']) !!}

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
                            {!! Field::select('category', $categories, null, 
                                ['tpl' => 'withicon', 'empty' => 'Elija categoría', 'v-model' => 'provider'], 
                                ['icon' => 'tag']) 
                            !!}  
                        </div>
                        <div class="col-md-6">
                            @foreach($categories as $category => $some)
                            <div v-if="provider == '{{ $category }}'" class="form-group">
                                <label for="familym" class="control-label"><b>Familia</b></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                    <select name="family" class="form-control">
                                        <option value="" selected>Elija una familia</option>
                                        @foreach($families[$category] as $family => $data)
                                        <option value="{{ $family }}">{{ $family }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            {!! Field::number('retail_price', 0, ['label' => 'Precio', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'money']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Field::select('iva', ['No', 'Sí'], 0, ['label' => '¿Aplicar IVA?', 'tpl' => 'withicon', 'empty' => '¿Aplicar IVA?'], ['icon' => 'hand-holding-usd']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Field::select('dollars', ['No', 'Sí'], 0, ['label' => '¿En dólares?', 'tpl' => 'withicon', 'empty' => '¿Precio es en dólares?'], ['icon' => 'question']) 
                            !!} 
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::number('wholesale_quantity', 0, ['label' => 'Cantidad mayoreo (dejar en 0 si no aplica)', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'boxes']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('wholesale_price', 0, ['label' => 'Precio mayoreo (dejar en 0 si no aplica)', 'tpl' => 'withicon', 'step' => '0.01', 'min' => '0'], ['icon' => 'dollar']) !!}
                        </div>
                    </div>

                    <input type="hidden" name="company" value="coffee">
                    <input type="hidden" name="is_variable" value="1">

                    <button type="submit" class="btn btn-danger pull-right">AGREGAR</button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
