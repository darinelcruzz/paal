<template>
    <div :class="'small-box bg-' + color">
        <div class="inner">
            <p>{{ title.toUpperCase() }}</p>
            <h3>
                 <em>{{ type == 'envíos' ? value: number_format(value).substring(1) }}</em>
            </h3>
        </div>
        <div class="icon">
            <i :class="'fa fa-' + icon"></i>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['color', 'title', 'icon', 'company', 'model', 'type', 'date'],
        data() {
            return {
                value: 0,
            }
        },
        methods: {
            number_format(value) {
                let formatter = new Intl.NumberFormat('en-US', {
                  style: 'currency',
                  currency: 'USD',
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                });

                return formatter.format(value);
            }
        },
        created() {
            axios.get('/api/monthly/' + this.model + '/' + this.date + '/' + this.company + '/' + this.type)
                .then((response) => {
                    this.value = response.data
                })
        }
    };
</script>
