<template>
	<tr>
        <td>
            <a href="#" @click="remove" style="color: red;"><i class="fa fa-times"></i></a>
        </td>
        <td>
            {{ item.description }}
            <input type="hidden" name="items[]" :value="item.id">
        </td>
        
        <td>
            <div class="input-group input-group-sm">
                <input class="form-control" type="number" name="quantities[]" min="1" v-model.number="quantity" @change="updateQ">
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    data() {
        return {
            quantity: 1
        };
    },
    props: ['item', 'index'],
    methods: {
        remove() {
            this.$root.$emit('delete-item', this.index)
        },
        updateQ() {
            this.$root.$emit('update-total', [this.index, this.quantity])
        }
    }
}
</script>
