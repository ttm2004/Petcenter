<?php
// Kết nối đến cơ sở dữ liệu
include '../php/connect.php';
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

// Nếu là hành động sửa thông tin khách hàng
if ($action == 'edit') {
    $MaKH = $_GET['MaKH'];

    // Lấy thông tin khách hàng từ cơ sở dữ liệu
    $sql = "SELECT * FROM khachhang WHERE MaKH = $MaKH";
    $result = $conn->query($sql);
    $customer = $result->fetch_assoc();
?>

    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../Employee/css/main.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <!-- or -->
        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
        <!-- Font-icon css-->
        <link rel="stylesheet" type="text/css"
            href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <title>Sửa Thông Tin Khách Hàng</title>
    </head>

    <body onload="time()" class="app sidebar-mini rtl">
        <style>
            #notification {
                position: fixed;
                top: 10px;
                right: 10px;
                z-index: 1000;
                padding: 20px;
                /* Tăng padding để thông báo trông rộng hơn */
                font-size: 18px;
                /* Tăng kích thước font chữ */
                border-radius: 8px;
                /* Làm tròn góc */
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                /* Thêm bóng đổ */
                display: none;
                /* Ẩn thông báo mặc định */
                transition: opacity 0.5s ease-in-out;
                /* Thêm hiệu ứng chuyển tiếp */
                opacity: 0;
                /* Đặt độ mờ mặc định */
            }

            #notification.show {
                display: block;
                /* Hiện thông báo */
                opacity: 1;
                /* Hiện thông báo */
            }

            #deleteConfirmationModal .modal-content {
                width: 100px;
                margin: 0 auto;
                text-align: center;
            }

            /* Màn mờ */
            #overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
                /* Đặt trên cùng */
                display: none;
            }

            /* Modal */
            .modal {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
                z-index: 1000;
                /* Đặt trên cùng */
                width: 100px;
                padding: 20px;
                display: none;
            }

            /* Nút đóng */
            .close {
                cursor: pointer;
                float: right;
                font-size: 20px;
            }
        </style>
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
                    <p class="app-sidebar__user-name"><b><?php echo $_SESSION['hoten']; ?></b></p>
                    <p class="app-sidebar__user-designation">Chào mừng bạn trở lại</p>
                </div>
            </div>
            <hr>
            <ul class="app-menu">
                <li><a class="app-menu__item haha" href="phan-mem-ban-hang.php"><i class='app-menu__icon bx bx-cart-alt'></i>
                        <span class="app-menu__label">Bán hàng</span></a></li>
                <li><a class="app-menu__item active" href="../Employee/employee.php"><i class='app-menu__icon bx bx-tachometer'></i><span
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
    </body>
    <div class="container mt-5 pl-5 mf-5">
        <h2 class="mb-4">Sửa thông tin khách hàng</h2>
        <?php

        $query = "SELECT KhachHang.MaKH, KhachHang.HoTenKH, KhachHang.SoDienThoai, KhachHang.Email, 
                        KhachHang.DiaChi, ThuCung.MaThuCung 
                    FROM KhachHang 
                    LEFT JOIN ThuCung ON KhachHang.MaKH = ThuCung.MaKH";
        $result = mysqli_query($conn, $query);
        $row = $result->fetch_assoc()
        ?>
        <form action="form-table-customer.php?action=update" method="POST">
            <input type="hidden" name="MaKH" value="<?php echo htmlspecialchars($customer['MaKH']); ?>">

            <div class="form-group">
                <label for="HoTen">Họ và tên:</label>
                <input type="text" class="form-control" id="HoTen" name="HoTen"
                    value="<?php echo htmlspecialchars($customer['HoTenKH']); ?>" required>
            </div>

            <div class="form-group">
                <label for="SoDienThoai">Số điện thoại:</label>
                <input type="text" class="form-control" id="SoDienThoai" name="SoDienThoai"
                    value="<?php echo htmlspecialchars($customer['SoDienThoai']); ?>" required>
            </div>

            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" id="Email" name="Email"
                    value="<?php echo htmlspecialchars($customer['Email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="DiaChi">Địa chỉ:</label>
                <input type="text" class="form-control" id="DiaChi" name="DiaChi"
                    value="<?php echo htmlspecialchars($customer['DiaChi']); ?>" required>
            </div>

            <div class="form-group">
                <label for="MaThuCung">Mã thú cưng:</label>
                <input type="text" class="form-control" id="MaThuCung" name="MaThuCung"
                    value="<?php echo $row['MaThuCung']; ?>">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="form-table-customer.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>
    <script src="../Employee/js/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="../Employee/js/popper.min.js"></script>
    <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
    <!--===============================================================================================-->
    <script src="../Employee/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="../Employee/js/main.js"></script>
    <!--===============================================================================================-->
    <script src="../Employee/js/plugins/pace.min.js"></script>
    <!--===============================================================================================-->
    <script type="text/javascript" src="../Employee/js/plugins/chart.js"></script>
    <!--===============================================================================================-->
    <script type="text/javascript">
        var data = {
            labels: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6"],
            datasets: [{
                    label: "Dữ liệu đầu tiên",
                    fillColor: "rgba(255, 213, 59, 0.767), 212, 59)",
                    strokeColor: "rgb(255, 212, 59)",
                    pointColor: "rgb(255, 212, 59)",
                    pointStrokeColor: "rgb(255, 212, 59)",
                    pointHighlightFill: "rgb(255, 212, 59)",
                    pointHighlightStroke: "rgb(255, 212, 59)",
                    data: [20, 59, 90, 51, 56, 100]
                },
                {
                    label: "Dữ liệu kế tiếp",
                    fillColor: "rgba(9, 109, 239, 0.651)  ",
                    pointColor: "rgb(9, 109, 239)",
                    strokeColor: "rgb(9, 109, 239)",
                    pointStrokeColor: "rgb(9, 109, 239)",
                    pointHighlightFill: "rgb(9, 109, 239)",
                    pointHighlightStroke: "rgb(9, 109, 239)",
                    data: [48, 48, 49, 39, 86, 10]
                }
            ]
        };
        var ctxl = $("#lineChartDemo").get(0).getContext("2d");
        var lineChart = new Chart(ctxl).Line(data);

        var ctxb = $("#barChartDemo").get(0).getContext("2d");
        var barChart = new Chart(ctxb).Bar(data);
    </script>
    <script type="text/javascript">
        //Thời Gian
        function time() {
            var today = new Date();
            var weekday = new Array(7);
            weekday[0] = "Chủ Nhật";
            weekday[1] = "Thứ Hai";
            weekday[2] = "Thứ Ba";
            weekday[3] = "Thứ Tư";
            weekday[4] = "Thứ Năm";
            weekday[5] = "Thứ Sáu";
            weekday[6] = "Thứ Bảy";
            var day = weekday[today.getDay()];
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            nowTime = h + " giờ " + m + " phút " + s + " giây";
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }
            today = day + ', ' + dd + '/' + mm + '/' + yyyy;
            tmp = '<span class="date"> ' + today + ' - ' + nowTime +
                '</span>';
            document.getElementById("clock").innerHTML = tmp;
            clocktime = setTimeout("time()", "1000", "Javascript");

            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            }
        }
    </script>
