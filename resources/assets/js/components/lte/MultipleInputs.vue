<template>
	<div class="multiple-inputs">
		<button type="button" :class="'btn btn-xs btn-' + color" @click="add">
			<i class="fa fa-plus"></i>
		</button>

		<div v-for="(input, index) in inputs" class="row" style="margin-top: 10px;">
			<div class="col-md-1">
				<label for="">&nbsp;</label>
				<button type="button" class="btn btn-xs btn-danger" @click="eliminate(index)">
					<i class="fa fa-times"></i>
				</button>
			</div>
			<div class="col-md-11">
				<slot></slot>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['color'],
		data() {
			return {
                inputs: [],
			}
		},
		methods: {
			add() {
                this.inputs.push({item: 'item'})
            },
            eliminate(index) {
            	this.inputs.splice(index, 1)
            }
        },
        created() {
        	this.inputs.push({item: 'item'})
        }
	}
</script>
