<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'] . '/php-eCommerce/');
define('CART_COOKIE', 'SBwi72UCklwiqzz2');
define('CART_COOKIE_EXPIRE', time() + (86400 * 30));
define('TAXRATE', 0.25);

define('CURRENCY',   'usd');
define('CHECKOUTMODE', 'TEST');

if (CHECKOUTMODE == 'TEST') {
    define('STRIPE_PRIVATE', 'sk_test_51IAwYIAzpcswNFJ0B1o0ezEE9JY5fdwiQz1eILPCjFckNDyQOYhINWs2jumxMwltsBaCDFo9rsVI158rO1wmbf2e00NsKRSQkE');
    define('STRIPE_PUBLIC', 'pk_test_51IAwYIAzpcswNFJ0DIPwlUwJylSup2s8XggTOedJcMFocR07ebsCdOGygZVEs2AtEnzi0QRNlEHMOpZmHdFcN3Db00h6oOX6e6');
}

if (CHECKOUTMODE == 'LIVE') {
    define('STRIPE_PRIVATE', '');
    define('STRIPE_PUBLIC', '');
}