<?php
} else {
    // Hiển thị danh sách khách hàng nếu không có hành động sửa
    $sql = "SELECT MaKH, HoTenKH, SoDienThoai, Email, DiaChi FROM khachhang";
    $result = $conn->query($sql);

?>

    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../Employee/css/main.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <!-- or -->
        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
        <!-- Font-icon css-->
        <link rel="stylesheet" type="text/css"
            href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
                        include 'php/get_role.php';
                    ?>
                </div>
            </div>
            <hr>
            <ul class="app-menu">
                <li><a class="app-menu__item active" href="admin.php"><i class='app-menu__icon bx bx-tachometer'></i><span
                            class="app-menu__label">Bảng điều khiển</span></a></li>
                <li><a class="app-menu__item " href="table-data-table.php"><i class='app-menu__icon bx bx-id-card'></i> <span
                            class="app-menu__label">Thông tin cá nhân</span></a></li>
                <li><a class="app-menu__item" href="table-employee.php"><i class='app-menu__icon fa-solid fa-user'></i><span
                            class="app-menu__label">Thông tin nhân viên</span></a></li>
                <li><a class="app-menu__item" href="form-table-customer.php"><i class='app-menu__icon bx bx-user-voice'></i><span
                            class="app-menu__label">Thông tin khách hàng</span></a></li>
                <li><a class="app-menu__item" href="table-data-product.php"><i
                            class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Thông tin sản phẩm</span></a>
                </li>
                <li><a class="app-menu__item" href="table-data-oder.php"><i class='app-menu__icon bx bx-task'></i><span
                            class="app-menu__label" style="white-space: wrap;">Đơn dịch vụ thú cưng</span></a></li>
                <li><a class="app-menu__item" href="Thongtinthucung.php"><i class="app-menu__icon fa-solid fa-hippo"></i><span
                            class="app-menu__label" style="white-space: wrap;">Thú cưng</span></a></li>
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
                            <div class="row element-button">
                                <!-- Các nút chức năng -->

                                <div class="col-sm-2">
                                    <a class="btn btn-primary btn-sm" type="button" title="In" onclick="printTable(this)"><i class="fas fa-print"></i> In dữ liệu</a>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-info btn-sm" type="button" title="Sao chép"><i class="fas fa-copy"></i> Sao chép</a>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-success btn-sm" href="./php/export-excel.php" title="Xuất Excel" onclick="exportToExcel()"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-warning btn-sm" type="button" title="Nhập" onclick="myFunction(this)"><i class="fas fa-file-upload"></i> Tải từ file</a>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-danger btn-sm" href="form-add-customer.php" title="Thêm"><i class="fas fa-plus"></i> Tạo mới khách hàng</a>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-danger btn-sm " id="deleteBtn" title="Xóa" onclick="deleteSelectedCustomers()" style="display:none;"><i class="fas fa-trash"></i> Xóa đã chọn</a>
                                </div>
                            </div>
                            <!-- Modal xác nhận xóa -->
                            <div id="deleteConfirmationModal" class="modal" style="display: none;">
                                <div class="modal-content" style="padding: 15px;width: 34%;">
                                    <span class="close" onclick="closeModal()">&times;</span>
                                    <h2>Xác nhận xóa khách hàng</h2>
                                    <p>Bạn có chắc chắn muốn xóa những khách hàng đã chọn?</p>
                                    <button id="confirmDelete" class="btn btn-danger">Xóa</button>
                                    <button id="cancelDelete" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
                                </div>
                            </div>

                            <!-- Màn mờ -->
                            <div id="overlay" style="display: none;"></div>
                            <!-- Ô tìm kiếm khách hàng -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm theo mã khách hàng hoặc tên khách hàng" onkeyup="searchTable()">
                                </div>
                            </div>
                            <br>

                            <form id="customerForm">
                                <table class="table table-hover table-bordered js-copytextarea" id="sampleTable">
                                    <thead>
                                        <tr>
                                            <th width='10'><input type='checkbox' id='all' name='check1' onclick="toggleAllCheckboxes(this)"></th>
                                            <th>Mã khách hàng</th>
                                            <th>Họ và tên</th>
                                            <th>Số điện thoại</th>
                                            <th>Email</th>
                                            <th>Địa chỉ</th>
                                            <th>Mã thú cưng</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customerTableBody">
                                        <?php
                                        // Kết nối tới cơ sở dữ liệu
                                        // $conn = mysqli_connect(...);

                                        // Xác định số bản ghi trên mỗi trang
                                        $records_per_page = 7; // Số lượng bản ghi mỗi trang
                                        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                        $offset = ($current_page - 1) * $records_per_page;

                                        // Truy vấn dữ liệu để lấy thông tin khách hàng và thú cưng
                                        $query = "SELECT KhachHang.MaKH, KhachHang.HoTenKH, KhachHang.SoDienThoai, KhachHang.Email, 
                                KhachHang.DiaChi, ThuCung.MaThuCung 
                                FROM KhachHang 
                                LEFT JOIN ThuCung ON KhachHang.MaKH = ThuCung.MaKH
                                LIMIT $offset, $records_per_page"; // Thêm LIMIT để phân trang
                                        $result = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td width='10'><input type='checkbox' name='check1' value='" . $row['MaKH'] . "'></td>" .
                                                    "<td>" . $row["MaKH"] . "</td>
                                        <td>" . $row["HoTenKH"] . "</td>
                                        <td>" . $row["SoDienThoai"] . "</td>
                                        <td>" . $row["Email"] . "</td>
                                        <td>" . $row["DiaChi"] . "</td>
                                        <td>" . ($row["MaThuCung"] ? $row["MaThuCung"] : 'Không có thú cưng') . "</td>
                                        <td>
                                            <a href='form-table-customer.php?action=edit&MaKH=" . $row["MaKH"] . "' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></a>
                                        </td>
                                      </tr>";
                                            }
                                        } else {
                                            echo "<tr id='noDataRow'><td colspan='8'>Không có dữ liệu</td></tr>";
                                        }

                                        // Đếm tổng số bản ghi để tính số trang
                                        $count_query = "SELECT COUNT(*) as total FROM KhachHang";
                                        $count_result = mysqli_query($conn, $count_query);
                                        $total_records = mysqli_fetch_assoc($count_result)['total'];
                                        $total_pages = ceil($total_records / $records_per_page);
                                        ?>
                                    </tbody>
                                </table>
                            </form>

                            <!-- Phân trang với Bootstrap -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php if ($current_page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo $i === $current_page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($current_page < $total_pages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>

<?php
}

$conn->close();
?>
<script src="../Employee/js/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="../Employee/js/popper.min.js"></script>
<script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
<!--===============================================================================================-->
<script src="../Employee/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="../Employee/js/main.js"></script>
<!--===============================================================================================-->
<script src="../Employee/js/plugins/pace.min.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="../Employee/js/plugins/chart.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" src="js/hours.js">
    var data = {
        labels: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6"],
        datasets: [{
                label: "Dữ liệu đầu tiên",
                fillColor: "rgba(255, 213, 59, 0.767), 212, 59)",
                strokeColor: "rgb(255, 212, 59)",
                pointColor: "rgb(255, 212, 59)",
                pointStrokeColor: "rgb(255, 212, 59)",
                pointHighlightFill: "rgb(255, 212, 59)",
                pointHighlightStroke: "rgb(255, 212, 59)",
                data: [20, 59, 90, 51, 56, 100]
            },
            {
                label: "Dữ liệu kế tiếp",
                fillColor: "rgba(9, 109, 239, 0.651)  ",
                pointColor: "rgb(9, 109, 239)",
                strokeColor: "rgb(9, 109, 239)",
                pointStrokeColor: "rgb(9, 109, 239)",
                pointHighlightFill: "rgb(9, 109, 239)",
                pointHighlightStroke: "rgb(9, 109, 239)",
                data: [48, 48, 49, 39, 86, 10]
            }
        ]
    };
    var ctxl = $("#lineChartDemo").get(0).getContext("2d");
    var lineChart = new Chart(ctxl).Line(data);

    var ctxb = $("#barChartDemo").get(0).getContext("2d");
    var barChart = new Chart(ctxb).Bar(data);
</script>