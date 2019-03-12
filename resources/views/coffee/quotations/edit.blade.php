@extends('coffee.root')

@push('pageTitle')
    Cotización | Editar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Editar cotización {{ $quotation->id }}" color="warning">
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.quotation.update', $quotation]]) !!}

                    <div class="row">
                        <div class="col-md-12">
                            {!! Field::text('client', $quotation->client->name, 
                                ['tpl' => 'withicon', 'disabled'],
                                ['icon' => 'user']) 
                            !!}
                        </div>
                    </div>
                    <br>
                    <shopping-list color="warning" :qproducts="{{ $quotation->products_list }}"></shopping-list>

                    {!! Form::submit('Guardar cambios', ['class' => 'btn btn-warning pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="warning">
                <p-table color="warning" :exchange="{{ env('EXCHANGE_RATE') }}"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
