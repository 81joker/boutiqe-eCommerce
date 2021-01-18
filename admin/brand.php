<?php
  session_start();
  ob_start();
  require_once ("../core/init.php");
  require_once ("includes/head.php");
  require_once ("includes/navbar.php");

  require_once ("includes/herlFull.php");
  if (!is_logged_in ()) {login_error_redirect();}


  //require_once ("add.php");
  $sql    = "SELECT * FROM brand ";
  $brands = $db->query($sql);

  //Edit vrand Code 

  if (isset($_GET['edit'])&& !empty($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $sql = "SELECT * FROM  brand WHERE id = ('$edit_id')";
    $edit = $db->query($sql);
    $brand_edit = mysqli_fetch_assoc($edit);
echo $brand_edit['brand'];


    // header('Location: brand.php');

  }

  //Delete brand Code 
  if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_id = (int)$_GET['delete'];
    $delete_id = sanitize($delete_id);
    $sql = "DELETE FROM brand WHERE id = ('$delete_id')";
    $db->query($sql);
    // echo  "<p> Deleted your brand</p>";
    header('Location: brand.php');
  }



// Add brand Code
if (isset($_POST['submit'])) {
  
  $errors = [];
  $brand =trim($_POST['brand']);
  $brand = sanitize($brand);

  // check if brand blank
  if ($_POST['brand'] == '') {
    $errors[] = "You must enter your a brand!";
  }
  $sql    = "SELECT * FROM brand WHERE brand =('$brand')  ";
  if(isset($_GET['edit'])){
    $sql = "SELECT * FROM brand WHERE brand ='$brand' AND id !='$edit_id'";	
  }

  $result = $db->query($sql);
  $count = mysqli_num_rows($result);
  if ($count > 0) {
    $errors[] = "The brand already exists.Please Chose another brand name!";
  }
$msg = '';
// display errors
if (!empty($errors)) {
    echo  error_display($errors);
} else {
  
  $sql = "INSERT INTO brand(brand)VALUES ('$brand')";

  if (isset($_GET['edit'])) {
 
  
     $sql = "UPDATE brand SET brand = ('$brand') WHERE id = ('$edit_id')";
     
  }
 
    $stmt = $db->query($sql);
    $msg = "Erflogreich brand gratuliere";
    header('Location: brand.php');
 }
}
?>

  <h2 class="text-center">Brand</h2>
  <hr>
  <!-- Class Error -->
  <div class="container">

</div>
<!-- Brand form Edit -->
<div class="text-center">
  <form action="brand.php<?= ((isset($_GET['edit']))? '?edit='.$_GET['edit'] : '')  ?>" class="form-inline" method="POST">
    <div class="form-group">
      <label for="brand"><?= ((isset($_GET['edit']))? 'Edit' : 'Add')  ?> Brand</label>
      <?php 
       if (isset($_GET['edit'])) {
        $brand_value = $brand_edit['brand'];
       } else {
         if (isset($_POST['brand'])) {
           $brand_value=  $_POST['brand'];
         }
       } 
      
      ?>
      <input type="text" class="form-control" name="brand" id="brand" value="<?= $brand_value;?>">
       <?php if ($_GET['edit']): ?>
        <a href="brand.php"  class="btn btn-default">Cencel</a>
      <?php  endif; ?>
      <input type="submit" class="btn btn-success" name="submit"  value="<?= ((isset($_GET['edit'])?'Edit': 'Add')) ?>Brand">

      
    </div>
  </form>
</div>
<hr>
<div class="container">
    
<table class="table table-bordered table-striped table-auto" >
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Brand</th>
      <th scope="col"></th>
    
    </tr>
  </thead>

  <tbody>
  <?php while ($brand= mysqli_fetch_assoc($brands)):?>

    <tr>
      <td><a href="?edit=<?=$brand['id'] ?>" class="btn btn.xs btn-default"><span class="glyphicon glyphicon-pencil"></span>Edit</a></td>

      <td><?=$brand['brand']?></td>

      <td><a href="?delete=<?=$brand['id'] ?>" class="btn btn.xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span>Delete</a></td>
    </tr>
    <?php endwhile; ?>


  </tbody>

</table>


</div>

<!--Start Details  Modal-->
<?php include ("includes/model.php");?>

<!-- Footer -->
<?php require_once("includes/footer.php");   
      ob_end_flush();?>

