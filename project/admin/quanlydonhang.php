<?php
include("../config/configDB.php");


$whereArr = []; // Mảng chứa điều kiện WHERE
$params = [];   // Mảng chứa giá trị tham số

$sqlWhere = "WHERE 1=1";

// Tìm kiếm
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
if ($keyword != '') {
    $sqlWhere .= " AND (dh.madonhang LIKE ? OR u.hoten LIKE ? OR u.sdt LIKE ?)";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
}

// Lọc trạng thái
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 0;
if ($statusFilter > 0) {
    $sqlWhere .= " AND dh.trangthai = ?";
    $params[] = $statusFilter;
}

// 1.2 Truy vấn danh sách đơn hàng
$sqlList = "SELECT dh.*, u.hoten, u.sdt 
            FROM don_hang dh 
            JOIN user u ON dh.userid = u.userid 
            $sqlWhere 
            ORDER BY dh.ngaydathang DESC";

$stmtList = $pdo->prepare($sqlList);
$stmtList->execute($params);
$listOrders = $stmtList->fetchAll(PDO::FETCH_ASSOC);

$orderDetail = null;
$orderItems = [];

if (isset($_GET['view_id'])) {
    $viewId = $_GET['view_id'];

    $sqlInfo = "SELECT dh.*, u.hoten, u.sdt, 
                (SELECT CONCAT(tenduong, ', ', phuong, ', ', tinh) FROM dia_chi dc WHERE dc.userid = u.userid LIMIT 1) as diachi
                FROM don_hang dh 
                JOIN user u ON dh.userid = u.userid 
                WHERE dh.madonhang = ?";
    $stmtInfo = $pdo->prepare($sqlInfo);
    $stmtInfo->execute([$viewId]);
    $orderDetail = $stmtInfo->fetch(PDO::FETCH_ASSOC);

    // Lấy danh sách sản phẩm
    if ($orderDetail) {
        $sqlItems = "SELECT ct.*, sp.tensanpham, ch.ram, ch.ocung, h.urlhinh
                     FROM chi_tiet_don_hang ct
                     JOIN cau_hinh ch ON ct.macauhinh = ch.macauhinh
                     JOIN san_pham sp ON ch.masanpham = sp.masanpham
                     LEFT JOIN hinh h ON sp.masanpham = h.masanpham
                     WHERE ct.madonhang = ?
                     GROUP BY ct.machitietdonhang"; // Group để lấy 1 ảnh
        $stmtItems = $pdo->prepare($sqlItems);
        $stmtItems->execute([$viewId]);
        $orderItems = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<div class="main-title">
    <h2>Quản lý đơn hàng</h2>
</div>

<div class="toolbar">
    <form action="" method="GET" class="search-box">
        <input type="hidden" name="page" value="quanlydonhang">
        
        <input type="text" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Mã đơn, Tên KH, SĐT...">
        <button class="btn-search">Tìm</button>
    </form>

    <form action="" method="GET">
        <input type="hidden" name="page" value="quanlydonhang">
        <input type="hidden" name="keyword" value="<?php echo htmlspecialchars($keyword); ?>">
        
        <select class="form-select" name="status" onchange="this.form.submit()">
            <option value="0" <?php echo $statusFilter==0?'selected':''; ?>>Tất cả trạng thái</option>
            <option value="1" <?php echo $statusFilter==1?'selected':''; ?>>Chờ xử lý</option>
            <option value="2" <?php echo $statusFilter==2?'selected':''; ?>>Đang giao</option>
            <option value="3" <?php echo $statusFilter==3?'selected':''; ?>>Hoàn thành</option>
            <option value="4" <?php echo $statusFilter==4?'selected':''; ?>>Đã hủy</option>
        </select>
    </form>
</div>

<div class="table-container">
    <table class="table-admin">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listOrders as $row): ?>
            <tr>
                <td>#<?php echo $row['madonhang']; ?></td>
                <td>
                    <b><?php echo $row['hoten']; ?></b><br>
                    <small><?php echo $row['sdt']; ?></small>
                </td>
                <td><?php echo date('d/m/Y', strtotime($row['ngaydathang'])); ?></td>
                <td style="color:red; font-weight:bold">
                    <?php echo number_format($row['tongtien'], 0, ',', '.'); ?>đ
                </td>
                <td>
                    <?php 
                        if($row['trangthai']==1) echo '<span style="color:blue; font-weight:bold">Chờ xử lý</span>';
                        elseif($row['trangthai']==2) echo '<span style="color:orange; font-weight:bold">Đang giao</span>';
                        elseif($row['trangthai']==3) echo '<span style="color:green; font-weight:bold">Hoàn thành</span>';
                        else echo '<span style="color:red; font-weight:bold">Đã hủy</span>';
                    ?>
                </td>
                <td>
                    <div style="display:flex; gap: 5px; align-items:center;">
                        <a href="?page=quanlydonhang&view_id=<?php echo $row['madonhang']; ?>&keyword=<?php echo $keyword; ?>&status=<?php echo $statusFilter; ?>" 
                           class="btn btn-primary btn-sm">Xem</a>

                        <?php if($row['trangthai'] == 1 || $row['trangthai'] == 2): ?>
                            <form action="controller/orderController.php" method="POST" style="display:flex;">
                                <input type="hidden" name="madonhang" value="<?php echo $row['madonhang']; ?>">
                                
                                <input type="hidden" name="btnCapNhatTrangThai" value="1"> 

                                <select name="trangthai" class="form-select" style="padding:5px; width:110px;"
                                        onchange="if(confirm('Bạn có chắc muốn đổi trạng thái không?')) { this.form.submit(); } else { location.reload(); }">
                                    
                                    <option value="1" <?php echo $row['trangthai']==1?'selected':''; ?>>Chờ xử lý</option>
                                    <option value="2" <?php echo $row['trangthai']==2?'selected':''; ?>>Đang giao</option>
                                    <option value="3">Hoàn thành</option>
                                    <option value="4">Hủy đơn</option>
                                </select>
                            </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if ($orderDetail): ?>
<div class="modal" style="display: block;">
    <div class="modal-content modal-lg">
        <a href="?page=quanlydonhang&keyword=<?php echo $keyword; ?>&status=<?php echo $statusFilter; ?>" class="close">&times;</a>
        
        <div class="main-title" style="border:none; margin-bottom:10px;">
            <h2>Chi tiết đơn hàng #<?php echo $orderDetail['madonhang']; ?></h2>
        </div>

        <div style="background:#f8f9fa; padding:15px; border-radius:5px; margin-bottom:20px; display:flex; justify-content:space-between;">
            <div>
                <p><strong>Khách hàng:</strong> <?php echo $orderDetail['hoten']; ?></p>
                <p><strong>SĐT:</strong> <?php echo $orderDetail['sdt']; ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo $orderDetail['diachi']; ?></p>
            </div>
            <div style="text-align:right;">
                <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y', strtotime($orderDetail['ngaydathang'])); ?></p>
                <p><strong>Trạng thái:</strong> 
                    <?php 
                        $tt = $orderDetail['trangthai'];
                        if($tt==1) echo 'Chờ xử lý';
                        elseif($tt==2) echo 'Đang giao';
                        elseif($tt==3) echo 'Hoàn thành';
                        else echo 'Đã hủy';
                    ?>
                </p>
                <p><strong>Tổng tiền:</strong> <span style="color:red; font-size:18px; font-weight:bold"><?php echo number_format($orderDetail['tongtien'], 0, ',', '.'); ?>đ</span></p>
            </div>
        </div>

        <table class="table-admin">
            <thead>
                <tr>
                    <th>Hình</th>
                    <th>Sản phẩm</th>
                    <th>Cấu hình</th>
                    <th>SL</th>
                    <th>Giá mua</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderItems as $item): 
                    $imgUrl = !empty($item['urlhinh']) ? '../uploads/' . $item['urlhinh'] : 'https://via.placeholder.com/50';
                ?>
                <tr>
                    <td><img src="<?php echo $imgUrl; ?>" width="50" style="object-fit:cover; border-radius:4px;"></td>
                    <td><?php echo $item['tensanpham']; ?></td>
                    <td><?php echo $item['ram'] . " / " . $item['ocung']; ?></td>
                    <td><?php echo $item['soluongsanpham']; ?></td>
                    <td><?php echo number_format($item['gialucmua'], 0, ',', '.'); ?>đ</td>
                    <td><?php echo number_format($item['soluongsanpham'] * $item['gialucmua'], 0, ',', '.'); ?>đ</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="form-actions">
            <a href="?page=quanlydonhang&keyword=<?php echo $keyword; ?>&status=<?php echo $statusFilter; ?>" class="btn btn-delete">Đóng</a>
        </div>
    </div>
</div>
<?php endif; ?>