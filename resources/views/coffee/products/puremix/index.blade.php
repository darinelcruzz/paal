@extends('coffee.root')

@push('pageTitle', 'PURE MIX | Lista')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="PURE MIX ESSENCE" color="danger">
                
                <data-table>

                    {{ drawHeader('ID', 'descripción', 'menudeo', 'mayoreo', 'cantidad') }}

                    <template slot="body">
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    {{ $product->description }} | <code>{{ $product->code }}</code>
                                </td>
                                <td>{{ number_format($product->retail_price, 2) }}</td>
                                <td>{{ number_format($product->wholesale_price, 2) }}</td>
                                <td>{{ $product->quantity }}</td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="COMPRA DE PURE" color="danger">
                
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.product.puremix.store']]) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('folio', ['tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::date('purchased_at', now(), ['tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9">
                            {!! Field::select('items[0][product_id]', $products->pluck('description', 'id')->toArray(), ['label' => 'Producto', 'empty' => 'Selecciona el producto']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Field::number('items[0][quantity]', 1, ['label' => 'Cantidad']) !!}
                        </div>
                    </div>

                    <div v-for="(item, index) in rproviders" :key="product_id" class="row">
                        <div class="col-md-9">
                            <br>
                            <select :name="'items[' + (index + 1) + '][product_id]'" class="form-control">
                                <option value="">Seleccione un producto</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <br>
                            <input type="number" :name="'items[' + (index + 1) + '][quantity]'" class="form-control" value="1">
                        </div>
                    </div>

                    <input type="hidden" name="provider_id" value="23">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="order_id" value="0">
                    <input type="hidden" name="amount" value="0">
                    <input type="hidden" name="company" value="coffee">

                    <hr>

                    <button type="button" class="btn btn-success pull-left" v-on:click="rproviders.push({product_id:1*rand, quantity:0})">
                        <i class="fa fa-plus"></i>&nbsp;PURE
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-warning" v-on:click="rproviders.pop()">
                        <i class="fa fa-times"></i>&nbsp;PURE
                    </button>

                    <button type="submit" class="btn btn-danger pull-right">
                        AGREGAR
                    </button>

                {!! Form::close() !!}

            </solid-box>
        </div>
    </div>

@endsection
