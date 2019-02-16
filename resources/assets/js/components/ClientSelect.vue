<template>
	<div>
		<label><b>Cliente</b></label><br>
        <v-select label="name" :options="clients" v-model="client" placeholder="Seleccione un cliente...">
            <template slot="option" slot-scope="option">
                {{ option.rfc }} - {{ option.name }}
            </template>
        </v-select>
        <input type="hidden" name="client_id" :value="client.id">
	</div>
</template>

<script>
	export default {
		data() {
			return {
				client: '',
				clients: []
			}
		},
		methods: {
			refresh() {
				const t = this;
				t.client_id = client.id

		        axios.get('/api/clients').then(({data}) => {
		            t.clients = data;
		        });
			}
		},
		created() {
			const t = this;

	        axios.get('/api/clients').then(({data}) => {
	            t.clients = data;
	        });
		}
	};
</script>