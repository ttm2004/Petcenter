<?php
include '../php/connect.php';

// 1. Tổng số nhân viên
$sql_nv = "SELECT COUNT(*) AS total_nv FROM NhanVien";
$result_nv = $conn->query($sql_nv);
$total_nv = 0;
if ($result_nv) {
    $row_nv = $result_nv->fetch_assoc();
    $total_nv = $row_nv['total_nv'];
}

// 2. Số nhân viên mới trong tháng
$sql_nv_new = "SELECT COUNT(*) AS new_nv FROM nhanvien WHERE MONTH(NgayVaoLam) = MONTH(CURDATE()) AND YEAR(NgayVaoLam) = YEAR(CURDATE())";
$result_nv_new = $conn->query($sql_nv_new);
$new_nv = 0;
if ($result_nv_new) {
    $row_nv_new = $result_nv_new->fetch_assoc();
    $new_nv = $row_nv_new['new_nv'];
}

// 3. Tổng thu nhập theo ngày
$selected_date = date('Y-m-d'); // Lấy ngày hiện tại
if (isset($_GET['date'])) {
    $selected_date = $_GET['date']; // Lấy ngày từ form nếu có
}

$sql_income = "SELECT SUM(TongTien) AS total_income FROM hoadon WHERE DATE(NgayLap) = ?";
$stmt_income = $conn->prepare($sql_income);
$stmt_income->bind_param("s", $selected_date);
$stmt_income->execute();
$result_income = $stmt_income->get_result();
$total_income = 0;
if ($result_income) {
    $row_income = $result_income->fetch_assoc();
    $total_income = $row_income['total_income'] ?: 0; // Tổng doanh thu (hoặc 0 nếu không có)
}

// 4. Tổng số hóa đơn theo ngày
$sql_total_invoice = "SELECT COUNT(*) AS total_invoices FROM hoadon WHERE DATE(NgayLap) = ?";
$stmt_invoice = $conn->prepare($sql_total_invoice);
$stmt_invoice->bind_param("s", $selected_date);
$stmt_invoice->execute();
$result_invoice = $stmt_invoice->get_result();
$total_invoices = 0;
if ($result_invoice) {
    $row_invoice = $result_invoice->fetch_assoc();
    $total_invoices = $row_invoice['total_invoices'] ?: 0;
}

// 5. Tổng số đơn chăm sóc (câu lệnh gốc)
$sql = "SELECT COUNT(*) AS total_orders FROM thucung";
$result = $conn->query($sql);
$total_orders = 0;
if ($result) {
    $row = $result->fetch_assoc();
    $total_orders = $row['total_orders'];
}

// 6. Tổng số khách hàng (câu lệnh gốc)
$sql2 = "SELECT COUNT(*) AS total_kh FROM khachhang";
$result2 = $conn->query($sql2);
$total_kh = 0;
if ($result2) {
    $row2 = $result2->fetch_assoc();
    $total_kh = $row2['total_kh'];
}

// Tổng số nhân viên xin nghỉ và bị buộc thôi việc
$sql6 = "SELECT COUNT(*) AS total_nv_end
        FROM NhanVien
        WHERE TrangThai = 'Không Hoạt Động";
$result6 = $conn -> query($sql6);
$total_nv_end = 0;
if($result6){
    $row6 = $result6 -> fetch_assoc();
    $total_nv_end = $row6["total_nv_end"];
}


// 7. Tổng số sản phẩm (câu lệnh gốc)
$sql3 = "SELECT COUNT(*) AS total_sp FROM sanpham";
$result3 = $conn->query($sql3);
$total_products = 0;
if ($result3) {
    $row3 = $result3->fetch_assoc();
    $total_products = $row3['total_sp'];
}


$sql5 = "SELECT COUNT(*) AS total_sp_end 
        FROM SanPham
        WHERE SoLuong <= 50";
$result5 = $conn ->query($sql5);

$total_sp_end = 0;
if ($result5) {
    $row5 = $result5->fetch_assoc();
    $total_sp_end = $row5['total_sp_end'];
}

// 8. Lấy danh sách sản phẩm (câu lệnh gốc)
$sql4 = "SELECT MaSP, TenSP, Gia, SoLuong FROM sanpham";
$result4 = $conn->query($sql4);

$products4 = array();
if ($result4->num_rows > 0) {
    while ($row = $result4->fetch_assoc()) {
        $products4[] = $row;
    }
}

$conn->close();
?>

<script>
    // Chuyển dữ liệu PHP sang JavaScript
    const products = <?php echo json_encode($products4); ?>;
</script>