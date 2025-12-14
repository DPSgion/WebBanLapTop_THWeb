// Mở modal khi nhấn nút "TIẾN HÀNH ĐẶT HÀNG"
document.addEventListener('DOMContentLoaded', function() {
    const btnOpenModal = document.getElementById('btn-open-modal');
    const modal = document.getElementById('checkout-modal');
    const closeModal = document.querySelector('.close-modal');
    const btnCancel = document.querySelector('.btn-cancel');

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

    
});

