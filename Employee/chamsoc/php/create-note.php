<?php
$servername = "localhost"; // hoặc địa chỉ máy chủ của bạn
$dbUsername = "root"; // tên đăng nhập của cơ sở dữ liệu
$dbPassword = ""; // mật khẩu của cơ sở dữ liệu
$dbname = "petcenter"; // tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

$username = $_SESSION['username'];
$hoten = "SELECT HoTenNV FROM NhanVien WHERE Username = '$username'";
$result_hoten = mysqli_query($conn, $hoten);

$row_hoten = mysqli_fetch_assoc($result_hoten);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maDonChamSoc = $_POST['MaDonChamSoc'];
    $note = $_POST['note'];
    $maNV = $row_hoten; // Lấy mã nhân viên từ phiên đăng nhập hoặc biến đã xác định

    $sql = "INSERT INTO ghichu (MaDonChamSoc, Note, MaNV , CreatedAt) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $maDonChamSoc, $note, $maNV);
    $stmt->execute();

    header("Location: ../details-invoice.php?MaDonChamSoc=" . $maDonChamSoc);
    // echo '<script>window.location.reload();</script>';
    exit();
}
