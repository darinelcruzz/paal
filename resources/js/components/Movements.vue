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
					<th style="text-align: right;"><small>IVA</small></th>
					<th style="text-align: right;"><small>IMPORTE</small></th>
				</tr>
			</thead>

			<tbody>
				<tr v-for="(movement, index) in movements">
					<td>{{ index + 1 }}</td>
					<td>{{ movement.description || movement.product.description }}</td>
					<td style="text-align: right;">{{ movement.price.toFixed(2) }}</td>
					<td style="text-align: center;">{{ movement.quantity }}</td>
					<td style="text-align: right;">{{ movement.discount.toFixed(2) }}</td>
					<td style="text-align: right;">{{ (movement.quantity * movement.price * (1 - movement.discount/100) * movement.product.iva * 0.16).toFixed(2) }}</td>
					<td style="text-align: right;">{{ (movement.quantity * movement.price * (1 - movement.discount/100)).toFixed(2) }}</td>
				</tr>
			</tbody>

			<tfoot>
				<tr>
					<td colspan="5"></td>
					<th style="text-align: right;"><small>SUBTOTAL</small></th>
					<td style="text-align: right;">{{ subtotal.toFixed(2) }}</td>
				</tr>
				<tr v-if="model.iva > 0">
					<td colspan="5"></td>
					<th style="text-align: right;"><small>I.V.A.</small></th>
					<td style="text-align: right;">{{ model.iva.toFixed(2) }}</td>
				</tr>
				<tr v-if="model.rounding != 0">
					<td colspan="5"></td>
					<th style="text-align: right;"><small>AJUSTE</small></th>
					<td style="text-align: right;">{{ model.rounding.toFixed(2) }}</td>
				</tr>
				<tr>
					<td colspan="5"></td>
					<th style="text-align: right;"><small>TOTAL</small></th>
					<th style="text-align: right;">{{ model.amount.toFixed(2) }}</th>
				</tr>
			</tfoot>
		</table>

		<table v-if="type != 'quotation'" class="table table-bordered table-condensed table-hover table-striped">
			<thead>
                <tr>
                    <th>&nbsp;</th>
                    <th><small>EFECTIVO</small></th>
                    <th><small>TRANSFERENCIA</small></th>
                    <th><small>CHEQUE</small></th>
                    <th><small>DÉBITO</small></th>
                    <th><small>CRÉDITO</small></th>
                    <th style="text-align: center;"><small>REFERENCIA</small></th>
                </tr>
            </thead>

            <tbody>
            	<tr v-for="payment in payments">
                    <th><small>PAGO</small></th>
                    <td>{{ payment.cash > 0 ? payment.cash.toFixed(2): 'X' }}</td>
                    <td>{{ payment.transfer > 0 ? payment.transfer.toFixed(2): 'X' }}</td>
                    <td>{{ payment.check > 0 ? payment.check.toFixed(2): 'X' }}</td>
                    <td>{{ payment.debit_card > 0 ? payment.debit_card.toFixed(2): 'X' }}</td>
                    <td>{{ payment.credit_card > 0 ? payment.credit_card.toFixed(2): 'X' }}</td>
                    <td style="text-align: center;">
                        {{ payment.reference }} <br> {{ payment.card_number }} 
                    </td>
                </tr>
            </tbody>
		</table>
	</div>
</template>

<script>
	export default {
		props: ['model', 'type'],
		data() {
			return {
				movements: [],
				payments: [],
				iva: 0,
				rounding: 0,
			}
		},
		computed: {
			subtotal() {
				return this.movements.reduce((total, movement) => total + (movement.quantity * movement.price * (1 - movement.discount/100)), 0);
			},
			total() {
				return this.subtotal + this.model.iva + this.model.rounding;
			}
		},
		watch: {
	    	model(oldVal, newVal) {
	    		this.fetchMovements(this.type, this.model.id);
	    		this.fetchPayments(this.model.id);
	    	}
	    },
	    methods: {
	        fetchMovements(type, id) {
            	axios.get('/api/movements/' + type + '/' + id).then((response) => {
            		console.log('movements', response.data)
            		this.movements = response.data;
            	});
	        },
	        fetchPayments(id) {
            	axios.get('/api/payments/' + id).then((response) => {
            		console.log('payments', response.data)
            		this.payments = response.data;
            	});
	        }
	    }
	}
</script>
