@extends('mbe.root')

@push('pageTitle')
    Envíos por paquetería
@endpush

@section('content')

<div class="row">
    @foreach($companies as $company => $product)

        @php
            $total = 0
        @endphp
        
        <div class="col-md-6">

            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-{{ $colors[$loop->index]}}">
                    <h3>{{ $company }}</h3>
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
                        @php
                            $total += $quantity;
                            $color = $colors[$loop->parent->index];
                        @endphp
                    @endforeach

                    <ul class="nav nav-stacked">
                        <li>
                            <a href="#">
                                <b>TOTAL</b><span class="pull-right badge bg-{{ $color }}">{{ $total }}</span>
                            </a>
                        </li>
                    </ul>

                    <br>
                </div>
            </div>

        </div>
    @endforeach
</div>

@endsection