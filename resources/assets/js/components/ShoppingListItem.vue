<template>
	<tr>
        <td>
            <a class="btn btn-danger btn-xs" @click="deleteItem"><i class="fa fa-times"></i></a>
        </td>
        <td>
            {{ product.description }}
            <input name="items[]" type="hidden" :value="product.id">
        </td>
        <td>
            {{ price.toFixed(2) }}
            <input name="prices[]" type="hidden" :value="price.toFixed(2)">
        </td>
        <td>
            <div v-if="product.family == 'SERVICIOS'">
                1 <input type="hidden" name="quantities[]" :value="1">
            </div>
            <div v-else>
                <input name="quantities[]" class="form-control input-sm" type="number" 
                    min="1" v-model.number="quantity" @change="updateTotal">
            </div>
        </td>
        <td>
            <input v-if="apply_discount" name="discounts[]" class="form-control input-sm" type="number" step="0.01" value="0"
                min="0" v-model.number="discount" @change="updateTotal">

            <input v-else name="discounts[]" type="hidden" value="0">
        </td>
        <td>
            <div v-if="product.family == 'SERVICIOS'">
                <input class="form-control input-sm" name="subtotals[]" type="number" step="0.01" :min="product.retail_price" v-model.number="price" @change="updateTotal">
            </div>
            <div v-else>
                $ {{ total.toFixed(2) }}
                <input name="subtotals[]" type="hidden" :value="total.toFixed(2)">
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    data() {
        return {
            quantity: 1,
            discount: 0,
            price: 1
        };
    },
    props: ['product', 'index', 'exchange', 'familycount'],
    methods: {
        deleteItem() {
            this.$root.$emit('delete-item', this.index)
            if (this.product.is_summable) {
                this.$root.$emit('update-family-count', [this.product.family, - this.quantity])
            }
        },
        updateTotal() {
            this.$root.$emit('update-total', [this.index, this.total, this.computed_iva])
        },
        computePrice() {
            var price;

            if (this.product.is_summable) {
                price = this.familycount >= this.product.wholesale_quantity ? this.product.wholesale_price: this.product.retail_price
            } else {
                price = this.quantity >= this.product.wholesale_quantity ? this.product.wholesale_price: this.product.retail_price
            }
            
            if (this.product.dollars) {
                price *= this.exchange
            }

            return price / (1 + 0.16 * this.product.iva)
        }
    },
    computed: {
    	total() {
    		return ((this.quantity * this.price) - this.discount)
    	},
    	apply_discount() {
    		return this.product.is_variable == 1 && this.product.family != 'SERVICIOS' && this.product.dollars != 1;
    	},
    	computed_iva() {
    		if (this.product.family == 'SERVICIOS') return 0
            return this.total * 0.16 * this.product.iva
    	},
        // price() {
        //     var price;

        //     if (this.product.is_summable) {
        //         price = this.quantity >= this.familycount ? this.product.wholesale_price: this.product.retail_price
        //     } else {
        //         price = this.quantity >= this.product.wholesale_quantity ? this.product.wholesale_price: this.product.retail_price
        //     }
            
        //     if (this.product.dollars) {
        //         price *= this.exchange
        //     }

        //     return price / (1 + 0.16 * this.product.iva)
        // }
    },
    watch: {
        quantity: function (newVal, oldVal) {
            if (this.product.is_summable) {
                this.$root.$emit('update-family-count', [this.product.family, newVal - oldVal])
            }
            this.price = this.computePrice()
        },
        familycount: function (val) {
            this.price = this.computePrice()
        }
    },
    created() {
        this.price = this.computePrice()
    }
};
</script>