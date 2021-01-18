<?php 
 session_start();
 ob_start();
//  require_once $_SERVER['DOCUMENT_ROOT'].'/php-eCommerce/core/init.php';
 require_once ("../core/init.php");
 require_once ("includes/head.php");
 require_once ("includes/navbar.php");
 require_once ("includes/herlFull.php");
 if (!is_logged_in ()) {login_error_redirect();}

 $sql = "SELECT * FROM categories WHERE parent = 0";
 $result = $db->query($sql);


/**
 * Edit blank
 */
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $edit_id = sanitize($_GET['edit']);
    $sqli_edit = "SELECT * FROM  categories WHERE id = '$edit_id'";
    $result_edit = $db->query($sqli_edit);
    $category_edit = mysqli_fetch_assoc($result_edit);
    // echo  $category_edit['category'];
    // exit;

}



/**
 * Delete Category and parent
*/
if ( isset($_GET['delete'])  &&  !empty($_GET['delete']) ) {
    $delete_id = sanitize($_GET['delete']);

    $sql = "SELECT * FROM categories WHERE id = '$delete_id";
    $result_de = $db->query($sql);
    $result_delete = mysqli_fetch_assoc($result_de);

    if ($result_delete['parent'] == 0 ) {
         $sql = "DELETE From categories WHERE parent = '$delete_id'";
         $db->query($sql);
    }
    $dsql = "DELETE From categories WHERE id = '$delete_id'";
    $db->query($dsql);

    header('Location: categories.php');
}


$errors= [];
$category = '';
$post_parent ='';
if (isset($_POST) && !empty($_POST)) {
$post_parent  = sanitize($_POST['parent']);
$category = sanitize($_POST['category']);
    
$sql_form = "SELECT * FROM categories WHERE category = '$category'  AND parent = '$post_parent' ";
$result_form = $db->query($sql_form);
$count = mysqli_num_rows($result_form);
   if ($category == '') {
    $errors[] .= "The Category cannot be left blank";
   }
   if ($count > 0 ) {
    $errors[] .= $category." The Category alrady exites";
        $errors[] .= $category." The Category alrady exites";


   }

   if(!empty($errors)){ 
    $display = error_display($errors);
    

    } else {
      
    $updatesql = "INSERT INTO categories(category,parent) VALUES ('$category' , '$parent')";
    $db->query($updatesql);
    header('Location: categories.php');
    }
   
}

$cat_value = '';
$parent_value = 0;
if (isset($_GET['edit'])){
  echo $cat_value = $category_edit['category'];
  echo "<br>";
 echo  $parent_value = $category_edit['parent'];
}else {
  if (isset($_POST)) {
    echo $cat_value = $category;
    echo "<br>";

    echo $parent_value = $post_parent;
    
  }
}

?>

<h3 class="text-center">Categories</h3>
<legend><?=((isset($_GET['edit'])?'Edit' : 'Add A')) ;?> Category</legend>

<div class="container">

 <div class="row">
    <div class="col-md-6">
    <div id="errors"><?= $display ?></div>

        <form action="categories.php<?=((isset($_GET['edit'])?'?edit='.$_GET['edit'] : '')) ;?>" method="post">
            <div class="form-group">
              <label for="parent">Parent</label>
              <select name="parent" id="" class="form-control">
                  <option value="<?=(($parent_value == 0)?'selected = selected':'')  ?>">Prent</option>
                  <?php while ($parent = mysqli_fetch_assoc($result)): ?>
                    <option value="<?=$parent['id'] ?>" <?=(($parent_value == $parent['id'] )? " selected = 'selected'": "") ?> ><?=$parent['category'] ?>  </option>
                  <?php endwhile; ?>
              </select>
             
            </div>
            <div class="form-group">
              <label for="categiry"> Catiegory</label>
             
                <input type="text" name="category" id="category" class="form-control" value="<?=$cat_value;?>">

            </div>
            <input type="submit" value="<?=((isset($_GET['edit'])?'Edit Category' : 'Add Category')) ;?>" class="btn btn-success ">
        </form>
    </div>
    <!-- table-striped table-hover  -->
    <p>Categoiry Show</p>
    <div class="col-md-6">
        <table class="table table-bordered table-responsive  ">
            <thead class="thead">
                <tr class="bg-dark text-white">
                <th scope="col">Categoery</th>
                <th scope="col">Parent</th>
                <th scope="col"></th>  
                </tr>
            </thead>
            <tbody>
                <?php 
                 $sql = "SELECT * FROM categories WHERE parent = 0";
                 $result = $db->query($sql);                
                while ($parent = mysqli_fetch_assoc($result)): ?>
                <tr class="bg-danger">
                <td><?= $parent['category'] ?></td>
                <td>Parent</td>
                <td><a href="categories.php?edit=<?=$parent['id'];?>" class="btn btn-xs btn-default" ><span class="glyphicon glyphicon-pencil" ></span></a>
                <a href="categories.php?delete=<?=$parent['id']; ?>" class="btn btn-xs btn-default" onclick=" confirm_delete()"><span class="glyphicon glyphicon-remove-sign" ></span></a></td>
                </tr>



                <?php 
                $parent_id = (int)$parent['id'];
                $sql2 = "SELECT * FROM categories   WHERE parent  = '$parent_id'";
                $parent_child  = $db->query($sql2);
                while ($child = mysqli_fetch_assoc($parent_child)): ?>
                <tr class="bg-info">
                <td ><?= $child['category'] ?></td>
                <td><?= $parent['category'] ?></td>
                <td><a href="categories.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil" ></span></a>
                <a href="categories.php?delete=<?=$child['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign" onclick=" confirm_delete()"></span></a></td>
                </tr>
                <?php 
                endwhile; 
                      endwhile;?>

        
            </tbody>
        </table>
    </div>

 </div>
</div>


 <?php 
  include("includes/footer.php"); 
  
  ?>