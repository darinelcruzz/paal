<template lang="html">
    <div :class="[itemColor]">
      <div class="box-header with-border">
        <h4 class="box-title">
          <a data-toggle="collapse" data-parent="#accordion" :href="'#' + title">
            {{ title }}
          </a>
        </h4>
      </div>
      <div :id="title" :class="[panel]">
        <div class="box-body">
          <slot></slot>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            itemColor: 'panel box box-',
            panel: 'panel-collapse collapse'
        };
    },
    props: ['title', 'color', 'open'],
    created() {
        this.itemColor += this.color;
        this.panel += this.open == '' ? ' in': '';
    }
}
</script>
