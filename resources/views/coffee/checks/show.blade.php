@extends('coffee.root')

@push('pageTitle')
    Cheques | Detalles
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">

            <solid-box title="Facturas del cheque {{ $check->folio }}" color="danger" button>



                <data-table example="1">

                    {{ drawHeader('folio', 'proveedor', 'fecha', 'PDF', 'I.V.A.', 'importe') }}

                    <template slot="body">
                        @foreach($check->egresses as $egress)
                            <tr style="text-align: center;">
                                <td>
                                    {{ $egress->folio }}
                                </td>
                                <td>{{ $egress->provider->name }}</td>
                                <td>{{ fdate($egress->emission, 'd M Y', 'Y-m-d') }}</td>
                                <td>
                                    <a href="{{ Storage::url($egress->pdf_bill) }}" target="_blank"><i class="fa fa-file-pdf"></i></a>&nbsp;
                                </td>
                                <td>$ {{ number_format($egress->iva, 2) }}</td>
                                <td>$  {{ number_format($egress->amount, 2) }}</td>
                            </tr>

                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                            <td>${{ number_format($check->egresses->sum('iva'), 2) }}</td>
                            <td>${{ number_format($check->egresses->sum('amount'), 2) }}</td>
                        </tr>
                    </template>

                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
