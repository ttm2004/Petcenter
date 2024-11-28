<?php
// Kết nối đến cơ sở dữ liệu
include 'php/connect.php';
session_start();

// Kiểm tra hành động (hiển thị danh sách hoặc chỉnh sửa)
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Cập nhật thông tin khách hàng nếu form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'update') {
    $MaKH = $_POST['MaKH'];
    $HoTen = $_POST['HoTen'];
    $SoDienThoai = $_POST['SoDienThoai'];
    $Email = $_POST['Email'];
    $DiaChi = $_POST['DiaChi'];
    $MaThuCung = $_POST['MaThuCung'];

    // Truy vấn cập nhật khách hàng
    $sql = "UPDATE khachhang 
            SET HoTenKH='$HoTen', SoDienThoai='$SoDienThoai', Email='$Email', DiaChi='$DiaChi', MaThuCung='$MaThuCung'
            WHERE MaKH=$MaKH";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Cập nhật thành công!</div>";
    } else {
        echo "<div class='alert alert-danger'>Lỗi cập nhật: " . $conn->error . "</div>";
    }

    // Sau khi cập nhật, quay lại danh sách khách hàng
    $action = 'list';
}



?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <script src="https://kit.fontawesome.com/54e4f189c9.js" crossorigin="anonymous"></script>
    <title>Danh Sách Khách Hàng</title>
</head>

<body onload="time()" class="app sidebar-mini rtl">
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
                    include "php/get_role.php";
                ?>
            </div>
        </div>
        <hr>
        <ul class="app-menu">
            <li><a class="app-menu__item active" href="dasboard.php"><i class='app-menu__icon bx bx-tachometer'></i><span
                        class="app-menu__label">Bảng điều khiển</span></a></li>
            <li><a class="app-menu__item " href="info_user.php"><i class='app-menu__icon bx bx-id-card'></i> <span
                        class="app-menu__label">Thông tin cá nhân</span></a></li>
            <li><a class="app-menu__item" href="custumer.php"><i class='app-menu__icon bx bx-user-voice'></i><span
                        class="app-menu__label">Thông tin khách hàng</span></a></li>
            <li><a class="app-menu__item" href="donchamsoc.php"><i
                        class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Thông tin sản phẩm</span></a>
            </li>
            <li><a class="app-menu__item" href="donchamsoc.php"><i class='app-menu__icon bx bx-task'></i><span
                        class="app-menu__label" style="white-space: wrap;">Đơn dịch vụ thú cưng</a></li>
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
                <li class="breadcrumb-item active"><a href="#"><b>Thông tin khách hàng</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div id="notification" class="alert alert-success" style="display: none;"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-hover table-bordered js-copytextarea" id="sampleTable">
                            <thead>
                                <tr>
                                    <th><input type='checkbox' id='all' name='check1' onclick="toggleAllCheckboxes(this)"></th>
                                    <th>Mã khách hàng</th>
                                    <th>Họ và tên</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Địa chỉ</th>
                                    <th>Mã thú cưng</th>
                                    <th>Mã đơn chăm sóc</th>
                                </tr>
                            </thead>
                            <tbody id="customerTableBody">
                                <?php
                                $query = "SELECT KhachHang.MaKH, KhachHang.HoTenKH, KhachHang.SoDienThoai, KhachHang.Email, 
                                KhachHang.DiaChi, ThuCung.MaThuCung, DonChamSoc.MaDonChamSoc 
                                FROM KhachHang 
                                LEFT JOIN
                                    DonChamSoc ON KhachHang.MaKH = DonChamSoc.MaKH
                                LEFT JOIN ThuCung ON KhachHang.MaKH = ThuCung.MaKH";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td><input type='checkbox' name='check1' value='" . $row['MaKH'] . "'></td>" .
                                            "<td>" . $row["MaKH"] . "</td>
                                <td>" . $row["HoTenKH"] . "</td>
                                <td>" . $row["SoDienThoai"] . "</td>
                                <td>" . $row["Email"] . "</td>
                                <td>" . $row["DiaChi"] . "</td>
                                <td>" . ($row["MaThuCung"] ? $row["MaThuCung"] : 'Khách hàng không có thú cưng') . "</td>
                                <td>" . ($row["MaDonChamSoc"] ? $row["MaDonChamSoc"] : 'Khách hàng không có đơn chăm sóc') . "</td>
                              </tr>";
                                    }
                                } else {
                                    echo "<tr id='noDataRow'><td colspan='8'>Không có dữ liệu</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#sampleTable').DataTable({
                "paging": true,
                "lengthMenu": [5, 10, 20, 50],
                "pageLength": 7,
                "searching": true,
                "ordering": true,
                "language": {
                    "sProcessing": "Đang xử lý...",
                    "sLengthMenu": "Hiển thị _MENU_ dòng trên mỗi trang",
                    "sZeroRecords": "Không tìm thấy dữ liệu phù hợp",
                    "sInfo": "Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ bản ghi",
                    "sInfoEmpty": "Hiển thị 0 đến 0 của 0 bản ghi",
                    "sInfoFiltered": "(được lọc từ _MAX_ bản ghi)",
                    "sInfoPostFix": "",
                    "sSearch": "Tìm kiếm:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "Đầu",
                        "sPrevious": "Trước",
                        "sNext": "Tiếp",
                        "sLast": "Cuối"
                    }
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/hours.js"></script>
    <script src="js/menu_active.js"></script>
</body>

</html>