@extends('paal.root')

@push('pageTitle')
    Ingresos | Agregar
@endpush

@section('content')
    <div class="row">
        <div class="col-md-5">
            <solid-box title="Crear ingreso" color="primary">
                {!! Form::open(['method' => 'POST', 'route' => 'paal.ingress.futureStore']) !!}

                    {!! Field::select('client_id', $clients, null,
                        ['tpl' => 'withicon', 'empty' => 'Seleccione un cliente', 'required' => 'true'],
                        ['icon' => 'user'])
                    !!}

                    <table v-if="inputs.length > 0" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><i class="fa fa-times"></i></th>
                                <th>Producto</th>
                                <th style="width: 15%">Cantidad</th>
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
                                        min="1" v-model="input.quantity" @change="changeQuantity(index)">
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
                                <th colspan="3"><span class="pull-right">Subtotal:</span></th>
                                <td>
                                    $ @{{ total.toFixed(2) }}
                                </td>
                            </tr>
                            <tr>
                                <th colspan="3"><span class="pull-right">IVA:</span></th>
                                <td>
                                    $ @{{ iva.toFixed(2) }}
                                    <input type="hidden" name="iva" :value="iva.toFixed(2)">
                                </td>
                            </tr>
                            <tr>
                                <th colspan="3"><span class="pull-right">Total:</span></th>
                                <td>
                                    $ @{{ (total + iva).toFixed(2) }}
                                    <input type="hidden" name="amount" :value="(total + iva).toFixed(2)">
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div v-else align="center">
                        <p style="color: #f56954"><b>No se han agregado produtos a la compra.</b></p>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary pull-right" onclick="submitForm(this);">Crear</button>

                {!! Form::close() !!}
            </solid-box>
        </div>

        <div class="col-md-7">
            <solid-box title="Productos" color="primary">
                Presione&nbsp; <i class="fa fa-plus"></i>&nbsp; para agregar

                <data-table example="1">
                    {{ drawHeader('<i class="fa fa-plus"></i>', 'descripción', 'precio', 'familia') }}

                    <template slot="body">
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <add-product @add-product="addRow" product="{{ $product->id }}"></add-product>
                                </td>
                                <td>
                                    {{ $product->description }} {!! $product->iva ? ' *': '' !!}<br>
                                    <small style="color: navy">{{ $product->code }}</small>
                                </td>
                                <td>
                                    $ {{ number_format($product->retail_price, 2) }} <br>
                                    $ {{ number_format($product->wholesale_price, 2) }} (a partir de {{ $product->wholesale_quantity }} pzs)
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
