<?php
$servername = "localhost"; // Tên máy chủ MySQL (thường là localhost)
$username = "root"; // Tên tài khoản MySQL
$password = ""; // Mật khẩu (thường để trống nếu là localhost)
$dbname = "petcenter"; // Tên database mà bạn muốn kết nối

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);


// Kiểm tra kêt nối 
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}



?>