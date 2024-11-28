<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'BacSi') {
    header("Location: ../Auth/login_register.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn chăm sóc</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://kit.fontawesome.com/54e4f189c9.js" crossorigin="anonymous"></script>
    <style>
        .detail-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .detail-item {
            flex: 1 1 45%;
            display: flex;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            align-items: center;
        }

        .detail-item img {
            max-width: 100px;
            border-radius: 5px;
            margin-right: 15px;
        }

        .detail-label {
            font-weight: bold;
            color: #333;
            margin-right: 5px;
        }
    </style>
    <style>
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .popup-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .hidden {
            display: none;
        }
    </style>


</head>

<body>
    <!-- Navbar-->
    <header class="app-header">
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
            aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">


            <!-- User Menu-->
            <li><a class="app-nav__item" href="../Auth/login_register.php"><i class='bx bx-log-out bx-rotate-180'></i> </a>

            </li>
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="../Image/employee1.jpeg" width="50px"
        alt="User Image">
      <div>
        <?php
        $servername = "localhost"; // hoặc địa chỉ máy chủ của bạn
        $dbUsername = "root"; // tên đăng nhập của cơ sở dữ liệu
        $dbPassword = ""; // mật khẩu của cơ sở dữ liệu
        $dbname = "petcenter"; // tên cơ sở dữ liệu

        // Tạo kết nối
        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

        $username = $_SESSION['username'];
        $hoten = "SELECT HoTenNV FROM NhanVien WHERE Username = '$username'";
        $result_hoten = mysqli_query($conn, $hoten);

        if ($result_hoten && mysqli_num_rows($result_hoten) > 0) {
          $row_hoten = mysqli_fetch_assoc($result_hoten);
          echo "<p class='app-sidebar__user-name'><b>" . htmlspecialchars($row_hoten['HoTenNV']) . "</b></p>";
          echo "<p class='app-sidebar__user-designation'>Chào mừng bạn trở lại</p>";
        } else {
          echo "<p class='app-sidebar__user-name'><b>Không tìm thấy tên nhân viên</b></p>";
        }
        ?>

      </div>
    </div>
    <hr>
    <ul class="app-menu">
      <li><a class="app-menu__item active" href="dashboard.php"><i class='app-menu__icon bx bx-tachometer'></i><span
            class="app-menu__label">Bảng điều khiển</span></a></li>
      <li><a class="app-menu__item " href="table-data-table.php"><i class='app-menu__icon bx bx-id-card'></i> <span
            class="app-menu__label">Thông tin cá nhân</span></a></li>
      <li><a class="app-menu__item" href="form-table-customer.php"><i class='app-menu__icon bx bx-user-voice'></i><span
            class="app-menu__label">Thông tin khách hàng</span></a></li>
      <li><a class="app-menu__item" href="table-data-product.php"><i
            class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Thông tin sản phẩm</span></a>
      </li>
      <li><a class="app-menu__item" href="table-data-oder.php"><i class='app-menu__icon bx bx-task'></i><span
            class="app-menu__label" style="white-space: wrap;">Đơn dịch vụ thú cưng</span></a></li>
      <li><a class="app-menu__item" href="Thongtinthucung.php"><i class="app-menu__icon fa-solid fa-hippo"></i><span
            class="app-menu__label" style="white-space: wrap;">Thú cưng</span></a></li>
      <li><a class="app-menu__item" href="table-data-banned.php"><i class='app-menu__icon bx bx-run'></i><span
            class="app-menu__label">Xin nghỉ phép
          </span></a></li>
      <li><a class="app-menu__item" href="table-data-money.php"><i class='app-menu__icon bx bx-dollar'></i><span
            class="app-menu__label">Bảng lương</span></a></li>
      <li><a class="app-menu__item" href="quan-ly-bao-cao.php"><i
            class='app-menu__icon bx bx-pie-chart-alt-2'></i><span class="app-menu__label">Báo cáo doanh thu</span></a>
      </li>
      <li><a class="app-menu__item" href="page-calendar.php"><i class='app-menu__icon bx bx-calendar-check'></i><span
            class="app-menu__label">Lịch làm việc</span></a></li>
      <li><a class="app-menu__item" href="#"><i class='app-menu__icon bx bx-cog'></i><span class="app-menu__label">Cài
            đặt hệ thống</span></a></li>
    </ul>
  </aside>

    <main class="app-content">
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Chi tiết đơn chăm sóc</h1>
                <div id="clock" class="text-primary font-weight-bold"></div>
            </div>

            <div class="card shadow">
                <div class="card-body">
                    <?php
                    $conn = new mysqli("localhost", "root", "", "petcenter");
                    if ($conn->connect_error) {
                        die("Kết nối thất bại: " . $conn->connect_error);
                    }

                    if (!isset($_GET['MaDonChamSoc'])) {
                        die("<div class='alert alert-danger'>Không tìm thấy mã đơn chăm sóc.</div>");
                    }

                    $maDonChamSoc = $_GET['MaDonChamSoc'];
                    // echo''. $maDonChamSoc .'';

                    $sql = "SELECT 
                                DonChamSoc.MaDonChamSoc,
                                KhachHang.MaKH,
                                KhachHang.HoTenKH,
                                KhachHang.DiaChi,
                                KhachHang.SoDienThoai,
                                KhachHang.Email,
                                ThuCung.MaThuCung,
                                ThuCung.TenThuCung,
                                ThuCung.LoaiThuCung,
                                ThuCung.MauSac,
                                ThuCung.CanNang,
                                ThuCung.HinhAnh,
                                ThuCung.ViTri,
                                ThuCung.NgayTiepNhan,
                                ThuCung.GhiChu AS GhiChuThuCung,
                                DonChamSoc.NgayBatDau,
                                DonChamSoc.NgayKetThuc,
                                DichVu.TenDichVu,
                                DonChamSoc.TinhTrangDon,
                                DonChamSoc.ChiPhi,
                                DonChamSoc.GhiChu AS GhiChuDon,
                                DonChamSoc.NgayTaoDon,
                                NhanVien.HoTenNV
                            FROM 
                                DonChamSoc
                            INNER JOIN 
                                KhachHang ON DonChamSoc.MaKH = KhachHang.MaKH
                            LEFT JOIN 
                                ThuCung ON DonChamSoc.MaDonChamSoc = ThuCung.MaDonChamSoc
                            LEFT JOIN
                                DichVu ON ThuCung.MaDichVu = DichVu.MaDichVu
                            LEFT JOIN
                                PhanCong ON DonChamSoc.MaDonChamSoc = PhanCong.MaDonChamSoc
                            LEFT JOIN
                                NhanVien ON PhanCong.MaNV = NhanVien.MaNV
                            WHERE 
                                DonChamSoc.MaDonChamSoc = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $maDonChamSoc);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    ?>
                        <h2>Thông tin khách hàng</h2>
                        <p><strong>Mã đơn chăm sóc:</strong> <?php echo $row['MaDonChamSoc']; ?></p>
                        <p><strong>Mã khách hàng:</strong> <?php echo $row['MaKH']; ?></p>
                        <p><strong>Họ tên khách hàng:</strong> <?php echo $row['HoTenKH']; ?></p>
                        <p><strong>Địa chỉ:</strong> <?php echo $row['DiaChi']; ?></p>
                        <p><strong>SĐT:</strong> <?php echo $row['SoDienThoai']; ?></p>
                        <p><strong>Email:</strong> <?php echo $row['Email']; ?></p>

                        <?php
                        $result->data_seek(0);

                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <div class="card shadow mb-4">
                                <div class="card-header bg-info text-white">
                                    <h3>Thông tin thú cưng: <?php echo $row['TenThuCung']; ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-4">
                                            <h4>Thông tin thú cưng</h4>
                                            <p><strong>Mã thú cưng:</strong> <?php echo $row['MaThuCung']; ?></p>
                                            <p><strong>Tên thú cưng:</strong> <?php echo $row['TenThuCung']; ?></p>
                                            <p><strong>Loại thú cưng:</strong> <?php echo $row['LoaiThuCung']; ?></p>
                                            <p><strong>Màu sắc:</strong> <?php echo $row['MauSac']; ?></p>
                                            <p><strong>Cân nặng:</strong> <?php echo $row['CanNang']; ?> kg</p>
                                            <p><strong>Vị trí:</strong> <?php echo $row['ViTri'] ?? 'Chưa có'; ?></p>
                                            <p><strong>Ngày tiếp nhận:</strong> <?php echo $row['NgayTiepNhan']; ?></p>
                                            <p><strong>Ghi chú:</strong> <?php echo $row['GhiChuThuCung']; ?></p>
                                        </div>

                                        <div class="col-md-4 mb-4">
                                            <h4>Thông tin đơn chăm sóc</h4>
                                            <p><strong>Ngày bắt đầu:</strong> <?php echo $row['NgayBatDau']; ?></p>
                                            <p><strong>Ngày kết thúc:</strong> <?php echo $row['NgayKetThuc']; ?></p>
                                            <p><strong>Dịch vụ:</strong> <?php echo $row['TenDichVu']; ?></p>
                                            <p><strong>Người chăm sóc:</strong> <?php echo $row['HoTenNV']; ?></p>
                                            <p><strong>Ngày tạo đơn:</strong> <?php echo $row['NgayTaoDon']; ?></p>
                                            <p><strong>Tình trạng đơn:</strong> <?php echo $row['TinhTrangDon']; ?></p>
                                            <p><strong>Chi phí:</strong> <?php echo number_format($row['ChiPhi']); ?> VND</p>
                                            <p><strong>Ghi chú:</strong> <?php echo $row['GhiChuDon']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<div class='alert alert-warning'>Không tìm thấy chi tiết đơn.</div>";
                    }
                    ?>
                    <div class="text-center mt-3">
                        <a href="donchamsoc.php?status=tat-ca" class="btn btn-primary">Quay lại danh sách</a>
                    </div>

                </div>
            </div>
        </div>
    </main>

<script src="js/main.js"></script>
</body>

</html>