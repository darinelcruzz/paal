<template lang="html">
    <div :class="itemClass">
        <img :src="img" :alt="caption">

        <div class="carousel-caption">
            {{ caption }}
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            itemClass: 'item'
        };
    },
    props: ['img', 'caption', 'active'],
    created() {
        this.itemClass += this.active == '' ? ' active': '';
    }
}
</script>
