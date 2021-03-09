@extends('sanson.root')

@push('pageTitle', 'Ventas | Números de serie')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar # de serie a los productos de la venta {{ $ingress->folio }}" color="info">
                {!! Form::open(['method' => 'POST', 'route' => ['sanson.serial_number.update', $ingress]]) !!}

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><small>PRODUCTO</small></th>
                                <th><small>NÚMERO(S) DE SERIE</small></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($ingress->movements as $movement)
                                @if($movement->product->is_seriable == 1)
                                    <tr>
                                        <td>{{ $movement->product->description }}</td>
                                        <td>
                                            @for($i = 0; $i < $movement->quantity; $i++)
                                                <select name="numbers[]">
                                                    <option value="">Seleccione un número de serie</option>
                                                    @foreach($movement->product->serial_numbers->where('ingress_id', null) as $serial_number)
                                                        <option value="{{ $serial_number->id }}">{{ $serial_number->number }} / {{ $serial_number->purchased_at }}</option>
                                                    @endforeach
                                                </select><br><br>
                                            @endfor
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>


                    {!! Form::submit('GUARDAR', ['class' => 'btn btn-info pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>
    </div>

@endsection
