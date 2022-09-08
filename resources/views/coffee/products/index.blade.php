@extends('coffee.root')

@push('pageTitle', 'Productos | Lista')

@push('headerTitle')
    <div class="row">
        <div class="col-md-6">
            @if(auth()->user()->level <= 2)
            <a href="{{ route('coffee.product.create') }}" class="btn btn-warning btn-xs"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
            @endif
        </div>
        <div class="col-md-3">
            @if(isAdmin())
            {!! Form::open(['method' => 'post', 'route' => 'coffee.product.import', 'enctype' => 'multipart/form-data']) !!}
                <div class="input-group input-group-sm">
                    <input type="file" name="products" class="form-control">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-upload"></i></button>
                    </span>
                </div>
            {!! Form::close() !!}
            @endif            
        </div>
        <div class="col-md-3">
            <a href="{{ route('coffee.product.export') }}" class="btn btn-success btn-xs pull-right">
                <i class="fa fa-file-excel"></i>&nbsp;&nbsp;EXPORTAR&nbsp;&nbsp;<i class="fa fa-file-export"></i>
            </a>
        </div>
    </div>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <solid-box title="Lista" color="warning">
                
                <table class="table table-striped table-bordered spanish">
                    <thead>
                        <tr>
                            <th><small>ID</small></th>
                            <th><small><i class="fa fa-cogs"></i></small></th>
                            <th><small>DESCRIPCIÓN</small></th>
                            <th><small>CÓDIGO</small></th>
                            <th><small>CATEGORÍA</small></th>
                            <th><small>FAMILIA</small></th>
                            <th><small>TIPO</small></th>
                            <th><small>MENUDEO</small></th>
                            <th><small>MAYOREO</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <dropdown icon="cogs" color="warning">
                                        <ddi icon="edit" to="{{ route('coffee.product.edit', $product) }}" text="Editar"></ddi>
                                        @if($product->type == 'EQUIPO' && (auth()->user()->level == 0 || auth()->user()->id == 4))
                                            <ddi icon="barcode" to="{{ route('coffee.product.serialize', $product) }}" text="Hacer seriable"></ddi>
                                        @endif
                                    </dropdown>
                                </td>
                                <td><small>{{ $product->description }}</small></td>
                                <td>{{ $product->code }}</td>
                                <td><small>{{ $product->category }}</small></td>
                                <td><small>{{ $product->family }}</small></td>
                                <td>
                                    <span class="label label-{{ $product->type ? ($product->type == 'EQUIPO' ? 'danger': 'warning'): 'default' }}">
                                        <small>{{ $product->type ?? 'SIN DEFINIR' }}</small>
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <small>{{ $product->dollars ? 'USD ': '' }}</small>{{ number_format($product->retail_price, 2) }}
                                </td>
                                <td style="text-align: right;">
                                    <small>{{ $product->dollars ? 'USD ': '' }}</small>{{ number_format($product->wholesale_price, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>

            </solid-box>
        </div>
    </div>

@endsection
