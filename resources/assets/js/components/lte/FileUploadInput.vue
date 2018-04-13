<template>
	<div class="fileUpload btn btn-success pull-left">
        <span><i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp;&nbsp;{{ fileName }}</span>
        <input type="file" :name="fname" :accept="'application/' + ext" class="upload" @change="showFileName">
    </div>
</template>

<script>

export default {
	data() {
        return {
            fileName: 'Subir archivo'
        };
    },
    props: ['fname', 'ext'],
    methods: {
    	showFileName() {
    		this.fileName = "Listo";
    	}
    },
    created() {
    	this.fileName += " ." + this.ext;
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