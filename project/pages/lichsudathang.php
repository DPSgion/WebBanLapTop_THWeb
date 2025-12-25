<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 15px;
    }
</style>


<?php
include("../config/configDB.php");
include("../includes/functions.php");
$path = ".."; 
include("../includes/header.php");

if (!isset($_SESSION['current_user'])) {
    echo "  <div class='container mt-5 text-center'>
                <h3>Vui lòng <a href='dangnhap.php'>đăng nhập</a> để xem lịch sử đơn hàng.</h3>
            </div>";
    include("../includes/footer.php");
    exit();
}

$current_user = $_SESSION['current_user'];

$sql_donhang = "SELECT * FROM don_hang WHERE userid = :uid ORDER BY madonhang DESC";
$stmt = $pdo->prepare($sql_donhang);
$stmt->bindParam(':uid', $current_user['userid']);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container py-5">
    <h2 class="mb-4 text-center" style="margin-bottom: 30px">Lịch Sử Đặt Hàng</h2>

    <?php if (count($orders) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="10%">Mã đơn</th>
                        <th width="20%">Ngày đặt</th>
                        <th width="20%">Tổng tiền</th>
                        <th width="10%">Trạng thái</th>
                        <th width="40%">Chi tiết sản phẩm</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['madonhang']; ?></td>
                            
                            <td><?php echo date("d/m/Y", strtotime($order['ngaydathang'])); ?></td>
                            
                            <td class="fw-bold text-danger">
                                <?php echo number_format($order['tongtien'], 0, ',', '.'); ?> đ
                            </td>

                            <td>
                                <?php 
                                    switch ($order['trangthai']) {
                                        case 1:
                                            echo '<span class="badge bg-warning text-dark">Chờ xử lý</span>';
                                            break;
                                        case 2:
                                            echo '<span class="badge bg-primary">Đang giao</span>';
                                            break;
                                        case 3:
                                            echo '<span class="badge bg-success">Hoàn thành</span>';
                                            break;
                                        case 4:
                                            echo '<span class="badge bg-danger">Đã hủy</span>';
                                            break;
                                        default:
                                            echo '<span class="badge bg-secondary">Không rõ</span>';
                                    }
                                ?>
                            </td>

                            <td>
                                
                                    <div class="mt-2 small">
                                        <?php
                                        $madon = $order['madonhang'];
                                        $sql_chitiet = "
                                            SELECT sp.tensanpham, ch.ram, ch.ocung, ct.soluongsanpham, ct.gialucmua 
                                            FROM chi_tiet_don_hang ct
                                            JOIN cau_hinh ch ON ct.macauhinh = ch.macauhinh
                                            JOIN san_pham sp ON ch.masanpham = sp.masanpham
                                            WHERE ct.madonhang = :madon
                                        ";
                                        $stmt_ct = $pdo->prepare($sql_chitiet);
                                        $stmt_ct->bindParam(':madon', $madon);
                                        $stmt_ct->execute();
                                        $items = $stmt_ct->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($items as $item) {
                                            echo "<p class='mb-1 border-bottom pb-1'>";
                                            echo "<strong>" . $item['tensanpham'] . "</strong><br>";
                                            echo "Cấu hình: " . $item['ram'] . " - " . $item['ocung'] . "<br>";
                                            echo "SL: " . $item['soluongsanpham'] . " x " . number_format($item['gialucmua'], 0, ',', '.') . "đ";
                                            echo "</p>";
                                            echo "<br>";
                                        }
                                        ?>
                                    
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Bạn chưa có đơn hàng nào. <a href="index.php">Mua sắm ngay!</a>
        </div>
    <?php endif; ?>
</div>

<?php
include("../includes/footer.php");
?>