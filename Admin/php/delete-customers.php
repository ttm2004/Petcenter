<?php
// Kết nối đến cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root', '', 'petcenter');

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Nhận dữ liệu từ request
$data = json_decode(file_get_contents("php://input"), true);
$ids = $data['ids'];

// Kiểm tra xem có ID nào không
if (empty($ids)) {
    echo json_encode(['success' => false, 'message' => 'Không có ID nào để xóa.']);
    exit;
}

// Tạo truy vấn xóa
$idList = implode(',', array_map('intval', $ids));
$query = "DELETE FROM KhachHang WHERE MaKH IN ($idList)";
if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>

