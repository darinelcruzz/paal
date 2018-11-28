<template lang="html">
	<a class="btn btn-success btn-xs" @click="buttonPressed">
		<i class="fa fa-plus"></i>
	</a>
</template>

<script>
	export default {
		data() {
			return {
				id: 0,
				description: '',
				wholesaleP: 0,
				retailP: 0,
				limit: 0,
				iva: 0,
				dollars: 0,
				is_variable: 0,
			};
		},
		props: ['product', 'exchange'],
		methods: {
			buttonPressed() {
				const t = this;
				this.$emit('add-product', t.id, t.description, t.wholesaleP, t.retailP, t.limit, t.iva, t.is_variable, t.family);
			}
		},
		created() {
	        const t = this;

	        axios.get('/paal/productos/axios/' + this.product).then(({data}) => {
	            t.id = data.id;
				t.description = data.description;
				t.limit = data.wholesale_quantity;
				t.iva = data.iva;
				t.dollars = data.dollars;
				t.family = data.family;
				t.is_variable = data.is_variable;
				t.retailP = data.dollars == 0 ? data.retail_price: data.retail_price * t.exchange;
				t.wholesaleP = data.dollars == 0 ? data.wholesale_price: data.wholesale_price * t.exchange;
	        });
            
	    }
	};
</script>