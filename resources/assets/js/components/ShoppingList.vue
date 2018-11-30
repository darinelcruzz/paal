<template>
	<div id="shopping_list">
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
                            {{ input.description }}
                            <input name="items[]" type="hidden" :value="input.id">
                        </td>
                        <td>
                            {{ input.price.toFixed(2) }}
                            <input name="prices[]" type="hidden" :value="input.price.toFixed(2)">
                        </td>
                        <td>
                            <div v-if="input.family == 'SERVICIOS'">
                                1 <input type="hidden" name="quantities[]" :value="1">
                            </div>
                            <div v-else>
                                <input name="quantities[]" class="form-control input-sm" type="number" 
                                    min="1" v-model.number="input.quantity" @change="changeRow(index)">
                            </div>
                        </td>
                        <td>
                            <input v-if="input.is_variable == 1 && input.family != 'SERVICIOS' && input.dollars != 1" name="discounts[]" class="form-control input-sm" type="number" step="0.01" value="0"
                                min="0" v-model.number="input.discount" @change="changeRow(index)">

                            <input v-else name="discounts[]" type="hidden" value="0">
                        </td>
                        <td>
                            <div v-if="input.family == 'SERVICIOS'">
                                <input class="form-control input-sm" name="subtotals[]" type="number" step="0.01" :min="input.retail_price" :value="input.retail_price" @change="changeRow(index)">
                            </div>
                            <div v-else>
                                $ {{ input.total.toFixed(2) }}
                                <input name="subtotals[]" type="hidden" :value="input.total.toFixed(2)">
                            </div>
                        </td>
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="5"><span class="pull-right">Subtotal:</span></th>
                        <td>
                            <span class="pull-right">$ {{ subtotal.toFixed(2) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="5"><span class="pull-right">IVA:</span></th>
                        <td>
                            <span class="pull-right">$ {{ iva.toFixed(2) }}</span>
                            <input type="hidden" name="iva" :value="iva.toFixed(2)">
                        </td>
                    </tr>
                    <tr>
                        <th colspan="5"><span class="pull-right">Total:</span></th>
                        <td>
                            <span class="pull-right">$ {{ (subtotal + iva).toFixed(2) }}</span>
                            <input type="hidden" name="amount" :value="(subtotal + iva).toFixed(2)">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div v-else align="center">
            <p style="color: #f56954"><b>No se han agregado produtos a la compra.</b></p>
        </div>
    </div>
</template>

<script>
	export default {
		props: ['color', 'exchange'],
		data() {
			return {
                inputs: [],
                subtotal: 0,
                iva: 0
			}
		},
		methods: {
			addRow(product) {
                this.setPrice(product)
                product.quantity = 1
                product.discount = 0
                // product.price = 0
                product.price = this.setPrice(product)
                product.total =  1 * product.price
                this.subtotal =  1 * product.price
                this.iva = this.calculateIva()
                this.inputs.push(product)
            },
            deleteRow(index) {
                this.inputs.splice(index, 1)
            },
            changeRow(index) {
                var product = this.inputs[index]
                this.changePrice(product)

                product.total = (product.price * product.quantity) - product.discount

                this.subtotal = this.inputs.reduce((total, input) => total + input.total, 0)
                this.iva = this.calculateIva()
            },
            changePrice(product) {
                if (product.dollars) {
                    product.price = product.retail_price * this.exchange
                } else if (product.is_variable) {
                    product.price = product.retail_price - product.retail_price * 0.16 * product.iva
                } else if (product.family == 'SERVICIOS') {
                    product.price = product.retail_price
                } else {
                    var after_iva = product.wholesale_quantity > 0 && product.quantity >= product.wholesale_quantity ? 
                        product.wholesale_price: product.retail_price
                    product.price = after_iva - after_iva * 0.16 * product.iva
                }
            },
            setPrice(product) {
                if (product.dollars) {
                    return product.retail_price * this.exchange
                } else if (product.is_variable) {
                    return product.retail_price - product.retail_price * 0.16 * product.iva
                } else if (product.family == 'SERVICIOS') {
                    return product.retail_price
                } else {
                    var after_iva = product.wholesale_quantity > 0 && product.quantity >= product.wholesale_quantity ? 
                        product.wholesale_price: product.retail_price
                    return after_iva - after_iva * 0.16 * product.iva
                }
            },
            calculateIva() {
                return this.inputs.reduce((iva, input) => {
                    if (input.dollars) {
                        return iva + (input.total * 0.16 * input.iva)
                    } else if (input.is_variable) {
                        return iva + (input.total * 16 / 84 * input.iva)
                    } else if (input.family == 'SERVICIOS') {
                        return iva + 0
                    } else {
                        return iva + (input.total * 16 / 84 * input.iva)
                    }
                }, 0)
            }
		},
        created() {
            this.$root.$on('add-element', (product) => {
                this.addRow(product)
            })
        }
	};
</script>
