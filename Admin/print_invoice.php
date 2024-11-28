<?php
include '../php/connect.php';

$maDonChamSoc = $_GET['MaDonChamSoc'] ?? null;
$updateSuccessful = false;

if (!$maDonChamSoc) {
    die("Không có mã đơn chăm sóc");
}

// Kiểm tra xem có yêu cầu cập nhật trạng thái không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentMethod = $_POST['payment_method'] ?? 'cash';

    // Tính tổng giá dịch vụ
    $query = "SELECT GiaTien FROM DichVu INNER JOIN DonChamSoc ON DonChamSoc.MaDichVu = DichVu.MaDichVu WHERE DonChamSoc.MaDonChamSoc = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $maDonChamSoc);
    $stmt->execute();
    $result = $stmt->get_result();
    $totalPrice = 0;

    while ($row = $result->fetch_assoc()) {
        $totalPrice += $row['GiaTien'];
    }

    // Cập nhật trạng thái đơn chăm sóc
    $updateQuery = "UPDATE DonChamSoc SET TinhTrangDon = 'Đã bàn giao', ChiPhi = ? WHERE MaDonChamSoc = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ds", $totalPrice, $maDonChamSoc);
    $updateSuccessful = $updateStmt->execute();

    // Cập nhật vị trí chuồng thú cưng
    if ($updateSuccessful) {
        $maThuCungQuery = "SELECT MaThuCung FROM DonChamSoc WHERE MaDonChamSoc = ?";
        $maThuCungStmt = $conn->prepare($maThuCungQuery);
        $maThuCungStmt->bind_param("s", $maDonChamSoc);
        $maThuCungStmt->execute();
        $result = $maThuCungStmt->get_result();
        $maThuCung = $result->fetch_assoc()['MaThuCung'];

        $updatePositionQuery = "UPDATE ThuCung SET ViTri = NULL WHERE MaThuCung = ?";
        $updatePositionStmt = $conn->prepare($updatePositionQuery);
        $updatePositionStmt->bind_param("s", $maThuCung);
        $updatePositionStmt->execute();

        $updatename = "UPDATE Chuong SET TrangThai = 'Trống' WHERE MaThuCung = ?";
        $updatenametmt = $conn->prepare($updatename);
        $updatenametmt->bind_param("s", $maThuCung);
        $updatenametmt->execute();
    }

    $updateStmt->close();
}

// Lấy thông tin hóa đơn
$query = "SELECT 
            DonChamSoc.MaDonChamSoc,
            KhachHang.HoTenKH,
            KhachHang.SoDienThoai,
            KhachHang.DiaChi,
            ThuCung.MaThuCung,
            ThuCung.TenThuCung,
            DichVu.TenDichVu,
            DichVu.GiaTien,
            DonChamSoc.TinhTrangDon
        FROM 
            DonChamSoc
        INNER JOIN 
            KhachHang ON DonChamSoc.MaKH = KhachHang.MaKH
        INNER JOIN 
            ThuCung ON DonChamSoc.MaThuCung = ThuCung.MaThuCung
        INNER JOIN 
            DichVu ON DonChamSoc.MaDichVu = DichVu.MaDichVu
        WHERE 
            DonChamSoc.MaDonChamSoc = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $maDonChamSoc);
$stmt->execute();
$result = $stmt->get_result();
$invoiceData = $result->fetch_all(MYSQLI_ASSOC);

$totalPrice = 0;
foreach ($invoiceData as $item) {
    $totalPrice += $item['GiaTien'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa Đơn Dịch Vụ</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #payment-info {
            display: none;
        }
    </style>
    <script>
        function togglePaymentInfo() {
            var paymentMethod = document.getElementById("payment_method").value;
            var paymentInfo = document.getElementById("payment-info");
            if (paymentMethod === "atm") {
                paymentInfo.style.display = "block";
            } else {
                paymentInfo.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h2>Hóa Đơn Dịch Vụ</h2>
            </div>
            <div class="card-body">
                <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($invoiceData[0]['HoTenKH']); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($invoiceData[0]['SoDienThoai']); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($invoiceData[0]['DiaChi']); ?></p>

                <table class="table table-bordered mt-3">
                    <thead class="thead-light">
                        <tr>
                            <th>Dịch vụ</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoiceData as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['TenDichVu']); ?></td>
                                <td><?php echo number_format($item['GiaTien'], 0, ',', '.'); ?> VND</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Tổng tiền</th>
                            <th><?php echo number_format($totalPrice, 0, ',', '.'); ?> VND</th>
                        </tr>
                    </tfoot>
                </table>
                
                <div class="form-group">
                    <label for="payment_method">Phương thức thanh toán:</label>
                    <select class="form-control" id="payment_method" name="payment_method" onchange="togglePaymentInfo()">
                        <option value="cash">Tiền mặt</option>
                        <option value="atm">Thanh toán qua ATM</option>
                    </select>
                </div>

                <div id="payment-info">
                    <h5>Thông tin thanh toán qua ATM</h5>
                    <p>Tên ngân hàng: <strong>Vietcombank</strong></p>
                    <p>Số tài khoản: <strong>123456789</strong></p>
                    <p>Chủ tài khoản: <strong>Trần Trọng Mạnh</strong></p>
                    <!-- Thay thế bằng mã QR thực tế -->
                    <img src="../Image/stk.png" alt="Mã QR" class="img-fluid w-25" />
                </div>
                
                <div class="text-center mt-4">
                    <form method="POST">
                        <button type="submit" class="btn btn-primary" onclick="window.print()">In hóa đơn</button>
                    </form>
                </div>
            </div>
            <div class="card-footer text-muted text-center">
                <p>Ngày in hóa đơn: <?php echo date('d/m/Y'); ?></p>
            </div>
        </div>
    </div>

    <?php
    if ($updateSuccessful) {
        echo "<script>alert('Đã cập nhật trạng thái bàn giao thú cưng và chi phí thành công.');</script>";
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<script>alert('Cập nhật trạng thái hoặc chi phí thất bại.');</script>";
    }

    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
