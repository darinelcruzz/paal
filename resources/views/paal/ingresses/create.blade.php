@extends('paal.root')

@push('pageTitle')
    Ingresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6">
            <solid-box title="Crear ingreso" color="primary">
                {!! Form::open(['method' => 'POST', 'route' => 'paal.ingress.store']) !!}

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
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-times"></i></th>
                                    <th>Producto</th>
                                    <th style="width: 15%">Cantidad</th>
                                    <th style="width: 15%">Descuento</th>
                                    <th>Importe</th>
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
                                        <input name="quantities[]" class="form-control input-sm" type="number" 
                                            min="1" v-model.number="input.quantity" @change="changeQuantity(index)">
                                    </td>
                                    <td>
                                        <input name="discounts[]" class="form-control input-sm" type="number" step="0.01" 
                                            min="0" v-model.number="input.discount" @change="changeQuantity(index)" :disabled="input.is_variable == 0">
                                    </td>
                                    <td>
                                        $ @{{ input.total.toFixed(2) }}
                                        <input name="prices[]" type="hidden" :value="input.priceW.toFixed(2)">
                                        <input name="subtotals[]" type="hidden" :value="input.total.toFixed(2)">
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="4"><span class="pull-right">Subtotal:</span></th>
                                    <td>
                                        $ @{{ total.toFixed(2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4"><span class="pull-right">IVA:</span></th>
                                    <td>
                                        $ @{{ iva.toFixed(2) }}
                                        <input type="hidden" name="iva" :value="iva.toFixed(2)">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4"><span class="pull-right">Total:</span></th>
                                    <td>
                                        $ @{{ (total + iva).toFixed(2) }}
                                        <input type="hidden" name="amount" :value="(total + iva).toFixed(2)">
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
                        <button class="btn btn-primary pull-right" :disabled="inputs.length == 0">
                            SIGUIENTE
                        </button>
                    </modal-button>

                    <modal title="Método de pago" id="next-step">
                        <template v-if="is_retained == 0">
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Field::select('methodA', ['Efectivo', 'T. Débito', 'T. Crédito', 'Cheque', 'Transferencia', 'Crédito'], null,
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
                                    <div class="col-md-6">
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
                                            <span class="form-control">@{{ (total + iva).toFixed(2) }}</span>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cambio</label>
                                            <span class="form-control" style="color: green">@{{ (amount_received - total - iva).toFixed(2) }}</span>
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
            <solid-box title="Productos" color="primary">
                Presione&nbsp; <i class="fa fa-plus"></i>&nbsp; para agregar

                <data-table example="1">
                    {{ drawHeader('<i class="fa fa-plus"></i>', 'descripción', 'precio', 'familia') }}

                    <template slot="body">
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <add-product @add-product="addRow" product="{{ $product->id }}" :exchange="{{ env('EXCHANGE_RATE') }}"></add-product>
                                </td>
                                <td>
                                    {{ $product->description }} {!! $product->iva ? ' *': '' !!}<br>
                                    <small style="color: navy">{{ $product->code }}</small>
                                </td>
                                <td>
                                    @if ($product->dollars)
                                        $ {{ number_format($product->retail_price, 2) }}
                                        <span class="flag-icon flag-icon-us pull-right"></span>
                                    @else
                                        $ {{ number_format($product->retail_price, 2) }} <br>
                                        $ {{ number_format($product->wholesale_price, 2) }} (a partir de {{ $product->wholesale_quantity }} pzs)
                                    @endif
                                </td>
                                <td style="color: red">{{ $product->family }}</td>
                            </tr>
                        @endforeach
                    </template>
                </data-table>
            </solid-box>
        </div>
    </div>

@endsection
