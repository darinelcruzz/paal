<template>
	<tr>
        <td>
            <div class="row">
                <div class="col-md-7">
                    <a v-if="product.serial_numbers.length > 0 || product.category != 'EQUIPO'" href="#" @click="buttonPressed"><i class="fa fa-plus"></i></a>
                    <i v-else class="fa fa-times"></i>
                    &nbsp;&nbsp;
                    {{ product.description }}
                </div>
                <div class="col-md-5 pull-right">
                    <i v-if="product.iva != 0" class="fas fa-hand-holding-usd"></i> &nbsp;
                    <i v-if="product.is_summable != 0" class="fas fa-layer-group"></i> &nbsp;
                    <div v-if="product.dollars == 1" class="pull-right">
                        <span style="color: olive">{{ (product.retail_price * exchange) | currency }}</span>
                    </div>
                    <div v-else-if="product.is_variable == 1" class="pull-right">
                        {{ product.retail_price | currency }}
                    </div>
                    <div v-else-if="product.family == 'SERVICIOS'" class="pull-right">
                        <div v-if="product.retail_price > 0">
                            {{ product.retail_price | currency }} <small>(mínimo)</small>
                        </div>
                    </div>
                    <div v-else-if="product.wholesale_quantity == 0" class="pull-right">
                        {{ product.retail_price | currency }}
                    </div>
                    <div v-else class="pull-right">
                        {{ product.retail_price | currency }} /
                        {{ product.wholesale_price | currency }} <small>(+ {{ product.wholesale_quantity }} pzs)</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <a href="#" style="color: orange" :title="product.features"><b>{{ product.code }}</b></a>
                </div>
                <div class="col-md-5">
                    <span class="pull-right" style="color: red"><small>{{ product.family }}</small></span>
                </div>
            </div>
        </td>
    </tr>
</template>

<script>
	export default {
		props: ['product', 'color', 'exchange', 'promo'],
		data() {
			return {
				test: ''
			}
		},
		methods: {
            buttonPressed() {
                var product = this.product
                product.quantity = 1
                product.discount = 0
                product.serial_numbers = product.serial_numbers.reduce((total, number) => total + (number.status == 'en inventario' ? 1: 0), 0)
                product.price = this.setPrice(product)
                product.total =  1 * product.price
                this.$root.$emit('add-element', product);
            },
            setPrice(product) {
                if (product.dollars) {
                    return product.retail_price * this.exchange
                } else if (product.is_variable) {
                    return product.retail_price / (1 + 0.16 * product.iva)
                } else if (product.family == 'SERVICIOS') {
                    return product.retail_price
                } else {
                    if (this.promo == 0) {
                        var after_iva = product.wholesale_quantity > 0 && product.quantity >= product.wholesale_quantity ? 
                            product.wholesale_price: product.retail_price
                        
                        return after_iva / (1 + 0.16 * product.iva)
                    }

                    return product.wholesale_price
                }
            },
		},
        filters: {
            translate: date => {
                date = new Date(date)
                return date.toLocaleDateString("es-ES", {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'})
            }
        },
	};
</script>
