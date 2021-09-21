<template lang="html">
    <li>
        <a type="button" v-if="datatarget" data-toggle="modal" :data-target="'#' + to">
	        <i :class="['fa fa-' + icon]" aria-hidden="true"></i>{{ text }}
	    </a>
        <a v-else :href="to" :target="target" :download="download">
            <i :class="['fa fa-' + icon]" aria-hidden="true"></i>{{ text }}
        </a>
    </li>
</template>

<script>
export default {
    props: {
    	to: String, 
    	icon: String,
    	text: String,
    	download: String,
    	datatarget: {
    		type: Boolean,
    		default: false
    	},
    	target: {
    		type: String,
    		default: '_self'
    	}
    }
};
</script>
