@extends('sanson.root')

@push('pageTitle', 'Compra | Agregar')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar compra [{{ $last_folio }}]" color="info">
                {!! Form::open(['method' => 'POST', 'route' => 'sanson.purchase.store', 'ref' => 'cform']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('provider_id', $order->provider->name, ['tpl' => 'withicon', 'disabled' => 'true'], ['icon' => 'truck']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::date('purchased_at', date('Y-m-d'), ['tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::text('folioE', ['label' => 'Folio', 'tpl' => 'withicon', 'ph' => 'XXXXX'], ['icon' => 'barcode']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::number('expiration', 0, ['tpl' => 'withicon', 'min' => '0'], ['icon' => 'clock-o']) !!}
                        </div>
                    </div>

                    @if($order->already_movements->count() > 0)
                        <code><small>OTROS PRODUCTOS DE ESTA ORDEN (#{{ $order->id }})</small></code>
                        <table class="table">
                            <tbody>
                                @foreach($order->already_movements as $movement)
                                <tr>
                                    <td></td>
                                    <td style="width: 31%;">{{ $movement->product->description }}</td>
                                    <td style="text-align: left;">{{ number_format($movement->price, 2) }}</td>
                                    <td style="text-align: center;width: 15%;">{{ $movement->quantity }}</td>
                                    <td style="text-align: right;">-{{ $movement->discount }}%</td>
                                    <td style="text-align: right;">{{ number_format($movement->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <code><small>LOS QUE HACEN FALTA</small></code>
                    @endif
                    <shopping-cart color="info" :movements="{{ $order->not_yet_movements }}" :promo="{{ $promo }}" :maxdiscount="99"></shopping-cart>

                    <input type="hidden" name="purchased_at" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="company" value="sanson">
                    <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                    <input type="hidden" name="folio" value="{{ $last_folio }}">
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="provider_id" value="{{ $order->provider_id }}">

                    {!! Form::submit('Agregar', ['class' => 'btn btn-info pull-right']) !!}

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="info">
                
                <p-table color="info" :exchange="{{ $exchange }}" type="sanson"></p-table>

            </solid-box>
        </div>
    </div>

@endsection
