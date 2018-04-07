<template lang="html">
    <li class="list-group-item">
        <b>{{ label }}</b> <a class="pull-right"><slot></slot></a>
    </li>
</template>

<script>
export default {
    props: ['label']
}
</script>
