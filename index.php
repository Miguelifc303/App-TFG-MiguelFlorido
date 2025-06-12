<!DOCTYPE html>

<html lang="en" data-bs-theme="light" data-menu-color="light" data-topbar-color="dark">

<?php
    include("maquetacion/head.php");
?>
<body>


    <!-- Begin page -->
    <div class="layout-wrapper">
        <!-- ========== Left Sidebar ========== -->
        <?php
        include("maquetacion/menu.php");
        ?>
        <!-- Start Page Content here -->

        <div class="page-content">

            <!-- ========== Topbar Start ========== -->
            <?php
                include("maquetacion/topbar.php")
            ?>
            <!-- ========== Topbar End ========== -->
            <!-- content -->
            <div class="px-3">
                <?php
                    include("maquetacion/content.php");
                ?> 
            </div> 

            <!-- Footer Start -->
            <?php
                include("maquetacion/footer.php");
            ?>
            <!-- end Footer -->

        </div>
        <!-- End Page content -->
    </div>
    <!-- END wrapper -->

    <!-- App js -->
    <?php
        include("maquetacion/scripts.php");
    ?>

</body>

</html>