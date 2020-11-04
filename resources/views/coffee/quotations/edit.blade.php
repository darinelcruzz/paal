@extends('coffee.root')

@push('pageTitle')
    Cotización | Editar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Editar cotización {{ $quotation->id }}" color="{{ $quotation->type == 'insumos' ? 'danger': 'warning'}}">
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.quotation.update', $quotation]]) !!}

                    @if($quotation->client_name)
                        <div class="row">
                            <div class="col-md-12">
                                {!! Field::text('client', $quotation->client_name, 
                                    ['tpl' => 'withicon', 'disabled'],
                                    ['icon' => 'user']) 
                                !!}
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                {!! Field::text('client', $quotation->client->name, 
                                    ['tpl' => 'withicon', 'disabled'],
                                    ['icon' => 'user']) 
                                !!}
                            </div>
                        </div>
                    @endif

                    <br>
                    <shopping-list 
                        color="danger" 
                        :qproducts="{{ $quotation->products_list }}" 
                        :exchange="{{ $exchange }}"
                        :promo="{{ $promo }}">
                    </shopping-list>

                    {!! Form::submit('Guardar cambios', ['class' => "btn btn-". ($quotation->type == 'insumos' ? 'danger': 'warning') ." pull-right"]) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="danger">
                <p-table color="danger" :exchange="{{ $exchange }}" :promo="{{ $promo }}" type="coffee"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
