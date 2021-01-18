<?php
//session_start();

function error_display($errors)
{
    $display =  "<div class='error'>";
    $display .= '<ul class="bg-danger">';
    foreach ($errors as $error) {
        $display .= "<li class='text-danger'>$error</li>";
    }
    $display .= "</ul>";
    $display .= "</div>";

    return $display;
}


function sanitize($dirty)
{
    return htmlentities($dirty,  ENT_QUOTES, "UTF-8");
}

function money($number)
{
    return  "$" . number_format($number, 2);
}

?>


<div id="headrWrapper">

    <div id="back-flower"></div>
    <div id="logotext"></div>
    <div id="for-flower"></div>

</div>