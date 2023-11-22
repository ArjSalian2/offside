<?php

    $db_name = "mysql:host=localhost;dbname=sports_ecommerce_database";
    $db_user = "root";
    $db_password = "";

     $connect = new PDO($db_name,$db_user, $db_password);

     if ($connect) {
        echo "connected";
     }

     function unique_id(){
      $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $charLength = strlen($chars);
      $randomString = '';

      for ($i=0; $i<20; $i++){
         $randomString .= $chars[mt_rand(0, $charLength - 1)];
      }
      return $randomString;
     }

?>