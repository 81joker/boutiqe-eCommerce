<?php
session_start();
ob_start();

 require_once ("../core/init.php");
 require_once ("includes/head.php");
 require_once ("includes/herlFull.php");



    if((isset($email))?sanitize($email) :'' );
    $email = trim($_POST['email']);
    if((isset($password))?sanitize($password):'' );
    $password = trim($_POST['password']);
    // echo $hash = password_hash($password, PASSWORD_DEFAULT);exit;
    $hashPass =  '$2y$10$7kIABb6rhiTMO2/Ceq47gu/hJUP13T3aXVEqEfXx8XdBBiyhQlz1K';
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
        <h2 class="text-center">Login</h2>
        <hr>
        <?php 
        if ($_POST) {
            if (empty($_POST['email']) || empty($_POST['password'])   ) {
                $errors[]  ='You muss provide Email and Password';
            }
            if (!filter_var($email , FILTER_VALIDATE_EMAIL)) {
                $errors[]  ='You muss Email input';

            }
            $query = $db->query("SELECT * FROM users WHERE email = '$email' ");
            $user = mysqli_fetch_assoc($query);
            $userCount = mysqli_num_rows($query);
            if ($userCount < 1) {
            $errors[]  ='Thats email exists is not our database';
            }
            
            if (strlen($password) < 4) {
                $errors[]  ='You muss provide Password mohr 4 ';
            }
        


        
        
        if (!password_verify($password , $user['password'])) {
            $errors[]  ='Thes Password dose not mush our records Plase try again';

         }
        // if (password_verify($password, $user['password'])) {
        //     echo 'Password is valid!';
        //     } else {
        //         echo 'Invalid password.';
        //     }


        if (!empty($errors)) {
            echo error_display($errors);
        } else {
            //Log user in page
           $userlog = $user['id'];
           
           login($userlog);
        }
    }
    ?>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email" value="<?=$email;  ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" value="<?=$password;  ?>">
        </div>
        <div class="form-group">
            <input type="submit" value="Login" class="btn btn-info" style="padding:10px 30px;border-radius:10px ">
        </div>
        </form>
        <p  class="text-right"><a href="/~nehadalaa/php-eCommerce/index.php">Visit Site</a></p>
    </div>



<?php 
 include("includes/footer.php");
 ob_end_flush();

?>