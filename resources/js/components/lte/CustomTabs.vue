<template lang="html">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li v-for="(tab, index) in tabs" :class="[{'active': index == 0}]">
                <a :href="'#tab_' + (index + 1)" data-toggle="tab">{{ tab }}</a>
            </li>
        </ul>
        <div class="tab-content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['tabs']
}
</script>
