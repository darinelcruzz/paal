<template lang="html">
    <div class="btn-group">
        <button type="button" :class="['btn btn-xs', 'btn-' + color, 'dropdown-toggle']" data-toggle="dropdown">
          <i :class="['fa fa-' + icon]" aria-hidden="true"></i>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
          <slot></slot>
        </ul>
    </div>
</template>

<script>
export default {
    props: ['color', 'icon']
}
</script>
