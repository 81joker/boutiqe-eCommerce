<?php
    session_start();
    ob_start();
    
    require_once ("../core/init.php");
    require_once ("includes/head.php");
    require_once ("includes/herlFull.php");
    if (!is_logged_in ()) {login_error_redirect();}

    $hashed = $userdata['password'];
    $id = $userdata['id'];
    
    $old_password = ((isset($old_password))?sanitize($old_password):'' );
    $old_password = trim($_POST['old_password']);
   

    $password = ((isset($password))?sanitize($password):'' );
    $password = trim($_POST['password']);

    $confirm = ((isset($confirm))?sanitize($confirm):'' );
    $confirm = trim($_POST['confirm']);
      
  
    // echo $hash = password_hash($password, PASSWORD_DEFAULT);exit;
    $errors = array();
    ?>
    <style>
    body{
        background-image: url('/~nehadalaa/php-eCommerce/images/headerlogo/background.png');
        background-size: 100vw 100vh ;
        background-attachment: fixed;
    }

    </style>

    <div id="login-form">
        <h2 class="text-center">Change Password</h2>
        <hr>
        <?php 
        if ($_POST) {
            if (empty($_POST['old_password']) || empty($_POST['password']) ||  empty($_POST['confirm']) ) {
                $errors[]  ='You muss enter field Password';
            }

        
        if (strlen($password) < 4) {
            $errors[]  ='You muss provide Password mohr 4 ';
        }
    
        if ($password != $confirm) {
            $errors[] = 'The Password dose not match our recorde .Place try again , ';
        }


        
        
        if (!password_verify($old_password , $hashed)) {
            $errors[]  ='Thes Old Password dose not mutched';

         }

        $new_hashed = password_hash($password, PASSWORD_DEFAULT);

        if (!empty($errors)) {
            echo error_display($errors);
        } else {
        // change password
        $db->query(("UPDATE users SET password = '$new_hashed'  WHERE id = '$id' "));
        $_SESSION['sucess_falsh']  ='You passsword has ben updated';
        header('Location: index.php');
        }
    }
    ?>
    <form action="chang_password.php" method="POST">
        <div class="form-group">
            <label for="old_password">Old_Password</label>
            <input type="password" class="form-control" name="old_password" id="old_password" value="<?=$old_password;  ?>">
        </div>
        <div class="form-group">
            <label for="password">New_Password</label>
            <input type="password" class="form-control" name="password" id="password" value="<?=$password;  ?>">
        </div>
        <div class="form-group">
            <label for="confirm">Confirm New Password</label>
            <input type="password" class="form-control" name="confirm" id="confirm" value="<?=$confirm;  ?>">
        </div>
        <div class="form-group">
            <a href="index.php" class="btn btn-default" style="padding:10px 30px;border-radius:10px ">Cancel</a>
            <input type="submit" value="Login" class="btn btn-info" style="padding:10px 30px;border-radius:10px ">
        </div>
        </form>
        <p  class="text-right"><a href="/~nehadalaa/php-eCommerce/index.php">Visit Site</a></p>
    </div>



<?php 
 include("includes/footer.php");
 ob_end_flush();

?>