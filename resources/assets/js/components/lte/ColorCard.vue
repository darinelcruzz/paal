<template>
    <div :class="'small-box bg-' + color">
        <div class="inner">
            <div v-html="label"></div>
            <h3>
                <slot></slot>
            </h3>
        </div>
        <div class="icon">
            <i :class="'fa fa-' + icon"></i>
        </div>
        <br>
    </div>
</template>

<script>
    export default {
        props: ['color', 'icon', 'label']
    }
</script>