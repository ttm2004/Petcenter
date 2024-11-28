<?php
include('php/connect.php');  // Kết nối cơ sở dữ liệu
include "php/care_filter.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'BacSi') {
    header("Location: ../Auth/login_register.php");
    exit();
}
// Lấy mã đơn chăm sóc từ URL
if (!isset($_GET['MaDonChamSoc'])) {
    die("Không tìm thấy đơn chăm sóc.");
}
$maDonChamSoc = $_GET['MaDonChamSoc'];

// Lấy thông tin đơn chăm sóc
$queryOrder = "SELECT 
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
                    GROUP_CONCAT(DichVu.TenDichVu ORDER BY DichVu.TenDichVu) AS TenDichVu, 
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
                    DonChamSoc.MaDonChamSoc = ?
                GROUP BY 
                    DonChamSoc.MaDonChamSoc";

$stmtOrder = $conn->prepare($queryOrder);
$stmtOrder->bind_param("s", $maDonChamSoc);
$stmtOrder->execute();
$order = $stmtOrder->get_result()->fetch_assoc();

if (!$order) {
    die("Đơn chăm sóc không tồn tại.");
}

// Kiểm tra và khởi tạo các bước chăm sóc trong bảng QuaTrinhChamsoc
$queryCheckSteps = "SELECT COUNT(*) AS StepCount FROM QuaTrinhChamsoc WHERE MaDonChamSoc = ?";
$stmtCheckSteps = $conn->prepare($queryCheckSteps);
$stmtCheckSteps->bind_param("s", $maDonChamSoc);
$stmtCheckSteps->execute();
$resultCheckSteps = $stmtCheckSteps->get_result()->fetch_assoc();

// Nếu chưa có bước nào, thêm mới các bước chăm sóc
if ($resultCheckSteps['StepCount'] == 0) {
    $queryInsertSteps = "INSERT INTO QuaTrinhChamsoc (MaDonChamSoc, MaBuoc, TrangThai)
                         SELECT ?, BuocChamsoc.MaBuoc, 'Chưa bắt đầu'
                         FROM BuocChamsoc
                         WHERE BuocChamsoc.MaDichVu = ?";
    $stmtInsertSteps = $conn->prepare($queryInsertSteps);
    $stmtInsertSteps->bind_param("si", $maDonChamSoc, $order['MaDichVu']);
    $stmtInsertSteps->execute();
}

// Lấy các bước chăm sóc
$querySteps = "SELECT 
                   BuocChamsoc.MaBuoc, 
                   BuocChamsoc.TenBuoc, 
                   BuocChamsoc.MoTa, 
                   QuaTrinhChamsoc.TrangThai
               FROM BuocChamsoc
               LEFT JOIN QuaTrinhChamsoc ON BuocChamsoc.MaBuoc = QuaTrinhChamsoc.MaBuoc
               LEFT JOIN DichVu ON BuocChamsoc.MaDichVu = DichVu.MaDichVu
               LEFT JOIN ThuCung ON DichVu.MaDichVu = ThuCung.MaDichVu
               LEFT JOIN DonChamSoc ON ThuCung.MaDonChamSoc = DonChamSoc.MaDonChamSoc
               WHERE DonChamSoc.MaDonChamSoc = ? 
               ORDER BY BuocChamsoc.MaBuoc";  // Thêm điều kiện và sắp xếp theo MaBuoc
$stmtSteps = $conn->prepare($querySteps);
$stmtSteps->bind_param("s", $maDonChamSoc);
$stmtSteps->execute();
$steps = $stmtSteps->get_result();

$maDonChamSoc = $order['MaDonChamSoc']; // Mã đơn chăm sóc cần lấy dịch vụ

// Truy vấn lấy danh sách dịch vụ dựa trên mã đơn chăm sóc
$queryServices = "SELECT DISTINCT DichVu.MaDichVu, DichVu.TenDichVu
                  FROM DonChamSoc
                  INNER JOIN ThuCung ON DonChamSoc.MaDonChamSoc = ThuCung.MaDonChamSoc
                  INNER JOIN DichVu ON ThuCung.MaDichVu = DichVu.MaDichVu
                  WHERE DonChamSoc.MaDonChamSoc = ?";
$stmtServices = $conn->prepare($queryServices);
$stmtServices->bind_param("s", $maDonChamSoc);
$stmtServices->execute();
$services = $stmtServices->get_result();
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn chăm sóc</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main.css">

</head>

