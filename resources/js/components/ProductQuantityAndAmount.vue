<template>
	<span>
		{{ quantity }} - {{ amount }}
	</span>
</template>

<script>
export default {
    props: ['category', 'date'],
	data() {
		return {
			amount: '',
			quantity: 0,
		}
	},
	methods: {
		fetch(route) {
			axios.get(route).then(({data}) => {
		       this.quantity = data.quantity;
		       this.amount = data.amount;
		    });
		}
	},
	created() {
		this.fetch('/api/products/amount/' + this.date + '/' + this.category)
	}
};
</script>