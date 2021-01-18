<?php
session_start();
ob_start();
require_once("../../core/init.php");
include_once("../includes/herlFull.php");

$product_id = sanitize($_POST['product_id']);
$available = sanitize($_POST['available']);
$quantity = sanitize($_POST['quantity']);
$size = sanitize($_POST['size']);

$item = array();
$item[] = array(
    'id'       => $product_id,
    'size'     => $size,
    'quantity' => $quantity,
);

$domain = false;
// $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? '.' . $_SERVER['HTTP_HOST'] : false;
// $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
$query = $db->query("SELECT * FROM products WHERE id = '{$product_id}' ");
$product = mysqli_fetch_assoc($query);
$_SESSION['sucess_falsh'] = $product['title'] . ' was added to your cart';

// check to see if the cart cookie exists
if ($cart_id != '') {
    // $cart_id = $db->$insert_id;
    $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
    $cart = mysqli_fetch_assoc($cartQ);
    $previous_items  = json_decode($cart['items'], true);
    $item_match = 0;
    $new_items = array();
    foreach ($previous_items as $pitem) {
        if ($item[0]['id'] == $pitem['id'] && $item[0]['size'] == $pitem['size']) {
            $pitem['quantity'] = $pitem['quantity'] + $item[0]['quantity'];
            if ($pitem['quantity'] > $available) {
                $pitem['quantity'] = $available;
            }
            $item_match = 1;
        }
        $new_items[] = $pitem;
    }
    if ($item_match != 1) {
        $new_items = array_merge($item, $previous_items);
    }

    $items_json = json_encode($new_items);
    $cart_expire = date('Y-m-d H:i:s', strtotime('+30 days'));
    $db->query("UPDATE cart SET items = '{$items_json}' , expire_date = '{$cart_expire}' WHERE id = '{$cart_id}'");
    setcookie(CART_COOKIE, '', 1,  '/', $domain, false);
    setcookie(CART_COOKIE, $cart_id,  time() + (86400 * 30), '/', $domain, false);
} else {
    // add the cart to the database and set cookie 
    $items_json = json_encode($item);
    $cart_expire = date('Y-m-d H:i:s', strtotime('+30 days'));
    $sql = ("INSERT INTO cart (items , expire_date) VALUES ('{$items_json}' , '{$cart_expire}')");
    $db->query($sql);
    $cart_id = $db->insert_id;
    setcookie(CART_COOKIE, $cart_id,  time() + (86400 * 30), '/', null);
}
ob_end_flush();
