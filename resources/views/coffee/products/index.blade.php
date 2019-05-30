@extends('coffee.root')

@push('pageTitle', 'Productos | Lista')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <solid-box title="Productos" color="danger">
                
                <data-table>

                    {{ drawHeader('ID', 'descripción', 'menudeo', 'mayoreo', '¿Dólares?') }}

                    <template slot="body">
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <a href="{{ route('coffee.product.edit', $product) }}">
                                        {{ $product->description }}                                        
                                    </a>
                                    |
                                    <code>{{ $product->code }}</code>
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