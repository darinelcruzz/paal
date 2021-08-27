@extends('coffee.root')

@push('pageTitle', 'Productos | Lista')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Productos" color="danger">
                
                <table class="table table-striped table-bordered spanish">
                    <thead>
                        <tr>
                            <th><small>ID</small></th>
                            <th><small><i class="fa fa-cogs"></i></small></th>
                            <th><small>DESCRIPCIÓN</small></th>
                            <th><small>CÓDIGO</small></th>
                            <th><small>CATEGORÍA</small></th>
                            <th><small>FAMILIA</small></th>
                            <th><small>MENUDEO</small></th>
                            <th><small>MAYOREO</small></th>
                        </tr>
                    </thead>

                    <tbody>
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
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->category }}</td>
                                <td>{{ $product->family }}</td>
                                <td style="text-align: right;">
                                    {{ number_format($product->retail_price, 2) }}{{ $product->dollars ? ' USD': '' }}
                                </td>
                                <td style="text-align: right;">
                                    {{ number_format($product->wholesale_price, 2) }}{{ $product->dollars ? ' USD': '' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>

            </solid-box>
        </div>
    </div>

@endsection
