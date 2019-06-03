@extends('coffee.root')

@push('pageTitle', 'Envíos | Lista')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Envíos" color="danger">
                
                <data-table>

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>', 'venta', 'número de guía', 'estado') }}

                    <template slot="body">
                        @foreach($shippings as $shipping)
                            <tr>
                                <td>{{ $shipping->id }}</td>
                                <td>
                                    <dropdown color="danger" icon="cogs">
                                        @if (!$shipping->guide_number)
                                            <li>
                                                <a type="button" data-toggle="modal" data-target="#addGuideNumberModal{{ $shipping->id }}">
                                                    <i class="fa fa-plus"></i> Agregar # guía
                                                </a>
                                            </li>
                                        @else
                                            <ddi icon="check" to="{{ route('coffee.shipping.edit', [$shipping, 'entregado']) }}" text="Entregado"></ddi>
                                        @endif
                                        {{-- <ddi icon="exclamation" to="{{ route('coffee.shipping.edit', [$shipping, 'error']) }}" text="Error"></ddi> --}}
                                        <li>
                                            <a href="{{ route('coffee.shipping.print', $shipping) }}" target="_blank">
                                                <i class="fa fa-print"></i> Rótulo
                                            </a>
                                        </li>
                                    </dropdown>

                                    <modal title="Agregar número de guía" id="addGuideNumberModal{{ $shipping->id }}" color="#dd4b39">
                                        @include('coffee.shippings._add_guide_number')
                                    </modal>
                                </td>
                                <td>
                                    {{ $shipping->ingress->folio }}
                                </td>
                                <td>{{ $shipping->guide_number }}</td>
                                <td>
                                    <span class="label label-{{ $shipping->color }}">{{ strtoupper($shipping->status) }}</span>
                                </td>

                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection