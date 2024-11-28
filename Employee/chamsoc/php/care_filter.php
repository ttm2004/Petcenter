<?php
session_start();
include('php/connect.php');

// Lấy mã nhân viên dựa trên `username` đã lưu trong session
$username = $_SESSION['username'];
$sql = "SELECT MaNV FROM NhanVien WHERE Username = ?";
$stmt = $conn->prepare($sql);

// Kiểm tra lỗi câu truy vấn SQL
if ($stmt === false) {
    die("Lỗi trong câu truy vấn: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $maNV = $row['MaNV']; // Mã nhân viên của người đăng nhập
} else {
    die("Không tìm thấy mã nhân viên cho tài khoản này.");
}

// Xác định trạng thái đơn từ URL (chua-cham-soc, dang-cham-soc, da-cham-soc)
$status = isset($_GET['status']) ? $_GET['status'] : 'tat-ca';

// Ánh xạ trạng thái sang giá trị trong bảng
$statusMapping = [
    'dang-xu-ly' => 'Chưa chăm sóc',
    'dang-cham-soc' => 'Đang chăm sóc',
    'da-cham-soc' => 'Đã chăm sóc'
];

// Truy vấn SQL cho các đơn dựa trên trạng thái
$sql2 = "SELECT 
            DonChamSoc.MaDonChamSoc,
            KhachHang.MaKH, 
            KhachHang.HoTenKH, 
            GROUP_CONCAT(DISTINCT ThuCung.MaThuCung SEPARATOR ', ') AS MaThuCung,
            GROUP_CONCAT(DISTINCT ThuCung.TenThuCung SEPARATOR ', ') AS TenThuCung,
            GROUP_CONCAT(DISTINCT DichVu.TenDichVu SEPARATOR ', ') AS TenDichVu,
            NhanVien.HoTenNV,
            NhanVien.MaNV,
            DonChamSoc.TinhTrangDon
        FROM 
            PhanCong
        INNER JOIN
            DonChamSoc ON PhanCong.MaDonChamSoc = DonChamSoc.MaDonChamSoc
        INNER JOIN
            NhanVien ON PhanCong.MaNV = NhanVien.MaNV
        LEFT JOIN 
            ThuCung ON PhanCong.MaThuCung = ThuCung.MaThuCung
        LEFT JOIN 
            KhachHang ON DonChamSoc.MaKH = KhachHang.MaKH
        LEFT JOIN
            DichVu ON PhanCong.MaDichVu = DichVu.MaDichVu
        WHERE 
            PhanCong.MaNV = ?";

// Nếu trạng thái hợp lệ, thêm điều kiện WHERE cho trạng thái
if (isset($statusMapping[$status])) {
    $sql2 .= " AND DonChamSoc.TinhTrangDon = ?";
}

// Thêm GROUP BY và ORDER BY
$sql2 .= " GROUP BY DonChamSoc.MaDonChamSoc ORDER BY DonChamSoc.NgayTaoDon DESC";

// Chuẩn bị và thực thi truy vấn
$stmt2 = $conn->prepare($sql2);

// Ràng buộc các tham số dựa trên trạng thái
if (isset($statusMapping[$status])) {
    $stmt2->bind_param("is", $maNV, $statusMapping[$status]);
} else {
    $stmt2->bind_param("i", $maNV);
}

$stmt2->execute();
$result2 = $stmt2->get_result();

?>
