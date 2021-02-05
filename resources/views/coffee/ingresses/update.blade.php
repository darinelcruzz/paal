@extends('coffee.root')

@push('pageTitle', 'Ventas | Números de serie')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar # de serie a los productos de la venta {{ $ingress->folio }}" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.serial_number.update', $ingress]]) !!}

                    @foreach($ingress->serial_numbers->groupBy('product.description') as $description => $serial_numbers)
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::text('', $description, ['tpl' => 'withicon','disabled'], ['icon' => 'comment-dots']) !!}
                            </div>
                            <div class="col-md-6">
                                @foreach($serial_numbers as $serial_number)
                                    <input type="hidden" name="items[]" value="{{ $serial_number->id }}">
                                    {!! Field::text('numbers[]', ['label' => '', 'ph' => '...0123456789'], ['icon' => 'barcode']) !!}
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {!! Form::submit('GUARDAR', ['class' => 'btn btn-danger pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
