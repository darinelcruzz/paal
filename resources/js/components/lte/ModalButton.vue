<template lang="html">
    <a type="button" data-toggle="modal" :data-target="'#' + target">
        <slot></slot>
    </a>
</template>

<script>
export default {
    props: ['target']
}
</script>
