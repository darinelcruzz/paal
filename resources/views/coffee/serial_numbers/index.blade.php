@extends('coffee.root')

@push('pageTitle', 'Números de serie')

@push('headerTitle')
    <a href="{{ route('coffee.serial_number.create') }}" class="btn btn-danger btn-sm"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;AGREGAR</a>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-10">
            <solid-box title="Números de serie" color="danger">
                
                <data-table>

                    {{ drawHeader('número', 'producto', 'compra', 'venta', 'estado', 'salida') }}

                    <template slot="body">
                        @foreach($serial_numbers as $serial_number)
                            <tr>
                                <td>{{ $serial_number->number }}</td>
                                <td>{{ $serial_number->product->description }}</td>
                                <td>
                                    {{ $serial_number->purchase->folio or $serial_number->purchase_id }}
                                </td>
                                <td>
                                    {{ $serial_number->ingress->folio or 'N/A' }}
                                </td>
                                <td>
                                    <span class="label label-{{ $serial_number->status == 'en inventario' ? 'default': 'success' }}">
                                        <small>{{ strtoupper($serial_number->status) }}</small>
                                    </span>
                                </td>
                                <td>
                                    @if($serial_number->released_at)
                                        {{ $serial_number->released_at }}
                                    @else
                                        {!! Form::open(['method' => 'post', 'route' => ['coffee.serial_number.release', $serial_number]]) !!}

                                        <div class="input-group input-group-sm">
                                            <input type="date" name="released_at" class="form-control">
                                            <span class="input-group-btn">
                                              <button type="submit" class="btn btn-success btn-flat btn-sm">
                                                  <i class="fa fa-check"></i>
                                              </button>
                                            </span>
                                        </div>

                                        {!! Form::close() !!}

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </template>
                    
                </data-table>

            </solid-box>
        </div>
    </div>

@endsection
