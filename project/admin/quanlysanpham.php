<div class="main-title">
    <h2>Quản lý Sản Phẩm</h2>
</div>

<div class="toolbar">
    <div class="search-box">
        <input type="text" id="search-product" placeholder="Tìm tên sản phẩm...">
        <button class="btn-search">Tìm</button>
    </div>
    <button id="openProductModalBtn" class="btn btn-primary">Thêm sản phẩm mới</button>
</div>

<div class="filter-bar">
    <div class="filter-left">
        <select class="form-select">
            <option value="">-- Tất cả Hãng --</option>
            <option value="dell">Acer</option>
            <option value="hp">Macbook</option>
            <option value="macbook">Lenovo</option>
        </select>

        <select class="form-select">
            <option value="">-- Tất cả RAM --</option>
            <option value="8gb">8GB</option>
            <option value="16gb">16GB</option>
            <option value="32gb">32GB</option>
        </select>

        <select class="form-select">
            <option value="">-- Ổ cứng --</option>
            <option value="ssd-256">SSD 256GB</option>
            <option value="ssd-512">SSD 512GB</option>
            <option value="ssd-1tb">SSD 1TB</option>
        </select>
    </div>

    <div class="filter-right">
        <select class="form-select">
            <option value="newest">Mới nhất</option>
            <option value="price-asc">Giá: Thấp -> Cao</option>
            <option value="price-desc">Giá: Cao -> Thấp</option>
            <option value="qty-desc">Số lượng nhiều nhất</option>
        </select>
    </div>


</div>

<div class="table-container">
    <table class="table-admin">
        <thead>
            <tr>
                <th width="5%">STT</th>
                <th width="20%">Tên sản phẩm</th>
                <th width="35%">Cấu hình</th>
                <th width="15%">Giá tiền</th>
                <th width="10%">Kho</th>
                <th width="15%">Hành động</th>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <td>1</td>
                <td>
                    <strong>MacBook Air M1</strong><br>
                    <small style="color:#888;">Mã: MBAM1</small>
                </td>
                <td class="config-cell">
                    - CPU: Apple M1<br>
                    - VGA: 7-core GPU<br>
                    - Màn: 13.3" Retina<br>
                    - RAM: 8GB<br>
                    - SSD: 256GB<br>
                    - Pin: 15h sử dụng
                </td>
                <td style="color: red; font-weight: bold;">18.990.000 đ</td>
                <td>5</td>
                <td>
                    <a href="#" class="btn btn-edit">Sửa</a>
                    <a href="#" class="btn btn-delete">Xóa</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>


<div id="modalProduct" class="modal">
    <div class="modal-content modal-lg">
        <span class="close">&times;</span>
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px;">Thêm Sản Phẩm Mới</h3>


        <form action="#" method="post">

            <div class="section-title">1. Thông tin chung (Cấu hình cứng)</div>
            <div class="row-group">
                <div class="col-6">
                    <label>Tên sản phẩm (Model):</label>
                    <input type="text" name="name" placeholder="VD: Dell XPS 9310" required>
                </div>
                <div class="col-6">
                    <label>Hãng sản xuất:</label>
                    <select name="brand_id" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                        <option value="1">Dell</option>
                        <option value="2">HP</option>
                        <option value="3">Macbook</option>
                        <option value="4">Asus</option>
                    </select>
                </div>
            </div>

            <div class="row-group">
                <div class="col-6"><label>CPU:</label><input type="text" name="cpu" placeholder="VD: Core i7 1165G7">
                </div>
                <div class="col-6"><label>VGA (Card đồ họa):</label><input type="text" name="vga"
                        placeholder="VD: Intel Iris Xe"></div>
            </div>
            <div class="row-group">
                <div class="col-6"><label>Màn hình:</label><input type="text" name="screen"
                        placeholder="VD: 13.4 inch FHD+"></div>
                <div class="col-6"><label>Pin:</label><input type="text" name="battery" placeholder="VD: 4 Cell 52Wh">
                </div>
            </div>

            <div class="section-title"
                style="margin-top: 20px; display:flex; justify-content:space-between; align-items:center;">
                <span>2. Các tùy chọn cấu hình (Biến thể)</span>
                <button type="button" id="btnAddVariant" class="btn btn-primary" style="font-size:12px;">+ Thêm cấu hình</button>
            </div>

            <div id="variant-container">
                <div class="variant-item">
                    <div class="variant-header">
                        <span>Cấu hình 1</span>
                    </div>
                    <div class="row-group">
                        <div class="col-3">
                            <label>RAM:</label>
                            <input type="text" name="ram[]" placeholder="VD: 8GB" required>
                        </div>
                        <div class="col-3">
                            <label>Ổ cứng:</label>
                            <input type="text" name="ssd[]" placeholder="VD: 256GB" required>
                        </div>
                        <div class="col-3">
                            <label>Giá tiền:</label>
                            <input type="number" name="price[]" placeholder="VNĐ" required>
                        </div>
                        <div class="col-3">
                            <label>Số lượng:</label>
                            <input type="number" name="quantity[]" placeholder="Kho" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
                <input type="submit" name="btn_add_product" value="Lưu tất cả" class="btn btn-primary"
                    style="width: 100%;">
            </div>
        </form>
    </div>
</div>

<script>
    // 1. Lấy các phần tử cần thiết
    var modalProd = document.getElementById("modalProduct");
    var btnProd = document.getElementById("openProductModalBtn");
    var closeProd = document.getElementsByClassName("close")[0]; 
    var container = document.getElementById('variant-container');

    function closeAndResetModal() {
        modalProd.style.display = "none";

        // Reset toàn bộ form (xóa chữ trong ô input)
        var form = modalProd.querySelector('form');
        if (form) {
            form.reset();
        }

        // Xóa các dòng biến thể thừa (chỉ giữ lại dòng đầu tiên)
        var items = container.getElementsByClassName('variant-item');
        
        while (items.length > 1) {
            items[items.length - 1].remove();
        }
    }

    btnProd.onclick = function () {
        modalProd.style.display = "block";
    }

    closeProd.onclick = closeAndResetModal;

    window.onclick = function (event) {
        if (event.target == modalProd) {
            closeAndResetModal();
        }
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === "Escape" && modalProd.style.display === "block") {
            closeAndResetModal();
        }
    });

    // --- XỬ LÝ THÊM BIẾN THỂ ---
    var btnAddVariant = document.getElementById('btnAddVariant');

    btnAddVariant.addEventListener('click', function () {
        const currentCount = container.getElementsByClassName('variant-item').length + 1;
        const newVariant = document.createElement('div');
        newVariant.classList.add('variant-item');

        newVariant.innerHTML = `
            <div class="variant-header">
                <span>Cấu hình ${currentCount}</span>
                <button type="button" class="btn-remove-variant" onclick="removeVariant(this)">&times;</button>
            </div>
            <div class="row-group">
                <div class="col-3"><label>RAM:</label><input type="text" name="ram[]" placeholder="VD: 16GB" required></div>
                <div class="col-3"><label>Ổ cứng:</label><input type="text" name="ssd[]" placeholder="VD: 512GB" required></div>
                <div class="col-3"><label>Giá tiền:</label><input type="number" name="price[]" placeholder="VNĐ" required></div>
                <div class="col-3"><label>Số lượng:</label><input type="number" name="quantity[]" placeholder="Kho" required></div>
            </div>
        `;
        container.appendChild(newVariant);
    });

    // Hàm xóa biến thể
    function removeVariant(btn) {
        const item = btn.closest('.variant-item');
        item.remove();
    }
</script>