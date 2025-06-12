<!doctype html>
<html lang="en" data-bs-theme="light" data-menu-color="light" data-topbar-color="dark">
  <?php include("maquetacion/head.php");?>
  <body>
   
    <!-- Begin page -->
    <div class="layout-wrapper">
      
      <!-- ========== Left Sidebar ========== -->
      <?php include("maquetacion/menu.php"); ?>

      <!-- Start Page Content here -->
      <div class="page-content">

        <!-- ========== Topbar Start ========== -->
        <?php include("maquetacion/topbar.php"); ?>
        <!-- ========== Topbar End ========== -->

        <!-- Content -->
        <div class="px-3">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Vehículos</h1>
          </div>

          <table class="table datatabla">
            <thead>
              <tr>
                <th>V.Id</th>
                <th>C.Nombre</th>
                <th>C.Telefono</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Matrícula</th>
                <th>Citas Totales</th> 
              </tr>
            </thead>
            <tbody>
              <?php
                $vehiculos = getAllVehiculosConClientesYCitas();

                if (count($vehiculos) > 0) {
                    foreach ($vehiculos as $v) {
              ?>
                      <tr>
                        <td><?php echo $v["id_vehiculo"]; ?></td>
                        <td><?php echo $v["nombre_cliente"]; ?></td> 
                        <td><?php echo $v["telefono"]; ?></td>
                        <td><?php echo $v["marca"]; ?></td>
                        <td><?php echo $v["modelo"]; ?></td>
                        <td><?php echo $v["año"]; ?></td>
                        <td><?php echo $v["matricula"]; ?></td>
                        <td><?php echo $v["total_citas"]; ?></td> 
                      </tr>
              <?php
                    }
                }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>V.Id</th>
                <th>C.Nombre</th>
                <th>C.Telefono</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Matrícula</th>
                <th>Citas Totales</th> 
              </tr>
            </tfoot>
          </table>

        </div> 

        <!-- Footer Start -->
        <?php include("maquetacion/footer.php"); ?>
      </div>
    </div>
    <?php include("maquetacion/scripts.php"); ?>

  </body>
</html>
