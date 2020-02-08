@extends('sanson.root')

@push('pageTitle')
    Cotización | Editar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Editar cotización {{ $quotation->id }}" color="{{ $quotation->type == 'proyecto' ? 'primary': 'info'}}">
                {!! Form::open(['method' => 'POST', 'route' => ['sanson.quotation.update', $quotation]]) !!}

                    {!! Field::text('client', $quotation->client_name ?? $quotation->client->name, 
                        ['tpl' => 'withicon', 'disabled'],
                        ['icon' => 'user']) 
                    !!}

                    <h4 style="text-align:center;">PRODUCTOS</h4>
                    <shopping-cart color="info" :movements="{{ $quotation->movements }}" :promo="{{ $promo }}"></shopping-cart>

                    {!! Form::submit('Guardar cambios', ['class' => "btn btn-". ($quotation->type == 'proyecto' ? 'primary': 'info') ." pull-right"]) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-5">
            <solid-box title="Productos" color="{{ $quotation->type == 'proyecto' ? 'primary': 'info' }}">
                <p-table 
                    color="{{ $quotation->type == 'proyecto' ? 'primary': 'info'}}" 
                    :exchange="{{ $exchange }}" 
                    :promo="{{ $promo }}" 
                    type="sanson">
                </p-table>
            </solid-box>
        </div>
    </div>

@endsection
