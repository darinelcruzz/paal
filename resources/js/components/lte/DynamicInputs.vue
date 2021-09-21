<template lang="html">
    <div class="table-responsive">
        <table v-if="inputs.length > 0" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Familia</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th style="width: 15%">Cantidad</th>
                    <th>Subtotal</th>
                    <th><i class="fa fa-trash"></i></th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(input, index) in inputs">
                    <td>{{ index + 1 }}</td>
                    <td>
                        <select name="families" v-model="selectedFamilies[index]">
                            <option value="0" selected>Seleccione una...</option>
                            <option v-for="family in families" :value="family">{{ family }}</option>
                        </select>
                    </td>
                    <td>
                        <select name="products[]" v-model="input.id" @change="productSelected(index)">
                            <option value="0" selected>Seleccione uno...</option>
                            <option v-if="product.family == selectedFamilies[index]" v-for="product in products" :value="product.id">{{ product.description }}</option>
                        </select>
                        <!-- <v-select label="description" name="ids[]" :options="products" v-model="input.id" placeholder="Seleccione un producto..." @change="productSelected(index)">
                            <template slot="option" slot-scope="option" :value="option.id">
                                {{ option.code + " - " + option.description }}
                            </template>
                        </v-select> -->
                    </td>
                    <td>
                        $ {{ input.quantity >= input.limit ? input.pricer.toFixed(2) : input.price.toFixed(2) }}
                         <input name="prices[]" type="hidden" :value="input.quantity >= input.limit ? input.pricer.toFixed(2) : input.price.toFixed(2)">
                    </td>
                    <td>
                        <input name="quantities[]" class="form-control input-sm" type="number" min="0" step="0.01" value=0 
                            v-model="input.quantity" @change="quantitySettled(index)">
                    </td>
                    <td>
                        $ {{ input.total.toFixed(2) }}
                        <input name="subtotals[]" type="hidden" :value="input.total.toFixed(2)">
                    </td>
                    <td>
                        <a class="btn btn-danger btn-xs" @click="deleteRow(index)"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="5"><span class="pull-right">Total:</span></th>
                    <td>
                        $ {{ total.toFixed(2) }}
                        <input type="hidden" name="amount" :value="total.toFixed(2)">
                        <input type="hidden" name="iva" :value="total.toFixed(2) * 0.16/1.16">
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <div align="center">
            <a class="btn btn-success btn-xs" @click="addRow"><i class="fa fa-plus"></i> Agregar</a>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            inputs: [],
            products: [],
            families: [],
            selectedFamilies: [],
        };
    },
    watch: {
        inputs: {
            handler: function(val, oldVal) {

                var newArray = $.map(val[0], function(value, index) {
                    return [value];
                });
                var oldArray = $.map(oldVal[0], function(value, index) {
                    return [value];
                });

                console.log(newArray, oldArray);
                console.log(val, oldVal);
            },
            deep: true  
        }
    },
    methods: {
        addRow() {
          this.inputs.push({
            id: 0,
            price: 0,
            pricer: 0,
            quantity: 0,
            limit: 0,
            total: 0
          })
          this.selectedFamilies.push(0)
        },
        deleteRow(index) {
          this.inputs.splice(index, 1)
        },
        productSelected(index) {
          this.inputs[index].price = this.products[this.inputs[index].id - 1].retail_price;
          // this.inputs[index].price = this.inputs[index].id.retail_price;
          this.inputs[index].pricer = this.products[this.inputs[index].id - 1].wholesale_price;
          // this.inputs[index].pricer = this.inputs[index].id.wholesale_price;
          this.inputs[index].limit = this.products[this.inputs[index].id - 1].wholesale_quantity;
          // this.inputs[index].limit = this.inputs[index].id.wholesale_quantity;
          this.quantitySettled(index);
        },
        quantitySettled(index) {
            if (this.inputs[index].quantity >= this.inputs[index].limit) {
                this.inputs[index].total = this.inputs[index].pricer * this.inputs[index].quantity
            } else {
                this.inputs[index].total = this.inputs[index].price * this.inputs[index].quantity
            }
        }
    },
    computed: {
        total() {
            return this.inputs.reduce((total, input) => total + input.total, 0)
        }
    },
    created() {
        const t = this;
        axios.get('/paal/productos/axios').then(({data}) => {
            t.products = data;
            let arr = t.products.map(function (item) {
                return item.family;
            });
            let families = [];
            for(let i = 0;i < arr.length; i++){
                if(families.indexOf(arr[i]) == -1){
                    families.push(arr[i])
                }
            }
            t.families = families;
        });
    }
};
</script>