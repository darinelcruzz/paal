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
                    <tr v-for="(product, index) in inputs" 
                        :index="index"
                        :key="index"
                        is="shopping-list-item" 
                        :product="product"
                        :exchange="exchange">
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="5"><span class="pull-right">Subtotal:</span></th>
                        <td>
                            <span class="pull-right">$ {{ total.toFixed(2) }}</span>
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
                            <span class="pull-right">$ {{ (total + iva).toFixed(2) }}</span>
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
    </div>
</template>

<script>
	export default {
		props: ['color', 'exchange'],
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
                    amount: product.price * 1,
                    iva: product.family == 'SERVICIOS' ? 0: product.price * 0.16 * product.iva
                })

                this.families[product.family] = 1

                var family = product.family

                if (this.families.length == 0 ) {
                    this.families[product.family] = 1
                } else {
                    if (this.families[family] === undefined) {
                        this.families[family] = 1
                    } else {
                        this.families[family] = this.families[family] + 1
                    }
                }

                this.setTotal()

                console.log(this.families)
            },
            deleteRow(index) {
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
            }
		},
        created() {
            this.$root.$on('add-element', (product) => {
                this.addRow(product)
            })
            this.$root.$on('delete-item', (index) => {
                this.deleteRow(index)
            })
            this.$root.$on('update-total', (data) => {
                this.updateTotal(data[0], data[1], data[2])
            })
        }
	};
</script>
