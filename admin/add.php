<?php


    $brand = trim($_POST['brand']);
    $brand = filter_var($brand , FILTER_SANITIZE_STRING);
    $error = [];
    if ($_SERVER['REQUEST_METHOD']=='POST' )
    {
    if (array_key_exists('brand' , $_POST)) {
        if ($brand === '') {
            false;
            $error[] = "<p > Sie museen keine empty inout lassen ";
        }

        $brandLang = strlen($brand);
        if ($brandLang < 3) {
            $error []= "<p > Sie museen mehr als 3 chrakter schreiben bitte  ";

        }
        if ($brandLang > 30) {
            $error []= "<p > Sie museen nich mehr als 30 charakter ";
        }
        if (filter_var($brand, FILTER_VALIDATE_INT)) {
            $error []= "<p > Input sollen nur String ";

        }
            $sql = "SELECT * FROM brand WHERE brand =  ('$brand')";
            $result = $db->query($sql);

            $count = mysqli_num_rows($result);
            if ($count > 0) {
             $error []= "<p > This is name $brand Existert ";
            }

       

    

       
    } else {
        echo "sie haban keine POST";
    }
 }


var_dump($brand);

 if (empty($error)) {
  $sqli = "INSERT INTO brand(brand)VALUES ('$brand')";
 $stmt = $db->query($sqli);

}