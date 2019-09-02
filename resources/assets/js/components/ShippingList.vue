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
			}
		},
		methods: {
			push(element) {
                this.elements.push(element)
            },
            pop(index) {
                this.elements.splice(index, 1)
            }
		},
        created() {
            this.$root.$on('add-element', (element) => {
                this.push(element)
            })
            this.$root.$on('delete-item', (data) => {
                this.pop(data[0], data[1])
            })
        }
	};
</script>