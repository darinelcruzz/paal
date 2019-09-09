@extends('paal.root')

@push('pageTitle')
    Productos | Lista
@endpush

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
                <solid-box title="Productos Coffee Depot" color="danger">
                
                    <data-table example="1">

                        {{ drawHeader('ID', '<i class="fa fa-cogs"></i>', 'descripción', 'familia', 'menudeo', 'mayoreo', 'cantidad') }}

                        <template slot="body">
                            @foreach($products as $product)
                                <tr>
                                    <td style="width: 5%">{{ $product->id }}</td>
                                    <td style="width: 5%">
                                        <dropdown icon="cogs" color="danger">
                                            <ddi to="{{ route('paal.product.edit', $product) }}" icon="edit" text="Editar"></ddi>
                                        </dropdown>
                                    </td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->family }}</td>
                                    <td>$ {{ number_format($product->retail_price, 2) }}</td>
                                    <td>$ {{ number_format($product->wholesale_price, 2) }}</td>
                                    <td>{{ $product->wholesale_quantity }}</td>
                                </tr>
                            @endforeach
                        </template>
                        
                    </data-table>

                </solid-box>
            @else
                <solid-box title="Productos Mailboxes" color="success">
                
                    <data-table example="1">

                        {{ drawHeader('ID', '<i class="fa fa-cogs"></i>', 'descripción', 'familia') }}

                        <template slot="body">
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
                        </template>
                        
                    </data-table>

                </solid-box>
            @endif
        </div>
    </div>

@endsection