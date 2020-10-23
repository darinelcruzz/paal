@extends('coffee.root')

@push('pageTitle', 'Compras | Lista')

@push('headerTitle')
    <a href="{{ route('coffee.purchase.create') }}" class="btn btn-danger btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10">
            <solid-box title="Compras" color="danger">
                
                <data-table>

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>', 'fecha', 'proveedor', 'monto', 'estado') }}

                    <template slot="body">
                        @foreach($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->id }}</td>
                                <td>
                                    <dropdown color="danger" icon="cogs">
                                        <ddi to="{{ route('coffee.purchase.edit', $purchase) }}" icon="edit" text="Editar"></ddi>
                                    </dropdown>
                                </td>
                                <td>{{ $purchase->purchased_at }}</td>
                                <td>{{ $purchase->provider->name }}</td>
                                <td>{{ number_format($purchase->amount, 2) }}</td>
                                <td><span class="label label-{{ $purchase->color }}">{{ strtoupper($purchase->status) }}</span></td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
