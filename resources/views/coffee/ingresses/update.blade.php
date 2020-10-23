@extends('coffee.root')

@push('pageTitle', 'Ventas | Números de serie')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Venta {{ $ingress->folio }}" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => ['coffee.serial_number.update', $ingress]]) !!}

                    @foreach($ingress->movements as $movement)
                        <div class="row">
                            <div class="col-md-6">
                                {{ $movement->product->description }}
                            </div>
                            <div class="col-md-6">
                                @for($i = 0; $i < $movement->quantity; $i++)
                                    <select name="numbers[]">
                                        <option value="">Seleccione un número de serie</option>
                                        @foreach($movement->product->serial_numbers as $serial_number)
                                            <option value="{{ $serial_number->id }}">{{ $serial_number->number }}</option>
                                        @endforeach
                                    </select><br><br>
                                @endfor
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
