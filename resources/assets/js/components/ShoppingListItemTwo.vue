<template>
	<tr>
		<td>
			<a href="#" @click="eliminate" style="color: red;">
				<i class="fa fa-times"></i>
			</a>
		</td>

		<td>
			<div v-if="product.family == 'ESPECIAL'">
				<input :name="'items[' + index + '][description]'" type="text" class="form-control input-sm" :placeholder="product.description">
			</div>
			<div v-else>
				{{ product.description }}
				<input :name="'items[' + index + '][description]'" type="hidden" :value="null">
			</div>
			<input :name="'items[' + index + '][product_id]'" type="hidden" :value="product.id">
		</td>

		<td class="money-field">
			<div v-if="custom_price">
				<input :name="'items[' + index + '][price]'" type="number" class="form-control input-sm" step="0.01" v-model.number="price">
			</div>
			<div v-else>
				{{ price | currency }}
				<input :name="'items[' + index + '][price]'" type="hidden" :value="price">
			</div>
		</td>

		<td class="centered-field">
			<div v-if="product.category == 'SERVICIOS'">
                1 <input type="hidden" :name="'items[' + index + '][quantity]'" :value="1">
            </div>
            <div v-else>
				<input :name="'items[' + index + '][quantity]'" class="form-control input-sm" type="number" min="1" v-model.number="quantity" @change="update">
            </div>
		</td>

		<td class="centered-field">
			<input v-if="discount.apply" :name="'items[' + index + '][discount]'" class="form-control input-sm" type="number" step="1" value="0"
                min="0" :max="discount.max" v-model.number="discount.amount" @change="update">
            <input v-else :name="'items[' + index + '][discount]'" type="hidden" value="0">
		</td>

		<td class="money-field">
			{{ amount | currency }}
			<input :name="'items[' + index + '][total]'" type="hidden" :value="amount.toFixed(decimals)">
		</td>
	</tr>
</template>

<script>
	export default {
		props: ['product', 'index', 'familycount', 'promo', 'exchange', 'company'],
		data() {
			return {
				decimals: 2,
				quantity: 1,
				discount: {
					max: 40,
					apply: false,
					amount: 0
				},
				custom_price: false,
				price: 0
			}
		},
		computed: {
			amount() {
				return (this.quantity * this.price)  - ((this.quantity * this.price) * this.discount.amount / 100)
			},
			iva() {
				return this.amount * 0.16 * this.product.iva
			}
		},
		watch: {
	        quantity: function (newVal, oldVal) {
	            if (this.product.is_summable) {
	                this.$root.$emit('update-family-count', [this.product.family, newVal - oldVal, this.iva])
	            }
	            if (this.product.category != 'SERVICIOS' && this.product.category != 'EQUIPO') {
	                this.price = this.getPrice()
	            }
	        },
	        familycount: function (val) {
	            if (this.product.category != 'SERVICIOS') {
	                this.price = this.getPrice()
	            }
	        },
	        price: function (val) {
	            this.$root.$emit('update-total', [this.index, this.amount, this.iva])
	        }
	    },
		methods: {
			getPrice() {
				let count = this.product.is_summable ? this.familycount: this.quantity

				if (this.promo) {
					this.price = this.product.wholesale_price
				} else {
					this.price = count > this.product.wholesale_quantity ? this.product.wholesale_price: this.product.retail_price
				}

				this.price = this.product.dollars ? this.product.retail_price * Number(this.exchange): this.price;

				// return this.price / (1 + 0.16 * this.product.iva)
				return (this.price / (1 + 0.16 * (this.product.family == 'ENVÍOS' ? 0:this.product.iva))).toFixed(2)
			},
			eliminate() {
	            this.$root.$emit('delete-item', [this.index, this.product.family])
	            if (this.product.is_summable) {
	                this.$root.$emit('update-family-count', [this.product.family, - this.quantity, this.iva])
	            }
	        },
	        update() {
	            this.$root.$emit('update-total', [this.index, this.amount, this.iva])
	        }
		},
		created() {
			let t = this
			let p = t.product
			t.quantity = p.amount || 1;
			t.discount.apply = p.is_variable == 1 && p.family != 'SERVICIOS'
			if (t.product.discount) {
				t.discount.amount = t.product.discount
			}
			t.custom_price = (p.retail_price == 0 && p.dollars) || p.category == 'SERVICIOS' || p.family == 'ESPECIAL'
			t.price = t.getPrice()
		}
	};
</script>

<style>
	.money-field {
		text-align: right;
	}

	.centered-field {
		text-align: center;
	}
</style>
