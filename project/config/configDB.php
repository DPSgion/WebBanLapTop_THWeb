<?php

try{
    $pdo = new PDO("mysql:hoost=localhost; dbname=banlaptop", "root", ""); 
}
catch (PDOException $ex){
    echo $ex->getMessage();
    die ("Kết nối DB không thành công");
}