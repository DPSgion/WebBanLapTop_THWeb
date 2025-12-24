<?php
include("../includes/config.php");
include("../includes/functions.php");
$path = ".."; // File này nằm sâu hơn 1 cấp, cần lùi ra ngoài để gặp assets
include("../includes/header.php");

// lấy id từ index
if (isset($_GET['id']))
  $id = $_GET['id'];

$sp = getChiTietSanPham($pdo, $id);

$hinh = getHinhAnhSanPham($pdo, $id);
$dsCauHinh = getCauHinhtSanPham($pdo, $id);


  ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chi tiết sản phẩm</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
  <div class="container">
    <div class="sp">
      <!-- Bên trái để hình laptop -->
      <div class="sp-left">
        <div class="sp-left-main">
          <img src="../assets/images/<?php echo $hinh['urlhinh'] ?>" alt="" />
        </div>

        <!-- <div class="sp-left-sub">
            <img src="../assets/images/macbook-pro-14-inch-m2-pro.jpg" alt="" />
            <img src="../assets/images/macbook-pro-14-inch-m2-pro.jpg" alt="" />
            <img src="../assets/images/macbook_E2_pro.webp" alt="" />
          </div> -->
      </div>

      <!-- Bên phải để thông tin sản phẩm -->
      <div class="sp-right">
        <h2><?php echo $sp['tensanpham'] ?></h2>

        <!-- lấy giá thấp nhất -->
        <div class="sp-right-price"><?php echo $dsCauHinh[0]['giatien'] ?></div>

        <h3>Chọn cấu hình</h3>
        <div class="sp-right-cauhinh">
          <?php
          // Kiểm tra xem có cấu hình nào không
          if (!empty($dsCauHinh)):
            foreach ($dsCauHinh as $index => $ch):
              ?>
            
                <input type="radio" name="macauhinh" value="<?php echo $ch['macauhinh']; ?>" <?php echo ($index == 0) ? 'checked' : ''; ?> hidden>

                <div class="sp-right-cauhinh-btn">
                  <span><?php echo $ch['ram']; ?> - <?php echo $ch['ocung']; ?></span>
                  <br />
                  <small style="color: #d70018; font-weight: bold;">
                    <?php echo formatCurrency($ch['giatien']); ?>
                  </small>
                </div>
            <?php
            endforeach;
          else:
            ?>
            <p>Đang cập nhật cấu hình...</p>
          <?php endif; ?>
        </div>

        <h3>Thông số kĩ thuật</h3>
        <table class="sp-right-thongso">
          <tr>
            <td>Thương hiệu</td>
            <td><?php echo $sp['tenthuonghieu'] ?></td>
          </tr>
          <tr>
            <td>CPU</td>
            <td><?php echo $sp['cpu'] ?></td>
          </tr>
          <tr>
            <td>Màn hình</td>
            <td><?php echo $sp['manhinh'] ?></td>
          </tr>
          <tr>
            <td>Pin</td>
            <td><?php echo $sp['cpu'] ?></td>
          </tr>
        </table>

        <div class="sp-right-action">
          <div class="sp-right-action-buy">
            <a href="giohang.php">
              <button>MUA NGAY</button>
            </a>
          </div>
          <div class="sp-right-action-cart">
            <button>
              <a href="giohang.php">
                <img src="../assets/images/shopping-cart.png" alt="" />
              </a>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>

<?php
include("../includes/footer.php");
?>