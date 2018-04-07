<template lang="html">
    <div :class="[tabClass]" :id="tabId">
        <slot></slot>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tabClass: 'tab-pane',
            tabId: 'tab_'
        };
    },
    props: ['i', 'active'],
    created() {
        this.tabClass += this.active == '' ? ' active': '';
        this.tabId += this.i;
    }
}
</script>
