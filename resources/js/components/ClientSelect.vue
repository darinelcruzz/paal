<template>
	<div>
		<label><b>Cliente</b></label><br>
        <v-select label="name" :options="clients" v-model="client" placeholder="Seleccione un cliente...">
            <template slot="option" slot-scope="option">
                {{ option.rfc }} - {{ option.name }}
            </template>
        </v-select>
        <br>

        <div v-if="addresses.length > 0 && model == 'sale'">
	        <div class="form-group">
	          <label>Entregar en</label>

	          <div class="input-group date">
	            <div class="input-group-addon">
	              <i class="fa fa-shipping-fast"></i>
	            </div>
	            <select name="address_id" class="form-control pull-right" required>
	            	<option v-for="address in addresses" :value="address.id" selected>{{ address.street }}</option>
	            </select>
	          </div>
	        </div>
        </div>

        <div v-if="client.name == 'CAMPAÑA' || client.name == 'FORMULARIO'">
        	<div class="form-group">
                <label>Nombre</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-comment"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="client_name">
                </div>
            </div>

            <div class="row">
            	<div class="col-md-6">
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
            	<div class="col-md-6">
			          <div class="form-group">
			              <label>Origen</label>

			              <div class="input-group date">
			                <div class="input-group-addon">
			                  <i class="fa fa-microphone"></i>
			                </div>
			                <select name="via" class="form-control pull-right">
			                	<option value="facebook" selected>Facebook</option>
			                	<option value="google">Google</option>
			                	<option value="adword">Adword</option>
			                	<option value="página web">Página web</option>
			                	<option value="recomendación">Recomendación</option>
			                	<option value="otro">Otro</option>
			                </select>
			              </div>
			          </div>
            	</div>
            </div>
        	<hr>
        </div>
        <input type="hidden" name="client_id" :value="client.id">
	</div>
</template>

<script>
	export default {
    props: {
      company: {
        type: String,
        default: 'coffee'
      },
      model: {
        type: String,
        default: 'sale'
      }
    },
		data() {
			return {
				client: '',
				clients: [],
				addresses: [],
			}
		},
		methods: {
			refresh() {
				const t = this;
				t.client_id = client.id
        axios.get('/api/clients/' + this.company).then(({data}) => {
            t.clients = data;
        });
			},
		},
		watch: {
			client(value) {
				if (value != '') {
						axios.get('/api/clients/' + this.client.id + '/addresses').then(({data}) => {
	            this.addresses = data;
	        });
				}
			}
		},
		created() {
			const t = this;

	        axios.get('/api/clients/' + this.company).then(({data}) => {
	            t.clients = data;
	        });
		}
	};
</script>
