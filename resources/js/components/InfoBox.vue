<template>
    <div :class="'small-box bg-' + color">
        <div class="inner">
            {{ title.toUpperCase() }}
            <h3>
                <small style="color: inherit;">
                    {{ number_format(value).substring(1) }}
                </small>
            </h3>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['color', 'title', 'company', 'type', 'date', 'model'],
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
                    console.log('/api/monthly/' + this.model + '/' + this.date + '/' + this.company + '/' + this.type);
                    this.value = response.data
                })
        }
    };
</script>
