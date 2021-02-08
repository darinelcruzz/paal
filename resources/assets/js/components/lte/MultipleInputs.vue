<template>
	<div class="multiple-inputs">
		<button type="button" class="btn btn-xs btn-success" @click="add">
			<i class="fa fa-plus"></i>
		</button>

		<div v-for="(input, index) in inputs" class="row">
			<div class="col-md-1" style="text-align: center;">
				<!-- <button type="button" class="btn btn-xs btn-danger" @click="eliminate(index)">
					<i class="fa fa-times"></i>
				</button> -->
				<a href="" @click="eliminate(index)" style="color: red;"><i class="fa fa-times"></i></a>
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
