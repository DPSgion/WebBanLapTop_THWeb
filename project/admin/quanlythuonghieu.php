<?php
    include("check_admin.php");
    include("../config/configDB.php");
?>


<div class="main-title">
    <h2>Quản lý thương hiệu</h2>
</div>

<div class="toolbar">
    <div class="search-box">
        <form action="" method="get">
            <input type="text" name="txtSearch" id="search-input" 
                placeholder="Tìm kiếm thương hiệu ..."
                value="<?php echo isset($_GET['txtSearch']) ? htmlspecialchars($_GET['txtSearch']) : ''; ?>">
            <input type="submit" style="width: 50px" class="btn-search" name="btnSearch" value="Tìm"/>
        </form>
    </div>
    <a  id="openModalBtn" class="btn btn-primary">Thêm thương hiệu mới</a>
</div>

<div class="table-container">
    <table class="table-admin">
        <thead>
            <tr>
                <th width="5%">STT</th>
                <th width="25%">Tên thương hiệu</th>
                <th width="20%">Số lượng SP</th>
                <!-- <th width="20%">Trạng thái</th> -->
                <th width="20%">Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $keyword = '';
            if (isset($_GET['txtSearch']) && !empty($_GET['txtSearch'])) {
                $keyword = $_GET['txtSearch'];
            }

            $sql = "SELECT thuong_hieu.mathuonghieu, tenthuonghieu, trangthai, COUNT(san_pham.masanpham) as soluong
                    FROM thuong_hieu
                    LEFT JOIN san_pham on san_pham.mathuonghieu = thuong_hieu.mathuonghieu";

            if ($keyword != '') {
                $sql .= " WHERE tenthuonghieu LIKE :keyword ";
            }

            $sql .= " GROUP BY thuong_hieu.mathuonghieu, tenthuonghieu, trangthai";

            $stmt = $pdo->prepare($sql);

            if ($keyword != '') {
                $stmt->bindValue(':keyword', '%' . $keyword . '%');
            }

            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Nếu không tìm thấy kết quả nào
            if ($stmt->rowCount() == 0) {
                echo "<tr><td colspan='5' style='text-align:center; color:red;'>Không tìm thấy thương hiệu nào!</td></tr>";
            }

            $count = 1;
            foreach($data as $dong){
                ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $dong['tenthuonghieu']; ?></td>
                    <td><?php echo $dong['soluong']; ?></td>
                    <!-- <td>
                        <?php
                        echo ($dong['trangthai'] == 0) ? 
                                "<span style='color: red'>Không hoạt động</span>" : 
                                "<span style='color: green'>Hoạt động</span>";  
                        ?>
                    </td> -->
                    <td>
                        <a href="#" 
                            class="btn btn-edit btn-update" 
                            data-id="<?php echo $dong['mathuonghieu']; ?>" 
                            data-name="<?php echo $dong['tenthuonghieu']; ?>">
                            Sửa
                        </a>
                        
                        <!-- <a href="controller/brandController.php?doitrangthai&id=<?php echo $dong['mathuonghieu']; ?>&trangthaihientai=<?php echo $dong['trangthai']; ?>"
                            class="btn btn-primary"
                            onclick="return confirm('Bạn có chắc muốn đổi trạng thái ?')">
                            Đổi trạng thái
                        </a> -->
                        
                        <a href="controller/brandController.php?xoathuonghieu&id=<?php echo $dong['mathuonghieu']; ?>"
                            class="btn btn-delete"
                            onclick="return confirm('Bạn có chắc muốn xóa không ?')">
                            Xóa
                        </a>
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


<div id="updateModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span> <h3>Sửa Thương Hiệu</h3>
        
        <form action="controller/brandController.php" method="post">
            
            <input type="hidden" id="id_edit" name="mathuonghieu">
            <input type="hidden" id="id_tenthuonghieu_cu" name="thuonghieu_cu">

            <div class="form-group">
                <label>Tên thương hiệu:</label>
                <input type="text" id="thuonghieu_edit" name="thuonghieu" required>
            </div>
            
            <div class="form-group">
                 <br>
                 <input type="submit" name="btnCapNhat" value="Cập nhật" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>



<script>
    // Modal Thêm
    var modal = document.getElementById("myModal");
    var btnOpen = document.getElementById("openModalBtn");
    var inputThem = document.getElementById("thuonghieu"); 

    // Modal Sửa
    var modalUpdate = document.getElementById("updateModal");
    var inputSua = document.getElementById("thuonghieu_edit");
    var inputId = document.getElementById("id_edit");

    var spans = document.getElementsByClassName("close");

    btnOpen.onclick = function() {
        modal.style.display = "block";
        inputThem.value = ""; 
        setTimeout(function() { inputThem.focus(); }, 100);
    }

    var editButtons = document.querySelectorAll(".btn-update");

    // 2. Gán sự kiện click cho từng nút
    editButtons.forEach(function(btn) {
        btn.onclick = function(event) {

            var id = this.getAttribute("data-id");
            var name = this.getAttribute("data-name");
            var oldName = this.getAttribute("data-name");

            // Điền dữ liệu vào form Sửa
            inputId.value = id;
            inputSua.value = name;
            id_tenthuonghieu_cu.value = oldName;

            // Hiện Modal Sửa
            modalUpdate.style.display = "block";
            
            setTimeout(function() { 
                inputSua.focus(); 
            }, 100);
        };
    });

    // Nút X của Modal Thêm
    spans[0].onclick = function() {
        modal.style.display = "none";
    }
    // Nút X của Modal Sửa
    spans[1].onclick = function() {
        modalUpdate.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == modalUpdate) {
            modalUpdate.style.display = "none";
        }
    }
</script>