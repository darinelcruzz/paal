<template>
	<tr>
        <td>
            <button :class="'btn btn-' + color + ' btn-xs'" @click="buttonPressed">
                <i class="fa fa-plus"></i>
            </button>
        </td>
        <td>
            <div class="row">
                <div class="col-md-7">
                    {{ product.description }}
                </div>
                <div class="col-md-5 pull-right">
                    <div v-if="product.dollars == 1" class="pull-right">
                        <span style="color: olive">$ {{ (product.retail_price * exchange).toFixed(2) }}</span>
                    </div>
                    <div v-else-if="product.is_variable == 1" class="pull-right">
                        $ {{ product.retail_price.toFixed(2) }}
                    </div>
                    <div v-else class="pull-right">
                        $ {{ product.retail_price.toFixed(2) }} /
                        {{ product.wholesale_price.toFixed(2) }} <small>(+ {{ product.wholesale_quantity }} pzs)</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <span style="color: orange"><b>{{ product.code }}</b></span>
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