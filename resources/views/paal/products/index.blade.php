@extends('paal.root')

@push('pageTitle', 'Productos | Lista')

@push('headerTitle')
    <a href="{{ route('paal.product.index') }}" class="btn btn-danger btn-sm">COFFEE DEPOT</a>
    <a href="{{ route('paal.product.index', 'mbe') }}" class="btn btn-success btn-sm">MAILBOXES</a>

    @if($company == 'coffee')
        <a href="{{ route('paal.product.create') }}" class="btn btn-danger btn-sm pull-right"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
    @else
        <a href="{{ route('paal.product.add') }}" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
    @endif
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($company == 'coffee')
                <solid-box title="PRODUCTOS" color="danger">
                
                    <table class="table table-striped table-bordered spanish">

                        <thead>
                            <tr>
                                <th style="width: 5%"><small>ID</small></th>
                                <th style="width: 5%"><small><i class="fa fa-cogs"></i></small></th>
                                <th><small>DESCRIPCION</small></th>
                                <th style="width: 5%;"><small>CÓDIGO</small></th>
                                <th><small>CATEGORÍA</small></th>
                                <th><small>FAMILIA</small></th>
                                <th style="width: 5%;"><small>CANTIDAD</small></th>
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
                                            <ddi to="{{ route('paal.product.edit', $product) }}" icon="edit" text="Editar"></ddi>
                                        </dropdown>
                                    </td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->category != '' ? $product->category: 'NO TIENE' }}</td>
                                    <td>{{ $product->family }}</td>
                                    <td style="text-align: center;">{{ $product->wholesale_quantity }}</td>
                                    <td style="text-align: right;">{{ number_format($product->retail_price, 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($product->wholesale_price == 0 ? $product->retail_price: $product->wholesale_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>

                </solid-box>
            @else
                <solid-box title="Productos Mailboxes" color="success">
                
                    <table class="table table-striped table-bordered spanish">

                        <thead>
                            <tr>
                                <th style="width: 5%"><small>ID</small></th>
                                <th style="width: 5%"><small><i class="fa fa-cogs"></i></small></th>
                                <th><small>DESCRIPCION</small></th>
                                <th><small>FAMILIA</small></th>
                            </tr>
                        </thead>

                        {{ drawHeader('ID', '<i class="fa fa-cogs"></i>', 'descripción', 'familia') }}

                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td style="width: 5%">{{ $product->id }}</td>
                                    <td style="width: 5%">
                                        <dropdown icon="cogs" color="success">
                                            <ddi to="{{ route('paal.product.edit', $product) }}" icon="edit" text="Editar"></ddi>
                                        </dropdown>
                                    </td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->family }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>

                </solid-box>
            @endif
        </div>
    </div>

@endsection