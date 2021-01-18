<?php
 ob_start(); 
 session_start();
//  session_regenerate_id();
    require_once ("../core/init.php");
    require_once ("includes/head.php");
    require_once ("includes/navbar.php");
    require_once ("includes/herlFull.php");
    if (!is_logged_in ()) {login_error_redirect();}


if ($_GET['delete']) {
   $delete_id = (int)$_GET['delete'];
   $db->query(" UPDATE `products` SET `deletes` = 1 WHERE id = '$delete_id' ");
   header('Location:products.php');
}
if ($_GET['restore']) {
    $restor_id = (int)$_GET['restore'];
    $db->query(" UPDATE `products` SET `deletes` = 0 WHERE id = '$restor_id' ");
    header('Location:products.php');
}

    $sql = "SELECT * FROM products WHERE deletes = 0";
    $result = $db->query($sql);
    if (isset($_GET['featured'])) {
        $featured = (int)$_GET['featured'];
        $id = (int)$_GET['id'];
        $sql_feat = "UPDATE `products` SET featuerd= '$featured' WHERE id = '$id'";
        $db->query($sql_feat);
        header('Location: products.php');
        }


?>
    <h2 class="text-center">Products</h2>
<?php 
    if ($_GET['add']  OR $_GET['edit']) {
    include_once('product/add_product.php'); 
    
        
    } else {
   

?>
    <div class="container">
    <a class="btn btn-success pull-right" href="?add=1" id="add-product-btn">Add Product</a><div class="clearfix"></div>
    <hr>
  
        
        <table class="table table-bordered table-condensed table-striped  ">
                    <thead class="thead">
                <tr>
                    <th></th>
                    <th>Produts</th>
                    <th>Price</th>
                    <th>Feuatured</th>
                    <th>Category</th>
                    <th>Sold</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                    while($product = mysqli_fetch_assoc($result)):
                    $childID = $product['categoriess'];
                    $sql_cat = "SELECT * FROM categories WHERE id = '$childID'";
                    $result_cat = $db->query($sql_cat);
                    $parent_cat = mysqli_fetch_assoc($result_cat);
                    $parentID = $parent_cat['parent'];
                    $sql_parent = "SELECT * FROM categories WHERE id = '$parentID'";
                    $result_parent =  $db->query($sql_parent);
                    $parent = mysqli_fetch_assoc($result_parent);
                    $category =  $parent['category']. '~' . $parent_cat['category'];      
                    
                    ?>

                    <tr>
                    <td >
                        <a href="products.php?edit=<?=$product['id'] ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil" ></span></a>
                        <a href="?delete=<?=$product['id']  ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-trash" ></span></a>     
           
                    </td>
                        <td><?=$product['title']  ?></td>
                        <td><?= money($product['price'])  ?></td>
                        <td><a href="?featured=<?=(($product['featuerd'] == 0)?'1':'0') ?>&id=<?=$product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-<?=(($product['featuerd']== 1)?'minus':'plus') ?>"></span></a>&nbsp <?=(($product['featuerd'])?'Feuterd Product':'') ?></td>
                        <td><?= $category?></td>
                        <td></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
        </table>

    </div>


<?php 
    }
 include("includes/footer.php");
 echo ob_get_clean();
?>

<!-- <script>
jQuery('document').ready(function(){
    get_child_options('<?=$child_edit;?>')
})
</script> -->
