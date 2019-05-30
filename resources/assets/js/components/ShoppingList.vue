<template>
	<div id="shopping_list">
        <div v-if="inputs.length > 0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><i class="fa fa-times"></i></th>
                            <th>Descripción</th>
                            <th style="width: 15%">Precio</th>
                            <th style="width: 15%">Cant</th>
                            <th style="width: 15%"><i class="fa fa-minus"></i> <i class="fa fa-percent"></i></th>
                            <th style="width: 15%">Importe</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(product, index) in inputs" 
                            :index="index"
                            :key="index"
                            is="shopping-list-item" 
                            :product="product"
                            :familycount="getFamilyCount(product.family)"
                            :exchange="exchange">
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="5"><span class="pull-right">Subtotal:</span></th>
                            <td>
                                <span class="pull-right">$ {{ total.toFixed(4) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5"><span class="pull-right">IVA:</span></th>
                            <td>
                                <span class="pull-right">$ {{ iva.toFixed(4) }}</span>
                                <input type="hidden" name="iva" :value="iva.toFixed(4)">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5"><span class="pull-right">Total:</span></th>
                            <td>
                                <span class="pull-right">$ {{ (total + iva).toFixed(4) }}</span>
                                <input type="hidden" name="amount" :value="(total + iva).toFixed(4)">
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div v-else align="center">
            <p style="color: #f56954"><b>No se han agregado produtos a la compra.</b></p>
        </div>

        <hr>
    </div>
</template>

<script>
	export default {
		props: ['color', 'exchange', 'qproducts'],
		data() {
			return {
                inputs: [],
                subtotals: [],
                families: [],
                total: 0,
                iva: 0
			}
		},
		methods: {
			addRow(product) {
                this.inputs.push(product)
                this.subtotals.push({
                    amount: 0,
                    iva: 0
                })

                if (this.families.length > 0) {
                    var has_family = false

                    for (var i = 0; i < this.families.length; i++) {
                        if (this.families[i].name == product.family) {
                            has_family = this.families[i].name == product.family
                            break
                        }
                    }

                    if (has_family) {
                        this.families[i].quantity += 0
                    } else {
                       this.families.push({
                            name: product.family,
                            quantity: 0
                        }) 
                    }
                } else {
                    this.families.push({
                        name: product.family,
                        quantity: 0
                    })
                }

                this.setTotal()
            },
            deleteRow(index, family) {
                this.inputs.splice(index, 1)
                this.subtotals.splice(index, 1)
                this.setTotal()
            },
            setTotal() {
                this.total = this.subtotals.reduce((total, subtotal) => total + subtotal.amount, 0)
                this.iva = this.subtotals.reduce((iva, subtotal) => iva + subtotal.iva, 0)
                this.$root.$emit('set-total', this.total + this.iva)
            },
            updateTotal(index, amount, iva) {
                this.subtotals[index].amount = amount
                this.subtotals[index].iva = iva
                this.total = this.subtotals.reduce((total, subtotal) => total + subtotal.amount, 0)
                this.iva = this.subtotals.reduce((total, subtotal) => total + subtotal.iva, 0)

                this.$root.$emit('set-total', this.total + this.iva)
            },
            updateFamilyCount(family, quantity) {
                for (var i = 0; i < this.families.length; i++) {
                    if (this.families[i].name == family) break
                }
                this.families[i].quantity += quantity
            },
            getFamilyCount(family) {
                for (var i = 0; i < this.families.length; i++) {
                    if (this.families[i].name == family) break
                }
                return this.families[i].quantity
            },
            setPrice(product) {
                if (product.dollars) {
                    return product.retail_price * this.exchange
                } else if (product.is_variable) {
                    return product.retail_price / (1 + 0.16 * product.iva)
                } else if (product.family == 'SERVICIOS') {
                    return product.retail_price
                } else {
                    var after_iva = product.wholesale_quantity > 0 && product.quantity >= product.wholesale_quantity ? 
                        product.wholesale_price: product.retail_price
                    return after_iva / (1 + 0.16 * product.iva)
                }
            },
		},
        created() {
            if (this.qproducts) {
                for (var i = 0; i < this.qproducts.length; i++) {
                    var product = this.qproducts[i]
                    // product.price = this.setPrice(product)
                    product.total =  product.quantity * product.price
                    if (product.special_description) {
                        product.description = product.special_description
                        product.retail_price = product.special_price
                    }
                    this.addRow(product)
                }
            }
            this.$root.$on('add-element', (product) => {
                this.addRow(product)
            })
            this.$root.$on('delete-item', (data) => {
                this.deleteRow(data[0], data[1])
            })
            this.$root.$on('update-total', (data) => {
                this.updateTotal(data[0], data[1], data[2])
            })
            this.$root.$on('update-family-count', (data) => {
                this.updateFamilyCount(data[0], data[1])
            })
        }
	};
</script>
