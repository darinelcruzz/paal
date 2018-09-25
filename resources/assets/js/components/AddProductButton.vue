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
			};
		},
		props: ['product'],
		methods: {
			buttonPressed() {
				const t = this;
				this.$emit('add-product', t.id, t.description, t.wholesaleP, t.retailP, t.limit, t.iva);
			}
		},
		created() {
	        const t = this;

	        axios.get('/paal/productos/axios/' + this.product).then(({data}) => {
	            t.id = data.id;
				t.description = data.description;
				t.wholesaleP = data.wholesale_price;
				t.retailP = data.retail_price;
				t.limit = data.wholesale_quantity;
				t.iva = data.iva;
	        });
            
	    }
	};
</script>