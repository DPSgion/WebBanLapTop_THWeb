

<div class="quanlydanhmuc">

    <div class="main-title">
        <h2>Quản lý danh mục</h2>
    </div>

    <div class="toolbar">
        <div class="search-box">
            <input type="text" id="search-input" placeholder="Tìm kiếm danh mục ...">
            <button class="btn-search">Tìm</button>
        </div>
        <a  id="openModalBtn" class="btn btn-primary">Thêm danh mục mới</a>
    </div>

    <div class="table-container">
        <table class="table-admin">
            <thead>
                <tr>
                    <th width="5%">STT</th>
                    <th width="45%">Tên danh mục</th>
                    <th width="20%">Số lượng SP</th>
                    <th width="20%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Laptop Acer</td>
                    <td>15</td>
                    <td>
                        <a href="#" class="btn btn-edit">Sửa</a>
                        <a href="#" class="btn btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Macbook</td>
                    <td>8</td>
                    <td>
                        <a href="#" class="btn btn-edit">Sửa</a>
                        <a href="#" class="btn btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Laptop Lenovo</td>
                    <td>24</td>
                    <td>
                        <a href="#" class="btn btn-edit">Sửa</a>
                        <a href="#" class="btn btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span> <h3>Thêm Danh Mục Mới</h3>
            
            <form action="" method="post">
                <div class="form-group">
                    <label>Tên danh mục:</label>
                    <input type="text" name="username" placeholder="Nhập tên danh mục..." required>
                </div>
                
                <div class="form-actions">
                    <input type="submit" value="Lưu lại" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>


</div>


<script>
    var modal = document.getElementById("myModal");
    var btnOpen = document.getElementById("openModalBtn");
    var btnClose = document.getElementsByClassName("close")[0];

    btnOpen.onclick = function() {
        modal.style.display = "block";
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