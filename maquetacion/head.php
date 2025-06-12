    <?php
session_start();
if((!isset($_SESSION["valido"]))and($_SESSION["valido"]!="1")){
   header("location:login.php");
}
include("db.php");
include("controller.php");
?>
<head>

    <meta charset="utf-8" />
    <title>Dashboard | Scoxe - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Myra Studio" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="assets/libs/morris.js/morris.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="assets/css/style.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <script src="assets/libs/jquery/jquery.min.js"></script>
   <link href="node_modules/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />
    
    <script src="node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
    <link src="node_modules/sweetalert2/dist/sweetalert2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <?php //include("controller.php");?>
    <?php //include("funciones.php");?>
    <script src="assets/js/config.js"></script>
        <link rel="stylesheet" href="style.css">
</head>