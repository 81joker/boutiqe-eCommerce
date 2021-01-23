<?php
session_start();
require_once("core/init.php");
require_once("includes/navbar.php");

require_once("includes/head.php");
require_once("includes/headfull.php");

// echo $file = __DIR__.'/includes/model.php';
$path = "images/products";
$sql = "SELECT * FROM `products` WHERE featuerd = 1 && deletes = 0 ";
$featured = $db->query("$sql");
$pathes = "/~nehadalaa/Ritzy/images/product";

define('BASEURL', '/~nehadalaa/php-eCommerce/');
?>

<?php ob_start(); ?>
<div class="contaoner">
    <div class="row">
        <!-- Right Side Bar -->
        <div class="col-md-2"> right side</div>


        <!-- Main side Bar -->
        <div class="col-md-8">
            <h2 class="text-center">Feauterd Produdct</h2>

            <div class="row">
                <?php
                if ($featured->num_rows > 0) {
                    while ($product = $featured->fetch_assoc()) :   ?>
                        <div class="col-md-3">
                            <h4><?= $product['title']; ?></h4>
                            <img src="<?= $path . '/' . $product['image']; ?>" alt="Levis Jeans"   class="img-thumbnail mg-fluid" />
                            <p class="list-price text-danger">List Price <s>$<?= $product['list_price']; ?></s></p>
                            <p class="price"> Our Price: $<?= $product['price']; ?></p>

                            <button type="button" class="btn btn-success btn-sm ml-4" id="details-model" onclick="detailsModel(<?= $product['id']; ?>)">Detalis</button>
                        </div>
                <?php endwhile;
                }  ?>
            </div>
        </div>


        <!-- Let Side Bar -->
        <div class="col-md-2"> left side</div>
    </div>
</div>

<!-- MOdeeell  -->


<!--Start Details  Modal-->
<?php include("includes/model.php"); ?>

<!-- Footer -->
<?php require_once("includes/footer.php");   ?>

<?php echo  ob_get_clean()  ?>