<?php
  ob_start();
  session_start();
  require_once ("conif.php");
  //require_once ("includes/head.php");
  

  $brand_query= $db->query("SELECT * FROM brand ORDER BY brand");
  $category_query= $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");


  $title = ((isset($_POST['titile']) && $_POST['titile'] != '' )? sanitize($_POST['titile']):'');
  $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))? sanitize($_POST['brand']):'');
  $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))? sanitize($_POST['parent']):'');
  //  $child = ((isset($_POST['child']) && !empty($_POST['child']))? sanitize($_POST['child']):'');
  $price = ((isset($_POST['price']) && $_POST['price'] != '' )? sanitize($_POST['price']):'');
  $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '' )?sanitize($_POST['list_price']):'');
  $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '' )? sanitize($_POST['sizes']):'');
  $description = ((isset($_POST['description']) && $_POST['description'] != '' )? sanitize($_POST['description']):'');
  $saveImage = '';

  if(isset($_GET['edit'])) {
  $edit_id = (int)$_GET['edit'];
  $edit_resulat = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
  $product = mysqli_fetch_assoc($edit_resulat);

  if (isset($_GET['delete_image'])) {
    $oldPicture = '/Users/nehadalaa/Sites/php-eCommerce/images/products/'.$product['image'];
    if (file_exists($oldPicture)) {
      unlink($oldPicture);
      echo 'Deleted old image';
  } 
  else {
      echo 'Image file does not exist';
  }
    $db->query("UPDATE products SET `image` = '' WHERE id = '$edit_id' ");
    header('Location: products.php?edit='.$edit_id);
     ob_get_clean();


  }


  $title = ((isset($_POST['title']) && $_POST['title'] != '' )? sanitize($_POST['title']):$product['title']);
  $brand = ((isset($_POST['brand']) && $_POST['brand'] != '' )? sanitize($_POST['brand']):$product['brand']);
  $price = ((isset($_POST['price']) && $_POST['price'] != '' )? sanitize($_POST['price']):$product['price']);
  $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '' )? sanitize($_POST['list_price']):$product['list_price']);
  $description = ((isset($_POST['description']) && $_POST['description'] != '' )? sanitize($_POST['description']):$product['description']);


  $child_edit = ((isset($_POST['child']) && $_POST['child'] != '' )? sanitize($_POST['child']):$product['categoriess']);
  $child_result = $db->query("SELECT * FROM categories WHERE id = '$child_edit' ");
  $child_fetch = mysqli_fetch_assoc($child_result);
  $parent = $child_fetch['parent'];
  $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '' )? sanitize($_POST['sizes']):$product['sizes']);
  $sizes = rtrim($sizes , ',');
  $saveImage =(($product['image'] != '')? $product['image']: '');
  $dbPath = $saveImage;

 }

  if ($sizes) {
  $sizeString = sanitize($sizes);
  $sizeArray = explode(',' ,$sizeString);
  $sArray = array();
  $qArray = array();
  foreach ($sizeArray as $ss) {
    $s = explode(':' , $ss);
    $sArray[] = $s[0];
    $qArray[] = $s[1];

  }
  }else { $sizeArray=array();}

  if ($_POST) {
    $requerd = array('title' , 'brand' , 'parent' , 'price' , 'sizes');
        foreach ($requerd as $field) {
            if ($_POST[$field] == '') {
            $errors[] = "All Field withe and Anstrisk are requierd";
            break;
            }
        }
    //Start validate Photo
    if (!empty($_FILES)) {
        // echo "<pre>";
        // print_r( $_FILES);
        // echo "</pre>";
        $title = sanitize($_POST['title']);
        $brand =sanitize($_POST['brand']);
        // $parent = $_POST['parent'];
        $categories = sanitize($_POST['child']);
        $price = sanitize($_POST['price']);
        $list_price = sanitize($_POST['list_price']);
        $sizes = sanitize($_POST['sizes']);
        $description = sanitize($_POST['description']);




        $photo = $_FILES['photo'] ;
        $name = $photo['name'];
        $nameArray = explode('.' , $name);
        $fileName  = $nameArray[0];
        $fileExst  = $nameArray[1];
        $mime      = explode('/' , $photo['type']);
        $mimiType  = $mime[0];
        $mimiExst  = $mime[1];
        $tmpLoc    = $photo['tmp_name'];
        $fileSize  = $photo['size'];
        $uploadName = md5(microtime()).'.'.$fileExst;
        $uploaddir = '/Users/nehadalaa/Sites/php-eCommerce/images/products/';
        $uploadPathe = $uploaddir.$uploadName;
        $dbPath = $uploadName;
        if ($mimiType != 'image') {
        $errors[] ="This file must be an image";
        }

        $allowed = array('png' , 'jpg' , 'gif' , 'jpeg');
        if (!in_array($fileExst, $allowed)) {
        $errors[] ="This file extension  must be a png , jpg , gif ,jpeg";
        }

        if ($fileSize > 1500000) {
        $errors[] ="This file Size   must be under 15MB";
        }


        // if ($fileExst != $mimiExst && ($mimiExst == 'jpeg' && $fileExst != 'jpj')) {
        // $errors[] ="This extenstion does not match the file ";
        // }




      }

        //End validate Photo
        if (!empty($errors)) {
            echo error_display($errors);
        }else{
            //Insert the date
            // echo $dbPath;

        if (!empty($_FILES)) {
          move_uploaded_file($tmpLoc, $uploadPathe);
        }
        $insertSql = "INSERT INTO  products (`title` , `brand`,`categoriess` , `description` , `sizes` , `price` , `list_price` , `image`) VALUES ('$title' , '$brand', '$categories' , '$description' , '$sizes' , '$price' ,'$list_price' , '$dbPath')";
        if (isset($_GET['edit'])) {
          $insertSql = ("  UPDATE products SET title = '$title' , brand = '$brand' , categoriess = '$child_edit', description = '$description' , price = '$price', list_price= '$list_price ', sizes = '$sizes' , image= '$dbPath'  WHERE id = '$edit_id'  ") ;
        }
        $db->query($insertSql);

        header("Location: products.php");
        ob_get_clean();
      }
    }


 ?>
      <h3 class="text-center"><?=((isset($_GET['add']))?'Add product':'Edit Product')?></h3>
      <form action="products.php?<?= ((isset($_GET['edit']) ?  'edit='.$edit_id  : 'add=1'))?>" method="POST" enctype="multipart/form-data">
          <div class="form-group col-md-3">
              <label for="title">*Title</label>
              <input type="text" name="title" id="title" class="form-control" value="<?= $title; ?>">
          </div>
          <div class="form-group col-md-3">
              <label for="brand">Brand*:</label>
              <select name="brand" id="" class="form-control" >
                  <option value="" <?=((($brand)?'selected':'')) ?> ></option>
                  <?php while($br= mysqli_fetch_assoc($brand_query)):?>
                  <option value="<?=$br['id'];?>" <?=(($brand == $br['id'])?' selected':'')?> ><?=$br['brand']  ?></option>
                  <?php endwhile; ?>
              </select>
          </div>
          <div class="form-group col-md-3">
              <label for="parent">Prent Category*:</label>
              <select name="parent" id="parent" class="form-control" >
                   <option value="" <?=((($parent)?'selected':'')) ?> ></option>
                  <?php while($pa= mysqli_fetch_assoc($category_query)):?>
                  <option value="<?=$pa['id'];?>" <?=(($parent == $pa['id'])?' selected':'')?> ><?=$pa['category']  ?></option>
                  <?php endwhile; ?>
              </select>
          </div>
          <div class="form-group col-md-3">
              <label for="child">Cahild*:</label>
              <select name="child" id="child" class="form-control">
              </select>
          </div>
          <div class="form-group col-md-3">
              <label for="price">Price*:</label>
              <input name="price" id="price" class="form-control"  value="<?=((isset($price)?$price:''))  ?>"/>

          </div>
          <div class="form-group col-md-3">
              <label for="list_price">List Price*:</label>
              <input name="list_price" id="list_price" class="form-control"  value="<?=((isset($list_price)?$list_price:''))  ?>">
          </div>

          </div>
          <div class="form-group col-md-3">
              <label for="list_price">Quantity & Sizes *:</label>
          <!-- <a href="product/sizes.php" class="btn btn-default form-control" > Sizes</a> -->
              <button class="btn btn-default form-control"  onclick="jQuery('#sizesModel').modal('toggle');return  false">Quantity </button>
          </div>
          <div class="form-group col-md-3">
              <label for="sizes">Sizes & Qty Preview *:</label>
              <input type="text" id="sizes" class="form-control" name="sizes" value="<?= ((isset($sizes))?$sizes:''); ?>">
          </div>
          <div class="form-group col-md-6">
              <?php
              $pathes ="/~nehadalaa/php-eCommerce/images/products";
              if($saveImage != ''):?>
              <div class="save-imge" >
           <img src="<?=  $pathes.'/'.$saveImage;?>" alt="<?=$title?>"   class="img-thumbnail" width="300"/>
              </div>
           <div class="image-update">
                <a href="products.php?edit=<?=$edit_id;?>&delete_image=<?=$edit_id;?>" class="text-danger">Delete Image</a>
           </div>
            <?php else:?>
            <label for="photo">Product Photo*:</label>
              <input type="file" name="photo" id="photo" class="form-control">
              <?php endif;  ?>
          </div>
          <div class="form-group col-md-6">
              <label for="description">Product Discription*:</label>
              <textarea name="description" id="description"  class="form-control" rows="3"><?= ((isset($description)?$description:''));?></textarea>
          </div>
          <hr>
          <div class="form-group col-md-4 pull-right mt-3">
             <a href="products.php" class="form-control btn btn-default" style="margin-bottom: 5px;"> Cancle</a>
              <input type="submit" id="submit" value="<?= ((isset($_GET['add']))?'Add Product':'Edit Product') ?>" class="form-control btn btn-success">
          </div>
          <div class="clearfix"></div>
      </form>


  <!-- Start Model  -->
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
  <!-- End Model  -->

<?php  echo ob_get_clean();?>
<script>
jQuery('document').ready(function(){
    get_child_options('<?=$child_edit;?>');
})
</script>

