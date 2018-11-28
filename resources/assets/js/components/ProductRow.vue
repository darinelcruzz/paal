<template>
	<tr>
        <td>
            <button :class="'btn btn-' + color + ' btn-xs'" @click="buttonPressed">
                <i class="fa fa-plus"></i>
            </button>
        </td>
        <td>
            {{ product.description }} <br>
            <span style="color: orange">{{ product.code }}</span>
        </td>
        <td>
            <div v-if="product.dollars == 1">
                <span style="color: olive">$ {{ (product.retail_price * exchange).toFixed(2) }}</span>
            </div>
            <div v-else-if="product.is_variable == 1">
                $ {{ product.retail_price.toFixed(2) }}
            </div>
            <div v-else>
                $ {{ product.retail_price.toFixed(2) }} /<br>
                {{ product.wholesale_price.toFixed(2) }} <small>(+ {{ product.wholesale_quantity }} pzs)</small>
            </div>
        </td>
        <td style="color: red">{{ product.family }}</td>
    </tr>
</template>

<script>
	export default {
		props: ['product', 'color', 'exchange'],
		data() {
			return {
				test: ''
			}
		},
		methods: {
            buttonPressed() {
                this.$emit('add-element')
            }
		},
        filters: {
            translate: date => {
                date = new Date(date)
                return date.toLocaleDateString("es-ES", {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'})
            }
        },
	};
</script>