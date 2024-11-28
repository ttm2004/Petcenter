<?php
session_start();
include 'php/check_role.php';

// Kiểm tra nếu người dùng không phải là admin
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản trị viên</title>
</head>
<body>
    <h1>Chào mừng, Quản trị viên!</h1>
    
</body>
</html>
