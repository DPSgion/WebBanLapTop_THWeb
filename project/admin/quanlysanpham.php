<?php
    include("../config/configDB.php");
    

    $stmtBrand = $pdo->prepare("SELECT * FROM thuong_hieu");
    $stmtBrand->execute();
    $dsThuongHieu = $stmtBrand->fetchAll(PDO::FETCH_ASSOC);

    // Lấy giá trị hiện tại trên URL để giữ trạng thái đã chọn
    $currentBrand = isset($_GET['brand']) ? $_GET['brand'] : '';
    $currentSort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
?>

<div class="main-title">
    <h2>Quản lý Sản Phẩm</h2>
</div>

<div class="toolbar">
    <form action="" method="GET" class="search-box">
        <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? $_GET['page'] : ''; ?>">

        <input type="text" name="txtSearch" id="search-input" 
                placeholder="Tìm kiếm thương hiệu ..."
                value="<?php echo isset($_GET['txtSearch']) ? htmlspecialchars($_GET['txtSearch']) : ''; ?>">
        <button class="btn-search">Tìm</button>
    </form>
    <button id="openProductModalBtn" class="btn btn-primary">Thêm sản phẩm mới</button>
</div>

<form action="" method="GET" class="filter-bar">
    
    <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? $_GET['page'] : ''; ?>">
    <input type="hidden" name="txtSearch" value="<?php echo isset($_GET['txtSearch']) ? htmlspecialchars($_GET['txtSearch']) : ''; ?>">

    <div class="filter-left">
        <select name="brand" class="form-select" onchange="this.form.submit()">
            <option value="">-- Tất cả Hãng --</option>
            <?php foreach ($dsThuongHieu as $th): ?>
                <option value="<?php echo $th['mathuonghieu']; ?>" 
                    <?php echo ($currentBrand == $th['mathuonghieu']) ? 'selected' : ''; ?>>
                    <?php echo $th['tenthuonghieu']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="filter-right">
        <select name="sort" class="form-select" onchange="this.form.submit()">
            <option value="newest" <?php echo ($currentSort == 'newest') ? 'selected' : ''; ?>>Mới nhất</option>
            <option value="price-asc" <?php echo ($currentSort == 'price-asc') ? 'selected' : ''; ?>>Giá: Thấp -> Cao</option>
            <option value="price-desc" <?php echo ($currentSort == 'price-desc') ? 'selected' : ''; ?>>Giá: Cao -> Thấp</option>
            <option value="qty-desc" <?php echo ($currentSort == 'qty-desc') ? 'selected' : ''; ?>>Số lượng nhiều nhất</option>
        </select>
    </div>
