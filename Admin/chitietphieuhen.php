<?php
// Kết nối đến cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "petcenter");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy mã đơn chăm sóc từ URL
if (!isset($_GET['MaDonChamSoc'])) {
    die("<div class='alert alert-danger'>Không tìm thấy mã đơn chăm sóc.</div>");
}

$maDonChamSoc = $_GET['MaDonChamSoc'];

// Truy vấn thông tin chi tiết lịch hẹn và danh sách thú cưng, dịch vụ dựa trên mã đơn chăm sóc
$sql = "SELECT 
            LichHen.MaLichHen,
            LichHen.NgayIn,
            KhachHang.HoTenKH,
            KhachHang.SoDienThoai,
            KhachHang.DiaChi,
            ThuCung.MaThuCung,
            ThuCung.TenThuCung,
            ThuCung.LoaiThuCung,
            ThuCung.MauSac,
            ThuCung.CanNang,
            DichVu.TenDichVu,
            DichVu.MoTa AS MoTaDichVu
        FROM 
            LichHen
        INNER JOIN 
            DonChamSoc ON LichHen.MaDonChamSoc = DonChamSoc.MaDonChamSoc
        INNER JOIN 
            KhachHang ON DonChamSoc.MaKH = KhachHang.MaKH
        INNER JOIN 
            ThuCung ON ThuCung.MaDonChamSoc = DonChamSoc.MaDonChamSoc
        INNER JOIN 
            DichVu ON ThuCung.MaDichVu = DichVu.MaDichVu
        WHERE 
            LichHen.MaDonChamSoc = ?";

if (!$stmt = $conn->prepare($sql)) {
    die("Lỗi chuẩn bị câu truy vấn: " . $conn->error);
}

$stmt->bind_param("s", $maDonChamSoc);
$stmt->execute();
$result = $stmt->get_result();



// Kiểm tra nếu có bản ghi nào được trả về
if ($result->num_rows > 0) {
    // Lấy thông tin khách hàng (chỉ cần lấy từ bản ghi đầu tiên vì các bản ghi khác nhau chỉ về thú cưng và dịch vụ)
    $row = $result->fetch_assoc();
    $hoTenKH = $row['HoTenKH'];
    $soDienThoai = $row['SoDienThoai'];
    $diaChi = $row['DiaChi'];
    $maLichHen = $row['MaLichHen'];
    $ngayIn = $row['NgayIn'];
    
    // Reset lại con trỏ kết quả để hiển thị thú cưng và dịch vụ trong vòng lặp
    $result->data_seek(0);
} else {
    die("<div class='alert alert-warning'>Không tìm thấy phiếu hẹn.</div>");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Hẹn Nhận Thú Cưng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .appointment-container {
            max-width: 600px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }

        .appointment-header {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .appointment-card {
            border: 1px solid #ddd;
            border-top: none;
            padding: 15px;
            background-color: #f9f9f9;
            margin: 0;
        }

        .appointment-card h2 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .appointment-card p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }

        .appointment-card h2 {
            font-weight: 600;
        }

        .appointment-card p strong {
            color: #333;
        }

        @media print {
            #export-appointment-slip {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="appointment-container">
        <div class="appointment-header">
            <h2>Phiếu Hẹn Nhận Thú Cưng</h2>
        </div>

        <!-- Hiển thị thông tin khách hàng -->
        <div class="appointment-card">
            <h2>Thông tin khách hàng</h2>
            <p><strong>Tên khách hàng:</strong> <?php echo $hoTenKH; ?></p>
            <p><strong>Số điện thoại:</strong> <?php echo $soDienThoai; ?></p>
            <p><strong>Địa chỉ:</strong> <?php echo $diaChi; ?></p>
        </div>

        <!-- Vòng lặp hiển thị danh sách thú cưng và dịch vụ -->
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="appointment-card">
                <h2>Thông tin thú cưng</h2>
                <!-- <p><strong>Mã thú cưng:</strong> <?php echo $row['MaThuCung']; ?></p> -->
                <p><strong>Tên thú cưng:</strong> <?php echo $row['TenThuCung']; ?></p>
                <!-- <p><strong>Loại thú cưng:</strong> <?php echo $row['LoaiThuCung']; ?></p> -->
                <p><strong>Màu sắc:</strong> <?php echo $row['MauSac']; ?></p>
                <p><strong>Cân nặng:</strong> <?php echo $row['CanNang']; ?></p>
            </div>
            <div class="appointment-card">
                <h2>Thông tin dịch vụ đã chọn</h2>
                <p><strong>Tên dịch vụ:</strong> <?php echo $row['TenDichVu']; ?></p>
                <!-- <p><strong>Mô tả dịch vụ:</strong> <?php echo $row['MoTaDichVu']; ?></p> -->
            </div>
        <?php } ?>

        <!-- Hiển thị thông tin lịch hẹn -->
        <div class="appointment-card">
            <h2>Thông tin lịch hẹn</h2>
            <p><strong>Mã lịch hẹn:</strong> <?php echo $maLichHen; ?></p>
            <p><strong>Ngày in:</strong> <?php echo $ngayIn; ?></p>
        </div>

        <a href="details-invoice.php?MaDonChamSoc=<?php echo $maDonChamSoc; ?>" class="btn btn-success">Trở lại đơn chăm sóc</a>
    </div>
</body>

</html>
