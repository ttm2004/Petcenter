<?php
header('Content-Type: application/json');

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "petcenter");
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Kết nối cơ sở dữ liệu thất bại.']);
    exit;
}

// Lấy danh sách chuồng và trạng thái của từng chuồng
$sql = "SELECT MaChuong, TenChuong, TrangThai FROM Chuong";
$result = $conn->query($sql);

$chuongList = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chuongList[] = $row;
    }
}

echo json_encode($chuongList);

$conn->close();
?>
