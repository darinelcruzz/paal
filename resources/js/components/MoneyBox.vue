<template>
	<div :class="'box box-' + color + ' box-solid collapsed-box'">
        <div class="box-header with-border">
            <h3 class="box-title">
                <div class="row">
                    <div class="col-md-4">
                        <i :class="icon + ' fa-2x'"></i>
                    </div>
                    <div class="col-md-8">
                        <slot></slot>
                    </div>
                </div>
            </h3>
        </div>
        <div class="box-body"></div>
    </div>
</template>

<script>
	export default {
		props: ['color', 'icon']
	};
</script>