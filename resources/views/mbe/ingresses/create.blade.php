@extends('mbe.root')

@push('pageTitle')
    Ingresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Agregar ingreso" color="success" button>
                {!! Form::open(['method' => 'POST', 'route' => 'mbe.ingress.store', 'ref' => 'cform']) !!}

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
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Field::text('folio', ['tpl' => 'withicon'], ['icon' => 'list']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Field::date('bought_at', Date::now(), ['tpl' => 'withicon'], ['icon' => 'calendar']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div v-if="mbe.client == '614'" class="col-md-6">
                                    {!! Field::select('invoice', ['no' => 'No require factura', 'otro' => 'Sí requiere'], null,
                                        ['tpl' => 'withicon', 'empty' => '¿Factura?'],
                                        ['icon' => 'credit-card'])
                                    !!}
                                    <input type="hidden" name="status" value="pagado">
                                </div>
                                <div v-else>
                                    <input type="hidden" name="invoice" value="otro">
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
                                    {!! Field::number('iva', 0, ['tpl' => 'withicon', 'v-model.number' => 'mbe.iva', 'min' => '0', 'step' => '0.01'], ['icon' => 'hand-holding-usd']) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    {!! Field::select('type', $methods, null,
                                        ['label' => 'Método', 'tpl' => 'withicon', 'empty' => 'Forma de pago'],
                                        ['icon' => 'credit-card'])
                                    !!}
                                </div>

                                <div class="col-md-6">
                                    <div>
                                        <label>
                                            <b>TOTAL</b>
                                        </label><br>
                                        <div class="pull-right">
                                            <h1 style="color: green;" v-text="mbe.subtotal + mbe.iva"></h1>
                                            <input type="hidden" name="amount" :value="mbe.subtotal + mbe.iva">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                        </tab-content>

                    </form-wizard>

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
