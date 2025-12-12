<?php
include("../includes/header.php");
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
            <img src="../assets/images/macbook_E2_pro.webp" alt="" />
          </div>

          <div class="sp-left-sub">
            <img src="../assets/images/macbook-pro-14-inch-m2-pro.jpg" alt="" />
            <img src="../assets/images/macbook-pro-14-inch-m2-pro.jpg" alt="" />
            <img src="../assets/images/macbook_E2_pro.webp" alt="" />
          </div>
        </div>

        <!-- Bên phải để thông tin sản phẩm -->
        <div class="sp-right">
          <h2>Laptop MacBook Pro 14</h2>

          <div class="sp-right-price">19.000.000₫</div>

          <h3>Chọn cấu hình</h3>
          <div class="sp-right-cauhinh">
            <button class="sp-right-cauhinh-btn">
              8GB RAM-256GB SSD <br />
              <small>19.000.000₫</small>
            </button>
            <button class="sp-right-cauhinh-btn">
              8GB RAM-256GB SSD <br />
              <small>19.000.000₫</small>
            </button>
          </div>

          <h3>Thông số kĩ thuật</h3>
          <table class="sp-right-thongso">
            <tr>
              <td>Thương hiệu</td>
              <td>Apple</td>
            </tr>
            <tr>
              <td>CPU</td>
              <td>Apple M2 Pro</td>
            </tr>
            <tr>
              <td>Màn hình</td>
              <td>14.2 inch</td>
            </tr>
            <tr>
              <td>Pin</td>
              <td>100Wh</td>
            </tr>
          </table>

          <div class="sp-right-action">
            <div class="sp-right-action-buy">
              <button>Mua ngay</button>
            </div>
            <div class="sp-right-action-cart">
              <button>
                <img src="../assets/images/shopping-cart.png" alt="" />
                  
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