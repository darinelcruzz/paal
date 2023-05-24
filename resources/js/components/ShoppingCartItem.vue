<template>
	<tr>
        <td>
            <a href="#" @click="deleteItem" style="color: red;"><i class="fa fa-times"></i></a>
        </td>
        <td>
            {{ product.description ? product.description : description }}
            <input :name="'items[' + index + '][product_id]'" type="hidden" :value="product.id">
        </td>

        <td>
            <div v-if="product.retail_price == 0 || product.family == 'ENVÍOS'">
                <input :name="'items[' + index + '][price]'" type="number" v-model.number="price" step="0.01" class="form-control input-sm">
            </div>
            <div v-else>
                {{ price | currency }}
                <input :name="'items[' + index + '][price]'" type="hidden" :value="price.toFixed(decimalsToFix)">
            </div>
        </td>
        
        <td>
            <div v-if="product.family == 'ENVÍOS'">
                1
                <input :name="'items[' + index + '][quantity]'" class="form-control input-sm" type="hidden" min="1" v-model.number="quantity" value="1">
                <input name="pi_amount" type="hidden" :value="price.toFixed(decimalsToFix)">
            </div>
            <div v-else>
                <input :name="'items[' + index + '][quantity]'" class="form-control input-sm" type="number" min="1" v-model.number="quantity" @change="updateTotal">
            </div>
        </td>
        <td>
            <input v-if="has_discount" :name="'items[' + index + '][discount]'" class="form-control input-sm" type="number" step="1" value="0"
                min="0" :max="max_discount" v-model.number="discount" @change="updateTotal">

            <input v-else :name="'items[' + index + '][discount]'" type="hidden" value="0">
        </td>
        <td style="text-align: right">
            {{ total | currency }}
            <input :name="'items[' + index + '][total]'" type="hidden" :value="total.toFixed(decimalsToFix)">
        </td>
    </tr>
</template>

<script>
export default {
    data() {
        return {
            decimalsToFix: 2,
            quantity: 1,
            discount: 0,
            price: 0,
            description: '',
            has_discount: false,
            iva: 0,
            dollars: 0,
        };
    },
    props: ['product', 'index', 'exchange', 'promo', 'type', 'maxdiscount'],
    methods: {
        deleteItem() {
            this.$root.$emit('delete-item', this.index)
        },
        updateTotal() {
            this.$root.$emit('update-total', [this.index, this.total, this.computed_iva])
        }
    },
    computed: {
    	total() {
    		return (this.quantity * this.price) - ((this.quantity * this.price) * this.discount / 100)
    	},
        max_discount() {
            return this.maxdiscount == 99 ? 99: (this.type == 'proyecto' ? 30: 40);
        },
    	computed_iva() {
            return this.total * 0.16 * this.iva
    	},
    },
    watch: {
        price(val) {
            this.$root.$emit('update-total', [this.index, this.total, this.computed_iva])
        },
        iva(val) {
            this.$root.$emit('update-total', [this.index, this.total, this.computed_iva])
        },
    },
    created() {
        if (this.product.quantity > 0) {
            this.quantity = this.product.quantity
            this.discount = this.product.discount
            if (this.product.family == 'ENVÍOS') {
                this.price = this.product.retail_price
            } else {
                this.price = this.product.price
            }

            axios.get('/api/products/' + this.product.id).then((response) => {
                var product = response.data
                this.description = product.description
                this.has_discount = product.is_variable == 1
                this.dollars = product.dollars
                this.iva = product.iva
            })

            if (this.dollars) {
                this.price = this.price * this.exchange
            }

        } else {
            this.price = this.product.retail_price * (this.product.dollars == 0 ? 1: this.exchange)
            this.has_discount = this.product.is_variable == 1
            this.iva = this.product.iva
        }
    }
};
</script>
