@extends('mbe.root')

@push('pageTitle')
    Ingresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar ingreso" color="success" button>
                {!! Form::open(['method' => 'POST', 'route' => 'mbe.ingress.store', 'ref' => 'cform']) !!}

                    <input type="hidden" name="bought_at" value="{{ date('Y-m-d') }}">

                    <form-wizard
                        title=""
                        subtitle=""
                        color="#00a65a"
                        @on-complete="submit"
                        back-button-text="Anterior"
                        next-button-text="Siguiente"
                        finish-button-text="Completado">

                        <tab-content title="Detalles" icon="fa fa-keyboard">
                            {!! Field::select('client_id', $clients, null,
                                ['tpl' => 'withicon', 'label' => 'Cliente', 'empty' => 'Seleccione un cliente', 'v-model' => 'mbe.client'],
                                ['icon' => 'user'])
                            !!}

                            <input type="hidden" name="type" value="{{ $type }}">
                            
                            <div class="row">
                                <div v-if="mbe.client > '627'" class="col-md-6">
                                    {!! Field::text('folio', ['label' => 'OT', 'tpl' => 'withicon'], ['icon' => 'list']) !!}
                                </div>
                                <div v-else class="col-md-6">
                                    {!! Field::text('invoice_id', ['label' => 'FI', 'tpl' => 'withicon'], ['icon' => 'list']) !!}
                                </div>
                                @if($isShifted)
                                <div class="col-md-6">
                                    {!! Field::date('bought_at', date('Y-m-d'), ['label' => 'Fecha', 'tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div v-if="mbe.client < '627'" class="col-md-6">
                                    <input type="hidden" name="status" value="pagado">
                                </div>
                                <div v-else>
                                    <input type="hidden" name="status" value="crédito">
                                </div>
                            </div>
                            <hr>
                        </tab-content>

                        <tab-content title="Productos" icon="fa fa-truck-loading">
                            <shipping-list color="success" :exchange="1"></shipping-list>
                            <input type="hidden" name="company" value="mbe">
                            <hr>
                        </tab-content>

                        <tab-content title="Pago" icon="fa fa-usd">
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Field::number('subtotal', 0, ['tpl' => 'withicon', 'v-model.number' => 'mbe.subtotal', 'min' => '0', 'step' => '0.01'], ['icon' => 'dollar']) !!}
                                </div>
                                <div class="col-md-6">
                                    <label for="">I.V.A (nacional por defecto)</label><br>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <input type="checkbox" v-model="mbe.iva">
                                        </span>
                                        <input type="text" class="form-control" disabled value="Aplicar internacional">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div v-if="mbe.client < '627'" class="col-md-6">
                                    {!! Field::select('method', $methods, null,
                                        ['label' => 'Método', 'tpl' => 'withicon', 'empty' => 'Forma de pago', 'v-model' => 'mbe.method'],
                                        ['icon' => 'credit-card'])
                                    !!}
                                </div>
                                <div v-else class="col-md-6">
                                    <input type="hidden" name="method" value="transferencia">
                                </div>

                                <div class="col-md-6" style="text-align: right;">
                                    <label><b>TOTAL</b></label>
                                    <h2 style="color: green;">
                                        @{{ mbe.subtotal * (mbe.iva ? 1.04: 1.16) | currency }}
                                    </h2>
                                    <input type="hidden" name="amount" :value="mbe.subtotal * (mbe.iva ? 1.04: 1.16)">
                                    <input type="hidden" name="iva" :value="mbe.subtotal * (mbe.iva ? 0.04: 0.16)">
                                </div>
                            </div>

                            <div v-if="mbe.client < '627' && mbe.method != 'efectivo' && mbe.method != ''" class="row">
                                <div class="col-md-6">
                                    {!! Field::text('reference', ['label' => 'Referencia', 'tpl' => 'withicon'], ['icon' => 'barcode']) !!}
                                </div>
                            </div>

                            <hr>
                        </tab-content>

                    </form-wizard>

                    
                    <input type="hidden" name="invoice" value="otro">

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-6">
            <solid-box title="Envíos" color="success">
                <p-table color="success" :exchange="{{ $exchange }}" type="mbe"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
