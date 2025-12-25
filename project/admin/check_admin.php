<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['current_user'])) {
    header("Location: ../pages/dangnhap.php");
    exit();
}

if ($_SESSION['current_user']['role'] != 1) {
    echo "  <script>
                alert('Bạn không có quyền truy cập!'); 
                window.location.href='../index.php';
            </script>";
    exit();
}