<?php
// File này chứa các hàm lấy dữ liệu từ Database

// 1. Hàm định dạng tiền tệ
function formatCurrency($n) {
    return number_format($n, 0, ',', '.') . '₫';
}

// 2. Hàm lấy Sản phẩm nổi bật (Random)
// Lấy sp có giá thấp nhất cùng masp trong bảng cấu hình
// left join để khi ko có hình thì sp vẫn còn
// group by để 1 masp chỉ lấy ra 1 sp duy nhất
function getSanphamNoiBat($pdo) {
    $sql = "SELECT sp.*, h.urlhinh, MIN(ch.giatien) as gia_thap_nhat 
            FROM san_pham sp 
            LEFT JOIN hinh h ON sp.masanpham = h.masanpham 
            JOIN cau_hinh ch ON sp.masanpham = ch.masanpham 
            GROUP BY sp.masanpham 
            ORDER BY RAND() 
            LIMIT 5";
    // cb câu truy vấn chưa thực thi ngay tranh SQL Injection
    $stmt = $pdo->prepare($sql);
    // thực thi câu truy vấn
    $stmt->execute();
    // trả về mảng kết quả
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 3. Hàm lấy Sản phẩm Mới (Theo ID giảm dần)
function getSanphamMoi($pdo) {
    $sql = "SELECT sp.*, h.urlhinh, Min(ch.giatien) as gia_thap_nhat 
		FROM san_pham sp 
        JOIN cau_hinh ch on sp.masanpham=ch.masanpham
        LEFT JOIN hinh h on h.masanpham=sp.masanpham
        GROUP BY sp.masanpham
        ORDER BY sp.masanpham DESC 
        LIMIT 5";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 4. Hàm lấy Sản phẩm Gaming
function getSanphamGaming($pdo) {
    $sql = "SELECT sp.*, h.urlhinh, MIN(ch.giatien) as gia_thap_nhat   
            FROM san_pham sp 
            LEFT JOIN hinh h ON sp.masanpham = h.masanpham 
            JOIN cau_hinh ch ON sp.masanpham = ch.masanpham 
            WHERE sp.tensanpham LIKE '%Gaming%' OR sp.vga LIKE '%RTX%'
            GROUP BY sp.masanpham 
            LIMIT 5";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Hàm lấy thông tin sản phẩm theo mã
function getChiTietSanPham($pdo, $id){
    $sql= "SELECT * FROM san_pham
            JOIN thuong_hieu on thuong_hieu.mathuonghieu=san_pham.mathuonghieu
            where masanpham= :id";

    $stmt = $pdo->prepare($sql);
    //lấy giá trị $id truyền vào :id
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getHinhAnhSanPham($pdo, $id){
    $sql= "SELECT * FROM hinh where masanpham= :id";

    $stmt = $pdo->prepare($sql);
    //lấy giá trị $id truyền vào :id
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getCauHinhtSanPham($pdo, $id){
    $sql= "SELECT * FROM cau_hinh where masanpham= :id";

    $stmt = $pdo->prepare($sql);
    //lấy giá trị $id truyền vào :id
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>