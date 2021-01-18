<?php
 session_start();
 $db = mysqli_connect('127.0.0.1' , 'root' , '12345678' , 'php-eCommerce');

    if (mysqli_connect_errno()) {
        echo 'Database connection failed withe follwing errors: ' . mysqli_connect_error();
        die();
    }

    $id = $_POST['id'];
    $id = (int)$id;
    $sql = "SELECT * FROM products WHERE id = '$id'";
  
    $result = $db->query($sql);
    $product = mysqli_fetch_assoc($result);

    $brand_id=$product['brand'];
    $sql ="SELECT brand FROM brand WHERE id = '$brand_id'";
    $brand_query = $db->query($sql);
    $brand = mysqli_fetch_assoc($brand_query);
    $sizestring = $product['sizes'];
    $exploden = explode(',' ,  $sizestring);
    // foreach ($exploden as $explodstring) {
    //   $explod = explode(':' , $explodstring);
    //   // echo "<pre>";
    //   // print_r($explod);
    //   // echo "</pre>";
    //   echo 
    //   echo "<br>";
    //   echo 
    //   echo "<br>";
    // }
 


// $id  = $_POST['id'];
// $id  = (int)$id;
// var_dump($_POST['id']);

// $sql ="SELECT * FROM products WHERE id = '$id'";
// $result = $db->query($sql);
// $product = mysqli_fetch_assoc($result);






?>

<?php ob_start(); ?>

  <!-- Modal -->
  <div class="modal fade" id="sizesModel" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container-fluid">          
        <?php for ($i=0; $i <12 ; $i++):?>
          <div class="col-md-4 form-group">
            <label for="size<?=$i; ?>">Sizes*:</label>
            <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?= ((!empty($sArray[$i-1])?$sArray[$i-1]:'')) ?>" class="form-control">
          </div>
          <div class="col-md-2 form-group">
            <label for="qty<?=$i; ?>">Quanitiy*:</label>
            <input type="number" name="qty<?=$i; ?>" id="qty<?=$i;?>" value="<?= ((!empty($qArray[$i-1])?$qArray[$i-1]:'')) ?>" class="form-control" min=0>
          </div>
        <?php endfor; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModel').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php echo ob_get_clean(); ?>
