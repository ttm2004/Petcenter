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

// Nếu form đã được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phanCongData = $_POST['phanCong'];
    
    foreach ($phanCongData as $maThuCung => $maNV) {
        if (!empty($maNV)) {
            // Lấy MaDichVu của từng thú cưng từ bảng ThuCung
            $sql_maDichVu = "SELECT MaDichVu FROM ThuCung WHERE MaThuCung = ?";
            $stmt_maDichVu = $conn->prepare($sql_maDichVu);
            $stmt_maDichVu->bind_param("s", $maThuCung);
            $stmt_maDichVu->execute();
            $result_maDichVu = $stmt_maDichVu->get_result();

            if ($result_maDichVu->num_rows > 0) {
                $row = $result_maDichVu->fetch_assoc();
                $maDichVu = $row['MaDichVu'];
            } else {
                die("Không tìm thấy dịch vụ cho thú cưng $maThuCung.");
            }
            $stmt_maDichVu->close();

            // Kiểm tra xem đã có nhân viên được phân công cho thú cưng này trong đơn chăm sóc chưa
            $sql = "SELECT * FROM PhanCong WHERE MaDonChamSoc = ? AND MaThuCung = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $maDonChamSoc, $maThuCung);
            $stmt->execute();
            $result = $stmt->get_result();

            // Nếu đã có nhân viên phân công, thì cập nhật; nếu chưa có, thì thêm mới
            if ($result->num_rows > 0) {
                // Cập nhật nhân viên chăm sóc cho thú cưng
                $sql_update = "UPDATE PhanCong SET MaNV = ?, NgayPhanCong = NOW() WHERE MaDonChamSoc = ? AND MaThuCung = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("sss", $maNV, $maDonChamSoc, $maThuCung);

                if ($stmt_update->execute()) {
                    $message = "Cập nhật nhân viên chăm sóc thành công cho thú cưng $maThuCung.";
                } else {
                    $message = "Lỗi khi cập nhật nhân viên: " . $stmt_update->error;
                }
                $stmt_update->close();
            } else {
                // Thêm mới bản ghi phân công cho thú cưng
                $sql_insert = "INSERT INTO PhanCong (MaPhanCong, MaDonChamSoc, MaNV, NgayPhanCong, MaThuCung, MaDichVu) 
                                VALUES (NULL, ?, ?, NOW(), ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);

                // Kiểm tra lỗi trong prepare
                if ($stmt_insert === false) {
                    die("Lỗi trong câu truy vấn INSERT: " . $conn->error);
                }

                $stmt_insert->bind_param("ssss", $maDonChamSoc, $maNV, $maThuCung, $maDichVu);

                if ($stmt_insert->execute()) {
                    $message = "Phân công nhân viên chăm sóc thành công cho thú cưng $maThuCung.";
                } else {
                    $message = "Lỗi khi phân công nhân viên: " . $stmt_insert->error;
                }
                $stmt_insert->close();
            }
            $stmt->close();
        }
    }
}

// Truy vấn để lấy danh sách thú cưng thuộc đơn chăm sóc này
$sql_thuCung = "SELECT MaThuCung, TenThuCung FROM ThuCung WHERE MaDonChamSoc = ?";
$stmt_thuCung = $conn->prepare($sql_thuCung);
$stmt_thuCung->bind_param("s", $maDonChamSoc);
$stmt_thuCung->execute();
$result_thuCung = $stmt_thuCung->get_result();

$thuCungList = [];
if ($result_thuCung->num_rows > 0) {
    while ($row = $result_thuCung->fetch_assoc()) {
        $thuCungList[] = $row;
    }
}

// Truy vấn để lấy danh sách nhân viên có cùng mã dịch vụ với mã dịch vụ trong đơn chăm sóc
$sql_nhanVien = "SELECT MaNV, HoTenNV FROM NhanVien WHERE MaDichVu IN (SELECT MaDichVu FROM ThuCung WHERE MaDonChamSoc = ?)";
$stmt_nhanVien = $conn->prepare($sql_nhanVien);
$stmt_nhanVien->bind_param("s", $maDonChamSoc);
$stmt_nhanVien->execute();
$result_nhanVien = $stmt_nhanVien->get_result();

$nhanVienList = [];
if ($result_nhanVien->num_rows > 0) {
    while ($row = $result_nhanVien->fetch_assoc()) {
        $nhanVienList[] = $row;
    }
}

// Đóng kết nối
$stmt_thuCung->close();
$stmt_nhanVien->close();
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
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="hidden" name="MaDonChamSoc" value="<?php echo htmlspecialchars($maDonChamSoc); ?>">

            <?php foreach ($thuCungList as $thuCung): ?>
                <div class="form-group">
                    <label for="phanCong_<?php echo $thuCung['MaThuCung']; ?>">Chọn nhân viên cho thú cưng: <?php echo htmlspecialchars($thuCung['TenThuCung']); ?></label>
                    <select class="form-control" id="phanCong_<?php echo $thuCung['MaThuCung']; ?>" name="phanCong[<?php echo $thuCung['MaThuCung']; ?>]" required>
                        <option value="">Chọn nhân viên</option>
                        <?php foreach ($nhanVienList as $nhanVien): ?>
                            <option value="<?php echo htmlspecialchars($nhanVien['MaNV']); ?>">
                                <?php echo htmlspecialchars($nhanVien['HoTenNV']) . ' (' . htmlspecialchars($nhanVien['MaNV']) . ')'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="btn btn-primary">Phân công</button>
            <a href="details-invoice.php?MaDonChamSoc=<?php echo htmlspecialchars($maDonChamSoc); ?>" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</body>

</html>
