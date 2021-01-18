<?php
session_start();
ob_start();

require_once ("includes/navbar.php") ;
require_once ("includes/head.php");
require_once ("../core/init.php");
if (!is_logged_in ()) {login_error_redirect();}

// if (!has_permission()) {
//         permission_error_redirect('brand.php');
//     }

    // echo $file = __DIR__.'/includes/model.php';
    if ($_SESSION['SBUser']) {
        echo  $_SESSION['SBUser'] ; }

    $sql    = "SELECT * FROM brand WHERE brand = brand";
    $brands = $db->query($sql);
    foreach ($brands as $key) {
        $key['brand'];
    }
   
    ?>

        haloo Admin 

<!-- Footer -->
<?php require_once("includes/footer.php");
ob_end_flush();
?>