<?php

try{
    // Tạo kết nối
    $pdo=new PDO("mysql:localhost=localhost;
                       dbname=banlaptop;
                       port=3307",
                       "root",
                       "");
    echo "Kết nối thành công";
    // kt lỗi
}catch(PDOException $ex){
    echo $ex->getMessage();
    die("Kết nối thất bại");
}
?>