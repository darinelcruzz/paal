<template>
	<div :id="'field_' + name" class="form-group">
        <label :for="name" class="control-label"><b>{{ label }}</b></label>
        <div class="input-group">
            <span class="input-group-addon">
                <i :class="'fa fa-' + icon"></i>
            </span>
            <select :id="name" :name="name" class="form-control" v-model="selected">
                <option value="" selected="selected">Seleccionar una opción</option>
                <option v-for="item in items" :value="item.name">{{ item.name }}</option>
            </select>
			<!-- <input list="options" :name="name" :id="name" class="form-control" v-model="selected">
			<datalist id="options">
			  	<option v-for="item in items" :value="item.name">{{ item.name }}</option>
			</datalist> -->
        </div>
    </div>
</template>

<script>
export default {
    props: {
      loaded: {
        type: Boolean,
        default: false
      },
      name: {
        type: String,
        default: ''
      },
      label: {
        type: String,
        default: ''
      },
      icon: {
        type: String,
        default: 'cogs'
      },
      model: {
        type: String,
        default: ''
      },
      emitting: {
        type: String,
        default: ''
      },
      recieving: {
        type: String,
        default: ''
      }
    },
	data() {
		return {
			items: [],
			selected: '',
			recieved: '',
		}
	},
	methods: {
		fetch(route) {
			axios.get(route).then(({data}) => {
		       this.items = data;
		    });
		}
	},
	computed: {
		route() {
			return '/api/' + this.recieving + '/' + this.recieved + '/' + this.model;
		}
	},
	watch: {
		selected(value) {
			this.$root.$emit("EV" + this.emitting, value);
			console.log('TEST EMIT: ' + "EV" + this.emitting +": "+ value);
		}
	},
	created() {
		if(this.loaded) {
			this.fetch('/api/' + this.recieving);
		}
		this.$root.$on("EV" + this.model, (recieved) => {
			this.recieved = recieved;
			this.fetch(this.route)
		});
	}
};
</script>