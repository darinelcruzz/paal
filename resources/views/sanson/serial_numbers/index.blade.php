@extends('sanson.root')

@push('pageTitle', 'Números de serie')

@push('headerTitle')
    <a href="{{ route('sanson.serial_number.create') }}" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10">
            <solid-box title="Números de serie" color="info">
                
                <data-table>

                    {{ drawHeader('número', 'producto', 'compra', 'venta', 'estado', 'salida') }}

                    <template slot="body">
                        @foreach($serial_numbers as $serial_number)
                            <tr>
                                <td>{{ $serial_number->number }}</td>
                                <td>
                                    <a href="{{ route('sanson.product.show', $serial_number->product) }}">
                                        {{ $serial_number->product->description }}
                                    </a>
                                </td>
                                <td>
                                    {{ $serial_number->purchase->folio or $serial_number->purchase_id }}
                                </td>
                                <td>
                                    {{ $serial_number->ingress->folio or 'N/A' }}
                                </td>
                                <td>
                                    <span class="label label-{{ $serial_number->status == 'en inventario' ? 'default': 'success' }}">
                                        <small>{{ strtoupper($serial_number->status) }}</small>
                                    </span>
                                </td>
                                <td>{{ $serial_number->released_at }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
