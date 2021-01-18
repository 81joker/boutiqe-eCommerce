<?php
session_start();
$db = mysqli_connect('127.0.0.1', 'root', '12345678', 'php-eCommerce');

if (mysqli_connect_errno()) {
  echo 'Database connection failed withe follwing errors: ' . mysqli_connect_error();
  die();
}

$id = $_POST['id'];
$id = (int) $id;
$sql = "SELECT * FROM products WHERE id = '$id'";

$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);

$brand_id = $product['brand'];
$sql = "SELECT brand FROM brand WHERE id = '$brand_id'";
$brand_query = $db->query($sql);
$brand = mysqli_fetch_assoc($brand_query);
$sizestring = $product['sizes'];
$exploden = explode(',', $sizestring);
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

<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">

  <!-- <div class="modal fade" id="details-model" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true" > -->

  <!-- <div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true"> -->
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <button class="close" type="button" onclick="closeModal()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center"><?php echo $product['title']; ?></h4>

      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <span id="modal_errors" class="bg-danger"></span>

          <div class="row">
            <div class="col-sm-6">
              <div class="center-block">
                <img src="images/products/<?= $product['image'] ?>" alt="Levis Jeans" class="details img-responsive" />
              </div>
            </div>
            <div class="col-sm-6">

              <h4>Details</h4>
              description
              <p><?= $product['description']; ?></p>
              <hr>
              <p>Price: <?= $product['price']; ?></p>
              <p>Brand: <?= $brand['brand']; ?></p>
              <form action="add_cart.php" method="POST" id="add_product_form">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <input type="hidden" name="available" id="available" value="">
                <div class="form-group">
                  <div class="col-xs-3">
                    <label for="quantity">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="0">
                  </div>
                  <div class="col-xs-9"></div>
                </div>

                <div class="form-group">
                  <label for="size">Size: </label>
                  <select class="form-control" id="size" name="size">
                    <option value=""></option>
                    <?php foreach ($exploden as $explodstring) {
                      $explod = explode(':', $explodstring);
                      $size = $explod[0];
                      $available = $explod[1];
                      echo "<option value='$size'  data-available='$available'>$size ($available Avaliable)</option>";
                    } ?>
                  </select>

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" onclick="closeModal()">Close</button>
        <button class="btn btn-danger" onclick="add_to_cart()"><span class="glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
      </div>
    </div>
  </div>
</div>
<script>
  // for value in input hidden available
  jQuery('#size').change(function() {
    var available = jQuery('#size option:selected').data('available');
    jQuery('#available').val(available);

  })


  function closeModal() {
    jQuery('#details-modal').modal('hide');
    setTimeout(function() {
      jQuery('#details-modal').remove();
      jQuery('.modal-backdrop').remove();
    }, 500);
  }
</script>
<?php echo ob_get_clean(); ?>