<template lang="html">
    <tr>
        <td>
            {{ num }}
        </td>
        <td>
            <div class="form-group">
                <select class="form-control" name="products[]" v-model="product_id" style="width: 100%;">
                    <option value="0" selected>Seleccione un producto</option>
                    <option v-for="product in products" :value="product.id">
                        {{ product.description }}
                    </option>
                </select>
            </div>
        </td>

        <td align="center">
            <div v-if="type != 'unisize'" class="form-group">
                <select class="form-control" name="sizes[]">
                    <option value="xsmall">XS</option>
                    <option value="small">S</option>
                    <option value="medium">M</option>
                    <option value="large">L</option>
                    <option value="xlarge">XL</option>
                </select>
            </div>
            <div v-else>
                N/A
                <input type="hidden" name="sizes[]" value="unisize">
            </div>
        </td>

        <td align="center">
            <div class="form-group">
                <input v-model="quantity" @change="updateTotal" class="form-control" type="number" name="quantities[]" min="0"
                    style="width:85px;">
            </div>
        </td>

        <td>
            {{ price }}
            <input type="hidden" name="amounts[]" :value="price">
        </td>
        <td>{{ total | twoDecimals }}</td>

    </tr>
</template>

<script>
export default {
    data() {
        return {
            product_id: 0,
            quantity: 0,
            total: 0,
            price: 0,
            type: 'unisize',
            products: []
        };
    },
    props: ['num'],
    methods: {
        updateTotal() {
            if (this.product_id > 0) {
                this.total = this.products[this.product_id].public * this.quantity;
            }
            this.$emit('subtotal', this.total, this.num);
        }
    },
    watch: {
        product_id: function (val, oldVal) {
            this.price = this.products[val].public;
            this.type = this.products[val].type;
        },
    },
    filters: {
      twoDecimals: function (value) {
        return value.toFixed(2);
      }
    },
    created() {
        axios.get('/products').then(response => {
            this.products = response.data;
        });
    }
}
</script>
