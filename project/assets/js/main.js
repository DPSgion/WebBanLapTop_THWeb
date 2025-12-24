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

    
});


