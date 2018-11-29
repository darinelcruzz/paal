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

                    <div v-if="inputs.length > 0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-times"></i></th>
                                    <th>Descripción</th>
                                    <th style="width: 15%">Precio</th>
                                    <th style="width: 15%">Cantidad</th>
                                    <th style="width: 15%">Descuento</th>
                                    <th style="width: 15%">Importe</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(input, index) in inputs">
                                    <td>
                                        <a class="btn btn-danger btn-xs" @click="deleteRow(index)"><i class="fa fa-times"></i></a>
                                    </td>
                                    <td>
                                        @{{ input.description }}
                                        <input name="items[]" type="hidden" :value="input.id">
                                    </td>
                                    <td>
                                        @{{ input.quantity >= input.limit ? input.wholesale_price.toFixed(2): input.retail_price.toFixed(2) }}
                                        <input name="prices[]" type="hidden" :value="input.quantity >= input.limit ? input.wholesale_price.toFixed(2): input.retail_price.toFixed(2)">
                                    </td>
                                    <td>
                                        <div v-if="input.family == 'SERVICIOS'">
                                            1 <input type="hidden" name="quantities[]" :value="1">
                                        </div>
                                        <div v-else>
                                            <input name="quantities[]" class="form-control input-sm" type="number" 
                                                min="1" v-model.number="input.quantity" @change="changeQuantity(index)">
                                        </div>
                                    </td>
                                    <td>
                                        <input v-if="input.is_variable == 1 && input.family != 'SERVICIOS' && input.dollars != 1" name="discounts[]" class="form-control input-sm" type="number" step="0.01" value="0"
                                            min="0" v-model.number="input.discount" @change="changeQuantity(index)">

                                        <input v-else name="discounts[]" type="hidden" value="0">
                                    </td>
                                    <td>
                                        <div v-if="input.family == 'SERVICIOS'">
                                            <input class="form-control input-sm" name="subtotals[]" type="number" step="0.01" :min="input.retail_price" :value="input.retail_price" @change="changeQuantity(index)">
                                        </div>
                                        <div v-else>
                                            $ @{{ input.total.toFixed(2) }}
                                            <input name="subtotals[]" type="hidden" :value="input.total.toFixed(2)">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="5"><span class="pull-right">Subtotal:</span></th>
                                    <td>
                                        <span class="pull-right">$ @{{ subtotal.toFixed(2) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="5"><span class="pull-right">IVA:</span></th>
                                    <td>
                                        <span class="pull-right">$ @{{ iva.toFixed(2) }}</span>
                                        <input type="hidden" name="iva" :value="iva.toFixed(2)">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="5"><span class="pull-right">Total:</span></th>
                                    <td>
                                        <span class="pull-right">$ @{{ (subtotal + iva).toFixed(2) }}</span>
                                        <input type="hidden" name="amount" :value="(subtotal + iva).toFixed(2)">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div v-else align="center">
                        <p style="color: #f56954"><b>No se han agregado produtos a la compra.</b></p>
                    </div>

                    <hr>

                    <input type="hidden" name="bought_at" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="company" value="coffee">

                    <modal-button target="next-step">
                        <button class="btn btn-danger pull-right" :disabled="inputs.length == 0">
                            SIGUIENTE
                        </button>
                    </modal-button>

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
                <p-table color="danger" @added="addRow" :exchange="{{ env('EXCHANGE_RATE') }}"></p-table>
            </solid-box>
        </div>
    </div>

@endsection
