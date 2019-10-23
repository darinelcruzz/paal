@extends('mbe.root')

@push('pageTitle')
    Empresariales
@endpush

@section('content')
    <div class="row">
        
        <div class="col-md-12">

            <solid-box title="{{ $client->name }}" color="success">
                
                <data-table>

                    {{ drawHeader('OT', 'fecha', 'i.V.A.', 'monto') }}

                    <template slot="body">
                        @foreach($client->ingresses as $ingress)
                            <tr>
                                <td>
                                    {{ $ingress->folio }}
                                </td>
                                <td>
                                    {{ $ingress->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    $ {{ number_format($ingress->iva, 2) }}
                                </td>
                                <td>
                                    $ {{ number_format($ingress->amount, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </template>

                    <template slot="footer">
                        <tr>
                            <td colspan="2"></td>
                            <th>Total</th>
                            <td>
                                $ {{ number_format($client->ingresses->sum('amount'), 2) }}
                            </td>
                        </tr>
                    </template>   
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection