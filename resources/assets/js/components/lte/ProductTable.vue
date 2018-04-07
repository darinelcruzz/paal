<template lang="html">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Talla</th>
                    <th>Cantidad</th>
                    <th>P. Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <prow :num="1" @subtotal="addToTotal"></prow>
                <prow :num="2" @subtotal="addToTotal"></prow>
                <prow :num="3" @subtotal="addToTotal"></prow>
                <prow :num="4" @subtotal="addToTotal"></prow>
                <prow :num="5" @subtotal="addToTotal"></prow>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td><b>Descuento:</b></td>
                    <td>
                        <input type="number" name="discount" v-model="discount" step="0.01" min="0" :max="total">
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td><b>Total:</b></td>
                    <td>
                        $ {{ total - discount | money }}
                        <input type="hidden" name="total" :value="total - discount">
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            total: 0,
            discount: 0,
            subtotals: [0, 0, 0, 0, 0],
        };
    },
    methods: {
        addToTotal(total, num) {
            this.subtotals[num - 1] = total;
            this.total = this.subtotals.reduce(function (total, value) {
                return total + value;
            }, 0);
        }
    },
    filters: {
      money: function (value) {
        return value.toFixed(2);
      }
    }
}
</script>
