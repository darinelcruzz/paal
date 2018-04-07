<template lang="html">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li v-for="(n, index) in numbers" data-target="#carousel-example-generic" :data-slide-to="index" :class="[{'active': index == 0}]"></li>
        </ol>

        <div class="carousel-inner">
            <slot></slot>
        </div>

        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <span class="fa fa-angle-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="fa fa-angle-right"></span>
        </a>
    </div>
</template>

<script>
export default {
    data() {
        return {
            numbers: []
        };
    },
    props: ['items'],

    created() {
        for (var i = 0; i < this.items; i++) {
            this.numbers[i] = i;
        }
    }
}
</script>

<style lang="css">
</style>
