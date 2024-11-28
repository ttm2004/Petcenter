<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost"; // Thay đổi nếu cần
$username = "root"; // Thay đổi nếu cần
$password = ""; // Thay đổi nếu cần
$dbname = "petcenter"; // Thay đổi nếu cần

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ yêu cầu POST
$tongTien = isset($_POST['TongTien']) ? floatval($_POST['TongTien']) : 0; // Chuyển đổi thành số thực
$giamGia = isset($_POST['GiamGia']) ? floatval($_POST['GiamGia']) : 0; // Chuyển đổi thành số thực
$hinhThucThanhToan = $_POST['HinhThucThanhToan'] ?? '';
$ghiChu = $_POST['GhiChu'] ?? '';
$ngayBan = date('Y-m-d H:i:s');
$sanPhamBan = json_decode($_POST['SanPham'], true) ?? []; 

// Tạo mã hóa đơn ngẫu nhiên
$maHD = 'HD' . strtoupper(bin2hex(random_bytes(4)));

// Lưu thông tin hóa đơn vào bảng hoadon
$sql = "INSERT INTO hoadonsp (MaHoaDon, NgayBan, HinhThucThanhToan, TongTien, GhiChu, GiamGia) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssddss", $maHD, $ngayBan, $hinhThucThanhToan, $tongTien, $ghiChu, $giamGia); // Sử dụng 'd' cho kiểu decimal

if ($stmt->execute() === TRUE) {
    // Lưu thông tin chi tiết hóa đơn vào bảng chitiethoadon
    $sqlChiTiet = "INSERT INTO chitiethoadon (MaHoaDon, MaSP, SoLuong, Gia) VALUES (?, ?, ?, ?)";
    $stmtChiTiet = $conn->prepare($sqlChiTiet);

    // Lặp qua từng sản phẩm trong danh sách sản phẩm được bán
    foreach ($sanPhamBan as $sanPham) {
        $maSP = $sanPham['ma'] ?? ''; // Mã sản phẩm (giả định có trường 'ma')
        $soLuong = isset($sanPham['soluong']) ? intval($sanPham['soluong']) : 0; // Chuyển đổi thành số nguyên
        $gia = isset($sanPham['gia']) ? floatval($sanPham['gia']) : 0; // Chuyển đổi thành số thực

        // Kiểm tra xem thông tin sản phẩm có hợp lệ không
        if (!empty($maSP) && $soLuong > 0 && $gia >= 0) {
            $stmtChiTiet->bind_param("ssdi", $maHD, $maSP, $soLuong, $gia); // Sử dụng 'i' cho số nguyên và 'd' cho kiểu decimal
            $stmtChiTiet->execute();
        } else {
            echo "<script>alert('Thông tin sản phẩm không hợp lệ!'); window.history.back();</script>";
            exit();
        }
    }

    echo "<script>alert('Hóa đơn đã được lưu thành công!')";
} else {
    echo "<script>alert('Có lỗi xảy ra khi lưu hóa đơn: " . $conn->error . "'); window.history.back();</script>";
}

$stmt->close();
$stmtChiTiet->close(); // Đóng statement chi tiết hóa đơn
$conn->close();
