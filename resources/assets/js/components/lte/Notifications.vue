<template>
  <li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i :class="'fa fa-' + icon"></i>
      <span v-if="notificationsCount > 0" :class="'label label-' + color">{{ notificationsCount }}</span>
    </a>
    <ul v-if="notificationsCount > 0" class="dropdown-menu">
    
      <li class="header">{{ notificationsCount }} {{ notificationsCount > 1 ? 'pendientes': 'pendiente' }} por revisar</li>

      <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu">
          <li v-if="shippings > 0">
            <a :href="'/'+ company + '/envios/pendiente'">
              <i class="fa fa-shipping-fast text-aqua"></i> {{ shippings }} envío{{ shippings > 1 ? 's': '' }} sin número de guía
            </a>
          </li>
          <li v-if="egresses > 0">
            <a :href="'/'+ company + '/egresos/pendiente'">
              <i class="fa fa-calendar-times text-red"></i> {{ egresses }} egreso{{ egresses > 1 ? 's': '' }} va{{ egresses > 1 ? 'n': '' }} a expirar pronto
            </a>
          </li>
          <li v-if="numbers > 0">
            <a :href="'/'+ company + '/ingresos'">
              <i class="fa fa-barcode text-yellow"></i> A {{ numbers }} venta{{ numbers > 1 ? 's': '' }} le faltan números de serie
            </a>
          </li>

          <li v-if="tasks > 0">
            <a :href="'/'+ company + '/tareas'">
              <i class="fa fa-tasks text-green"></i> {{ tasks }} tarea{{ tasks > 1 ? 's': '' }} pendiente{{ tasks > 1 ? 's': '' }} de revisar
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </li>
</template>

<script>
  export default {
    props: ['icon', 'color', 'company'],
    data() {
      return {
        shippings: 0,
        egresses: 0,
        numbers: 0,
        tasks: 0,
      }
    },
    methods: {
      fetch(model) {
          axios.get('/api/notifications/' + this.company + '/' + model)
              .then((response) => {
                  // console.log(response.data);
                  this[model] = response.data;
              })
      },
    },
    computed: {
      notificationsCount() {
        return this.shippings + this.egresses + this.numbers + this.tasks;
      }
    },
    created() {
      this.fetch('shippings');
      this.fetch('egresses');
      this.fetch('numbers');
      this.fetch('tasks');
    }
  };
</script>
