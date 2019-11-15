<template>
	<div>
		<label><b>Cliente</b></label><br>
        <v-select label="name" :options="clients" v-model="client" placeholder="Seleccione un cliente...">
            <template slot="option" slot-scope="option">
                {{ option.rfc }} - {{ option.name }}
            </template>
        </v-select>
        <br>

        <div v-if="client.name == 'INTERNET INTERNO' || client.name == 'INTERNET EXTERNO'">
        	<div class="form-group">
                <label>Nombre</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-comment"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="client_name">
                </div>
            </div>

            <div class="form-group">
                <label>Correo</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-at"></i>
                  </div>
                  <input type="email" class="form-control pull-right" name="email">
                </div>
            </div>
        </div>
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