@extends('paal.root')

@push('pageTitle')
    Productos | Lista
@endpush

@push('headerTitle')
    <a href="{{ route('paal.product.create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Productos" color="primary" button>
                
                <data-table example="1">

                    {{ drawHeader('ID', 'descripción', 'familia', 'menudeo', 'mayoreo', 'cantidad') }}

                    <template slot="body">
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    {{ $product->description }} &nbsp;&nbsp;
                                    <a href="{{ route('paal.product.edit', ['product' => $product->id]) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                                <td>{{ $product->family }}</td>
                                <td>$ {{ number_format($product->retail_price, 2) }}</td>
                                <td>$ {{ number_format($product->wholesale_price, 2) }}</td>
                                <td>{{ $product->wholesale_quantity }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection