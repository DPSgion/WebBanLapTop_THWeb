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

    // Mở modal
    if (btnOpenModal) {
        btnOpenModal.addEventListener('click', function() {
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden'; // Không cho scroll khi modal mở
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
    // Giỏ hàng
    // =====================

    // Hàm tính lại Tổng tiền (chỉ tính những ô checkbox được chọn)
    function updateCartTotal() {
        let total = 0;
        let totalItems = 0;

        // Lấy tất cả checkbox đang được chọn
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        
        checkboxes.forEach(chk => {
            const key = chk.getAttribute('data-key');
            const price = parseFloat(chk.getAttribute('data-price'));
            
            // Tìm ô input số lượng tương ứng
            const qtyInput = document.querySelector(`.qty-input[data-key="${key}"]`);
            if (qtyInput) {
                const qty = parseInt(qtyInput.value);
                total += price * qty;
            }
        });

        // Đếm tổng số lượng item (dùng để hiển thị ở header)
        document.querySelectorAll('.qty-input').forEach(input => {
            totalItems += parseInt(input.value);
        });

        // Cập nhật giao diện
        const finalPriceEl = document.querySelector('.final-price');
        const cartCountEl = document.querySelector('.cart-count');

        if (finalPriceEl) finalPriceEl.innerText = formatMoney(total);
        if (cartCountEl) cartCountEl.innerText = `(${totalItems} sản phẩm)`;
    }

    // ---  XỬ LÝ NÚT TĂNG GIẢM SỐ LƯỢNG (+ / -) ---

    // Hàm xử lý chung cho việc đổi số lượng
    function handleQuantityChange(btn, isIncrease) {
        const key = btn.getAttribute('data-key');
        const input = document.querySelector(`.qty-input[data-key="${key}"]`);
        let currentQty = parseInt(input.value);

        // Tính toán số lượng mới
        let newQty = isIncrease ? currentQty + 1 : currentQty - 1;
        if (newQty < 1) newQty = 1; // Không cho giảm dưới 1

        // 1. Cập nhật giao diện (Số lượng & Thành tiền dòng đó)
        input.value = newQty;
        
        const checkbox = document.querySelector(`.item-checkbox[data-key="${key}"]`);
        const price = parseFloat(checkbox.getAttribute('data-price'));
        const rowTotalEl = document.querySelector(`#item-${key} .item-total`);
        
        if (rowTotalEl) {
            rowTotalEl.innerText = formatMoney(price * newQty);
        }

        // 2. Tính lại tổng tiền cả giỏ
        updateCartTotal();

        // 3. Gửi AJAX để lưu vào Session (Backend)
        // Dùng FormData để gửi dữ liệu dạng POST
        const formData = new FormData();
        formData.append('action', 'update');
        formData.append('key', key);
        formData.append('qty', newQty);

        fetch('xuly_giohang.php', {
            method: 'POST',
            body: formData
        }).catch(err => console.error('Lỗi cập nhật session:', err));
    }

    // Gắn sự kiện click cho tất cả nút tăng/giảm
    document.querySelectorAll('.btn-increase').forEach(btn => {
        btn.addEventListener('click', function() { handleQuantityChange(this, true); });
    });

    document.querySelectorAll('.btn-decrease').forEach(btn => {
        btn.addEventListener('click', function() { handleQuantityChange(this, false); });
    });

    // ---  XỬ LÝ CHECKBOX ---

    // Nút "Tất cả"
    const checkAll = document.getElementById('check-all');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');

    if (checkAll) {
        checkAll.addEventListener('change', function() {
            const isChecked = this.checked;
            itemCheckboxes.forEach(chk => {
                chk.checked = isChecked;
            });
            updateCartTotal(); // Tính lại tiền
        });
    }

    // Checkbox từng món
    itemCheckboxes.forEach(chk => {
        chk.addEventListener('change', updateCartTotal);
    });


    
});


