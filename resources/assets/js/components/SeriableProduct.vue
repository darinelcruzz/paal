<template>
	<tr>
        <td style="width: 10%; text-align: center;">
            <a href="#" @click="add"><i class="fa fa-plus-square"></i></a>
        </td>
        <td>{{ product.description }}</td>
        <td><span style="color: #1E90FF">{{ product.code }}</span></td>
        <td style="text-align: right;color: olive;">{{ product.retail_price.toFixed(2) }}</td>
    </tr>
</template>

<script>
	export default {
		props: ['product'],
		methods: {
            add(size, quantity) {
                this.$root.$emit('add-element', this.product);
            },
		},
	};
</script>
