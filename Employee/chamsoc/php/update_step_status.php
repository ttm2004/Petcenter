<?php
include('connect.php');  // Kết nối cơ sở dữ liệu

if (isset($_POST['MaDonChamSoc']) && isset($_POST['MaBuoc'])) {
    $maDonChamSoc = $_POST['MaDonChamSoc'];
    $maBuoc = $_POST['MaBuoc'];
    error_log("Mã đơn chăm sóc: " . $maDonChamSoc);
    error_log("Mã bước: " . $maBuoc);

    // Kiểm tra xem bước đã có trong bảng QuaTrinhChamsoc chưa
    $queryCheck = "SELECT * FROM QuaTrinhChamsoc WHERE MaDonChamSoc = ? AND MaBuoc = ?";
    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bind_param("si", $maDonChamSoc, $maBuoc);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    
    if ($resultCheck->num_rows > 0) {
        // Cập nhật trạng thái thành 'Đã hoàn thành'
        $queryUpdate = "UPDATE QuaTrinhChamsoc SET TrangThai = 'Đã hoàn thành', ThoiGianKetThuc = NOW() WHERE MaDonChamSoc = ? AND MaBuoc = ?";
    } else {
        // Thêm mới bước với trạng thái 'Đã hoàn thành'
        $queryUpdate = "INSERT INTO QuaTrinhChamsoc (MaDonChamSoc, MaBuoc, TrangThai, ThoiGianBatDau, ThoiGianKetThuc)
                        VALUES (?, ?, 'Đã hoàn thành', NOW(), NOW())";
    }
    
    $stmtUpdate = $conn->prepare($queryUpdate);
    $stmtUpdate->bind_param("si", $maDonChamSoc, $maBuoc);
    
    if ($stmtUpdate->execute()) {
        // Kiểm tra xem tất cả các bước trong đơn chăm sóc đã hoàn thành chưa
        $queryCheckAllSteps = "SELECT COUNT(*) AS TotalSteps, 
                                      SUM(CASE WHEN TrangThai = 'Đã hoàn thành' THEN 1 ELSE 0 END) AS CompletedSteps 
                               FROM QuaTrinhChamsoc 
                               WHERE MaDonChamSoc = ?";
        $stmtCheckAllSteps = $conn->prepare($queryCheckAllSteps);
        $stmtCheckAllSteps->bind_param("s", $maDonChamSoc);
        $stmtCheckAllSteps->execute();
        $resultCheckAllSteps = $stmtCheckAllSteps->get_result()->fetch_assoc();

        if ($resultCheckAllSteps['TotalSteps'] > 0 && $resultCheckAllSteps['TotalSteps'] == $resultCheckAllSteps['CompletedSteps']) {
            // Nếu tất cả các bước đã hoàn thành, cập nhật trạng thái đơn chăm sóc thành 'Đã chăm sóc'
            $queryUpdateOrderStatus = "UPDATE DonChamSoc SET TinhTrangDon = 'Đã chăm sóc' WHERE MaDonChamSoc = ?";
            $stmtUpdateOrderStatus = $conn->prepare($queryUpdateOrderStatus);
            $stmtUpdateOrderStatus->bind_param("s", $maDonChamSoc);
            $stmtUpdateOrderStatus->execute();
        }
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    error_log("Không nhận được tham số MaDonChamSoc hoặc MaBuoc");
    echo 'error';
}
?>
