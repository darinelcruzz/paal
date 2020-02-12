@extends('sanson.root')

@push('pageTitle', 'Cheques | Detalles')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <solid-box title="Facturas del cheque {{ $check->folio }}" color="info" button>



                <data-table example="1">

                    {{ drawHeader('fecha', 'folio', 'proveedor', 'PDF', 'I.V.A.', 'importe') }}

                    <template slot="body">
                        @foreach($check->egresses as $egress)
                            <tr style="text-align: center;">
                                <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                <td>
                                    {{ $egress->folio != '' ? $egress->folio: $egress->provider->name }}
                                </td>
                                <td>{{ $egress->folio != '' ? $egress->provider->name: $egress->provider_name  }}</td>
                                <td>
                                    <a href="{{ Storage::url($egress->pdf_bill) }}" target="_blank"><i class="fa fa-file-pdf"></i></a>&nbsp;
                                </td>
                                <td>$ {{ number_format($egress->iva, 2) }}</td>
                                <td>$  {{ number_format($egress->amount, 2) }}</td>
                            </tr>

                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr style="text-align: center;">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: center;">Total</th>
                            <td>${{ number_format($check->egresses->sum('iva'), 2) }}</td>
                            <td>${{ number_format($check->egresses->sum('amount'), 2) }}</td>
                        </tr>
                    </template>

                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
