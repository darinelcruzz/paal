@extends('coffee.root')

@push('pageTitle')
    Ingresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Crear ingreso" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.ingress.store']) !!}

                    <div class="row">
                        <div class="col-md-6">
                            {!! Field::select('client_id', $clients, null,
                                ['tpl' => 'withicon', 'empty' => 'Seleccione un cliente', 'required' => 'true'],
                                ['icon' => 'user'])
                            !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('is_retained', ['Sí', 'No'], 1,
                                ['tpl' => 'withicon', 'empty' => '¿Se deja anticipo?', 'v-model.number' => 'is_retained','required' => 'true'],
                                ['icon' => 'question'])
                            !!}
                        </div>
                    </div>

                    <shopping-list color="danger" :exchange="{{ env('EXCHANGE_RATE') }}"></shopping-list>

                    <modal title="Método de pago" id="next-step">
                        <template v-if="is_retained == 0">
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Field::select('methodA', ['Efectivo', 'T. Débito', 'T. Crédito', 'Cheque', 'Transferencia'], null,
                                        ['tpl' => 'withicon', 'empty' => 'Seleccione un método', 'v-model.number' => 'payment_method','required' => 'true'],
                                        ['icon' => 'credit-card'])
                                    !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Field::number('retainer', ['tpl' => 'withicon', 'step' => '0.01', 'v-model.number' => 'retainer'], ['icon' => 'usd']) !!}
                                </div>
                            </div>

                            <div v-if="payment_method > 0">
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Field::text('referenceA', ['tpl' => 'withicon', 'ph' => 'XXX-XXXX-XXXX', 'required' => 'true'], ['icon' => 'registered']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="form-control btn btn-success btn-xs">
                                                <i class="fa fa-plus-square"></i>&nbsp; A G R E G A R
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Field::number('received', ['tpl' => 'withicon', 'v-model.number' => 'amount_received', 'required' => 'true'], ['icon' => 'money']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cambio</label>
                                            <span class="form-control" style="color: green">@{{ (amount_received - retainer).toFixed(2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"></div><div class="col-md-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="form-control btn btn-success btn-xs">
                                                <i class="fa fa-plus-square"></i>&nbsp; A G R E G A R
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template v-else>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Field::select('method', ['Efectivo', 'T. Débito', 'T. Crédito', 'Cheque', 'Transferencia', 'Crédito'], null,
                                        ['tpl' => 'withicon', 'empty' => 'Seleccione un método', 'v-model.number' => 'payment_method','required' => 'true'],
                                        ['icon' => 'credit-card'])
                                    !!}
                                </div>
                            </div>

                            <div v-if="payment_method > 0">
                                <div class="row">
                                    <div v-if="payment_method < 4" class="col-md-6">
                                        {!! Field::text('reference', ['tpl' => 'withicon', 'ph' => 'XXX-XXXX-XXXX', 'required' => 'true'], ['icon' => 'registered']) !!}
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="form-control btn btn-success btn-xs">
                                                <i class="fa fa-plus-square"></i>&nbsp; A G R E G A R
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Field::number('received', ['tpl' => 'withicon', 'v-model.number' => 'amount_received', 'required' => 'true'], ['icon' => 'money']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total</label>
                                            <span class="form-control">@{{ (subtotal + iva).toFixed(2) }}</span>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cambio</label>
                                            <span class="form-control" style="color: green">@{{ (amount_received - subtotal - iva).toFixed(2) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="form-control btn btn-success btn-xs">
                                                <i class="fa fa-plus-square"></i>&nbsp; A G R E G A R
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                    </modal>

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Productos" color="danger">
                <p-table color="danger" :exchange="{{ env('EXCHANGE_RATE') }}"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
