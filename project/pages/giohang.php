<?php
require_once("../includes/config.php");
include("../includes/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="cart-page-container">
        <div class="container">
        <div class="cart-header-title">
            <a href="../index.php" class="back-home"> << Về trang chủ</a>
            <h3>Giỏ hàng <span class="cart-count">(2 sản phẩm)</span></h3>
        </div>

        <div class="cart-layout">
            <div class="cart-left">
                <div class="cart-table-header">
                    <div class="ct-checkbox"><input type="checkbox"> Tất cả</div>
                    <div class="ct-info">Sản phẩm</div>
                    <div class="ct-qty">Số lượng</div>
                    <div class="ct-price">Thành tiền</div>
                    <div class="ct-action">Xóa</div>
                </div>

                <div class="cart-item">
                    <div class="ci-checkbox">
                        <input type="checkbox" checked>
                    </div>
                    <div class="ci-img">
                        <img src="../assets/images/macbook_E2_pro.webp" alt="Laptop">
                    </div>
                    <div class="ci-info">
                        <a href="#" class="ci-name">Laptop MacBook Pro 14 M3 (2024)</a>
                        <p class="ci-variant">Cấu hình: 8GB - 256GB SSD</p>
                        <p class="ci-price-one">Đơn giá: 39.990.000₫</p>
                    </div>
                    <div class="ci-qty">
                        <div class="qty-control">
                            <button>-</button>
                            <input type="number" value="1" min="1">
                            <button>+</button>
                        </div>
                    </div>
                    <div class="ci-total-price">39.990.000₫</div>
                    <div class="ci-action">
                        <button class="btn-delete"><img src="../assets/images/icons-recycle-bin.png" alt=""></button>
                    </div>
                </div>

                <div class="cart-item">
                    <div class="ci-checkbox">
                        <input type="checkbox">
                    </div>
                    <div class="ci-img">
                        <img src="../assets/images/lenovo.jpg" alt="Laptop">
                    </div>
                    <div class="ci-info">
                        <a href="#" class="ci-name">Laptop Lenovo Legion 5</a>
                        <p class="ci-variant">Cấu hình: 16GB - 512GB SSD</p>
                        <p class="ci-price-one">Đơn giá: 25.000.000₫</p>
                    </div>
                    <div class="ci-qty">
                        <div class="qty-control">
                            <button>-</button>
                            <input type="number" value="2" min="1">
                            <button>+</button>
                        </div>
                    </div>
                    <div class="ci-total-price">50.000.000₫</div>
                    <div class="ci-action">
                         <button class="btn-delete"><img src="../assets/images/icons-recycle-bin.png" alt=""></button>
                    </div>
                </div>
            </div>

            <div class="cart-right">
                <div class="cart-summary-box">
                    <div class="cs-row total">
                        <span>Tổng tiền:</span>
                        <span class="final-price">89.990.000₫</span>
                    </div>
                    <button class="btn-checkout" id="btn-open-modal">ĐẶT HÀNG</button>
                    <a href="../index.php" class="continue-shopping">Chọn thêm sản phẩm khác</a>
                </div>
            </div>
            </div>
        </div>
</div>


<!-- form đặt hàng -->
<div id="checkout-modal" class="modal-overlay">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        
        <div class="modal-header">
            <h3>THÔNG TIN GIAO HÀNG</h3>
            <p>Vui lòng điền thông tin để hoàn tất đơn hàng</p>
        </div>

        <form action="xuly_dathang.php" method="POST" class="checkout-form">
            <div class="form-group">
                <label>Họ và tên người nhận</label>
                <input type="text" name="hoten" required>
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="tel" name="sdt"  required>
            </div>

            <div class="form-group">
                <label>Địa chỉ giao hàng</label>
                <input type="text" name="diachi" placeholder="Số nhà, tên đường, phường/xã..." required>
            </div>


            <div class="modal-actions">
                <button type="button" class="btn-cancel">Hủy bỏ</button>
                <button type="submit" class="btn-confirm">XÁC NHẬN ĐẶT HÀNG</button>
            </div>
        </form>
    </div>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>