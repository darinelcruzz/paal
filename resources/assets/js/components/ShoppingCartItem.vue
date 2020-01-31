<template>
	<tr>
        <td>
            <a href="#" @click="deleteItem" style="color: red;"><i class="fa fa-times"></i></a>
        </td>
        <td>
            {{ product.description }}
            <input :name="'items[' + index + '][product_id]'" type="hidden" :value="product.id">
        </td>

        <td>
            <div v-if="product.retail_price == 0">
                <input :name="'items[' + index + '][price]'" type="number" v-model.number="price" step="0.01" class="form-control input-sm">
            </div>
            <div v-else>
                {{ price | currency }}
                <input :name="'items[' + index + '][price]'" type="hidden" :value="price.toFixed(decimalsToFix)">
            </div>
        </td>
        
        <td>
            <input :name="'items[' + index + '][quantity]'" class="form-control input-sm" type="number" min="1" v-model.number="quantity" @change="updateTotal">
        </td>
        <td>
            <input v-if="product.is_variable == 1" :name="'items[' + index + '][discount]'" class="form-control input-sm" type="number" step="1" value="0"
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
        };
    },
    props: ['product', 'index', 'exchange', 'familycount', 'promo', 'type'],
    methods: {
        deleteItem() {
            this.$root.$emit('delete-item', [this.index, this.product.family])
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
            return this.type == 'info' ? 20: 100;
        },
    	computed_iva() {
            return this.total * 0.16 * this.product.iva
    	},
    },
    watch: {
        price: function (val) {
            this.$root.$emit('update-total', [this.index, this.total, this.computed_iva])
        }
    },
    created() {
        if (this.product.dollars == 1) {
            this.price = this.product.retail_price * Number(this.exchange)
        } else {
            this.price = this.product.retail_price
        }
    }
};
</script>