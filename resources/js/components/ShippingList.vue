<template>
	<div id="ingresses_list">
        <div v-if="elements.length > 0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><i class="fa fa-times"></i></th>
                            <th style="width: 75%">Descripción</th>
                            <th style="width: 20%">Cantidad</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(element, index) in elements" :index="index" :key="index" is="shipping-item" :item="element"></tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th></th>
                            <th style="text-align: right;">Total</th>
                            <td style="text-align: center;"><big>{{ total }}</big></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div v-else align="center">
            <p style="color: #f56954"><b>No se han agregado produtos a la compra.</b></p>
        </div>

        <hr>
    </div>
</template>

<script>
	export default {
		props: ['color'],
		data() {
			return {
                elements: [],
                quantities: [],
                total: 0,
			}
		},
		methods: {
			push(element) {
                this.elements.push(element)
                this.quantities.push(1)
                this.total = this.quantities.reduce((total, quantity) => total + quantity, 0)
            },
            pop(index) {
                this.elements.splice(index, 1)
                this.quantities.splice(index, 1)
                this.total = this.quantities.reduce((total, quantity) => total + quantity, 0)
            },
            updateQ(index, quantity) {
                this.quantities[index] = quantity
                this.total = this.quantities.reduce((total, quantity) => total + quantity, 0)
            }
		},
        created() {
            this.$root.$on('add-element', (element) => {
                this.push(element)
            })
            this.$root.$on('delete-item', (data) => {
                this.pop(data[0])
            })
            this.$root.$on('update-total', (data) => {
                this.updateQ(data[0], data[1])
            })
        }
	};
</script>
