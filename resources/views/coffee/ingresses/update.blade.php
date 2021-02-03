@extends('coffee.root')

@push('pageTitle', 'Ventas | Números de serie')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar # de serie a los productos de la venta {{ $ingress->folio }}" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.serial_number.update', $ingress]]) !!}

                    @foreach($ingress->serial_numbers as $serial_number)
                        <div class="row">
                            <div class="col-md-6">
                                {!! Field::text('', $serial_number->product->description, ['tpl' => 'withicon','disabled'], ['icon' => 'comment-dots']) !!}
                                <input type="hidden" name="items[]" value="{{ $serial_number->id }}">
                            </div>
                            <div class="col-md-6">
                                {!! Field::text('numbers[]', ['label' => '', 'tpl' => 'withicon', 'ph' => '...0123456789'], ['icon' => 'barcode']) !!}
                            </div>
                        </div>

                        <hr>
                    @endforeach

                    {!! Form::submit('GUARDAR', ['class' => 'btn btn-danger pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
