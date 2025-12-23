<?php
    include("../config/configDB.php");
?>


<div class="main-title">
    <h2>Quản lý thương hiệu</h2>
</div>

<div class="toolbar">
    <div class="search-box">
        <input type="text" id="search-input" placeholder="Tìm kiếm thương hiệu ...">
        <button class="btn-search">Tìm</button>
    </div>
    <a  id="openModalBtn" class="btn btn-primary">Thêm thương hiệu mới</a>
</div>

<div class="table-container">
    <table class="table-admin">
        <thead>
            <tr>
                <th width="5%">STT</th>
                <th width="45%">Tên thương hiệu</th>
                <th width="20%">Số lượng SP</th>
                <th width="20%">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM thuong_hieu";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $count = 1;
                foreach($data as $dong){
                    ?>

                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $dong['tenthuonghieu']; ?></td>
                        <td>?</td>
                        <td>
                            <a href="#" class="btn btn-edit">Sửa</a>
                            <a href="#" class="btn btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                        </td>
                    </tr>

                    <?php
                    $count++;
                }

            ?>
        </tbody>
    </table>
</div>


<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span> <h3>Thêm Thương Hiệu Mới</h3>
        
        <form action="controller/brandController.php" method="post">
            <div class="form-group">
                <label>Tên thương hiệu:</label>
                <input type="text" id="thuonghieu" name="thuonghieu" placeholder="Nhập tên thương hiệu..." required>
            </div>
            
            <div class="form-actions">
                <input type="submit" name="btnThem" value="Lưu lại" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>



<script>
    var modal = document.getElementById("myModal");
    var btnOpen = document.getElementById("openModalBtn");
    var btnClose = document.getElementsByClassName("close")[0];

    btnOpen.onclick = function() {
        modal.style.display = "block";
        thuonghieu.value = ""; 
        setTimeout(function() {
            thuonghieu.focus();
        }, 100);
    }

    btnClose.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            modal.style.display = "none";
        }
    });
</script>