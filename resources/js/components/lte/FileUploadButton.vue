<template>
	<div :class="['fileUpload btn btn-xs', 'btn-' + boxColor]">
        <span><i class="fa fa-cloud-upload" aria-hidden="true"></i></span>
        <input type="file" :name="fname" :accept="'application/' + ext" class="upload" @change="changeButtonColor">
    </div>
</template>

<script>

export default {
    data() {
        return {
            boxColor: '',
        };
    },
    props: ['fname', 'ext', 'color'],
    methods: {
    	changeButtonColor() {
    		this.boxColor = "success";
    	}
    },
    created() {
        this.boxColor = this.color;
    }
}
	
</script>

<style lang="css">
	.fileUpload {
        position: relative;
        overflow: hidden;
        margin: 10px;
    }

    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 16px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
</style>