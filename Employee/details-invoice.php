

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
        include 'php/get_role.php';
        ?>

      </div>
    </div>
    <hr>
    <ul class="app-menu">
      <li><a class="app-menu__item" href="phan-mem-ban-hang.php"><i class='app-menu__icon bx bx-cart-alt'></i>
          <span class="app-menu__label">Bán hàng</span></a></li>
      <li><a class="app-menu__item" href="employee.php"><i class='app-menu__icon bx bx-tachometer'></i><span
            class="app-menu__label">Bảng điều khiển</span></a></li>
      <li><a class="app-menu__item " href="table-data-table.php"><i class='app-menu__icon bx bx-id-card'></i> <span
            class="app-menu__label">Thông tin cá nhân</span></a></li>
      <li><a class="app-menu__item" href="form-table-customer.php"><i class='app-menu__icon bx bx-user-voice'></i><span
            class="app-menu__label">Thông tin khách hàng</span></a></li>
      <li><a class="app-menu__item" href="table-data-product.php"><i
            class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Thông tin sản phẩm</span></a>
      </li>
      <li><a class="app-menu__item active" href="table-data-oder.php"><i class='app-menu__icon bx bx-task'></i><span
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
                        <a href="table-data-oder.php" class="btn btn-primary">Quay lại danh sách</a>

                        <?php
                        // Kết nối đến cơ sở dữ liệu và lấy mã đơn chăm sóc
                        $maDonChamSoc = $_GET['MaDonChamSoc'];

                        // Kiểm tra xem có thú cưng nào chưa có chuồng trong đơn chăm sóc này không
                        $sql_check_vitri = "SELECT COUNT(*) as count FROM ThuCung WHERE MaDonChamSoc = ? AND (ViTri IS NULL OR ViTri = '')";
                        $stmt_check = $conn->prepare($sql_check_vitri);
                        $stmt_check->bind_param("s", $maDonChamSoc);
                        $stmt_check->execute();
                        $result_check = $stmt_check->get_result();
                        $row_check = $result_check->fetch_assoc();

                        // Nếu có ít nhất một thú cưng chưa có chuồng, hiển thị nút "Thêm thú cưng vào chuồng"
                        if ($row_check['count'] > 0) {
                            echo '<a href="nhanthucung.php?MaDonChamSoc=' . $maDonChamSoc . '" class="btn btn-success">Thêm thú cưng vào chuồng</a>';
                        } else {
                            // Nếu tất cả thú cưng đã có chuồng, hiển thị nút "Đổi vị trí chuồng"
                            echo '<a href="nhanthucung.php?MaDonChamSoc=' . $maDonChamSoc . '" class="btn btn-warning">Đổi vị trí chuồng</a>';
                        }
                       $sql_tinhtrang = "SELECT TinhTrangDon FROM DonChamSoc WHERE MaDonChamSoc = ?";
                        $result_tinhtrang = $conn->prepare($sql_tinhtrang);
                        $result_tinhtrang->bind_param("s", $maDonChamSoc);
                        $result_tinhtrang->execute();
                        $row_tinhtrang = $result_tinhtrang->get_result();
                        $row_tinhtrang = $row_tinhtrang->fetch_assoc();
                        if ($row_tinhtrang['TinhTrangDon'] == 'Khách hàng đã xác nhận thú cưng thành công') {
                            echo  '<a href="chamsoc/invoice.php?MaDonChamSoc=' . $maDonChamSoc . '" class="btn btn-active">In hóa đơn và kết thúc đơn chăm sóc</a>';
                        }

                        
                        // Đóng statement và kết nối sau khi sử dụng
                        $stmt_check->close();
                        ?>    
                        <a href="chitietphieuhen.php?MaDonChamSoc=<?php echo $maDonChamSoc; ?>" class="btn btn-danger">Xem chi tiết phiếu hẹn</a>
                    </div>

                </div>
            </div>
        </div>
    </main>


    <script>
        let currentMaThuCung = null;

        // Hiển thị popup khi chọn thêm thú cưng vào chuồng
        function openPositionForm(maThuCung) {
            currentMaThuCung = maThuCung;
            document.getElementById("overlay").classList.remove("hidden");
            loadChuongList();
        }

        // Đóng popup
        function closePositionForm() {
            document.getElementById("overlay").classList.add("hidden");
        }

        // Tải danh sách chuồng từ server để xem chuồng nào trống hoặc đã có thú cưng
        function loadChuongList() {
            fetch('get_chuong_list.php')
                .then(response => response.json())
                .then(data => {
                    const chuongSelect = document.getElementById("chuongSelect");
                    chuongSelect.innerHTML = ""; // Xóa nội dung cũ

                    data.forEach(chuong => {
                        const option = document.createElement("option");
                        option.value = chuong.MaChuong;
                        option.textContent = `Chuồng: ${chuong.TenChuong} - ${chuong.TrangThai}`;
                        option.disabled = chuong.TrangThai !== 'Trống'; // Chỉ cho phép chọn chuồng trống
                        chuongSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Lỗi khi tải danh sách chuồng:', error));
        }

        // Lưu vị trí chuồng đã chọn cho thú cưng
        function savePosition() {
            const selectedChuong = document.getElementById("chuongSelect").value;

            // Kiểm tra nếu mã thú cưng và mã chuồng đều có giá trị hợp lệ
            if (!currentMaThuCung) {
                alert("Mã thú cưng không hợp lệ.");
                return;
            }

            if (!selectedChuong) {
                alert("Vui lòng chọn vị trí chuồng hợp lệ.");
                return;
            }

            // Kiểm tra dữ liệu trước khi gửi
            console.log("MaThuCung:", currentMaThuCung);
            console.log("MaChuong:", selectedChuong);

            // Gửi dữ liệu chuồng đã chọn về server để lưu
            fetch('nhanthucung.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        MaChuong: selectedChuong,
                        MaThuCung: currentMaThuCung
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Server response:", data); // Kiểm tra phản hồi từ server
                    if (data.status === 'success') {
                        alert("Thêm thú cưng vào chuồng thành công!");
                        // document.getElementById("viTriDisplay").innerText = selectedChuong;
                        closePositionForm();
                        document.getElementById("addToKennelButton").style.display = "none";
                    } else {
                        alert("Lỗi khi thêm thú cưng vào chuồng: " + data.message);
                    }
                })
                .catch(error => console.error('Lỗi khi thêm thú cưng vào chuồng:', error));
        }
    </script>



    <script>
        function showProductForm() {
            document.getElementById("productForm").style.display = "block";
        }

        function hideProductForm() {
            document.getElementById("productForm").style.display = "none";
        }

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const row = button.closest('tr');
                const maSP = row.getAttribute('data-masp');
                const tenSP = row.getAttribute('data-tensp');
                const gia = row.getAttribute('data-gia');
                const soLuong = row.querySelector('.so--luong1').value;

                // Xử lý thêm sản phẩm vào danh sách hóa đơn
                addProductToInvoice(maSP, tenSP, gia, soLuong);
            });
        });

        function addProductToInvoice(maSP, tenSP, gia, soLuong) {
            // Code xử lý thêm sản phẩm vào hóa đơn
            console.log(`Thêm sản phẩm: ${tenSP} - Số lượng: ${soLuong} - Giá: ${gia}`);
            alert(`Đã thêm ${tenSP} vào hóa đơn với số lượng ${soLuong}`);
            hideProductForm();
        }


        // Hàm thêm sản phẩm vào hóa đơn
        function addProductToInvoice(productId, productName, productPrice) {
            // Bạn có thể lưu tạm thời các sản phẩm vào một mảng và hiển thị trên trang
            // Mã thêm vào danh sách sản phẩm và tổng hợp dữ liệu sản phẩm để in hóa đơn
        }

        // Đồng hồ thời gian thực
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById("clock").textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
        updateClock(); // Cập nhật ngay khi trang tải
    </script>


</body>

</html>