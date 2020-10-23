@extends('coffee.root')

@push('pageTitle', 'Orden de compra | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Agregar orden de compra" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.order.store', 'ref' => 'cform']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('provider_id', $providers, null, ['tpl' => 'withicon', 'empty' => 'Seleccione un proveedor'], ['icon' => 'truck']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::date('ordered_at', date('Y-m-d'), ['tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                        </div>
                    </div>

                    <shopping-cart color="danger" :exchange="{{ $exchange }}" :promo="{{ $promo }}"></shopping-cart>

                    <input type="hidden" name="company" value="coffee">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                    {!! Form::submit('Agregar', ['class' => 'btn btn-danger pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-5">
            <solid-box title="Productos" color="danger">
                <p-table 
                    color="danger" 
                    :exchange="{{ $exchange }}" 
                    :promo="{{ $promo }}" 
                    type="coffee">
                </p-table>
            </solid-box>
        </div>
    </div>

@endsection
