<?php
session_start();

// Kết nối tới cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "petcenter");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy mã đơn chăm sóc từ URL
if (!isset($_GET['MaDonChamSoc'])) {
    die("Không tìm thấy mã đơn chăm sóc.");
}

$maDonChamSoc = $_GET['MaDonChamSoc'];

// Kiểm tra giá trị của $maDonChamSoc
if (empty($maDonChamSoc)) {
    die("Mã đơn chăm sóc không hợp lệ.");
}

// Truy vấn để lấy danh sách nhân viên có cùng mã dịch vụ với mã dịch vụ trong đơn chăm sóc
$sql = "SELECT MaNV, HoTenNV, MaDichVu FROM NhanVien
        WHERE MaDichVu = (SELECT MaDichVu FROM DonChamSoc WHERE MaDonChamSoc = ?)";
$stmt = $conn->prepare($sql);

// Kiểm tra nếu prepare thất bại
if ($stmt === false) {
    die("Lỗi trong câu truy vấn: " . $conn->error);
}

$stmt->bind_param("s", $maDonChamSoc);
$stmt->execute();
$result = $stmt->get_result();

// Lưu kết quả vào mảng để sử dụng trong HTML
$nhanVienList = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nhanVienList[] = $row;
    }
} else {
    // echo "Không tìm thấy nhân viên nào cho dịch vụ này.";
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân Công Người Chăm Sóc</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Phân Công Người Chăm Sóc Cho Thú Cưng</h2>
        <form action="assign-caregiver-process.php" method="POST">
            <input type="hidden" name="MaDonChamSoc" value="<?php echo htmlspecialchars($maDonChamSoc); ?>">
            <div class="form-group">
                <label for="MaNV">Chọn nhân viên:</label>
                <select class="form-control" id="MaNV" name="MaNV" required>
                    <?php if (!empty($nhanVienList)): ?>
                        <?php foreach ($nhanVienList as $nhanVien): ?>
                            <option value="<?php echo htmlspecialchars($nhanVien['MaNV']); ?>">
                                <?php echo htmlspecialchars($nhanVien['HoTenNV']) . htmlspecialchars($nhanVien['MaNV']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option disabled>Không có nhân viên nào để chọn</option>
                    <?php endif; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Phân công</button>
            <a href="details-invoice.php?MaDonChamSoc=<?php echo htmlspecialchars($maDonChamSoc); ?>" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</body>

</html>
