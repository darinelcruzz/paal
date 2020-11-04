<template>
	<div id="shopping_list">
        <div v-if="inputs.length > 0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center"><i class="fa fa-times"></i></th>
                            <th style="width: 31%; text-align: center">Descripción</th>
                            <th style="width: 15%; text-align: center">Precio</th>
                            <th style="width: 15%; text-align: center">Cantidad</th>
                            <th style="width: 14%; text-align: center">- (%)</th>
                            <th style="width: 20%; text-align: center">Importe</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(product, index) in inputs" 
                            :index="index"
                            :key="product.id"
                            is="shopping-list-item" 
                            :product="product"
                            :familycount="getFamilyCount(product.family)"
                            :exchange="exchange"
                            :promo="promo"
                            :type="color">
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="5"><span class="pull-right">Subtotal:</span></th>
                            <td><span class="pull-right">{{ total | currency }}</span></td>
                        </tr>
                        <tr>
                            <th colspan="5"><span class="pull-right">IVA:</span></th>
                            <td>
                                <span class="pull-right">{{ iva | currency }}</span>
                                <input type="hidden" name="iva" :value="iva.toFixed(decimalsToFix)">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5"><span class="pull-right">Redondeo:</span></th>
                            <td>
                                <input type="number" v-model.number="redondeo" step="0.01" class="form-control input-sm">
                                <input type="hidden" name="redondeo" :value="redondeo.toFixed(decimalsToFix)">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5"><span class="pull-right">Total:</span></th>
                            <td>
                                <span class="pull-right">{{ total + iva + redondeo | currency }}</span>
                                <input type="hidden" name="amount" :value="(total + iva + redondeo).toFixed(decimalsToFix)">
                                <input type="hidden" name="type" :value="type">
                            </td>
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
		props: ['color', 'exchange', 'qproducts', 'promo'],
		data() {
			return {
                inputs: [],
                subtotals: [],
                families: [],
                types:[],
                type: 'insumos',
                total: 0,
                iva: 0,
                redondeo: 0,
                decimalsToFix: 2
			}
		},
		methods: {
			addRow(product) {
                this.inputs.push(product)
                this.subtotals.push({
                    amount: 0,
                    iva: 0
                })

                this.updateTypes(product)

                if (this.families.length > 0) {
                    var has_family = false

                    for (var i = 0; i < this.families.length; i++) {
                        if (this.families[i].name == product.family) {
                            has_family = this.families[i].name == product.family
                            break
                        }
                    }

                    if (has_family) {
                        this.families[i].quantity += 1
                    } else {
                       this.families.push({
                            name: product.family,
                            quantity: 1
                        }) 
                    }
                } else {
                    this.families.push({
                        name: product.family,
                        quantity: 1
                    })
                }

                this.setTotal()
            },
            deleteRow(index, family) {
                let category = this.inputs[index].category == 'EQUIPO' ? 'equipo': 'insumos'
                this.types.splice(this.types.indexOf(category), 1)
                this.type = this.types.length == 2 ? 'proyecto': this.types[0];
                this.inputs.splice(index, 1)
                this.subtotals.splice(index, 1)
                this.setTotal()
            },
            setTotal() {
                this.total = this.subtotals.reduce((total, subtotal) => total + subtotal.amount, 0)
                this.iva = this.subtotals.reduce((iva, subtotal) => iva + subtotal.iva, 0)
                this.$root.$emit('set-total', this.total + this.iva)
            },
            updateTotal(index, amount, iva) {
                this.subtotals[index].amount = amount
                this.subtotals[index].iva = iva
                this.total = this.subtotals.reduce((total, subtotal) => total + subtotal.amount, 0)
                this.iva = this.subtotals.reduce((total, subtotal) => total + subtotal.iva, 0)

                this.$root.$emit('set-total', this.total + this.iva)
            },
            updateFamilyCount(family, quantity) {
                for (var i = 0; i < this.families.length; i++) {
                    if (this.families[i].name == family) break
                }
                this.families[i].quantity += quantity
            },
            getFamilyCount(family) {
                for (var i = 0; i < this.families.length; i++) {
                    if (this.families[i].name == family) break
                }
                return this.families[i].quantity
            },
            setPrice(product) {
                if (product.dollars) {
                    return product.retail_price * this.exchange
                } else if (product.is_variable) {
                    return product.retail_price / (1 + 0.16 * product.iva)
                } else if (product.family == 'SERVICIOS') {
                    return product.retail_price
                } else {
                    if (this.promo == 0) {
                        var after_iva = product.wholesale_quantity > 0 && product.amount >= product.wholesale_quantity ? 
                            product.wholesale_price: product.retail_price
                        
                        return after_iva / (1 + 0.16 * product.iva)
                    }
                    
                    return product.wholesale_price
                }
            },
            updateTypes(product) {
                let category = product.category == 'EQUIPO' ? 'equipo': 'insumos'

                // if (this.types.includes(category)) {
                //     console.log('Ya hay un equipo')
                // } else {
                //     this.types.push(category)
                //     console.log('Se agregó categoría ' + category)
                // }

                this.type = this.types.length == 2 ? 'proyecto': this.types[0];

                // console.log(this.types)
            }
		},
        created() {
            if (this.qproducts) {
                for (var i = 0; i < this.qproducts.length; i++) {
                    var product = this.qproducts[i]

                    product.total =  product.amount * product.price
                    if (product.special_description) {
                        product.description = product.special_description
                        product.retail_price = product.special_price
                    }
                    this.addRow(product)
                }
            }
            this.$root.$on('add-element', (product) => {
                this.addRow(product)
            })
            this.$root.$on('delete-item', (data) => {
                this.deleteRow(data[0], data[1])
            })
            this.$root.$on('update-total', (data) => {
                this.updateTotal(data[0], data[1], data[2])
            })
            this.$root.$on('update-family-count', (data) => {
                this.updateFamilyCount(data[0], data[1])
            })
        }
	};
</script>