</form>

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
            <?php
            $sqlProduct = "SELECT sp.masanpham, sp.tensanpham, sp.cpu, sp.vga, sp.man_hinh, sp.pin, 
                                ch.ram, ch.ocung, ch.giatien, ch.soluong
                        FROM `san_pham` sp
                        INNER JOIN cau_hinh ch ON ch.masanpham = sp.masanpham
                        WHERE 1=1"; // Mẹo: thêm WHERE 1=1 để dễ dàng nối chuỗi AND phía sau

            // Tìm kiếm
            $keyword = '';
            if (isset($_GET['txtSearch']) && !empty($_GET['txtSearch'])) {
                $keyword = $_GET['txtSearch'];
                $sqlProduct .= " AND sp.tensanpham LIKE :keyword";
            }

            // Lọc theo thương hiệu
            $brandID = '';
            if (isset($_GET['brand']) && !empty($_GET['brand'])) {
                $brandID = $_GET['brand'];
                $sqlProduct .= " AND sp.mathuonghieu = :brand";
            }

            // Sắp xếp
            $sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
            switch ($sortOption) {
                case 'price-asc':
                    $sqlProduct .= " ORDER BY ch.giatien ASC";
                    break;
                case 'price-desc':
                    $sqlProduct .= " ORDER BY ch.giatien DESC";
                    break;
                case 'qty-desc':
                    $sqlProduct .= " ORDER BY ch.soluong DESC";
                    break;
                default: // newest
                    $sqlProduct .= " ORDER BY sp.masanpham DESC"; // ID lớn nhất là mới nhất
                    break;
            }

            // --- 5. Chuẩn bị và Gán giá trị ---
            $stmt = $pdo->prepare($sqlProduct);

            if (!empty($keyword)) {
                $stmt->bindValue(':keyword', '%' . $keyword . '%');
            }
            if (!empty($brandID)) {
                $stmt->bindValue(':brand', $brandID);
            }

            // --- 6. Thực thi ---
            $stmt->execute();
            $dsSP = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // --- 7. Hiển thị dữ liệu (Giữ nguyên code hiển thị của bạn) ---
            $count = 1;
            if (count($dsSP) > 0) {
                foreach ($dsSP as $sanpham) {
            ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><strong><?php echo $sanpham['tensanpham']; ?></strong></td>
                        <td class="config-cell">
                            - CPU: <?php echo $sanpham['cpu'] ?><br>
                            - VGA: <?php echo $sanpham['vga'] ?><br>
                            - RAM: <?php echo $sanpham['ram'] ?> / SSD: <?php echo $sanpham['ocung'] ?>
                        </td>
                        <td style="color: red; font-weight: bold;">
                            <?php echo number_format($sanpham['giatien'], 0, ',', '.') ?> đ
                        </td>
                        <td><?php echo $sanpham['soluong'] ?></td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-edit btn-edit-product" data-id="<?php echo $sanpham['masanpham']; ?>">Sửa</a>
                            <a href="#" class="btn btn-delete">Xóa</a>
                        </td>
                    </tr>
            <?php
                    $count++;
                }
            } else {
                echo '<tr><td colspan="6" style="text-align:center;">Không tìm thấy sản phẩm nào!</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>


<div id="modalProduct" class="modal">
    <div class="modal-content modal-lg">
        <span class="close">&times;</span>
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px;">Thêm Sản Phẩm Mới</h3>


        <form action="controller/productController.php" method="post" enctype="multipart/form-data">

            <div class="section-title">1. Thông tin chung (Cấu hình cứng)</div>
            <div class="row-group">
                <div class="col-6">
                    <label>Tên sản phẩm (Model):</label>
                    <input type="text" name="name" placeholder="VD: Dell XPS 9310" required>
                </div>
                <div class="col-6">
                    <label>Hãng sản xuất:</label>
                    <select name="brand_id" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">

                        <?php

                        $sql = "SELECT * FROM thuong_hieu";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($data as $thuonghieu){
                        ?>

                            <option value="<?php echo $thuonghieu['mathuonghieu']; ?>"><?php echo $thuonghieu['tenthuonghieu']; ?></option>

                        <?php
                        }
                        ?>

                        
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

            <div class="row-group">
                <div class="col-6"><label>Hình ảnh:</label>
                <input type="file" name="images[]" multiple accept=".jpg, .jpeg, .png">
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

<div id="modalUpdateProduct" class="modal">
    <div class="modal-content modal-lg">
       

        <span class="close" onclick="document.getElementById('modalUpdateProduct').style.display='none'">&times;</span>
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px;">Cập Nhật Sản Phẩm</h3>

        <form action="controller/productController.php" method="post" enctype="multipart/form-data">
            
            <input type="hidden" name="product_id" id="edit_product_id">
            <input type="hidden" name="deleted_image_ids" id="deleted_image_ids" value="">

            <div class="section-title">1. Thông tin chung</div>
            <div class="row-group">
                <div class="col-6">
                    <label>Tên sản phẩm (Model):</label>
                    <input type="text" name="name" id="edit_name" required>
                </div>
                <div class="col-6">
                    <label>Hãng sản xuất:</label>
                    <select name="brand_id" id="edit_brand_id" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                        <?php
                        
                        $sql = "SELECT * FROM thuong_hieu";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($data as $thuonghieu){
                        ?>
                            <option value="<?php echo $thuonghieu['mathuonghieu']; ?>"><?php echo $thuonghieu['tenthuonghieu']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row-group">
                <div class="col-6"><label>CPU:</label>
                    <input type="text" name="cpu" id="edit_cpu">
                </div>
                <div class="col-6"><label>VGA (Card đồ họa):</label>
                    <input type="text" name="vga" id="edit_vga">
                </div>
            </div>
            <div class="row-group">
                <div class="col-6"><label>Màn hình:</label>
                    <input type="text" name="screen" id="edit_screen">
                </div>
                <div class="col-6"><label>Pin:</label>
                    <input type="text" name="battery" id="edit_battery">
                </div>
            </div>

            <div class="row-group">
                <div class="col-12">
                    <label>Hình ảnh hiện tại:</label>
                    <div id="current_images_container" style="display:flex; gap:10px; margin-bottom:10px; flex-wrap:wrap;">
                        </div>
                </div>
                <div class="col-12">
                    <small style="color:red; font-style:italic;">* Nếu không chọn file, ảnh cũ sẽ được giữ nguyên.</small>
                    <br>
                    <label>Chọn ảnh mới (Nếu muốn thay đổi):</label>
                    <input type="file" name="images[]" multiple accept=".jpg, .jpeg, .png">
                    
                </div>
            </div>

            <div class="section-title" style="margin-top: 20px;">2. Các tùy chọn cấu hình (Biến thể)</div>
            
            <div id="variant-container-update">
                <div class="variant-item">
                    <div class="variant-header"><span>Cấu hình 1</span></div>
                    
                    <input type="hidden" name="variant_id[]" class="edit_variant_id"> 
                    
                    <div class="row-group">
                        <div class="col-3">
                            <label>RAM:</label>
                            <input type="text" name="ram[]" class="edit_ram" required>
                        </div>
                        <div class="col-3">
                            <label>Ổ cứng:</label>
                            <input type="text" name="ssd[]" class="edit_ssd" required>
                        </div>
                        <div class="col-3">
                            <label>Giá tiền:</label>
                            <input type="number" name="price[]" class="edit_price" required>
                        </div>
                        <div class="col-3">
                            <label>Số lượng:</label>
                            <input type="number" name="quantity[]" class="edit_quantity" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
                <input  type="submit" 
                        name="btn_update_product" 
                        value="Cập nhật thay đổi" 
                        class="btn btn-primary" 
                        style="width: 100%;" 
                        onclick="return confirm('Tất cả hình bạn xóa khi nãy sẽ bị xóa vĩnh viễn, nội dung sẽ thay đổi sau khi bạn bấm nút Cập Nhật. Bạn chắc chứ?');">
            </div>
            
        </form>
    </div>
</div>


<script>
    // ======================================
    // CẤU HÌNH CHO MODAL THÊM SẢN PHẨM (ADD)
    // ======================================
    var modalAdd = document.getElementById("modalProduct");
    var btnOpenAdd = document.getElementById("openProductModalBtn");
    var closeAdd = modalAdd.getElementsByClassName("close")[0]; 
    var containerAdd = document.getElementById('variant-container');

    btnOpenAdd.onclick = function() {
        modalAdd.style.display = "block";
    }
    closeAdd.onclick = function() {
        modalAdd.style.display = "none";
    }

    var btnAddVariant = document.getElementById('btnAddVariant');
    if(btnAddVariant){
        btnAddVariant.addEventListener('click', function () {
            const currentCount = containerAdd.getElementsByClassName('variant-item').length + 1;
            const newVariant = document.createElement('div');
            newVariant.classList.add('variant-item');
            newVariant.innerHTML = `
                <div class="variant-header">
                    <span>Cấu hình ${currentCount}</span>
                    <button type="button" class="btn-remove-variant" onclick="this.closest('.variant-item').remove()">&times;</button>
                </div>
                <div class="row-group">
                    <div class="col-3"><label>RAM:</label><input type="text" name="ram[]" required></div>
                    <div class="col-3"><label>SSD:</label><input type="text" name="ssd[]" required></div>
                    <div class="col-3"><label>Giá:</label><input type="number" name="price[]" required></div>
                    <div class="col-3"><label>Kho:</label><input type="number" name="quantity[]" required></div>
                </div>`;
            containerAdd.appendChild(newVariant);
        });
    }

    // ====================================
    // CẤU HÌNH CHO MODAL CẬP NHẬT (UPDATE)
    // ====================================
    var modalUpdate = document.getElementById("modalUpdateProduct");
    var updateContainer = document.getElementById("variant-container-update");
    
    // Tạo nút
    var btnAddVarUpdate = document.getElementById('btnAddVariantUpdate');
    if(!btnAddVarUpdate){
        let btnArea = document.querySelector('#modalUpdateProduct .form-actions');
        let newBtn = document.createElement('button');
        newBtn.type = 'button';
        newBtn.id = 'btnAddVariantUpdate';
        newBtn.className = 'btn btn-secondary';
        newBtn.innerText = '+ Thêm cấu hình mới';
        newBtn.style.marginBottom = '10px';
        newBtn.onclick = function() { addVariantToUpdateModal(null, updateContainer.children.length + 1); };
        
        let submitBtn = modalUpdate.querySelector('input[type="submit"]');
        submitBtn.parentNode.insertBefore(newBtn, submitBtn);
    } else {
        btnAddVarUpdate.addEventListener('click', function() {
             addVariantToUpdateModal(null, updateContainer.children.length + 1);
        });
    }

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btn-edit-product')) {
            e.preventDefault();
            var productId = e.target.getAttribute('data-id');
            openUpdateModal(productId);
        }
    });

    var deletedImageIds = [];

    // Hàm mở Modal và Load dữ liệu
    function openUpdateModal(id) {
        // Reset giao diện
        document.getElementById('current_images_container').innerHTML = 'Đang tải...';
        deletedImageIds = []; 
        document.getElementById('deleted_image_ids').value = '';
        updateContainer.innerHTML = ''; 
        
        // Gọi API lấy dữ liệu
        fetch('controller/productController.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                if(data.status === 'error') { alert(data.message); return; }

                var prod = data.product;
                var variants = data.variants;
                var images = data.images;

                // Điền thông tin chung
                document.getElementById('edit_product_id').value = prod.masanpham;
                document.getElementById('edit_name').value = prod.tensanpham;
                document.getElementById('edit_brand_id').value = prod.mathuonghieu;
                document.getElementById('edit_cpu').value = prod.cpu;
                document.getElementById('edit_vga').value = prod.vga;
                document.getElementById('edit_screen').value = prod.man_hinh;
                document.getElementById('edit_battery').value = prod.pin;

                var imgHtml = '';
                var uploadPath = 'upload/'; 
                
                if(images && images.length > 0){
                    images.forEach(img => {
                        // Thêm ID cho thẻ div bọc ngoài để dễ tìm xóa (img-box-ID)
                        // Thêm nút X (span onclick)
                        imgHtml += `
                            <div id="img-box-${img.mahinh}" style="position:relative; width:60px; height:60px; border:1px solid #ccc; margin-right:10px;">
                                <img src="../${uploadPath}${img.urlhinh}" style="width:100%; height:100%; object-fit:cover;">
                                
                                <span onclick="markImageForDelete(${img.mahinh})" 
                                      style="position:absolute; top:-5px; right:-5px; background:red; color:white; 
                                             border-radius:50%; width:18px; height:18px; text-align:center; 
                                             line-height:16px; font-size:12px; cursor:pointer; font-weight:bold;">
                                      &times;
                                </span>
                            </div>
                        `;
                    });
                } else {
                    imgHtml = '<span style="color:#999; font-size:12px;">Không có ảnh</span>';
                }
                document.getElementById('current_images_container').innerHTML = imgHtml;

                // Điền các cấu hình (biến thể)
                if(variants.length > 0){
                    variants.forEach((variant, index) => {
                        addVariantToUpdateModal(variant, index + 1);
                    });
                } else {
                    // Nếu lỗi data không có cấu hình nào, tạo 1 dòng trống
                    addVariantToUpdateModal(null, 1);
                }

                modalUpdate.style.display = "block";
            })
            .catch(err => console.error('Lỗi:', err));
    }

    // --- HÀM ĐÁNH DẤU XÓA ẢNH (XÓA TẠM THỜI) ---
    function markImageForDelete(id) {

        deletedImageIds.push(id);
        document.getElementById('deleted_image_ids').value = deletedImageIds.join(',');

        var box = document.getElementById('img-box-' + id);
        if(box) box.style.display = 'none';
    }


    // Hàm vẽ giao diện biến thể (Dùng chung cho Load DB và Thêm Mới)
    function addVariantToUpdateModal(data, index) {
        var ram = data ? data.ram : '';
        var ssd = data ? data.ocung : '';
        var price = data ? data.giatien : '';
        var qty = data ? data.soluong : '';
        var varId = data ? data.macauhinh : ''; // ID rỗng nếu là thêm mới

        var html = `
            <div class="variant-item-update" style="background:#f9f9f9; padding:10px; margin-bottom:10px; border-radius:5px; border:1px dashed #ccc;">
                <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                    <strong>Cấu hình ${data ? '(Hiện có)' : '(Mới)'}</strong>
                    <button type="button" class="btn-remove-update" style="color:red; border:none; background:none; cursor:pointer;">&times; Xóa dòng này</button>
                </div>

                <input type="hidden" name="variant_id[]" value="${varId}">

                <div class="row-group">
                    <div class="col-3"><input type="text" name="ram[]" value="${ram}" placeholder="RAM" required></div>
                    <div class="col-3"><input type="text" name="ssd[]" value="${ssd}" placeholder="SSD" required></div>
                    <div class="col-3"><input type="number" name="price[]" value="${price}" placeholder="Giá" required></div>
                    <div class="col-3"><input type="number" name="quantity[]" value="${qty}" placeholder="Kho" required></div>
                </div>
            </div>
        `;
        updateContainer.insertAdjacentHTML('beforeend', html);
    }

    // Xử lý nút XÓA cấu hình (biến thể) trong modal Update
    updateContainer.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btn-remove-update')) {
            var currentRows = updateContainer.getElementsByClassName('variant-item-update').length;
            if (currentRows <= 1) {
                alert("Sản phẩm phải giữ lại ít nhất 1 cấu hình!");
                return;
            }
        }
    });

    window.onclick = function (event) {
        if (event.target == modalAdd) modalAdd.style.display = "none";
        if (event.target == modalUpdate) modalUpdate.style.display = "none";
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            if (modalAdd && modalAdd.style.display === "block") {
                modalAdd.style.display = "none";
            }

            if (modalUpdate && modalUpdate.style.display === "block") {
                modalUpdate.style.display = "none";
            }
        }
    });
</script>