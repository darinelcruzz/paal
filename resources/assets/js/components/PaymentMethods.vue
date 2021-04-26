<template>
	<div>
		<div class="row">
	        <div class="col-md-6">
	            <div v-if="amount != undefined" class="control-group">
	                <label>Total a pagar</label>
	                <span class="form-control" style="color: green;">
	                    <b>{{ amount.toFixed(2) }}</b>
	                </span>
	            </div>
	            <div v-else class="form-group">
				    <label class="control-label">
				        <b>Total a pagar</b>
				    </label>				    
				    <div class="input-group">
				        <span class="input-group-addon"><i class="fa fa-cash-register"></i></span>
				        <input type="number" name="amount" value="0" min="0" step="0.01" class="form-control" v-model.number="total">
				    </div>
				</div>
	        </div>
	        <div class="col-md-6">
	        	<div class="form-group">
				    <label class="control-label">
				        <b>Efectivo</b>
				    </label>				    
				    <div class="input-group">
				        <span class="input-group-addon"><i class="fa fa-money-bill-alt"></i></span>
				        <input type="number" name="cash" value="0" min="0" step="0.01" class="form-control" 
				        	:max="amount - (debit_card + credit_card + transfer + check)" :required="total == 0"
				        	v-model.number="cash" :disabled="amount == 0">
				    </div>
				</div>
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-md-6">
				<div class="form-group">
				    <label class="control-label">
				        <b>Cheque</b>
				    </label>				    
				    <div class="input-group">
				        <span class="input-group-addon"><i class="fa fa-money-check-alt"></i></span>
				        <input type="number" name="check" value="0" min="0" step="0.01" class="form-control" 
				        	:max="amount - (debit_card + credit_card + transfer + cash)" :required="total == 0"
				        	v-model.number="check" :disabled="amount == 0">
				    </div>
				</div>
	            <div class="form-group">
				    <label class="control-label">
				        <b>Tarjeta de crédito</b>
				    </label>				    
				    <div class="input-group">
				        <span class="input-group-addon"><i class="fab fa-cc-visa"></i></span>
				        <input type="number" name="credit_card" value="0" min="0" step="0.01" class="form-control" 
				        	:max="amount - (debit_card + cash + transfer + check)" :required="total == 0"
				        	v-model.number="credit_card" :disabled="amount == 0">
				    </div>
				</div>
	        </div>
	        <div class="col-md-6">
				<div class="form-group">
				    <label class="control-label">
				        <b>Transferencia</b>
				    </label>				    
				    <div class="input-group">
				        <span class="input-group-addon"><i class="fa fa-exchange-alt"></i></span>
				        <input type="number" name="transfer" value="0" min="0" step="0.01" class="form-control" 
				        	:max="amount - (debit_card + credit_card + cash + check)"  :required="total == 0"
				        	v-model.number="transfer" :disabled="amount == 0">
				    </div>
				</div>
	        	<div class="form-group">
				    <label class="control-label">
				        <b>Tarjeta de débito</b>
				    </label>				    
				    <div class="input-group">
				        <span class="input-group-addon"><i class="fab fa-cc-mastercard"></i></span>
				        <input type="number" name="debit_card" value="0" min="0" step="0.01" class="form-control" 
				        	:max="amount - (cash + credit_card + transfer + check)" :required="total == 0"
				        	v-model.number="debit_card" :disabled="amount == 0">
				    </div>
				</div>
	        </div>
	    </div>

	    <div class="row">
	        <div v-if="credit_card + debit_card + transfer + check > 0" class="col-md-6">
	            <div class="form-group">
				    <label class="control-label">
				        <b>Referencia</b>
				    </label>				    
				    <div class="input-group">
				        <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				        <input type="text" name="reference" value="" class="form-control">
				    </div>
				</div>
	        </div>

	        <div v-if="credit_card + debit_card > 0" class="col-md-6">
	            <div class="form-group">
				    <label class="control-label">
				        <b>Número de tarjeta</b>
				    </label>				    
				    <div class="input-group">
				        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
				        <input type="text" name="card_number" value="" class="form-control">
				    </div>
				</div>
	        </div>

	    </div>
	</div>
</template>

<script>
export default {
    props: ['amount'],
    data() {
        return {
            cash: 0,
            transfer: 0,
            debit_card: 0,
            credit_card: 0,
            check: 0,
        };
    },
    computed: {
    	total() {
    		return this.cash + this.transfer + this.debit_card + this.credit_card + this.check;
    	}
    }
};
</script>
