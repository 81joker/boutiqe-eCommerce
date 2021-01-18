<?php
    session_start();
    require_once ("core/init.php");
    require_once ("includes/head.php");
    require_once ("includes/navbar.php") ;
    require_once ("includes/headfull.php");

    if (isset($_GET['cat'])) {
        $cat_id = (int)$_GET['cat'];
        $cat_id = sanitize($_GET['cat']);
        
        
    }else {
        $cat_id = '';
    }

    $sql = "SELECT * FROM `products` WHERE categoriess = '$cat_id' &&   featuerd = 1  ";
    $productQ = $db->query("$sql");
    $path ="images/products";
    $pathes ="/~nehadalaa/php-eCommerce/images/products";

    define('BASEURL', '/~nehadalaa/php-eCommerce/' );

  



?>

<?php ob_start(); ?>
<div class="contaoner">
    <div class="row">
        <!-- Right Side Bar -->
        <div class="col-md-2"> right side</div>

        
         <!-- Main side Bar -->
        <div class="col-md-8" > 
        <h2 class="text-center">Feauterd  Produdct</h2>

        <div class="row">
        <?php   
        if ($productQ->num_rows > 0) {
            while($product = $productQ->fetch_assoc()) :   ?>
                    <div class="col-md-3" >
                        <h4><?= $product['title'];?></h4>
                        <img src="<?=  $path.'/'.$product['image'];?>" alt="Levis Jeans"   class="img-thumbnail"/>
                        <p class="list-price text-danger">List Price <s>$<?= $product['list_price'];?></s></p>
                        <p class="price"> Our Price: $<?= $product['price'];?></p>
                        <button type="button" class="btn btn-success btn-sm"  id="details-model" onclick="detailsModel(<?= $product['id'];?>)"  >Detalis</button>  
                      </div>
                    <?php  endwhile; }  ?>  
            </div>
        </div>


        <!-- Let Side Bar -->
        <div class="col-md-2"> left side</div>
    </div>
</div>

<!-- MOdeeell  -->


<!--Start Details  Modal-->
<?php include ("includes/model.php");?>

<!-- Footer -->
<?php require_once("includes/footer.php");   ?>

<?php echo  ob_get_clean()  ?>