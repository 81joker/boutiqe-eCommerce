<?php

?>

<div class="text-center" id="footer">&copy; Copyright2020-2012 Shaunta's Boutique </div>

<?php
define('BASEURL', '/~nehadalaa/php-eCommerce/');
?>
<script>
    // var baseurl = window.location.origin+window.location.pathname;
    // console.log(baseurl);
    function detailsModel(id) {
        var data = {
            "id": id
        };
        jQuery.ajax({
            url: '/~nehadalaa/php-eCommerce/includes/model.php',
            method: "POST",
            type: 'POST',
            data: data,
            success: function(res) {
                if (jQuery('#details-modal').length) {
                    jQuery('#details-modal').remove();
                }
                jQuery('body').append(res);
                jQuery('#details-modal').modal('toggle');
            },

            error: function() {
                alert("Something went worng")
            },
        });
    }



    //Function Update cart
    function update_cart(mode, edit_id, eidt_size) {
        var data = {
            "mode": mode,
            "edit_id": edit_id,
            "eidt_size": eidt_size
        };
        jQuery.ajax({
            url: '/~nehadalaa/php-eCommerce/admin/product/update_cart.php',
            method: "post",
            data: data,
            success: function() {
                location.reload()
            },
            error: function() {
                alert("Sothong went worng..in your edit_cart");
            }


        })
    }

    // function for add cart in omdel
    function add_to_cart() {
        jQuery('#modal_errors').html();
        var size = jQuery('#size').val();
        // var quantity = jQuery('#quantity').val();
        var quantity = Number(jQuery('#quantity').val());

        var available = parseInt(jQuery('#available').val());
        // var available = jQuery('#available').val();
        var error = '';
        var data = jQuery('#add_product_form').serializeArray();
        // serializeArray();
        // serialize();
        if (size == '' || quantity == '' || quantity == 0) {
            error += '<p  class="text-danger text-center"> You must Choes a size and quantity</p>'
            jQuery('#modal_errors').html(error);
            return;

        } else if (quantity > available) {
            error += '<p  class="text-danger text-center"> They are only ' + available + ' avalible . </p>';

            jQuery('#modal_errors').html(error);
            return;

        } else {
            jQuery.ajax({
                url: '/~nehadalaa/php-eCommerce/admin/product/add_cart.php',
                method: 'post',
                data: data,
                success: function() {
                    location.reload();
                },
                error: function() {
                    alert('Somting went wrong')
                }
            })
        }
    }
</script>
<script src="js/main.js"></script>
</body>

</html>