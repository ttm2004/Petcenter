
// Hiển thị thông báo
function showNotification(message, isError = false) {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    if (isError) {
        notification.classList.add('error');
    } else {
        notification.classList.remove('error');
    }
    notification.style.display = 'block';

    // Ẩn thông báo sau 3 giây
    setTimeout(function() {
        notification.style.display = 'none';
    }, 3000);
}

// Kiểm tra nếu có thông báo từ URL
const urlParams = new URLSearchParams(window.location.search);
const message = urlParams.get('message');
if (message === 'updated') {
    showNotification('Cập nhật thành công!');
} else if (message === 'deleted') {
    showNotification('Xóa thành công!');
}




    // Khởi tạo datepicker
    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd"
    });
    $(document).ready(function () {
        $(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
    });

    // Hiển thị form thêm/sửa lịch làm việc
    $("#addScheduleBtn").click(function () {
        $("#scheduleForm").show();
    });

    // Hủy thao tác thêm/sửa
    $("#cancelEditBtn").click(function () {
        $("#scheduleForm").hide();
    });
