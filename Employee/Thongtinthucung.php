<?php
// Kết nối đến cơ sở dữ liệu
include '../php/connect.php';
session_start();

?>



<!DOCTYPE html>
<html lang="vi">

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="https://kit.fontawesome.com/54e4f189c9.js" crossorigin="anonymous"></script>
        <title>Danh Sách Thú Cưng</title>
    </head>
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
            <li><a class="app-menu__item" href="phan-mem-ban-hang.php"><i class='app-menu__icon bx bx-cart-alt'></i>
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
    <main class="app-content bg-gray-100">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>Danh sách thú cưng ở trung tâm</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="container mx-auto p-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Thông tin thú cưng</h2>

            <!-- Bảng hiển thị thông tin thú cưng -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="sampleTable" class="min-w-full bg-white border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 border text-gray-600">Chọn</th>
                                <th class="px-4 py-2 border text-gray-600">Mã thú cưng</th>
                                <th class="px-4 py-2 border text-gray-600">Tên thú cưng</th>
                                <th class="px-4 py-2 border text-gray-600">Loại thú cưng</th>
                                <th class="px-4 py-2 border text-gray-600">Màu sắc</th>
                                <th class="px-4 py-2 border text-gray-600">Cân nặng</th>
                                <th class="px-4 py-2 border text-gray-600">Vị trí để thú cưng</th>
                                <th class="px-4 py-2 border text-gray-600">Hình ảnh</th>
                                <th class="px-4 py-2 border text-gray-600">Ngày tiếp nhận</th>
                                <th class="px-4 py-2 border text-gray-600">Mã khách hàng</th>
                                <th class="px-4 py-2 border text-gray-600">Họ tên khách hàng</th>
                                <th class="px-4 py-2 border text-gray-600">Mã đơn chăm sóc</th>
                                <th class="px-4 py-2 border text-gray-600">Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php
                            // Thay thế kết nối và truy vấn dữ liệu cho bảng
                            $query = "SELECT KhachHang.MaKH, KhachHang.HoTenKH, ThuCung.MaThuCung, ThuCung.TenThuCung,
                                  ThuCung.LoaiThuCung, ThuCung.MauSac, ThuCung.CanNang, ThuCung.ViTri, ThuCung.HinhAnh,
                                  DonChamSoc.MaDonChamSoc, ThuCung.NgayTiepNhan 
                                  FROM KhachHang 
                                  LEFT JOIN ThuCung ON KhachHang.MaKH = ThuCung.MaKH
                                  LEFT JOIN DonChamSoc ON KhachHang.MaKH = DonChamSoc.MaKH";
                            $result = mysqli_query($conn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='px-4 py-2 border'><input type='checkbox' name='check1' value='" . $row['MaThuCung'] . "'></td>";
                                    echo "<td class='px-4 py-2 border'>" . $row["MaThuCung"] . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . $row["TenThuCung"] . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . $row["LoaiThuCung"] . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . $row["MauSac"] . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . $row["CanNang"] . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . $row["ViTri"] . "</td>";
                                    echo "<td class='px-4 py-2 border'><img src='" . $row["HinhAnh"] . "' alt='Hình thú cưng' class='w-16 h-16 object-cover'></td>";
                                    echo "<td class='px-4 py-2 border'>" . $row["NgayTiepNhan"] . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . $row["MaKH"] . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . $row["HoTenKH"] . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . ($row["MaDonChamSoc"] ? $row["MaDonChamSoc"] : 'Không có đơn chăm sóc') . "</td>";
                                    echo "<td class='px-4 py-2 border'>
                                        <a href='form-table-customer.php?action=edit&MaKH=" . $row["MaKH"] . "' class='text-yellow-500'><i class='fa fa-edit'></i></a>
                                        <a href='delete-customer.php?MaKH=" . $row["MaKH"] . "' class='text-red-500' onclick='return confirm(\"Bạn có chắc chắn muốn xóa thông tin khách hàng này?\")'><i class='fa fa-trash'></i></a>
                                      </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='13' class='text-center py-4'>Không có dữ liệu</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- jQuery và DataTables -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#sampleTable').DataTable({
                    "pageLength": 7,
                    "lengthMenu": [5, 7, 10, 20],
                    "language": {
                        "sSearch": "Tìm kiếm:",
                        "lengthMenu": "Hiển thị _MENU_ dòng",
                        "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                        "paginate": {
                            "previous": "Trước",
                            "next": "Tiếp"
                        }
                    }
                });
            });
        </script>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script scr="./js/hours.js"></script>
    <script src="main.js"></script>
</body>

</html>