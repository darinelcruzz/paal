<template lang="html">
    <li>
        <a :href="to">
            <i :class="['fa fa-' + icon]" aria-hidden="true"></i>{{ text }}
        </a>
    </li>
</template>

<script>
export default {
    props: ['to', 'icon', 'text']
}
</script>