<body onload="time()" class="app sidebar-mini rtl">
    <header class="app-header">
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
            aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <!-- User Menu-->
            <li><a class="app-nav__item" href="../../Auth/login_register.php"><i class='bx bx-log-out bx-rotate-180'></i> </a>

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
                include "php/get_role.php";
                ?>
            </div>
        </div>
        <hr style="background-color:#f2f2f2;">
        <ul class="app-menu">
            <li><a class="app-menu__item " href="dashbroad.php"><i class='app-menu__icon bx bx-tachometer'></i><span
                        class="app-menu__label">Bảng điều khiển</span></a></li>
            <li><a class="app-menu__item active" href="table-data-table.php"><i class='app-menu__icon bx bx-id-card'></i> <span
                        class="app-menu__label">Thông tin cá nhân</span></a></li>
            <li><a class="app-menu__item" href="form-table-customer.php"><i class='app-menu__icon bx bx-user-voice'></i><span
                        class="app-menu__label">Thông tin khách hàng</span></a></li>
            <li><a class="app-menu__item" href="table-data-product.php"><i
                        class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Thông tin sản phẩm</span></a>
            </li>
            <li>
                <a class="app-menu__item has-submenu" href="donchamsoc.php">
                    <i class='app-menu__icon bx bx-task'></i>
                    <span class="app-menu__label">Đơn dịch vụ thú cưng</span>
                </a>

            </li>


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
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active">
                    <span><b>Danh sách đơn dịch vụ thú cưng</b></span>
                    <span id="status-label"> <b>&#10159; Quá trình thực hiện đơn dịch vụ </b></span>
                </li>
            </ul>
            <div id="clock"></div>
            <div id="notification" class="hidden fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50 transition-opacity duration-300 ease-in-out w-25 h-10">
                Bước chăm sóc đã được hoàn thành!
            </div>

        </div>
        <div class="row">
            <div class="max-w-4xl mx-auto my-8 p-6 bg-white shadow-lg rounded-lg ">
                <h2 class="text-2xl font-bold mb-4 text-indigo-600 text-center">Chi tiết quá trình chăm sóc cho đơn hàng<br> #<?php echo $order['MaDonChamSoc']; ?></h2>

                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><span class="font-semibold">Khách hàng:</span> <?php echo $order['HoTenKH']; ?></p>
                    </div>
                    <div>
                        <p><span class="font-semibold">Địa chỉ:</span> <?php echo $order['DiaChi']; ?></p>
                    </div>
                    <div>
                        <p><span class="font-semibold">Số điện thoại:</span> <?php echo $order['SoDienThoai']; ?></p>
                    </div>
                    <div>
                        <p><span class="font-semibold">Email:</span> <?php echo $order['Email']; ?></p>
                    </div>
                    <div>
                        <p><span class="font-semibold">Tên dịch vụ:</span> <?php echo $order['TenDichVu']; ?></p> <!-- Hiển thị tất cả dịch vụ -->
                    </div>
                </div>


                <h3 class="text-xl font-semibold mb-3 text-gray-700 text-center">Các bước chăm sóc</h3>

                <?php
                while ($service = $services->fetch_assoc()) {
                    // Hiển thị tên dịch vụ
                    echo "<h3 class='text-xl font-semibold mb-4 text-indigo-600'>" . htmlspecialchars($service['TenDichVu'], ENT_QUOTES) . "</h3>";

                    // Truy vấn các bước chăm sóc cho dịch vụ hiện tại
                    $querySteps = "SELECT BuocChamsoc.MaBuoc, BuocChamsoc.TenBuoc, BuocChamsoc.MoTa, QuaTrinhChamsoc.TrangThai, QuaTrinhChamsoc.ThoiGianKetThuc
                                   FROM BuocChamsoc
                                   LEFT JOIN QuaTrinhChamsoc ON BuocChamsoc.MaBuoc = QuaTrinhChamsoc.MaBuoc AND QuaTrinhChamsoc.MaDonChamSoc = ?
                                   WHERE BuocChamsoc.MaDichVu = ?";
                    $stmtSteps = $conn->prepare($querySteps);
                    $stmtSteps->bind_param("si", $maDonChamSoc, $service['MaDichVu']);
                    $stmtSteps->execute();
                    $steps = $stmtSteps->get_result();

                    // Hiển thị bảng các bước chăm sóc cho dịch vụ hiện tại
                ?>
                    <div class="overflow-x-auto mb-8">
                        <table class="table-auto w-full bg-white shadow-lg rounded-lg">
                            <thead>
                                <tr class="bg-indigo-500 text-white">
                                    <th class="px-4 py-2">Bước</th>
                                    <th class="px-4 py-2">Mô tả</th>
                                    <th class="px-4 py-2">Trạng thái</th>
                                    <th class="px-4 py-2">Thao tác</th>
                                    <th class="px-4 py-2">Thời gian thực hiện</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($steps->num_rows > 0) { ?>
                                    <?php while ($step = $steps->fetch_assoc()) { ?>
                                        <tr class="border-b">
                                            <td class="px-4 py-3"><?php echo htmlspecialchars($step['TenBuoc'], ENT_QUOTES); ?></td>
                                            <td class="px-4 py-3"><?php echo htmlspecialchars($step['MoTa'], ENT_QUOTES); ?></td>
                                            <td class="px-4 py-3" id="status-<?php echo htmlspecialchars($step['MaBuoc'], ENT_QUOTES); ?>">
                                                <?php echo $step['TrangThai'] ?: 'Chưa bắt đầu'; ?>
                                            </td>
                                            <td class="px-4 py-3">
                                                <?php if ($step['TrangThai'] !== 'Đã hoàn thành') { ?>
                                                    <button onclick="updateStepStatus('<?php echo htmlspecialchars($maDonChamSoc, ENT_QUOTES); ?>', <?php echo (int)$step['MaBuoc']; ?>)"
                                                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-1 px-2 rounded ">
                                                        Thực hiện
                                                    </button>
                                                <?php } else { ?>
                                                    <span class="text-gray-500 italic">Đã hoàn thành</span>
                                                <?php } ?>
                                            </td>

                                            <td class="px-4 py-3">
                                                <?php echo $step['ThoiGianKetThuc'] ? date('d/m/Y H:i:s', strtotime($step['ThoiGianKetThuc'])) : 'Chưa thực hiện'; ?>

                                                <?php if ($step['TrangThai'] === 'Chưa bắt đầu') { ?>
                                                    <button onclick="deleteStep('<?php echo htmlspecialchars($maDonChamSoc, ENT_QUOTES); ?>', <?php echo (int)$step['MaBuoc']; ?>)"
                                                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded ml-2">
                                                        Xóa
                                                    </button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-center text-gray-500">Không có bước chăm sóc nào cho dịch vụ này.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <div class="flex justify-center mt-6">
                    <?php
                    if ($order['TinhTrangDon'] == 'Đang chăm sóc') {
                        echo "<a href='donchamsoc.php?status=dang-cham-soc' class='bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded mr-2'>Quay lại các đơn đang chăm sóc</a>";
                    } else if ($order['TinhTrangDon'] == 'Đã chăm sóc') {
                        echo "<a href='donchamsoc.php?status=da-cham-soc' class='bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded'>Quay lại các đơn đã hoàn thành</a>";
                    }
                    ?>
                </div>

            </div>

            <script>
                function updateStepStatus(maDonChamSoc, maBuoc) {
                    $.ajax({
                        url: 'php/update_step_status.php', // Tệp xử lý cập nhật trạng thái bước
                        type: 'POST',
                        data: {
                            MaDonChamSoc: maDonChamSoc,
                            MaBuoc: maBuoc
                        },
                        success: function(response) {
                            const notification = document.getElementById('notification');
                            if (response === 'success') {
                                $('#status-' + maBuoc).text('Đã hoàn thành');

                                // Thiết lập nội dung và màu nền cho thông báo thành công
                                notification.textContent = 'Bước chăm sóc đã được hoàn thành!';
                                notification.classList.remove('hidden', 'bg-red-500');
                                notification.classList.add('bg-green-500', 'opacity-100');

                            } else {
                                // Thiết lập nội dung và màu nền cho thông báo lỗi
                                notification.textContent = 'Lỗi khi cập nhật trạng thái bước.';
                                notification.classList.remove('hidden', 'bg-green-500');
                                notification.classList.add('bg-red-500', 'opacity-100');
                            }

                            // Ẩn thông báo sau 3 giây
                            setTimeout(() => {
                                notification.classList.add('hidden');
                                window.location.reload();
                            }, 2000);
                        },
                        error: function() {
                            // Thiết lập nội dung và màu nền cho thông báo lỗi khi không kết nối được server
                            const notification = document.getElementById('notification');
                            notification.textContent = 'Không thể kết nối đến server.';
                            notification.classList.remove('hidden', 'bg-green-500');
                            notification.classList.add('bg-red-500', 'opacity-100');

                            // Ẩn thông báo sau 3 giây
                            setTimeout(() => {
                                notification.classList.add('hidden');
                                window.location.reload();
                            }, 2000);
                        }
                    });
                }
            </script>
        </div>
    </main>


</body>
<script src="js/main.js"></script>
<script src="js/hours.js"></script>
<script src="js/menu_active.js">
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy tất cả các thẻ <a> trong menu
        const menuItems = document.querySelectorAll(".app-menu__item");

        // Kiểm tra URL hiện tại và thêm class active vào mục phù hợp
        const currentPath = window.location.pathname.split("/").pop();
        menuItems.forEach((item) => {
            if (item.getAttribute("href") === currentPath) {
                item.classList.add("active");
            } else {
                item.classList.remove("active");
            }
        });

        // Thêm sự kiện click vào mỗi mục menu
        menuItems.forEach((item) => {
            item.addEventListener("click", function(event) {
                // Xóa lớp 'active' khỏi tất cả các mục
                menuItems.forEach((i) => i.classList.remove("active"));

                // Thêm lớp 'active' vào mục được nhấp
                this.classList.add("active");
            });
        });
    });
</script>


</html>