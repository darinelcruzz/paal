<template>
	<div id="shopping_cart">
        <div v-if="elements.length > 0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center"><i class="fa fa-times"></i></th>
                            <th style="width: 31%; text-align: center">Descripción</th>
                            <th style="width: 15%; text-align: center">Precio</th>
                            <th style="width: 15%; text-align: center">Cantidad</th>
                            <th style="width: 14%; text-align: center">- (%)</th>
                            <th style="width: 20%; text-align: center">Importe</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(product, index) in elements"
                            :index="index"
                            :key="index"
                            is="shopping-cart-item" 
                            :product="product"
                            :exchange="exchange"
                            :promo="promo"
                            :type="color">
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="5"><span class="pull-right">Subtotal:</span></th>
                            <td><span class="pull-right">{{ total | currency }}</span></td>
                        </tr>
                        <tr>
                            <th colspan="5"><span class="pull-right">IVA:</span></th>
                            <td>
                                <span class="pull-right">{{ iva | currency }}</span>
                                <input type="hidden" name="iva" :value="iva.toFixed(decimalsToFix)">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5"><span class="pull-right">Total:</span></th>
                            <td>
                                <span class="pull-right">{{ total + iva | currency }}</span>
                                <input type="hidden" name="amount" :value="(total + iva).toFixed(decimalsToFix)">
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
		props: ['color', 'exchange', 'movements', 'promo'],
		data() {
			return {
                elements: [],
                subtotals: [],
                total: 0,
                iva: 0,
                decimalsToFix: 2,
                movement: null,
                product: null
			}
		},
        watch: {
            subtotals(val) {
                this.total = val.reduce((total, subtotal) => total + subtotal.amount, 0)
                this.iva = val.reduce((iva, subtotal) => iva + subtotal.iva, 0)
            }
        },
		methods: {
			addRow(product) {
                this.elements.push(product)

                let price = product.retail_price * (product.dollars == 0 ? 1: this.exchange)
                let iva = price * 0.16 * product.iva

                this.subtotals.push({amount: price, iva: iva})
            },
            deleteRow(index) {
                this.elements.splice(index, 1)
                this.subtotals.splice(index, 1)
            },
            updateTotal(index, amount, iva) {
                this.subtotals[index].amount = amount
                this.subtotals[index].iva = iva
                this.updateTotalAndIva()
            },
            updateTotalAndIva() {
                this.total = this.subtotals.reduce((total, subtotal) => total + subtotal.amount, 0)
                this.iva = this.subtotals.reduce((iva, subtotal) => iva + subtotal.iva, 0)
            }
		},
        created() {
            if (this.movements) {
                for (var j = 0; j < this.movements.length; j++) {
                    var item = this.movements[j]

                    if (item.quantity != 0) {
                        this.addRow({
                            id: item.product_id,
                            quantity: item.quantity,
                            discount: item.discount,
                            price: item.price,
                            total: item.total,
                            amount: item.total,
                            iva: 0,
                        }) 
                    }            
                    
                }
            }

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
