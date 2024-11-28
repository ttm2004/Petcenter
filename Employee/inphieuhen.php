<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "petcenter");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra nếu có yêu cầu lưu và chuyển hướng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['MaDonChamSoc'])) {
    $maDonChamSoc = $_POST['MaDonChamSoc'];

    // Thực hiện lưu vào bảng LichHen
    $sql_insert = "INSERT INTO LichHen (MaDonChamSoc, NgayIn) VALUES (?, NOW())";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("s", $maDonChamSoc);

    if ($stmt_insert->execute()) {
        // Chuyển hướng sau khi lưu thành công
        header("Location: nhanthucung.php?MaDonChamSoc=" . $maDonChamSoc);
        exit;
    } else {
        echo "Lỗi: " . $stmt_insert->error;
    }
    $stmt_insert->close();
    $conn->close();
    exit; // Kết thúc script sau khi xử lý POST
}

// Nếu không có yêu cầu POST, thực hiện hiển thị trang
if (!isset($_GET['MaDonChamSoc'])) {
    die("<div class='alert alert-danger'>Không tìm thấy mã đơn chăm sóc.</div>");
}

$maDonChamSoc = $_GET['MaDonChamSoc'];

// Truy vấn lấy thông tin chi tiết đơn chăm sóc và khách hàng
$sql = "SELECT 
            DonChamSoc.MaDonChamSoc,
            KhachHang.MaKH,
            KhachHang.HoTenKH,
            KhachHang.DiaChi,
            KhachHang.SoDienThoai,
            KhachHang.Email,
            ThuCung.MaThuCung,
            ThuCung.TenThuCung,
            ThuCung.LoaiThuCung,
            LoaiThuCung.TenLoaiThuCung,
            ThuCung.MauSac,
            ThuCung.CanNang,
            ThuCung.HinhAnh,
            ThuCung.ViTri,
            ThuCung.NgayTiepNhan,
            ThuCung.GhiChu AS GhiChuThuCung,
            DonChamSoc.NgayBatDau,
            DonChamSoc.NgayKetThuc,
            DichVu.TenDichVu,
            DonChamSoc.TinhTrangDon,
            DonChamSoc.ChiPhi,
            DonChamSoc.GhiChu AS GhiChuDon,
            DonChamSoc.NgayTaoDon,
            NhanVien.HoTenNV
        FROM 
            DonChamSoc
        INNER JOIN 
            KhachHang ON DonChamSoc.MaKH = KhachHang.MaKH
        LEFT JOIN 
            ThuCung ON DonChamSoc.MaDonChamSoc = ThuCung.MaDonChamSoc
        LEFT JOIN 
            LoaiThuCung ON ThuCung.MaLoaiThuCung = LoaiThuCung.MaLoaiThuCung
        LEFT JOIN
            DichVu ON ThuCung.MaDichVu = DichVu.MaDichVu
        LEFT JOIN
            PhanCong ON DonChamSoc.MaDonChamSoc = PhanCong.MaDonChamSoc
        LEFT JOIN
            NhanVien ON PhanCong.MaNV = NhanVien.MaNV
        WHERE 
            DonChamSoc.MaDonChamSoc = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $maDonChamSoc);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $customer_info = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phiếu Hẹn</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .container { max-width: 600px; }
        @media print { .no-print { display: none; } }
    </style>
    <script type="text/javascript">
        function confirmPrint() {
            if (confirm("Bạn có chắc chắn muốn in phiếu hẹn?")) {
                window.print();
                document.getElementById("saveForm").submit(); // Gửi biểu mẫu sau khi in
            }
        }
    </script>
</head>
<body class="bg-gray-100 p-4 flex justify-center">
    <div class="container bg-white shadow-lg rounded-lg p-6 mb-8">
        <div class="text-center mb-4">
            <h1 class="text-2xl font-bold text-blue-500">Phiếu Hẹn</h1>
            <p class="text-gray-600">Đơn chăm sóc mã: <?php echo htmlspecialchars($customer_info['MaDonChamSoc']); ?></p>
        </div>
        <div class="info-section mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Thông tin khách hàng</h3>
            <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($customer_info['HoTenKH']); ?></p>
            <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($customer_info['DiaChi']); ?></p>
            <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($customer_info['SoDienThoai']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($customer_info['Email']); ?></p>
        </div>
        <div class="info-section mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Thông tin thú cưng và đơn chăm sóc</h3>
            <?php do { ?>
                <div class="border-t border-gray-300 pt-4 mt-4">
                    <p><strong>Tên thú cưng:</strong> <?php echo htmlspecialchars($customer_info['TenThuCung']); ?></p>
                    <p><strong>Loại thú cưng:</strong> <?php echo htmlspecialchars($customer_info['TenLoaiThuCung']); ?></p>
                    <p><strong>Màu sắc:</strong> <?php echo htmlspecialchars($customer_info['MauSac']); ?></p>
                    <p><strong>Ngày nhận:</strong> <?php echo htmlspecialchars($customer_info['NgayBatDau']); ?></p>
                    <p><strong>Ngày kết thúc:</strong> <?php echo htmlspecialchars($customer_info['NgayKetThuc']); ?></p>
                    <p><strong>Dịch vụ:</strong> <?php echo htmlspecialchars($customer_info['TenDichVu']); ?></p>
                </div>
            <?php } while ($customer_info = $result->fetch_assoc()); ?>
        </div>
        <div class="text-center no-print mt-6">
            <!-- Biểu mẫu để gửi dữ liệu lưu -->
            <form id="saveForm" method="POST" action="inphieuhen.php">
                <input type="hidden" name="MaDonChamSoc" value="<?php echo $maDonChamSoc; ?>">
                <button type="button" onclick="confirmPrint()" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow-md">In phiếu hẹn</button>
            </form>
        </div>
    </div>

</body>
</html>
<?php
} else {
    echo "<div class='alert alert-danger'>Không tìm thấy chi tiết phiếu hẹn.</div>";
}
?>
