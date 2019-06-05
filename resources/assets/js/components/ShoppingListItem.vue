<template>
	<tr>
        <td>
            <a href="#" @click="deleteItem" style="color: red;"><i class="fa fa-times"></i></a>
        </td>
        <td>
            <div v-if="product.family == 'ESPECIAL'">
                <div v-if="product.special_description">
                    <input name="items[]" type="text" class="form-control input-sm" :placeholder="product.description" :value="product.description">
                </div>
                <div v-else>
                    <input name="items[]" type="text" class="form-control input-sm" :placeholder="product.description">
                </div>
                <input type="hidden" name="is_special[]" value="1">
                <input type="hidden" name="ids[]" :value="product.id">
            </div>
            <div v-else>
                {{ product.description }}
                <input name="items[]" type="hidden" :value="product.id">
                <input type="hidden" name="is_special[]" value="0">
                <input type="hidden" name="ids[]" :value="product.id">
            </div>
        </td>

        <td>
            <div v-if="product.dollars == 1">
                <div v-if="product.retail_price == 0">
                    <input name="prices[]" type="number" v-model.number="price" step="0.0001" class="form-control input-sm">
                </div>
                <div v-else>
                    {{ price.toFixed(4) }}
                    <input name="prices[]" type="hidden" :value="price.toFixed(4)">
                </div>
            </div>
            <div v-else-if="product.category == 'SERVICIOS'">
                <input name="prices[]" type="number" class="form-control input-sm" step="0.0001" :min="product.price" v-model.number="price">
            </div>

            <div v-else-if="product.category == 'EQUIPO'">
                <input name="prices[]" type="number" class="form-control input-sm" step="0.0001" :min="product.price" v-model.number="price">
            </div>
            <div v-else>
                {{ price.toFixed(4) }}
                <input name="prices[]" type="hidden" :value="price.toFixed(4)">
            </div>
        </td>
        
        <td>
            <div v-if="product.category == 'SERVICIOS'">
                1 <input type="hidden" name="quantities[]" :value="1">
            </div>
            <div v-else>
                <input name="quantities[]" class="form-control input-sm" type="number" 
                    min="1" v-model.number="quantity" @change="updateTotal">
            </div>
        </td>
        <td>
            <input v-if="apply_discount" name="discounts[]" class="form-control input-sm" type="number" step="1" value="0"
                min="0" v-model.number="discount" @change="updateTotal">

            <input v-else name="discounts[]" type="hidden" value="0">
        </td>
        <td>
            <div v-if="product.family == 'SERVICIOS'">
                <input class="form-control input-sm" name="subtotals[]" type="number" step="0.01" :min="product.retail_price" v-model.number="price" @change="updateTotal">
            </div>
            <div v-else>
                $ {{ total.toFixed(4) }}
                <input name="subtotals[]" type="hidden" :value="total.toFixed(4)">
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    data() {
        return {
            quantity: 0,
            discount: 0,
            price: 0,
            price_in_dollars: 0
        };
    },
    props: ['product', 'index', 'exchange', 'familycount'],
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

            if (this.product.is_summable) {
                price = this.familycount > this.product.wholesale_quantity ? this.product.wholesale_price: this.product.retail_price
            } else if (this.product.dollars) {
                price = this.product.retail_price * Number(this.exchange)
            } else {
                price = this.quantity > this.product.wholesale_quantity ? this.product.wholesale_price: this.product.retail_price
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