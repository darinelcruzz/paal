@extends('coffee.root')

@push('pageTitle', 'Números de serie')

@push('headerTitle')
    <a href="{{ route('coffee.serial_number.create') }}" class="btn btn-danger btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <solid-box title="Números de serie" color="danger">

                <table class="table table-bordered table-striped spanish-simple">
                    <thead>
                        <tr>
                            <th><small>FECHA</small></th>
                            <th><small>NÚMERO</small></th>
                            <th><small>PRODUCTO</small></th>
                            <th style="text-align: center;"><small>COMPRA</small></th>
                            <th style="text-align: center;"><small>VENTA</small></th>
                            <th style="text-align: center;"><small>ESTADO</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($serial_numbers as $serial_number)
                            <tr>
                                <td>{{ fdate($serial_number->purchased_at, 'd/m/y', 'Y-m-d') }}</td>
                                <td>{{ $serial_number->number }}</td>
                                <td>{{ $serial_number->product->description }}</td>
                                <td style="text-align: center;">
                                    {{ $serial_number->purchase_id }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $serial_number->ingress->folio ?? 'S/V' }}
                                </td>
                                <td style="text-align: center;">
                                    <span class="label label-{{ $serial_number->status == 'en inventario' ? 'default': 'success' }}">
                                        <small>{{ strtoupper($serial_number->status) }}</small>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </solid-box>
        </div>
    </div>

@endsection
