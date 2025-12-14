<?php
// Lấy đường dẫn thư mục của file đang chạy hiện tại
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);

// Kiểm tra: Nếu đang chạy trong thư mục 'pages' (ví dụ: /duan/pages)
if (substr($scriptPath, -6) === '/pages') {
    // Lùi lại 1 cấp để về thư mục gốc
    $scriptPath = dirname($scriptPath);
} 
// Kiểm tra: Nếu đang chạy trong thư mục 'admin' (nếu sau này bạn làm admin)
elseif (substr($scriptPath, -6) === '/admin') {
    $scriptPath = dirname($scriptPath);
}

// Xử lý dấu gạch chéo để tạo URL chuẩn
$basePath = rtrim($scriptPath, '/\\');

// Định nghĩa hằng số BASE_URL
define('BASE_URL', $basePath === '' ? '/' : $basePath . '/');
?>