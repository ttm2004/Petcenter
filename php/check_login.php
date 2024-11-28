<?php
// Kết nối cơ sở dữ liệu
session_start();
include('connect.php');

// Hàm kiểm tra thông tin đăng nhập
function checkLogin($username, $password) {
    global $conn;

    // Sử dụng Prepared Statements để tránh SQL Injection
    $stmt = $conn->prepare("SELECT * FROM info_user WHERE user = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    // Lấy kết quả từ câu truy vấn
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // So sánh mật khẩu với mật khẩu trong database (giả sử bạn đã mã hóa mật khẩu)
        if (password_verify($password, $user['password'])) {
            // Nếu mật khẩu đúng, trả về thông tin người dùng
            return $user;
        } else {
            return false; // Mật khẩu không khớp
        }
    } else {
        return false; // Không tìm thấy người dùng
    }
}

// Ví dụ sử dụng hàm checkLogin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Gọi hàm kiểm tra thông tin đăng nhập
    $user = checkLogin($username, $password);

    if ($user) {
        header("location: ../Home/index.php");
    } else {
        $message = "Sai tên đăng nhập hoặc mật khẩu!";
    }
}
?>
