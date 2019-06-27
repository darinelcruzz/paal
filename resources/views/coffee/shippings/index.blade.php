@extends('coffee.root')

@push('pageTitle', 'Envíos | Lista')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Envíos" color="danger">
                
                <data-table>

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>', 'cliente', 'dirección', 'enviado', 'entregado', 'empresa', 'estado', 'observaciones') }}

                    <template slot="body">
                        @foreach($shippings as $shipping)
                            <tr>
                                <td>{{ $shipping->id }}</td>
                                <td>
                                    <dropdown color="danger" icon="cogs">
                                        @if (!$shipping->guide_number)
                                            <ddi icon="plus" to="{{ route('coffee.shipping.addInfo', $shipping) }}" text="Número de guía"></ddi>
                                        @else
                                            <ddi icon="check" to="{{ route('coffee.shipping.edit', $shipping) }}" text="Entregado"></ddi>
                                        @endif
                                        <li>
                                            <a href="{{ route('coffee.shipping.print', $shipping) }}" target="_blank">
                                                <i class="fa fa-print"></i> Rótulo
                                            </a>
                                        </li>
                                    </dropdown>
                                </td>
                                <td style="width: 20%">
                                    {{ $shipping->ingress->client->name }}
                                    ({{ $shipping->ingress->folio }})
                                </td>
                                <td>
                                    {{ $shipping->address or 'No se proporcionó' }}
                                </td>
                                <td>
                                    {{ fdate($shipping->shipped_at, 'd \d\e F, Y', 'Y-m-d') }} <br>
                                    <code>{{ $shipping->guide_number }}</code>
                                </td>
                                <td>
                                    {{ $shipping->delivered_at }}
                                </td>
                                <td>{{ strtoupper($shipping->company) }}</td>
                                <td>
                                    <span class="label label-{{ $shipping->color }}">{{ strtoupper($shipping->status) }}</span>
                                </td>
                                <td>{{ $shipping->observations }}</td>

                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection