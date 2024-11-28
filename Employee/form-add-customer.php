<?php
// Kết nối đến cơ sở dữ liệu
include '../php/connect.php'; // Thay đổi tên file nếu cần

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    // $maKH = $_POST["MaKH"];
    $hoTen = $_POST['HoTen'];
    $soDienThoai = $_POST['SoDienThoai'];
    $email = $_POST['Email'];
    $diaChi = $_POST['DiaChi'];

    // Kết nối đến cơ sở dữ liệu và thêm thông tin khách hàng
    $sql = "INSERT INTO khachhang ( HoTenKH, SoDienThoai, Email, DiaChi) 
            VALUES ('$hoTen', '$soDienThoai', '$email', '$diaChi')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Khách hàng đã được thêm thành công!'); window.location.href='form-add-don-hang.php';</script>";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}
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
    <title>Thêm Khách Hàng</title>
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
<div class="container mt-5">
    <div class="container mt-5">
        <h2 class="mb-4">Thêm khách hàng mới</h2>
        <form action="form-add-customer.php" method="POST">
            <!-- <div class="form-group">
                <label for="MaKhachHang">Mã khách hàng:</label>
                <input type="text" class="form-control" id="MaKhachHang" name="MaKhachHang" required>
            </div> -->
            <div class="form-group">
                <label for="HoTen">Họ và tên:</label>
                <input type="text" class="form-control" id="HoTen" name="HoTen" required>
            </div>

            <div class="form-group">
                <label for="SoDienThoai">Số điện thoại:</label>
                <input type="text" class="form-control" id="SoDienThoai" name="SoDienThoai" required>
            </div>

            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" id="Email" name="Email" required>
            </div>

            <div class="form-group">
                <label for="DiaChi">Địa chỉ:</label>
                <input type="text" class="form-control" id="DiaChi" name="DiaChi" required>
            </div>

            <!-- <div class="form-group">
                <label for="MaThuCung">Mã thú cưng:</label>
                <input type="text" class="form-control" id="MaThuCung" name="MaThuCung">
            </div> -->

            <button type="submit" class="btn btn-primary">Thêm khách hàng</button>
            <a href="form-table-customer.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
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