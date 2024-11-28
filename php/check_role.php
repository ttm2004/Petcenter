<?php
session_start();

if (!isset($_SESSION['role'])) {
    header(header: 'Location: ../login.html'); // Nếu chưa đăng nhập, chuyển đến trang login
    exit();
}
?>
