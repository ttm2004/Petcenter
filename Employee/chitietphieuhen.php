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

// Truy vấn thông tin chi tiết lịch hẹn dựa trên mã đơn chăm sóc
$sql = "SELECT 
            DonChamSoc.MaDonChamSoc,
            KhachHang.MaKH,
            KhachHang.HoTenKH,
            KhachHang.SoDienThoai,
            KhachHang.DiaChi,
            ThuCung.MaThuCung,
            ThuCung.TenThuCung,
            LoaiThuCung.LoaiThuCung,
            ThuCung.MauSac,
            ThuCung.CanNang,
            ThuCung.NgayTiepNhan,
            DonChamSoc.NgayBatDau,
            DonChamSoc.NgayKetThuc,
            DichVu.TenDichVu,
            DichVu.MoTa AS MoTaDichVu
        FROM 
            LichHen
        INNER JOIN 
            DonChamSoc ON LichHen.MaDonChamSoc = DonChamSoc.MaDonChamSoc
        INNER JOIN 
            KhachHang ON DonChamSoc.MaKH = KhachHang.MaKH
        INNER JOIN 
            ThuCung ON ThuCung.MaDonChamSoc = ThuCung.MaDocChamSoc
        
        INNER JOIN 
            DichVu ON ThuCung.MaDichVu = DichVu.MaDichVu
        WHERE 
            DonChamSoc.MaDonChamSoc = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $maDonChamSoc);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("<div class='alert alert-warning'>Không tìm thấy phiếu hẹn.</div>");
}

// Kiểm tra xem phiếu hẹn đã được in chưa
$check_sql = "SELECT * FROM LichHen WHERE MaDonChamSoc = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $maDonChamSoc);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

// Biến kiểm tra trạng thái của phiếu hẹn
$daIn = $check_result->num_rows > 0;

$check_stmt->close();
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

        <form action="" method="post">
            <!-- Hiển thị thông tin dịch vụ đã chọn -->
            <div class="appointment-card">
                <h2>Thông tin khách hàng</h2>
                <p><strong>Tên khách hàng:</strong> <?php echo $row['HoTenKH']; ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo $row['SoDienThoai']; ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo $row['DiaChi']; ?></p>
            </div>
            <div class="appointment-card">
                <h2>Thông tin thú cưng</h2>
                <p><strong>Mã thú cưng:</strong> <?php echo $row['MaThuCung']; ?></p>
                <p><strong>Tên thú cưng:</strong> <?php echo $row['TenThuCung']; ?></p>
                <p><strong>Loại thú cưng:</strong> <?php echo $row['LoaiThuCung']; ?></p>
                <p><strong>Màu sắc:</strong> <?php echo $row['MauSac']; ?></p>
                <p><strong>Cân nặng:</strong> <?php echo $row['CanNang']; ?></p>
                <p><strong>Ngày tiếp nhận:</strong> <?php echo $row['NgayTiepNhan']; ?></p>
            </div>

            <!-- Hiển thị thông tin dịch vụ đã chọn (không cần submit) -->
            <div class="appointment-card">
                <h2>Thông tin dịch vụ đã chọn</h2>
                <p><strong>Mã đơn chăm sóc:</strong> <?php echo $row['MaDonChamSoc']; ?></p>
                <p><strong>Tên dịch vụ:</strong> <?php echo $row['TenDichVu']; ?></p>
                <p><strong>Mô tả dịch vụ:</strong> <?php echo $row['MoTaDichVu']; ?></p>
            </div>

            <!-- Thông tin cần gửi đến bảng lichhen -->
            <div class="appointment-card">
                <h2>Thông tin lịch hẹn</h2>
                <!-- Các trường ẩn để gửi dữ liệu cần thiết -->
                <input type="hidden" name="MaKH" value="<?php echo $row['MaKH']; ?>">
                <input type="hidden" name="MaThuCung" value="<?php echo $row['MaThuCung']; ?>">
                <input type="hidden" name="MaDonChamSoc" value="<?php echo $row['MaDonChamSoc']; ?>">
                <!-- Trường ngày in (người dùng có thể chọn hoặc tự động lấy ngày hiện tại) -->
                <p><strong>Ngày bắt đầu chăm sóc:</strong> <?php echo $row['NgayBatDau']; ?></p>
                <p><strong>Ngày hẹn trả thú cưng:</strong> <?php echo $row['NgayKetThuc']; ?></p>
                <p><strong>Ngày in:</strong> <span id="currentDateTime"></span></p>
                <!-- Trường ẩn để gửi thời gian về server -->
                <input type="hidden" name="NgayIn" id="ngayIn">
            </div>

            <a href="details-invoice.php?MaDonChamSoc=<?php echo $row['MaDonChamSoc']; ?>" class="btn btn-success">Trở lại đơn chăm sóc</a>

        </form>
    </div>

    <script type="text/javascript">
        function updateDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const formattedDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            document.getElementById("currentDateTime").textContent = formattedDateTime;
            document.getElementById("ngayIn").value = formattedDateTime;
        }

        window.onload = updateDateTime;
    </script>
</body>

</html>
