@extends('coffee.root')

@push('pageTitle', 'Números de serie')

@push('headerTitle')
    <a href="{{ route('coffee.serial_number.create') }}" class="btn btn-danger btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Números de serie" color="danger">
                
                <data-table>

                    {{ drawHeader('número', 'producto', 'venta', 'estado') }}

                    <template slot="body">
                        @foreach($serial_numbers as $serial_number)
                            <tr>
                                <td>{{ $serial_number->number }}</td>
                                <td>{{ $serial_number->product->description }}</td>
                                <td style="text-align: center;">
                                    {{ $serial_number->ingress->folio or 'N/A' }}
                                </td>
                                <td style="text-align: center;">
                                    <span class="label label-{{ $serial_number->status == 'en inventario' ? 'default': 'success' }}">
                                        <small>{{ strtoupper($serial_number->status) }}</small>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
