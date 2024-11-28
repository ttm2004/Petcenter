<?php
include 'connect.php';

// Lấy dữ liệu từ yêu cầu AJAX
$data = json_decode(file_get_contents('php://input'), true);
$maDonChamSoc = $data['MaDonChamSoc'];
$tinhTrangDon = $data['TinhTrangDon'];

// Chuẩn bị câu truy vấn cập nhật
$sql = "UPDATE DonChamSoc SET TinhTrangDon = ? WHERE MaDonChamSoc = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $tinhTrangDon, $maDonChamSoc);

// Thực thi truy vấn
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}
?>
