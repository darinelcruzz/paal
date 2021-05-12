@extends('sanson.root')

@push('pageTitle', 'Orden de compra | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Agregar orden de compra" color="info">
                {!! Form::open(['method' => 'POST', 'route' => 'sanson.order.store', 'ref' => 'cform']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('provider_id', $providers, null, ['tpl' => 'withicon', 'empty' => 'Seleccione un proveedor'], ['icon' => 'truck']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::date('ordered_at', date('Y-m-d'), ['tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                        </div>
                    </div>

                    <shopping-cart color="info" :exchange="{{ $exchange }}" :promo="{{ $promo }}" :maxdiscount="99"></shopping-cart>

                    <input type="hidden" name="company" value="sanson">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                    {!! Form::submit('Agregar', ['class' => 'btn btn-info pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-5">
            <solid-box title="Productos" color="info">
                <p-table 
                    color="info" 
                    :exchange="{{ $exchange }}" 
                    :promo="{{ $promo }}" 
                    type="sanson">
                </p-table>
            </solid-box>
        </div>
    </div>

@endsection
