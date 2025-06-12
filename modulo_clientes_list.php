  <!doctype html>
  <html lang="en" data-bs-theme="light" data-menu-color="light" data-topbar-color="dark">
    <?php include("maquetacion/head.php"); ?>
    <?php include("db.php"); ?>

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
              <h1 class="h2">Clientes</h1>
              
            </div>

            <table class="table datatabla">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Teléfono</th>
                  <th>Vehículos</th>
                </tr>
              </thead>
             <tbody>
                <?php
                $clientes = getAllClientesyVehiculos('clientes');
                foreach ($clientes as $cliente) { 
                    // Codifica vehículos en JSON para usar en JS
                    $vehiculos_json = htmlspecialchars(json_encode($cliente['vehiculos']));
                ?>
                    <tr data-vehiculos='<?= $vehiculos_json ?>'>
                      <td><?= $cliente['id'] ?></td>
                      <td><?= $cliente['nombre'] ?></td>
                      <td><?= $cliente['email'] ?></td>
                      <td><?= $cliente['telefono'] ?></td>
                      <td>
                        <button class="btn btn-primary btn-ver-vehiculos" type="button">Ver vehículos</button>
                      </td>
                    </tr>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Teléfono</th>
                  <th>Vehículos</th>
                </tr>
              </tfoot>
            </table>

          </div> <!-- End Content -->

          <!-- Footer Start -->
          <?php include("maquetacion/footer.php"); ?>

        </div>
      </div>

      <?php include("maquetacion/scripts.php"); ?>

    </body>
  </html>
