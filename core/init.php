<?php

$db = mysqli_connect('127.0.0.1', 'root', '12345678', 'php-eCommerce');

if (mysqli_connect_errno()) {
    echo 'Database connection failed withe follwing errors: ' . mysqli_connect_error();
    die();
}

session_start();
// ob_start();
$pathe_confi = "/Users/nehadalaa/Sites/php-eCommerce/admin/product/conif.php";
// require_once($pathe_confi);
// $path_herFull = "/Users/nehadalaa/Sites/php-eCommerce/admin/includes/herlFull.php";
// require_once($path_herFull);
define('CART_COOKIE', 'SBwi72UCklwiqzz2');
define('CART_COOKIE_EXPIRE', time() + (86400 * 30));
define('TAXRATE', 0.25);



$cart_id = '';
if (isset($_COOKIE[CART_COOKIE])) {
    $cart_id = $_COOKIE[CART_COOKIE];

    // $cart_id = $db->$insert_id;
}

if (isset($_SESSION['SBUser'])) {
    $userid = $_SESSION['SBUser'];
    $query = $db->query("SELECT * FROM users WHERE id = '$userid' ");
    $userdata = mysqli_fetch_assoc($query);
    $fn = explode(' ', $userdata['full_name']);
    $firstname = $fn[0];
    $lastname = $fn[1];
}

if ($_SESSION['sucess_falsh']) {
    echo "<div class='bg-success'><p class='text-center text-dark'>" . $_SESSION['sucess_falsh'] . "</p></div>";
    unset($_SESSION['sucess_falsh']);
}

if ($_SESSION['error_falsh']) {
    echo "<div class='bg-danger'><p class='text-center text-danger'>" . $_SESSION['error_falsh'] . "</p></div>";
    unset($_SESSION['error_falsh']);
}


// ob_end_flush();
