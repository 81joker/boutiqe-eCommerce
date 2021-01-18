<?php
session_start();
ob_start();

require_once ("includes/head.php");
require_once ("includes/navbar.php") ;
require_once ("../core/init.php");
require_once ("includes/herlFull.php");
if (!is_logged_in ()) {login_error_redirect();}
if (!has_permission('admin')) {
    permission_error_redirect('index.php');
}

$name = ((isset($_POST['name']))?sanitize(trim($_POST['name'])):'');
$email = ((isset($_POST['email']))?sanitize(trim($_POST['email'])):'');
$password = ((isset($_POST['password']))?sanitize(trim($_POST['password'])):'');
$confirm = ((isset($_POST['confirm']))?sanitize(trim($_POST['confirm'])):'');
$permissions = ((isset($_POST['permissions']))?sanitize(trim($_POST['permissions'])):'');

if (isset($_POST)) {
    $errors = array();
        $emailQuery = $db->query("SELECT * FROM users WHERE email = '$email' ");
        $emailCount = mysqli_fetch_row($emailQuery);
        if ($emailCount != 0) {
            $errors[] = "Thats email already in our database";
        }


  $requerd = array('name' , 'email' , 'password' , 'confirm' , 'permissions');
  foreach( $requerd as $requer) {
       if (empty($_POST[$requer])) {
         $errors[] = "You mus all the fieled ";
         break;
       }
  }
        if (strlen($password) < 4) {
            $errors[] = "Your mus password be al leasst 4 charackter";

        }
        if ($password != $confirm) {
            $errors[] = "Your password not match";
        }
        if (!filter_var($email ,FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'You must enter vaild your email';
        }
  if (!empty($errors)) {
      echo "<div class='container'>";
         echo error_display($errors);
      echo "</div>";
   }else {
    //save in the database
       $hashPassword = password_hash($password ,PASSWORD_DEFAULT);
       $add_user =$db->query("INSERT INTO users (`full_name`, `email`, `password`, `permissions`) VALUES ('$name' , '$email' , '$hashPassword', '$permissions')");

       $_SESSION['sucess_falsh'] = "User has ben added";
       header('Location: users.php') ;
   }
}
?>
   <div class="container">
       
    <h2 class="text-center">Add A New User</h2>
    <form action="#" method="POST">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" name="name" id="name" class="form-control" placeholder="" value="<?=((isset($name))?$name: '')?>">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="text" name="email" id="email" class="form-control" placeholder="" value="<?=((isset($email))?$email: '')?>">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" class="form-control" placeholder="" value="<?=((isset($password))?$password: '')?>">
    </div> <div class="form-group">
      <label for="confirm">Confirm Password</label>
      <input type="password" name="confirm" id="confirm" class="form-control" placeholder="" value="<?=((isset($confirm))?$confirm: '')?>">
    </div> 
    <div class="form-group">
      <label for="permisseion">Permission: </label>
      <select name="permissions" id="permission"  class="form-control">
          <option value="" <?= (($permissions == '')?' selected="selected"':'');?>></option>
          <option value="editor" <?= (($permissions == "editor")?' selected="selected"':'');?> >  Editor </option>
          <option value="admin,editor" <?= (($permissions == "admin,editor")?' selected="selected"':'');?> > Admin </option>
          
      </select>
    </div>
    <div class="from-group">
        <input type="submit" class="btn btn-success" value="Send">
        <a class="btn btn-default"  href="users.php" >Cancel</a>

    </div>


    </form>   
</div>

<!-- Footer -->
<?php 
       
        ob_end_flush();
?>