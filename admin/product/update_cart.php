<?php

session_start();
ob_start();
require_once("../../core/init.php");
include_once("../includes/herlFull.php");

$mode = sanitize($_POST['mode']);
$edit_id = sanitize($_POST['edit_id']);
$eidt_size = sanitize($_POST['eidt_size']);

$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$result = mysqli_fetch_assoc($cartQ);
$items = json_decode($result['items'], true);
$updated_items = array();
$domain = (($_SERVER['HTTP_HOST'] != 'localhost') ? '.' . $_SERVER['HTTP_HOST'] : false);


if ($mode == "removeone") {
    foreach ($items as $item) {
        if ($item['id'] == $edit_id && $item['size'] == $eidt_size) {
            $item['quantity'] = $item['quantity'] - 1;
        }
        if ($item['quantity'] > 0) {
            $updated_items[] = $item;
        }
    }
}

if ($mode == "addone") {
    foreach ($items as $item) {
        if ($item['id'] == $edit_id && $item['size'] == $eidt_size) {
            $item['quantity'] = $item['quantity'] + 1;
        }
        $updated_items[] = $item;
    }
}

if (!empty($updated_items)) {
    $jeson_update = json_encode(($updated_items));
    $db->query("UPDATE cart SET items = '{$jeson_update}' WHERE id = '{$cart_id}'");
    $_SESSION['sucess_falsh'] = "Your Shopping cart has been updated";
}

if (empty($updated_items)) {
    $db->query("DELETE FROM cart WHERE id = '{$cart_id}'");
    setcookie(CART_COOKIE, "", 1, "/", $domain, false);
}
ob_end_flush();
