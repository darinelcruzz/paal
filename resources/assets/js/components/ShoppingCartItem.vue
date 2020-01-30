<template>
	<tr>
        <td>
            <a href="#" @click="deleteItem" style="color: red;"><i class="fa fa-times"></i></a>
        </td>
        <td>
            {{ product.description }}
            <input :name="'items[' + index + '][i]'" type="hidden" :value="product.id">
        </td>

        <td>
            <div v-if="product.retail_price == 0">
                <input :name="'items[' + index + '][p]'" type="number" v-model.number="price" step="0.01" class="form-control input-sm">
            </div>
            <div v-else>
                {{ price | currency }}
                <input :name="'items[' + index + '][p]'" type="hidden" :value="price.toFixed(decimalsToFix)">
            </div>
        </td>
        
        <td>
            <input :name="'items[' + index + '][q]'" class="form-control input-sm" type="number" min="1" v-model.number="quantity" @change="updateTotal">
        </td>
        <td>
            <input v-if="apply_discount" :name="'items[' + index + '][d]'" class="form-control input-sm" type="number" step="1" value="0"
                min="0" :max="max_discount" v-model.number="discount" @change="updateTotal">

            <input v-else :name="'items[' + index + '][d]'" type="hidden" value="0">
        </td>
        <td style="text-align: right">
            {{ total | currency }}
        </td>
    </tr>
</template>

<script>
export default {
    data() {
        return {
            decimalsToFix: 2,
            quantity: 0,
            discount: 0,
            price: 0,
            price_in_dollars: 0
        };
    },
    props: ['product', 'index', 'exchange', 'familycount', 'promo', 'type'],
    methods: {
        deleteItem() {
            this.$root.$emit('delete-item', [this.index, this.product.family])
            if (this.product.is_summable) {
                this.$root.$emit('update-family-count', [this.product.family, - this.quantity, this.computed_iva])
            }
        },
        updateTotal() {
            this.$root.$emit('update-total', [this.index, this.total, this.computed_iva])
        },
        computePrice() {
            var price;

            if (this.product.is_summable && this.promo == 0) {
                price = this.familycount > this.product.wholesale_quantity ? this.product.wholesale_price: this.product.retail_price
            } else if (this.product.dollars) {
                price = this.product.retail_price * Number(this.exchange)
            } else {
                if (this.promo == 1) {
                    price = this.product.wholesale_price
                } else {
                    price = this.quantity > this.product.wholesale_quantity ? this.product.wholesale_price: this.product.retail_price
                }
            }

            return price / (1 + 0.16 * this.product.iva)
        }
    },
    computed: {
    	total() {
    		return ((this.quantity * this.price) - ((this.quantity * this.price) * this.discount / 100))
    	},
    	apply_discount() {
    		return this.product.is_variable == 1 && this.product.family != 'SERVICIOS';
    	},
        max_discount() {
            return this.type == 'info' ? 20: 100;
        },
    	computed_iva() {
    		if (this.product.family == 'SERVICIOS') return 0
            return this.total * 0.16 * this.product.iva
    	},
    },
    watch: {
        quantity: function (newVal, oldVal) {
            if (this.product.is_summable) {
                this.$root.$emit('update-family-count', [this.product.family, newVal - oldVal, this.computed_iva])
            }
            if (this.product.category != 'SERVICIOS' && this.product.category != 'EQUIPO') {
                this.price = this.computePrice()
            }
        },
        familycount: function (val) {
            if (this.product.category != 'SERVICIOS') {
                this.price = this.computePrice()
            }
        },
        price: function (val) {
            this.$root.$emit('update-total', [this.index, this.total, this.computed_iva])
        }
    },
    created() {
        if (this.product.category != 'SERVICIOS') {
            this.price = this.computePrice()
        } else {
            this.price = this.product.retail_price
            this.quantity = 1
        }

        if (this.product.quantity > 0) {
            this.quantity = this.product.quantity
        }

        if (this.product.discount > 0) {
            this.discount = this.product.discount
        }
    }
};
</script>