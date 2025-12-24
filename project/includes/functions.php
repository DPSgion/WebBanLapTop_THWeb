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
    $sql = "SELECT sp.*, h.urlhinh, MIN(lc.giatien) as gia_thap_nhat 
            FROM san_pham sp 
            LEFT JOIN hinh h ON sp.masanpham = h.masanpham 
            JOIN cau_hinh lc ON sp.masanpham = lc.masanpham 
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
    $sql = "SELECT sp.*, h.urlhinh, Min(lc.giatien) as gia_thap_nhat 
		FROM san_pham sp 
        JOIN cau_hinh lc on sp.masanpham=lc.masanpham
        LEFT JOIN hinh h on h.masanpham=sp.masanpham
        GROUP BY sp.masanpham
        ORDER BY sp.masanpham DESC ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



//  Hàm tìm kiếm và lọc sản phẩm nâng cao (Đã cập nhật)
function timKiemSanPham($pdo, $tuKhoa = null, $hang = null, $mucGia = null, $ram = null, $ocung = null, $vga = null) {
    // Join bảng cau_hinh để lọc RAM, Giá, Ổ cứng
    // Join bảng hinh để lấy ảnh
    $sql = "SELECT sp.*, h.urlhinh, MIN(ch.giatien) as gia_thap_nhat 
            FROM san_pham sp 
            JOIN cau_hinh ch ON sp.masanpham = ch.masanpham 
            LEFT JOIN hinh h ON sp.masanpham = h.masanpham 
            WHERE 1=1"; 

    $params = [];

    // 1. Lọc theo Từ khóa
    if ($tuKhoa != null) {
        $sql .= " AND sp.tensanpham LIKE :tuKhoa";
        $params[':tuKhoa'] = "%$tuKhoa%";
    }

    // 2. Lọc theo Hãng
    if ($hang != null) {
        $sql .= " AND sp.tensanpham LIKE :hang";
        $params[':hang'] = "%$hang%";
    }

    // 3. Lọc theo RAM
    if ($ram != null) {
        $sql .= " AND ch.ram LIKE :ram";
        $params[':ram'] = "%$ram%";
    }

    // 4. Lọc theo Mức giá
    if ($mucGia != null) {
        if ($mucGia == 'duoi-15') {
            $sql .= " AND ch.giatien < 15000000";
        } elseif ($mucGia == '15-20') {
            $sql .= " AND ch.giatien BETWEEN 15000000 AND 20000000";
        } elseif ($mucGia == 'tren-20') {
            $sql .= " AND ch.giatien > 20000000";
        }
    }

    // 5. Lọc theo Ổ cứng (Mới)
    if ($ocung != null) {
        // Dùng LIKE để '1T' vẫn tìm ra được '1TB'
        $sql .= " AND ch.ocung LIKE :ocung";
        $params[':ocung'] = "%$ocung%";
    }

    // 6. Lọc theo Card đồ họa (Mới - Xử lý thông minh)
    if ($vga != null) {
        if ($vga == 'nvdia') {
            // Nếu khách chọn NVDIA -> Tìm các máy có RTX, GTX hoặc NVIDIA
            $sql .= " AND (sp.vga LIKE '%RTX%' OR sp.vga LIKE '%GTX%' OR sp.vga LIKE '%NVIDIA%')";
        } elseif ($vga == 'amd') {
            // Nếu khách chọn AMD -> Tìm các máy có AMD hoặc Radeon
            $sql .= " AND (sp.vga LIKE '%AMD%' OR sp.vga LIKE '%Radeon%' OR sp.vga LIKE '%RX%')";
        } else {
            // Tìm chính xác theo từ khóa khác
            $sql .= " AND sp.vga LIKE :vga";
            $params[':vga'] = "%$vga%";
        }
    }

    // Group by để không bị lặp sản phẩm
    $sql .= " GROUP BY sp.masanpham ORDER BY sp.masanpham DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>