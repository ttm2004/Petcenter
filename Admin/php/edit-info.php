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
              WHERE MaNV = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param(
            "sssssssssi",
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

        if ($stmt->execute()) {
            $_SESSION['status'] = "success";
            $_SESSION['message'] = "Cập nhật thông tin thành công!";
            header("Location: ../table-data-table.php"); 
        } else {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Có lỗi xảy ra khi cập nhật thông tin.";
        }

        $stmt->close();
    } else {
        $_SESSION['status'] = "error";
        $_SESSION['message'] = "Có lỗi xảy ra trong quá trình chuẩn bị câu lệnh.";
    }

    
}

$conn->close();
?>
