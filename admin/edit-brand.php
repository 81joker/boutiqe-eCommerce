<?php
    session_start();
    require_once ("../core/init.php");
    require_once ("includes/head.php");
    require_once ("includes/navbar.php") ;
    require_once ("includes/headfull.php");
// echo $file = __DIR__.'/includes/model.php';

$sql    = "SELECT * FROM brand  where id = ";
$brands = $db->query($sql);


 


?>

<h2 class="text-center">Edit-Brand</h2>

<div class="container">
<form>
  <div class="form-group">
    <label for="brand">Brand address</label>
    <?php while ($brand= mysqli_fetch_assoc($brands)):?>

    <input type="text" class="form-control form-control-lg" name="brand" id="brand" aria-describedby="brand" value="<?=$brand['brand']?>">
    <?php endwhile; ?>

  </div>
 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>


</div>

<!--Start Details  Modal-->
<?php include ("includes/model.php");?>

<!-- Footer -->
<?php require_once("includes/footer.php");   ?>

