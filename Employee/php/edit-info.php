<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../Auth/login_register.php");
    exit();
}

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "petcenter";

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_POST['save_changes'])) {
    // Lấy dữ liệu từ form
    $maNV = $_POST['MaNV'];
    $hoTenNV = $_POST['HoTenNV'];
    $ngaySinh = $_POST['NgaySinh'];
    $gioiTinh = $_POST['GioiTinh'];
    $diaChi = $_POST['DiaChi'];
    $soDienThoai = $_POST['SoDienThoai'];
    $email = $_POST['Email'];
    $soCMND = $_POST['SoCMND'];
    $ngayCapCMND = $_POST['NgayCapCMND'];
    $noiCapCMND = $_POST['NoiCapCMND'];

    // Câu lệnh SQL để cập nhật thông tin nhân viên
    $query = "UPDATE nhanvien SET
                HoTenNV = ?, 
                NgaySinh = ?, 
                GioiTinh = ?, 
                DiaChi = ?, 
                SoDienThoai = ?, 
                Email = ?, 
                SoCMND = ?, 
                NgayCapCMND = ?, 
                NoiCapCMND = ?
              WHERE MaNV = ?"; // 10 dấu ? ở đây

    // Chuẩn bị và thực thi câu lệnh SQL
    if ($stmt = $conn->prepare($query)) {
        // Gán tham số
        $stmt->bind_param(
            "sssssssssi",  // 10 tham số
            $hoTenNV,
            $ngaySinh,
            $gioiTinh,
            $diaChi,
            $soDienThoai,
            $email,
            $soCMND,
            $ngayCapCMND,
            $noiCapCMND,
            $maNV
        );

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            // Cập nhật thành công
            echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='../table-data-table.php';</script>"; // Đổi your_redirect_page.php thành trang bạn muốn chuyển hướng tới
        } else {
            // Thất bại khi cập nhật
            echo "<script>alert('Có lỗi xảy ra khi cập nhật thông tin.');</script>";
        }

        // Đóng câu lệnh
        $stmt->close();
    } else {
        // Lỗi trong quá trình chuẩn bị câu lệnh
        echo "<script>alert('Có lỗi xảy ra trong quá trình chuẩn bị câu lệnh.');</script>";
    }
}

// Đóng kết nối
$conn->close();
?>
