<?php
$servername = "localhost"; // hoặc địa chỉ máy chủ của bạn
$dbUsername = "root"; // tên đăng nhập của cơ sở dữ liệu
$dbPassword = ""; // mật khẩu của cơ sở dữ liệu
$dbname = "petcenter"; // tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
session_start();
$username = $_SESSION['username'];
$hoten = "SELECT HoTenNV, VaiTro FROM NhanVien WHERE Username = '$username'";
$result_hoten = mysqli_query($conn, $hoten);

if ($result_hoten && mysqli_num_rows($result_hoten) > 0) {
    $row_hoten = mysqli_fetch_assoc($result_hoten);
    if ($row_hoten["VaiTro"] == "LeTan") {
        $role = "Lễ Tân";
        echo "<p class='app-sidebar__user-name'><b>" . htmlspecialchars($row_hoten['HoTenNV']) . "</b></p>";
        echo "<p class='app-sidebar__user-name'><b>" . htmlspecialchars($role ). "</b></p>";
        echo "<p class='app-sidebar__user-designation'>Chào mừng bạn trở lại</p>";
    }
    
} else {
    echo "<p class='app-sidebar__user-name'><b>Không tìm thấy tên lễ tân</b></p>";
}
