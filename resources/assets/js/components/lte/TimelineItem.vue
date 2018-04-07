<template lang="html">
    <li>
        <i :class="'fa fa-' + icon + ' bg-' + color"></i>

        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> {{ hour }}</span>

            <h3 class="timeline-header"><slot name="title"></slot></h3>

            <div v-if="hasSlotDefault" class="timeline-body">
                <slot></slot>
            </div>

            <div v-if="hasSlotFooter" class="timeline-footer">
                <slot name="footer"></slot>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    props: ['icon', 'color', 'hour'],
    computed: {
        hasSlotDefault() {
        	return this.$slots.default;
        },
        hasSlotFooter() {
        	return this.$slots.footer;
        },
    }
}
</script>
