
// Không cho tìm từ khóa trống hoặc nhỏ hơn 2 ký tự
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('searchForm');
    const input = document.getElementById('searchInput');
    const wrapper = document.getElementById('inputWrapper');
    const errorMsg = document.getElementById('errorMsg');

    form.addEventListener('submit', function(e) {
        const value = input.value.trim();

        if (value.length > 0 && value.length <= 2) {
            e.preventDefault(); // Chặn gửi form
            
            // Hiện thông báo tiếng Việt
            errorMsg.innerText = "Từ khóa quá ngắn. Vui lòng nhập trên 2 ký tự!";
            errorMsg.classList.remove('hidden');
            
            // Đổi màu viền để cảnh báo
            wrapper.classList.add('border-red-500/50', 'bg-red-500/5');
            
        } else if (value.length === 0) {
            e.preventDefault();
            errorMsg.innerText = "Bạn chưa nhập từ khóa tìm kiếm!";
            errorMsg.classList.remove('hidden');
            wrapper.classList.add('border-red-500/50');
        } else {
            // Nếu hợp lệ thì ẩn lỗi (trong trường hợp dùng AJAX)
            errorMsg.classList.add('hidden');
            wrapper.classList.remove('border-red-500/50', 'bg-red-500/5');
        }
    });

    // Ẩn thông báo khi người dùng bắt đầu gõ lại
    input.addEventListener('input', function() {
        errorMsg.classList.add('hidden');
        wrapper.classList.remove('border-red-500/50', 'bg-red-500/5');
    });
});