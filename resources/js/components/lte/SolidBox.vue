<template lang="html">
    <div :class="[colorBox, {'box box-solid': true, 'collapsed-box': isCollapsed}]">
        <div class="box-header with-border">
            <h3 class="box-title">{{ title }}</h3>
            <div class="box-tools pull-right">
                <button v-if="showButton" class="btn btn-box-tool" data-widget="collapse">
                    <i :class="{'fa fa-minus': !isCollapsed, 'fa fa-plus': isCollapsed}"></i>
                </button>

                 <span v-if="hasLabel" :class="'label label-' + color">{{ label }}</span>
            </div>
        </div>

        <div class="box-body">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isCollapsed: false,
            showButton: false,
            colorBox: 'box-',
            hasLabel: false,
        };
    },
    props: ['title', 'color', 'button', 'collapsed', 'label'],
    created() {
        this.isCollapsed = this.collapsed == '';
        this.showButton = this.button == '';
        this.colorBox += this.color;
        this.hasLabel = this.label != '';
    }
}
</script>
