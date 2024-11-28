<?php
include('../php/connect.php');
session_start();
?>


<!DOCTYPE html>
<html lang="en">

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

</head>

<body onload="time()" class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header">
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
            aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <!-- Phần HTML cho icon và danh sách thông báo -->
        <ul class="app-nav">
            <!-- Notification Icon with Count -->
            <li class="notification-item">
                <a class="app-nav__item" href="#" onclick="toggleNotifications()">
                    <i class='bx bx-bell'></i>
                    <span class="notification-count m-r-10" id="notificationCount">0</span> <!-- Hiển thị số thông báo chưa đọc -->
                </a>

            </li>

            <!-- User Menu-->
            <li>
                <a class="app-nav__item" href="../Auth/login_register.php">
                    <i class='bx bx-log-out bx-rotate-180'></i>
                </a>
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
                include('php/get_role.php');
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
    <main class="app-content bg-gray-100">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item active"><a href="#"><b>Danh sách đơn dịch vụ</b></a></li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="container mx-auto p-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Thông tin dịch vụ</h2>
            <!-- Các nút chức năng -->
            <div class="flex flex-wrap gap-4 mb-6">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="printTable(this)">In dữ liệu</button>
                <script>
                    var myApp = new function() {
                        this.printTable = function() {
                            var tab = document.getElementById('sampleTable');
                            var win = window.open('', '', 'height=700,width=700');
                            win.document.write(tab.outerHTML);
                            win.document.close();
                            win.print();
                        }
                    }
                </script>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Sao chép</button>
                <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded" onclick="exportToExcel()">Xuất Excel</button>
                <button class="bg-orange-500 hover:bg-black-700 text-white font-bold py-2 px-4 rounded" onclick="myFunction(this)">Tải từ file</button>
                <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="form-add-customer.php" id="create-dcs">Tạo mới đơn chăm sóc</a>
                <style>
                    #create-dcs:hover {
                        text-decoration: none;
                    }
                </style>
            </div>

            <!-- Bảng hiển thị thông tin thú cưng -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="sampleTable" class="min-w-full bg-white border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 border text-gray-600">Chọn</th>
                                <th class="px-4 py-2 border text-gray-600">Mã đơn chăm sóc</th>
                                <th class="px-4 py-2 border text-gray-600">Mã khách hàng</th>
                                <th class="px-4 py-2 border text-gray-600">Họ tên khách hàng</th>
                                <th class="px-4 py-2 border text-gray-600">Mã thú cưng</th>
                                <th class="px-4 py-2 border text-gray-600">Tên thú cưng</th>
                                <th class="px-4 py-2 border text-gray-600">Dịch vụ chọn</th>
                                <th class="px-4 py-2 border text-gray-600">Mã nhân viên chăm sóc</th>
                                <th class="px-4 py-2 border text-gray-600">Họ tên nhân viên chăm sóc</th>
                                <th class="px-4 py-2 border text-gray-600">Tình trạng đơn</th>
                                <!-- <th class="px-4 py-2 border text-gray-600">Ngày tạo đơn</th> -->
                                <!-- <th class="px-4 py-2 border text-gray-600">Mã khách hàng</th>
                                <th class="px-4 py-2 border text-gray-600">Họ tên khách hàng</th>
                                <th class="px-4 py-2 border text-gray-600">Mã đơn chăm sóc</th> -->
                                <th class="px-4 py-2 border text-gray-600">Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php
                            // Thay thế kết nối và truy vấn dữ liệu cho bảng
                            $query = "SELECT 
                                        DonChamSoc.MaDonChamSoc,
                                        KhachHang.MaKH, 
                                        KhachHang.HoTenKH, 
                                        GROUP_CONCAT(ThuCung.MaThuCung SEPARATOR ', ') AS MaThuCung,
                                        GROUP_CONCAT(ThuCung.TenThuCung SEPARATOR ', ') AS TenThuCung,
                                        GROUP_CONCAT(DichVu.TenDichVu SEPARATOR ', ') AS TenDichVu,
                                        NhanVien.HoTenNV,
                                        NhanVien.MaNV,
                                        DonChamSoc.TinhTrangDon
                                    FROM 
                                        DonChamSoc
                                    LEFT JOIN 
                                        KhachHang ON DonChamSoc.MaKH = KhachHang.MaKH
                                    LEFT JOIN
                                        ThuCung ON DonChamSoc.MaDonChamSoc = ThuCung.MaDonChamSoc
                                    LEFT JOIN
                                        DichVu ON ThuCung.MaDichVu = DichVu.MaDichVu
                                    LEFT JOIN
                                        PhanCong ON DonChamSoc.MaDonChamSoc = PhanCong.MaDonChamSoc
                                    LEFT JOIN
                                        NhanVien ON PhanCong.MaNV = NhanVien.MaNV
                                    GROUP BY 
                                        DonChamSoc.MaDonChamSoc, KhachHang.MaKH, KhachHang.HoTenKH, NhanVien.HoTenNV, NhanVien.MaNV, DonChamSoc.TinhTrangDon
                                    ORDER BY 
                                        DonChamSoc.NgayTaoDon DESC";


                            $result = mysqli_query($conn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='px-4 py-2 border'><input type='checkbox' name='check1' value='" . $row['MaDonChamSoc'] . "'></td>";
                                    echo "<td class='px-4 py-2 border'>" . $row['MaDonChamSoc'] . "</td>"; // Mã đơn chăm sóc
                                    echo "<td class='px-4 py-2 border'>" . ($row['MaKH'] ?? 'N/A') . "</td>"; // Mã khách hàng
                                    echo "<td class='px-4 py-2 border'>" . ($row['HoTenKH'] ?? 'N/A') . "</td>"; // Họ tên khách hàng
                                    echo "<td class='px-4 py-2 border'>" . ($row['MaThuCung'] ?? 'N/A') . "</td>"; // Mã thú cưng (gộp)
                                    echo "<td class='px-4 py-2 border'>" . ($row['TenThuCung'] ?? 'N/A') . "</td>"; // Tên thú cưng (gộp)
                                    echo "<td class='px-4 py-2 border'>" . ($row['TenDichVu'] ?? 'N/A') . "</td>"; // Tên dịch vụ (gộp)
                                    echo "<td class='px-4 py-2 border'>" . ($row["MaNV"] ?? "chưa có nhân viên chăm sóc") . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . ($row["HoTenNV"] ?? "chưa có nhân viên chăm sóc") . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . ($row["TinhTrangDon"]) . "</td>";
                                    echo "<td class='px-4 py-2 border'>
                                            <a href='details-invoice.php?MaDonChamSoc=" . $row['MaDonChamSoc'] . "' class='btn btn-info btn-sm' title='Xem chi tiết đơn'><i class='fas fa-eye'></i></a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='11' class='text-center py-4'>Không có dữ liệu</td></tr>";
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


    <!-- <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Chi tiết đơn chăm sóc</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    Nội dung chi tiết sẽ được AJAX đổ vào đây
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div> -->
    <script>
        function viewDetails(maDonChamSoc) {
            $.ajax({
                url: 'details-invoice.php', // Tạo file PHP này để xử lý yêu cầu
                type: 'POST',
                data: {
                    MaDonChamSoc: maDonChamSoc
                },
                success: function(data) {
                    // Hiển thị thông tin chi tiết trong một modal
                    $('#modalContent').html(data); // Hiển thị dữ liệu nhận được vào modal
                    $('#detailsModal').modal('show'); // Hiển thị modal
                },
                error: function() {
                    alert("Có lỗi xảy ra khi tải chi tiết đơn.");
                }
            });
        }
    </script>





    <div class="modal fade" id="ModalUP" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="php/edit-info.php"> <!-- Update action to your processing file -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <h1 style="font-size: 1.5rem; color: #000000; text-align: center; font-weight: bold; margin-top: 20px; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                                    Chỉnh sửa thông tin đơn chăm sóc thú cưng
                                </h1>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="form-group col-md-6" width="10"><input type="checkbox" id="all"></d> -->
                            <div class="form-group col-md-6">
                                <label class="control-label">Mã thú cưng</label>
                                <input class="form-control" type="text" name="MaThuCung" value="<?php echo $row2['MaThuCung']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Tên thú cưng</label>
                                <input class="form-control" type="text" name="TenThuCung" value="<?php echo $row2['TenThuCung']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Loại thú cưng</label>
                                <input class="form-control" type="text" name="LoaiThuCung" value="<?php echo $row2['LoaiThuCung']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Mã Khách hàng</label>
                                <input class="form-control" type="text" name="MaKH" value="<?php echo $row2['MaKH']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Dịch vụ chọn</label>
                                <input class="form-control" type="text" name="DichVuChon" value="<?php echo $row2['DichVuChon']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Trạng thái chữa bệnh</label>
                                <input class="form-control" type="tel" name="TrangThaiChuaBenh" value="<?php echo $row2['TrangThaiChuaBenh']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Thời gian nhận</label>
                                <input class="form-control" type="date" name="ThoiGianNhan" value="<?php echo $row2['ThoiGianNhan']; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Thời gian trả</label>
                                <input class="form-control" type="date" name="ThoiGianTra" value="<?php echo $row2['ThoiGianTra']; ?>" readonly>
                            </div>

                        </div>
                        <button class="btn btn-save" type="submit" name="save_changes">Lưu lại</button>
                        <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
                    </div>
                    <div class="modal-footer"></div>
                </form>
            </div>

        </div>
    </div>
    <script src="js/hours.js"></script>
    <script src="js/menu_active.js"></script>
</body>

</html>