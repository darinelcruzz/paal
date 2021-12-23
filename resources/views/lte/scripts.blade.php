<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<script src="{{ mix('js/app.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->

<script>
    // Data Table With Full Features
    var language = {
      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Registros del _START_ al _END_ de _TOTAL_ ",
      "sInfoEmpty":      "No hay registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "<i class='fa fa-forward' aria-hidden='true'></i>",
          "sPrevious": "<i class='fa fa-backward' aria-hidden='true'></i>"
      },
      "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    };

    $('.spanish').DataTable({
      'ordering': true,
      'order': [[ 0, "desc" ]],
      'language': language
    });

    $('.spanish-simple').DataTable({
      ordering: false,
      language: language
    });


    $(window).keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });
</script>

<!-- Charting library -->
<script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
<!-- Your application script -->

@yield('chartisan')

<script>
    function submitForm(btn) {
        // disable the button
        btn.disabled = true;
        // submit the form
        btn.form.submit();
    }
    
    function printTicket() {
        window.print();
    }

    $(document).ready(function() {
        $('tbody').on('click', '.deleteThisObject', function () {
            id = $(this).attr('idInstance');
            route = $(this).attr('route');

            swal('¿Está seguro?', 'Si no lo está, puede cancelar la acción', 'warning', {
                buttons: ['Salir', 'Siguiente'],
                dangerMode: true
            })
            .then((result) => {
                if(result) {
                    swal('Escribe la razón de la cancelación:', {
                      buttons: ['Salir', 'Cancelar'],
                      content: "input",
                    }).then((value) => {
                        if (value) {
                          window.location = route + "/cancelar/" + id + "/" + value;
                        }
                    });
                } else {
                  swal('No se cancelará nada :)')
                }
            });
        });

        $('tbody').on('click', '.deleteThisObjectNoReason', function () {
            id = $(this).attr('idInstance');
            route = $(this).attr('route');

            swal('¿Está seguro?', 'Si no lo está, puede cancelar la acción', 'warning', {
                buttons: ['Salir', 'Confirmar'],
                dangerMode: true
            })
            .then((result) => {
                if(result) {
                    window.location = '/coffee/' + route + "/eliminar/" + id;
                } else {
                  swal('No se cancelará nada :)')
                }
            });
        });
    });
</script>