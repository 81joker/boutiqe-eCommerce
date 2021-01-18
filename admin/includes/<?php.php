<?php 
 ob_start(); 
 session_start();

 function error_display($errors){
    $display =  "<div class='error'>";
     $display .= '<ul class="bg-danger">';
        foreach ($errors as $error) {
            $display .= "<li class='text-danger'>$error</li>";
        }
        $display .= "</ul>";
        $display .= "</div>";

        return $display;
 }


 function sanitize($dirty){
     return htmlentities($dirty ,  ENT_QUOTES, "UTF-8");
 }

 function money($number){
     return  "$".number_format($number, 2);

 }


 function login($userlog){
    $_SESSION['SBUser'] = $userlog;
    global $db;
    $date = date('Y-m-d H:i:s');
    $db->query("UPDATE users SET last_login	='$date' WHERE id = '$userlog'");
    $_SESSION['sucess_falsh'] = 'You are now logged in!';
    header('Location: index.php');

    }
 
 function is_logged_in (){
    if (isset($_SESSION['SBUser']) && $_SESSION['SBUser'] > 0) {
        return true;
    }
    return false;
 }

 function login_error_redirect(){
    $_SESSION['error_falsh']  = 'You must be logged in to sucess that page';
    header('Location: login.php');

 }

 echo ob_get_clean();

 