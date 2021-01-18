<?php
   ob_start(); 
   session_start();
  //  session_regenerate_id();
      require_once ("../core/init.php");
      require_once ("includes/head.php");
      require_once ("includes/navbar.php");
      require_once ("includes/herlFull.php");
      if (!is_logged_in ()) {login_error_redirect();}


      $sql = "SELECT * FROM products WHERE deletes = 1";
      $result = $db->query($sql);
      if ($_GET['restore']) {
      $restor_id = (int)$_GET['restore'];
      $db->query(" UPDATE `products` SET `deletes` = 0 WHERE id = '$restor_id' ");
      header('Location:products.php');
      }
?>
   <div class="container">
        <h1 class="text-center">Archived-Products</h1>
   <table class="table table-bordered table-condensed table-striped  ">
                    <thead class="thead">
                <tr>
                    <th></th>
                    <th>Produts</th>
                    <th>Price</th>
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
                        <a href="?restore=<?=$product['id']  ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-refresh" ></span></a>                
           
                    </td>
                        <td><?=$product['title'] ;?></td>
                        <td><?= money($product['price'])  ?></td>
                        <!-- <td><a href="?featured=<?=(($product['featuerd'] == 0)?'1':'0') ?>&id=<?=$product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-<?=(($product['featuerd']== 1)?'minus':'plus') ?>"></span></a>&nbsp <?=(($product['featuerd'])?'Feuterd Product':'') ?></td> -->
                        <td><?= $category?></td>
                        <td></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
        </table>
   </div> 
<?php 

 include("includes/footer.php");
 echo ob_get_clean();
?>
