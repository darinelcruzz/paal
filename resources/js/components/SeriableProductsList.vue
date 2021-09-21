<template>
	<div id="serialable-products-list">
        <div v-if="elements.length > 0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10%;"><i class="fa fa-times"></i></th>
                            <th style="width: 50%;"><small>DESCRIPCIÓN</small></th>
                            <th style="width: 40%;"><small>NÚMERO(S) DE SERIE</small></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(product, index) in elements" :index="index" :key="product.id">
                            <td>
                                <a href="#" @click="remove(index)" style="color: red;"><i class="fa fa-times"></i></a>
                            </td>
                            <td>
                                {{ product.description}}
                                <input type="hidden" :name="'items[' + index + '][product_id]'" :value="product.id">
                            </td>
                            <td>
                                <input type="text" class="form-control input-sm" :name="'items[' + index + '][number]'">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-else align="center">
            <p style="color: #f56954"><b>No se han agregado produtos.</b></p>
        </div>

        <hr>
    </div>
</template>

<script>
	export default {
		data() {
			return {
                elements: [],
			}
		},
		methods: {
			add(product) {
                this.elements.push(product)
            },
            remove(index) {
                this.elements.splice(index, 1)
            },
		},
        created() {
            this.$root.$on('add-element', (product) => {
                this.add(product)
            })
        }
	};
</script>
