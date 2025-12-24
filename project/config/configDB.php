<?php

try{
    $pdo = new PDO("mysql:hoost=localhost; dbname=banlaptop", "root", ""); 
}
catch (PDOException $ex){
    echo "<script>
            console.error('". $ex->getMessage() ."');
        </script>";
    die ("Kết nối DB không thành công");
}