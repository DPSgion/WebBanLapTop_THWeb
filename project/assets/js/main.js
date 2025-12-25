// Mở modal khi nhấn nút "TIẾN HÀNH ĐẶT HÀNG"
document.addEventListener('DOMContentLoaded', function() {
    // Nút hiển thị form mua hàng
    const btnOpenModal = document.getElementById('btn-open-modal');
    const modal = document.getElementById('checkout-modal');
    const closeModal = document.querySelector('.close-modal');
    const btnCancel = document.querySelector('.btn-cancel');

    // nút cấu hình và chỗ hiển thị giá
    const configButtons = document.querySelectorAll('.sp-right-cauhinh-btn');
    const priceDisplay = document.getElementById('display-price');

    // --- HÀM HỖ TRỢ ĐỊNH DẠNG TIỀN TỆ (Giống PHP) ---
    function formatCurrencyJS(amount) {
        // Định dạng số: 25000000 -> 25.000.000
        let formatted = new Intl.NumberFormat('vi-VN').format(amount);
        return formatted + '₫';
    }

    // Mở modal
    if (btnOpenModal) {
        btnOpenModal.addEventListener('click', function() {
            // 1. KIỂM TRA ĐĂNG NHẬP TRƯỚC
            // Biến userDaDangNhap lấy từ Global (do PHP truyền sang ở file HTML)
            if (typeof userDaDangNhap !== 'undefined' && userDaDangNhap === true) {
                
                // --- TRƯỜNG HỢP 1: ĐÃ ĐĂNG NHẬP ---> MỞ MODAL ---
                if (modal) {
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden'; // Khóa cuộn trang
                }

            } else {
                
                // --- TRƯỜNG HỢP 2: CHƯA ĐĂNG NHẬP ---> CẢNH BÁO ---
                var xacNhan = confirm("Bạn cần đăng nhập để mua hàng.\nBạn có muốn chuyển đến trang đăng nhập không?");

                if (xacNhan) {
                    window.location.href = 'dangnhap.php'; 
                }
                // Không làm gì thêm (Modal sẽ không mở ra)
            }
        });
    }

    // Đóng modal khi nhấn nút X
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto'; // Cho phép scroll lại
            }
        });
    }

    // Đóng modal khi nhấn nút Hủy
    if (btnCancel) {
        btnCancel.addEventListener('click', function() {
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    }

    // 2. Gắn sự kiện Click cho từng nút
    configButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            
            //  Xóa class 'active' ở tất cả các nút khác
            configButtons.forEach(b => b.classList.remove('active'));

            // B. Thêm class 'active' cho nút vừa bấm (this chính là nút được bấm)
            this.classList.add('active');

            // C. Lấy giá tiền từ thuộc tính 'data-price' (chúng ta sẽ thêm ở bước 2)
            const price = this.getAttribute('data-price');
            
            // D. Cập nhật giá hiển thị
            if (priceDisplay && price) {
                priceDisplay.innerText = price;
            }


        });
    });

    // =====================
    // XỬ LÝ GIỎ HÀNG 
    // =====================

    // 1. Hàm tính lại Tổng tiền giỏ hàng
    function updateCartTotal() {
        let total = 0;
        let totalItems = 0;

        // Chỉ tính những sản phẩm có checkbox được chọn
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        
        checkboxes.forEach(chk => {
            const key = chk.getAttribute('data-key');
            // Lấy giá gốc (dạng số nguyên)
            const price = parseFloat(chk.getAttribute('data-price'));
            
            // Tìm ô input số lượng tương ứng để lấy số lượng hiện tại
            const qtyInput = document.querySelector(`.qty-input[data-key="${key}"]`);
            if (qtyInput) {
                const qty = parseInt(qtyInput.value);
                total += price * qty;
            }
        });

        // Đếm tổng số lượng item để hiển thị ở header
        document.querySelectorAll('.qty-input').forEach(input => {
            totalItems += parseInt(input.value);
        });

        // Cập nhật hiển thị Tổng tiền cuối cùng
        const finalPriceEl = document.querySelector('.final-price');
        const cartCountEl = document.querySelector('.cart-count');

        if (finalPriceEl) {
            finalPriceEl.innerText = formatCurrencyJS(total);
        }
        
        if (cartCountEl) {
            cartCountEl.innerText = `(${totalItems} sản phẩm)`;
        }
    }

    // 2. Hàm xử lý khi bấm Tăng/Giảm số lượng
    function handleQuantityChange(btn, isIncrease) {
        const key = btn.getAttribute('data-key');
        const input = document.querySelector(`.qty-input[data-key="${key}"]`);
        
        if (!input) return;

        let currentQty = parseInt(input.value);
        let newQty = isIncrease ? currentQty + 1 : currentQty - 1;
        
        if (newQty < 1) newQty = 1; // Không cho giảm dưới 1

        // A. Cập nhật số lượng vào ô input
        input.value = newQty;
        
        // B. Cập nhật "Thành tiền" của dòng đó (Item Total)
        const checkbox = document.querySelector(`.item-checkbox[data-key="${key}"]`);
        const price = parseFloat(checkbox.getAttribute('data-price')); // Giá đơn vị
        const rowTotalEl = document.querySelector(`#item-${key} .item-total`); // Ô thành tiền
        
        if (rowTotalEl) {
            // Tính thành tiền mới và format lại
            rowTotalEl.innerText = formatCurrencyJS(price * newQty);
        }

        // C. Tính lại tổng tiền cả giỏ hàng
        updateCartTotal();

        // D. Gửi AJAX để lưu vào Session (Backend)
        const formData = new FormData();
        // LƯU Ý QUAN TRỌNG: Phải dùng 'update_qty' để khớp với file PHP
        formData.append('action', 'update_qty'); 
        formData.append('key', key);
        formData.append('qty', newQty);

        fetch('xuly_giohang.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            // console.log('Update success:', data);
        })
        .catch(err => console.error('Lỗi cập nhật session:', err));
    }

    // Gắn sự kiện click cho các nút
    document.querySelectorAll('.btn-increase').forEach(btn => {
        btn.addEventListener('click', function() { handleQuantityChange(this, true); });
    });

    document.querySelectorAll('.btn-decrease').forEach(btn => {
        btn.addEventListener('click', function() { handleQuantityChange(this, false); });
    });

    // =====================
    // XỬ LÝ CHECKBOX
    // =====================

    // Hàm gửi AJAX lưu trạng thái checkbox
    function updateCheckboxSession(key, isChecked) {
        const formData = new FormData();
        formData.append('action', 'update_select');
        formData.append('key', key);
        formData.append('status', isChecked ? 1 : 0);

        fetch('xuly_giohang.php', {
            method: 'POST',
            body: formData
        }).catch(err => console.error('Lỗi:', err));
    }

    // Nút "Chọn tất cả"
    const checkAll = document.getElementById('check-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');

    if (checkAll) {
        checkAll.addEventListener('change', function() {
            const isChecked = this.checked;
            itemCheckboxes.forEach(chk => {
                chk.checked = isChecked;
                updateCheckboxSession(chk.getAttribute('data-key'), isChecked);
            });
            updateCartTotal(); 
        });
    }

    // Checkbox từng món
    itemCheckboxes.forEach(chk => {
        chk.addEventListener('change', function() {
            updateCartTotal();
            const key = this.getAttribute('data-key');
            updateCheckboxSession(key, this.checked);
            
            // Logic phụ: Nếu bỏ chọn 1 cái thì bỏ chọn nút "Tất cả"
            if (!this.checked && checkAll) {
                checkAll.checked = false;
            }
        });
    });

    // Gọi 1 lần lúc load trang để đảm bảo tính đúng giá ban đầu
    updateCartTotal();


    function checkLoginAndRedirect() {
    // Biến userDaDangNhap sẽ được lấy từ bên file PHP (global variable)
    // Kiểm tra xem biến này có tồn tại và có bằng true không
    if (typeof userDaDangNhap !== 'undefined' && userDaDangNhap === true) {
        // TRƯỜNG HỢP 1: Đã đăng nhập
        window.location.href = 'form_giao_hang.php'; 
    } else {
        // TRƯỜNG HỢP 2: Chưa đăng nhập
        var xacNhan = confirm("Bạn cần đăng nhập để thực hiện chức năng này.\nBạn có muốn chuyển đến trang đăng nhập không?");

        if (xacNhan) {
            window.location.href = 'login.php'; 
            }
        }
    }



    
});


