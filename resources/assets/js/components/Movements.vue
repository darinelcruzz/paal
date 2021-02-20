<template>
	<div class="table-responsive">
		<table class="table table-bordered table-condensed table-hover table-striped">
			<thead>
				<tr>
					<th><small>N°</small></th>
					<th><small>DESCRIPCIÓN</small></th>
					<th style="text-align: right;"><small>PRECIO</small></th>
					<th style="text-align: center;"><small>CANTIDAD</small></th>
					<th style="text-align: right;"><small>DESCUENTO</small></th>
					<th style="text-align: right;"><small>IMPORTE</small></th>
				</tr>
			</thead>

			<tbody>
				<tr v-if="model" v-for="(movement, index) in model.movements">
					<td>{{ index + 1 }}</td>
					<td>{{ movement.description || movement.product.description }}</td>
					<td style="text-align: right;">{{ movement.price.toFixed(2) }}</td>
					<td style="text-align: center;">{{ movement.quantity }}</td>
					<td style="text-align: right;">{{ movement.discount.toFixed(2) }}</td>
					<td style="text-align: right;">{{ (movement.quantity * movement.price * (1 - movement.discount/100)).toFixed(2) }}</td>
				</tr>
			</tbody>

			<tfoot>
				<tr v-if="model.iva > 0">
					<td colspan="4"></td>
					<th style="text-align: right;"><small>I.V.A.</small></th>
					<td style="text-align: right;">{{ model.iva.toFixed(2) }}</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<th style="text-align: right;"><small>TOTAL</small></th>
					<th style="text-align: right;">{{ total.toFixed(2) }}</th>
				</tr>
			</tfoot>
		</table>
	</div>
</template>

<script>
	export default {
		props: ['model'],
		computed: {
			total() {
				return this.model.movements.reduce((total, movement) => total + (movement.quantity * movement.price * (1 - movement.discount/100)), 0) + this.model.iva;
			}
		}
	}
</script>
