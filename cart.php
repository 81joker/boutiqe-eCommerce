<?php
session_start();
require_once("core/init.php");
require_once("includes/navbar.php");
require_once("includes/head.php");
require_once("includes/headfull.php");

if ($cart_id != '') {
    $cardQ = $db->query("SELECT * FROM cart WHERE id = '$cart_id' ");
    $result = mysqli_fetch_assoc($cardQ);
    $items = json_decode($result['items'], true);
    $i = 1;
    $sub_total = 0;
    $item_count = 0;
}
?>
<div class="row">
    <div class="col-md-12">
        <h2 class="text-center">My Shopping Cart</h2>
        <hr>
        <?php if ($cart_id == '') : ?>
            <div class="bg-danger " style="margin: 0 60px;">
                <p class="text-center text-black">
                    You Shopping Cart is Empty
                </p>
            </div>
        <?php else : ?>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <th>#</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Size</th>
                    <th>Sub Total</th>
                </thead>
                <thbody>
                    <?php
                    foreach ($items as $item) {
                        $product_id = $item['id'];

                        $productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
                        $product = mysqli_fetch_assoc($productQ);
                        $sArray = explode(',', $product['sizes']);
                        foreach ($sArray as $sizeString) {
                            $s = explode(':', $sizeString);
                            if ($s[0] == $item['size']) {
                                $available = $s[1];
                            }
                        }
                    ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $product['title']  ?></td>
                            <td><?= money($product['price']) ?> </td>
                            <td>

                                <button class="btn btn-xs btn-outline-secondary" onclick="update_cart('removeone' ,'<?= $product['id'] ?>' ,'<?= $item['size']; ?>')">-</button>
                                <?= $item['quantity'];
                                if ($item['quantity'] < $available) : ?>
                                    <button class="btn btn-xs  btn-outline-secondary" onclick="update_cart('addone' ,'<?= $product['id'] ?>' , '<?= $item['size']; ?>')">+</button>
                                <?php else : ?>
                                    <span class="text-danger">Max </span>
                                <?php endif; ?>
                            </td>
                            <td><?= $item['size']  ?></td>
                            <td><?= money($item['quantity'] * $product['price']); ?></td>
                        </tr>
                    <?php
                        $i++;
                        $item_count += $item['quantity'];
                        $sub_total +=  ($item['quantity'] * $product['price']);
                    }
                    $tax = TAXRATE * $sub_total;
                    $tax = number_format($tax, 2);
                    $grand_total = $tax + $sub_total;
                    ?>
                </thbody>
            </table>
            <table class="table table-bordered table-condensed text-right">
                <legend>Totals</legend>
                <thead class="totals-table-header text-center">
                    <th>Total items</th>
                    <th>Sub_Total</th>
                    <th>Tax</th>
                    <th>Grand Total</th>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td><?= $item_count; ?></td>
                        <td><?= money($sub_total); ?></td>
                        <td><?= money($tax); ?></td>
                        <td class="bg-success"><?= money($grand_total); ?></td>

                    </tr>
                </tbody>
            </table>
            <!-- ChekOUt Button  modal -->
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#chekoutModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z" />
                </svg>
                Check out >>
            </button>

            <!-- Modal -->
            <div class=" modal fade" id="chekoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="checkoutModalLabel">Shipping Adress</h4>

                        </div>
                        <div class="modal-body">
                            <form action="thankYou.php" method="post" id="payment-form">
                                <span id="payment-errors"></span>

                                <div id="step1" style="display: blocke;">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="full_name">Full Name : </label>
                                            <input type="text" name="full_name" id="full_name" class="form-control">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="email">Email : </label>
                                            <input type="text" name="email" id="email" class="form-control">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="street">Street Address : </label>
                                            <input type="text" name="street" id="street" class="form-control">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="street2">Street Address 2:</label>
                                            <input type="text" name="street2" id="street2" class="form-control">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="city">City : </label>
                                            <input type="text" name="city" id="city" class="form-control">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="state">Status : </label>
                                            <input type="text" name="state" id="state" class="form-control">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="zip_code">Zip Code : </label>
                                            <input type="text" name="zip_code" id="zip_code" class="form-control">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="country">Country : </label>
                                            <input type="text" name="country" id="country" class="form-control">
                                        </div>

                                    </div>

                                </div>
                                <div id="step2" style="display: none;">

                                    <div class="row">

                                        <div class="col-md-3 col-xs-4 form-group">
                                            <label for="name">Name On Card : </label>
                                            <input type="text" name="name" id="name" class="form-control">

                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="number">Number Of Card : </label>
                                            <input type="text" name="number" id="number" class="form-control">

                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label for="cvc">CVS : </label>
                                            <input type="text" name="cvc" id="cvc" class="form-control">

                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label for="exp_month">Expire Month:</label>
                                            <select name="exp_month" id="exp_month" class="form-control">
                                                <option value=""></option>
                                                <?php for ($i = 0; $i < 13; $i++) : ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <label for="exp_year">Expire Year: </label>
                                            <select name="exp_year" id="exp_year" class="form-control">
                                                <option value=""></option>
                                                <?php
                                                $yr = date('Y');
                                                for ($i = 0; $i < 11; $i++) : ?>
                                                    <option value="<?= $yr + $i ?>"><?= $yr + $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="check_address()" id="next_button">Next >></button>
                            <button type="button" class="btn btn-primary" onclick="back_address()" id="back_button" style="display: none;">
                                << Backe </button>
                                    <button type="submit" class="btn btn-primary" id="checkout_button" onclick="checkout_button()" style="display: none;">Check Out>></button>
                                    </form>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
    function back_address() {
        jQuery('#payment-errors').html('');
        jQuery('#step1').css('display', 'block');
        jQuery('#step2').css('display', 'none');
        jQuery('#next_button').css('display', 'inline-block');
        jQuery('#back_button').css('display', 'none');
        jQuery('#checkout_button').css('display', 'none');
        jQuery('#checkoutModalLabel').html('Shipping Adress');
    }

    function check_address() {
        var data = {
            'full_name': jQuery('#full_name').val(),
            'email': jQuery('#email').val(),
            'street': jQuery('#street').val(),
            'street2': jQuery('#street2').val(),
            'city': jQuery('#city').val(),
            'state': jQuery('#state').val(),
            'zip_code': jQuery('#zip_code').val(),
            'country': jQuery('#country').val(),

        };
        jQuery.ajax({
            url: '/~nehadalaa/php-eCommerce/admin/product/check_address.php',
            method: 'post',
            data: data,
            success: function(data) {
                if (data != 'passed') {
                    jQuery('#payment-errors').html(data)

                }
                if (data == 'passed') {
                    jQuery('#payment-errors').html('');
                    jQuery('#step1').css('display', 'none');
                    jQuery('#step2').css('display', 'block');
                    jQuery('#next_button').css('display', 'none');
                    jQuery('#back_button').css('display', 'inline-block');
                    jQuery('#checkout_button').css('display', 'inline-block');
                    jQuery('#checkoutModalLabel').html('Enter Your Card Details');

                }
            },
            error: function() {
                alert('Sothong went worang in check Your Address')
            }
        })
    }
</script>
<!-- Footer -->
<?php require_once("includes/footer.php");   ?>