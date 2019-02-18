<template>
	<div id="sale_modal">
		<table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 200px;">Descripción</th>
                    <th>Precio</th>
                    <th>Can</th>
                    <th>Descuento</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            	<tr v-for="product in products">
                    <td>{{ product.i }}</td>
                    <td>$ {{ Number(product.p).toFixed(2) }}</td>
                    <td style="text-align: center;">{{ product.q }}</td>
                    <td>$ {{ Number(product.d).toFixed(2) }}</td>
                    <td>$ {{ Number(product.t).toFixed(2) }}</td>
                </tr>
                <tr v-for="product in special_products">
            		<td>{{ product.i }}</td>
                    <td>$ {{ Number(product.p).toFixed(2) }}</td>
                    <td style="text-align: center;">{{ product.q }}</td>
                    <td>$ 0.00</td>
                    <td>$ {{ Number(product.t).toFixed(2) }}</td>
            	</tr>
            </tbody>
            <tfoot>
                <tr v-if="iva > 0">
                    <td colspan="3"></td>
                    <th>I.V.A.</th>
                    <td>$ {{ Number(iva).toFixed(2) }}</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <th>Total</th>
                    <td>$ {{ Number(amount).toFixed(2) }}</td>
                </tr>
            </tfoot>
        </table>
	</div>
</template>

<script>
	export default {
		props: ['sale', 'amount', 'iva'],
		data() {
			return {
                products: [],
				special_products: []
			}
		},
		methods: {
			fetchProducts() {
                axios.get('/api/sales/show/' + this.sale)
                    .then((response) => {
                        this.products = response.data[0]
                        this.special_products = response.data[1]
                    })
            },
		},
        watch: {
            sale(val) {
                this.fetchProducts()
            }
        },
		created() {
			this.fetchProducts()
		}
	};
</script>