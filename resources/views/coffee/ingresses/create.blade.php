@extends('coffee.root')

@push('pageTitle')
    Ingresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Crear ingreso" color="danger">
                {!! Form::open(['method' => 'POST', 'route' => 'coffee.ingress.store']) !!}

                    <form-wizard
                        title=""
                        subtitle=""
                        color="#dd4b39"
                        {{-- @on-complete="enableButton" --}}
                        {{-- @on-change="disableButton" --}}
                        back-button-text="Anterior"
                        next-button-text="Siguiente"
                        finish-button-text="Completado">

                      <tab-content title="Cliente" icon="fa fa-user">
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
                        <hr>
                      </tab-content>

                      <tab-content title="Productos" icon="fa fa-tag">
                          <shopping-list color="danger" :exchange="{{ env('EXCHANGE_RATE') }}"></shopping-list>
                       </tab-content>

                       <tab-content title="Pago" icon="fa fa-dollar">
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
                                    <div v-if="payment_method < 5 && payment_method > 0" class="col-md-6">
                                        {!! Field::text('reference', ['tpl' => 'withicon', 'ph' => 'XXX-XXXX-XXXX', 'required' => 'true'], ['icon' => 'registered']) !!}
                                    </div>
                                    <div v-if="payment_method == 0" class="col-md-6">
                                        <div class="form-group">
                                            <label>Total</label>
                                            <span class="form-control">@{{ (ingress_total).toFixed(2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="payment_method == 0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! Field::number('received', ['tpl' => 'withicon', 'v-model.number' => 'amount_received', 'required' => 'true'], ['icon' => 'money']) !!}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Cambio</label>
                                                <span class="form-control" style="color: green">@{{ (amount_received - ingress_total).toFixed(2) }}</span>
                                            </div>
                                        </div>                                                                          
                                    </div>
                                </div>
                            </template>
                            <hr>
                       </tab-content>

                    </form-wizard>

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
