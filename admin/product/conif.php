<?php

// $db = mysqli_connect('127.0.0.1', 'root', '12345678', 'php-eCommerce');

// if (mysqli_connect_errno()) {
//     echo 'Database connection failed withe follwing errors: ' . mysqli_connect_error();
//     die();
// }
session_start();
ob_start();

define('BASEURL', $_SERVER['DOCUMENT_ROOT'] . '/php-eCommerce/');
define('CART_COOKIE', 'SBwi72UCklwiqzz2');
define('CART_COOKIE_EXPIRE', time() + (86400 * 30));
