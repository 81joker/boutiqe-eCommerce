<?php 
    session_start();
    $db = mysqli_connect('127.0.0.1' , 'root' , '12345678' , 'php-eCommerce');

    if (mysqli_connect_errno()) {
        echo 'Database connection failed withe follwing errors: ' . mysqli_connect_error();
        die();
    }
    $prentID =(int)$_POST['prentID'];
    $childQuery = $db->query("SELECT * FROM categories WHERE parent = '$prentID'");
   $selectd = $_POST['selected'];
    
    
    ob_start()
    ?>
    <option value=""></option>
    <?php  while($child_selected= mysqli_fetch_assoc($childQuery)):  ?>
    <option value="<?=$child_selected['id'];?>"    <?=(($selectd == $child_selected['id'])?' selected':'')?>  ><?=$child_selected['category'];?></option>
    <?php endwhile;  ?>
    <?= ob_get_clean();  ?>
