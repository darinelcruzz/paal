@extends('coffee.root')

@push('pageTitle', 'Productos | Lista')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Productos" color="danger">
                
                <data-table>

                    {{ drawHeader('ID', '<i class="fa fa-cogs"></i>', 'descripción', 'menudeo', 'mayoreo', '¿Dólares?') }}

                    <template slot="body">
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="danger">
                                        <ddi icon="edit" to="{{ route('coffee.product.edit', $product) }}" text="Editar"></ddi>
                                        @if(auth()->user()->level == 0)
                                            <ddi icon="barcode" to="{{ route('coffee.product.serialize', $product) }}" text="Hacer seriable"></ddi>
                                        @endif
                                    </dropdown>
                                </td>
                                <td>
                                    {{ $product->description }} | <code>{{ $product->code }}</code>
                                </td>
                                <td>$ {{ number_format($product->retail_price, 2) }}</td>
                                <td>$ {{ number_format($product->wholesale_price, 2) }}</td>
                                <td> {{ $product->dollars ? 'Sí': 'No' }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
