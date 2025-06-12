
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.js"></script>

<!-- Jquery Sparkline Chart  -->
<script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

<!-- Jquery-knob Chart Js-->
<script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>


<!-- Morris Chart Js-->
<script src="assets/libs/morris.js/morris.min.js"></script>

<script src="assets/libs/raphael/raphael.min.js"></script>

<!-- Dashboard init-->
<script src="assets/js/pages/dashboard.js"></script>

<!-- third party js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="node_modules/select2/dist/js/select2.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
  var table = $(".datatabla").DataTable({
    language: {
      "decimal": "",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
      "infoFiltered": "(Filtrado de _MAX_ total entradas)",
      "lengthMenu": "Mostrar _MENU_ Entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "Sin resultados encontrados",
      "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": ">",
        "previous": "<"
      }
    },
    lengthMenu: [
        [5, 10, 20],//Numeros de filas a mostrar
        [5, 10, 20] //Etiquetas del desplegable
    ]
  });

  $('.datatabla tbody').on('click', '.btn-ver-vehiculos', function() {
    var tr = $(this).closest('tr');
    var row = table.row(tr);

    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
    } else {
      // Opcional: cerrar otras filas abiertas
      table.rows('.shown').every(function() {
        this.child.hide();
        $(this.node()).removeClass('shown');
      });

      var vehiculos = tr.data('vehiculos');
      var html = '<ul class="list-group m-2">';
      if (vehiculos && vehiculos.length > 0) {
        vehiculos.forEach(function(v) {
          html += '<li class="list-group-item">' + v.marca + ' ' + v.modelo + ' - ' + v.matricula + '</li>';
        });
      } else {
        html += '<li class="list-group-item">Este cliente no tiene vehículos asignados.</li>';
      }
      html += '</ul>';

      row.child(html).show();
      tr.addClass('shown');
    }
  });

  $(".select2").select2();
});
</script>
<!-- third party js ends -->