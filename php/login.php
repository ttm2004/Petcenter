<?php
session_start();
require("../php/data_care.php");
// Dữ liệu người dùng giả lập
$users = [
    'admin' => ['password' => 'admin123', 'role' => 'admin'],
    'employee' => ['password' => 'emp123', 'role' => 'employee'],
    'customer' => ['password' => 'cust123', 'role' => 'customer']
];

// Lấy thông tin đăng nhập từ form
$username = $_POST['username'];
$password = $_POST['password'];

// Kiểm tra thông tin đăng nhập
if (isset($users[$username]) && $users[$username]['password'] === $password) {
    $_SESSION['role'] = $users[$username]['role'];
    
    // Điều hướng theo vai trò
    if ($_SESSION['role'] === 'admin') {
        header('Location: ../admin.html');
    } elseif ($_SESSION['role'] === 'employee') {
        header('Location: ../employee.html');
    } else {
        header('Location: ../customer.html');
    }
} else {
    echo "Sai tên đăng nhập hoặc mật khẩu!";
}
?>
