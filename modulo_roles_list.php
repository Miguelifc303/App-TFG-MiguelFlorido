<!doctype html>
<html lang="en" data-bs-theme="light" data-menu-color="light" data-topbar-color="dark">
<?php include("maquetacion/head.php"); ?>

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
          <h1 class="h2">Roles</h1>
          <div class="d-flex align-items-center gap-2">
            <a href="#" class="btn btn-success" id="exportar">Exportar&nbsp;<i class="fa-regular fa-file-excel"></i></a>
          </div>
        </div>

        <?php
        $excel = '<table><thead><tr>
          <th>Id</th>
          <th>Rol</th>
        </tr></thead><tbody>';
        ?>

        <table class="table datatabla">
          <thead>
            <tr>
              <th>Id</th>
              <th>Rol</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $roles = getAllV("roles");

            if (count($roles) > 0) {
              foreach ($roles as $r) {
            ?>
                <tr>
                  <td><?php echo $r["id"]; ?></td>
                  <td><?php echo $r["rol"]; ?></td>
                </tr>
            <?php
                $excel .= '<tr>';
                $excel .= '<td>' . $r["id"] . '</td>';
                $excel .= '<td>' . $r["rol"] . '</td>';
                $excel .= '</tr>';
              }
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>Rol</th>
            </tr>
          </tfoot>
        </table>

        <?php $excel .= '</tbody></table>'; ?>

        <form action="fichero_excel.php" method="post" enctype="multipart/form-data" id="formExportar">
          <input type="hidden" value="Roles" name="nombreFichero">
          <input type="hidden" value="<?php echo $excel; ?>" name="datos_a_enviar">
        </form>

      </div> <!-- End Content -->

      <!-- Footer Start -->
      <?php include("maquetacion/footer.php"); ?>
    </div>
  </div>
  <?php include("maquetacion/scripts.php"); ?>

  <script>
    $("#exportar").click(function () {
      $("#formExportar").submit();
    });
  </script>


</body>
</html>
