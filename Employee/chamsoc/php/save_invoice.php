<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "petcenter");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Không thể kết nối cơ sở dữ liệu']));
}

// Lấy dữ liệu JSON từ frontend
$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra dữ liệu
if (!$data || empty($data['maDonChamSoc']) || empty($data['items'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
    exit;
}

// Thêm hóa đơn vào bảng `HoaDon`
$stmtInvoice = $conn->prepare("
    INSERT INTO HoaDon (MaDonChamSoc, TongTien, NgayLap) 
    VALUES (?, ?, NOW())
");
$stmtInvoice->bind_param(
    "sd",
    $data['maDonChamSoc'],
    $data['totalPrice']
);

if ($stmtInvoice->execute()) {
    $invoiceId = $stmtInvoice->insert_id; // Lấy mã hóa đơn vừa thêm

    // Thêm từng dịch vụ/sản phẩm vào bảng `ChiTietHoaDon`
    $stmtDetail = $conn->prepare("
        INSERT INTO ChiTietHoaDon (MaHoaDon, MaDichVu, MaSP, SoLuong, Gia) 
        VALUES (?, ?, ?, ?, ?)
    ");
    foreach ($data['items'] as $item) {
        $maDichVu = $item['type'] === 'service' ? $item['id'] : null; // Nếu là dịch vụ
        $maSP = $item['type'] === 'product' ? $item['id'] : null; // Nếu là sản phẩm
        $quantity = $item['quantity'];
        $price = $item['price'];

        $stmtDetail->bind_param(
            "iisid",
            $invoiceId,
            $maDichVu,
            $maSP,
            $quantity,
            $price
        );
        $stmtDetail->execute();
    }

    // Cập nhật tình trạng đơn thành "Đã in hóa đơn"
    $stmtUpdateStatus = $conn->prepare("
        UPDATE DonChamSoc
        SET TinhTrangDon = 'Đã in hóa đơn'
        WHERE MaDonChamSoc = ?
    ");
    $stmtUpdateStatus->bind_param("s", $data['maDonChamSoc']);
    if ($stmtUpdateStatus->execute()) {
        echo json_encode(['success' => true, 'message' => 'Hóa đơn đã được lưu và cập nhật tình trạng đơn']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Hóa đơn đã được lưu nhưng không thể cập nhật tình trạng đơn']);
    }
    $stmtUpdateStatus->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Không thể lưu hóa đơn']);
}

$stmtInvoice->close();
$conn->close();
?>
