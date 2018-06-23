<template lang="html">
    <div class="table-responsive">
        <table v-if="inputs.length > 0" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th style="width: 20%">Cantidad</th>
                    <th>Subtotal</th>
                    <th><i class="fa fa-trash"></i></th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(input, index) in inputs">
                    <td>{{ index + 1 }}</td>
                    <td>
                        <select v-model="input.id" @change="productSelected(index)">
                            <option value="0" selected>Seleccione uno...</option>
                            <option v-for="product in products" :value="product.id">{{ product.description }}</option>
                        </select>
                    </td>
                    <td>
                        $ {{ input.quantity >= input.limit ? input.pricer.toFixed(2) : input.price.toFixed(2) }}
                    </td>
                    <td>
                        <input class="form-control input-sm" type="number" min="0" step="0.01" value=0 
                            v-model="input.quantity" @change="quantitySettled(index)">
                    </td>
                    <td>
                        $ {{ input.total.toFixed(2) }}
                    </td>
                    <td>
                        <button class="btn btn-danger btn-xs" @click="deleteRow(index)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="4"><span class="pull-right">Total:</span></th>
                    <td>$ {{ total.toFixed(2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <div align="center">
            <button class="btn btn-success btn-xs" @click="addRow"><i class="fa fa-plus"></i> Agregar</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            inputs: [],
            products: [
                {id: 1, description: 'coca-cola', price: 10.0, pricer: 5.5, limit: 20},
                {id: 2, description: 'sprite', price: 9.0, pricer: 4.5, limit: 30},
                {id: 3, description: 'fanta', price: 9.5, pricer: 5.0, limit: 50},
                {id: 4, description: 'manzanita', price: 8.5, pricer: 4.0, limit: 100},
                {id: 5, description: 'senzao', price: 8.0, pricer: 3.0, limit: 200},
            ]
        };
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
        },
        deleteRow(index) {
          this.inputs.splice(index, 1)
        },
        productSelected(index) {
          this.inputs[index].price = this.products[this.inputs[index].id - 1].price;
          this.inputs[index].pricer = this.products[this.inputs[index].id - 1].pricer;
          this.inputs[index].limit = this.products[this.inputs[index].id - 1].limit;
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
    }
};
</script>