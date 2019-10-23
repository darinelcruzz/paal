@extends('mbe.root')

@push('pageTitle')
    Envíos por paquetería
@endpush

@section('content')

<div class="row">
    @foreach($companies as $company => $product)
        
        <div class="col-md-6">

            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-{{ $colors[$loop->index]}}">
                    <h3>{{ $company }} <span class="pull-right">{{ array_sum(array_values($product)) }}</span></h3>
                </div>
                <div class="box-footer no-padding">
                    @foreach($product as $name => $quantity)
                        <ul class="nav nav-stacked">
                            <li>
                                <a href="#">
                                    {{ $name }} <span class="pull-right badge bg-{{ $colors[$loop->parent->index]}}">{{ $quantity }}</span>
                                </a>
                            </li>
                        </ul>
                    @endforeach
                </div>
            </div>

        </div>
    @endforeach
</div>

@endsection