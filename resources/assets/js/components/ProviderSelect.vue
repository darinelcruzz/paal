<template>
	<div>
		<label><b>Proveedor</b></label><br>
        <v-select label="name" :options="providers" v-model="provider" placeholder="Seleccione un proveedor...">
            <template slot="option" slot-scope="option">
                {{ option.name }}
            </template>
        </v-select>
        <input type="hidden" name="provider_id" :value="provider.id" v.model="generalE.provider">
	</div>
</template>

<script>
	export default {
		data() {
			return {
				provider: '',
				providers: []
			}
		},
		methods: {
			refresh() {
				const t = this;
				t.provider_id = provider.id

		        axios.get('/api/providers').then(({data}) => {
		            t.providers = data;
		        });
			}
		},
		created() {
			const t = this;

	        axios.get('/api/providers').then(({data}) => {
	            t.providers = data;
	        });
		}
	};
</script>