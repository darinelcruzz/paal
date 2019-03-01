@extends('coffee.root')

@push('pageTitle')
    Cotizaciones
@endpush

@push('headerTitle')
    
@endpush

@section('content')
    <div class="row">

        <div class="col-md-10">
            {!! Form::open(['method' => 'post', 'route' => 'coffee.quotation.index']) !!}
                
                <div class="row">
                    <div class="col-md-3">                        
                        <div class="input-group input-group-sm">
                            <input type="month" name="date" class="form-control" value="{{ $date }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}

            <br>

            <solid-box title="Cotizaciones" color="warning">

                <data-table example="1">

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>','fecha', 'cliente', 'IVA', 'total') }}

                    <template slot="body">
                        @foreach($quotations as $quotation)
                            <tr>
                                <td>{{ $quotation->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="warning">
                                        <ddi to="{{ route('coffee.quotation.show', $quotation) }}" icon="eye" text="Detalles"></ddi>
                                        <ddi to="{{ route('coffee.quotation.download', $quotation) }}" icon="file-pdf" text="Ver PDF"></ddi>
                                        <ddi to="{{ route('coffee.quotation.transform', $quotation) }}" icon="mug-hot" text="Crear venta"></ddi>
                                    </dropdown>
                                </td>
                                <td>{{ fdate($quotation->created_at, 'd M Y') }}</td>
                                <td style="width: 40%">{{ $quotation->client->name }}</td>
                                <td>$ {{ number_format($quotation->iva, 2) }}</td>
                                <td>$ {{ number_format($quotation->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </template>

                </data-table>

            </solid-box>
        </div>
    </div>

    @include('sweet::alert')

@endsection