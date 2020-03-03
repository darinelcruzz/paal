@extends('sanson.root')

@push('pageTitle', 'Productos | Lista')

@push('headerTitle')
    <a href="{{ route('sanson.product.create') }}" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10">
            <solid-box title="Productos" color="info">
                
                <data-table>

                    {{ drawHeader('ID', 'descripción', 'modelo', 'marca', 'MXN', 'USD', 'cantidad', 'mínimo') }}

                    <template slot="body">
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <a href="{{ route('sanson.product.edit', $product) }}">{{ $product->description }}</a>
                                </td>
                                <td><code>{{ $product->code }}</code></td>
                                <td>{{ $product->family }}</td>
                                @if($product->dollars)
                                    <td>{{ number_format($product->retail_price * $exchange, 2) }}</td>
                                    <td>{{ number_format($product->retail_price, 2) }}</td>
                                @else
                                    <td>{{ number_format($product->retail_price, 2) }}</td>
                                    <td>---</td>
                                @endif
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->minimum }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection