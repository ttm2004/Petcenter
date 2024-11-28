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
    <link rel="stylesheet" href="./css/main.css">
    <script src="https://kit.fontawesome.com/54e4f189c9.js" crossorigin="anonymous"></script>

</head>

<body onload="time()" class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header">
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
            aria-label="Hide Sidebar"></a>

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
        <div class="app-sidebar__user d-flex flex-col"><img class="app-sidebar__user-avatar" src="../Image/employee1.jpeg" width="50px"
                alt="User Image">
            <div>
                <?php 
                    include "./php/get_role.php";
                ?>
            </div>
        </div>
        <hr>
        <ul class="app-menu">
            <li><a class="app-menu__item" href="phan-mem-ban-hang.php"><i class='app-menu__icon bx bx-cart-alt'></i>
                    <span class="app-menu__label">Bán hàng</span></a></li>
            <li><a class="app-menu__item active " href="employee.php"><i class='app-menu__icon bx bx-tachometer'></i><span
                        class="app-menu__label">Bảng điều khiển</span></a></li>
            <li><a class="app-menu__item " href="table-data-table.php"><i class='app-menu__icon bx bx-id-card'></i> <span
                        class="app-menu__label">Thông tin cá nhân</span></a></li>
            <li><a class="app-menu__item" href="form-table-customer.php"><i class='app-menu__icon bx bx-user-voice'></i><span
                        class="app-menu__label">Thông tin khách hàng</span></a></li>
            <li><a class="app-menu__item" href="table-data-product.php"><i
                        class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Thông tin sản phẩm</span></a>
            </li>
            <li><a class="app-menu__item" href="table-data-oder.php"><i class='app-menu__icon bx bx-task'></i><span
                        class="app-menu__label " style="white-space: wrap;">Đơn dịch vụ thú cưng</span></a></li>
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
                <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" href="form-add-don-hang.php" id="create-dcs">Tạo mới đơn chăm sóc</a>
                <style>
                    #create-dcs:hover {
                        text-decoration: none;
                    }
                </style>
                <div class="filter-buttons mb-3 ml-3">
                    <a href="table-data-oder.php?status=tat-ca" class="btn btn-primary filter-btn" data-status="Tất cả">Tất cả</a>
                    <a href="table-data-oder.php?status=dang-xy-ly" class="btn btn-secondary filter-btn" data-status="Đang xử lý">Các đơn đang xử lý</a>
                    <a href="table-data-oder.php?status=dang-cham-soc" class="btn btn-warning filter-btn" data-status="Đang chăm sóc">Các đơn đang chăm sóc</a>
                    <a href="table-data-oder.php?status=da-cham-soc" class="btn btn-success filter-btn" data-status="Đã chăm sóc">Các đơn đã chăm sóc</a>
                </div>
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
                                <th class="px-4 py-2 border text-gray-600">Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php
                            // Xác định trạng thái đơn từ URL
                            $status = isset($_GET['status']) ? $_GET['status'] : 'tat-ca';

                            // Ánh xạ trạng thái sang giá trị trong cơ sở dữ liệu
                            $statusMapping = [
                                'dang-xy-ly' => 'Đang xử lý',
                                'chua-cham-soc' => 'Chưa chăm sóc',
                                'dang-cham-soc' => 'Đang chăm sóc',
                                'da-cham-soc' => 'Đã chăm sóc'
                            ];

                            // Câu truy vấn cơ bản
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
                                        NhanVien ON PhanCong.MaNV = NhanVien.MaNV";

                            // Thêm điều kiện lọc trạng thái nếu có
                            if (isset($status) && $status !== 'tat-ca' && isset($statusMapping[$status])) {
                                $query .= " WHERE DonChamSoc.TinhTrangDon = ?";
                            }

                            // Thêm GROUP BY và ORDER BY
                            $query .= " GROUP BY 
                    DonChamSoc.MaDonChamSoc, KhachHang.MaKH, KhachHang.HoTenKH, NhanVien.HoTenNV, NhanVien.MaNV, DonChamSoc.TinhTrangDon
                ORDER BY DonChamSoc.NgayTaoDon DESC";

                            // Chuẩn bị và thực thi câu lệnh truy vấn
                            $stmt = $conn->prepare($query);

                            // Gán tham số nếu có lọc trạng thái
                            if (isset($status) && $status !== 'tat-ca' && isset($statusMapping[$status])) {
                                $stmt->bind_param("s", $statusMapping[$status]);
                            }

                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Hiển thị kết quả
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='px-4 py-2 border'><input type='checkbox' name='check1' value='" . htmlspecialchars($row['MaDonChamSoc']) . "'></td>";
                                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['MaDonChamSoc']) . "</td>"; // Mã đơn chăm sóc
                                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['MaKH'] ?? 'N/A') . "</td>"; // Mã khách hàng
                                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['HoTenKH'] ?? 'N/A') . "</td>"; // Họ tên khách hàng
                                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['MaThuCung'] ?? 'N/A') . "</td>"; // Mã thú cưng (gộp)
                                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['TenThuCung'] ?? 'N/A') . "</td>"; // Tên thú cưng (gộp)
                                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['TenDichVu'] ?? 'N/A') . "</td>"; // Tên dịch vụ (gộp)
                                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row["MaNV"] ?? "Chưa có nhân viên chăm sóc") . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row["HoTenNV"] ?? "Chưa có nhân viên chăm sóc") . "</td>";
                                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row["TinhTrangDon"]) . "</td>";
                                    echo "<td class='px-4 py-2 border'>
                    <a href='details-invoice.php?MaDonChamSoc=" . htmlspecialchars($row['MaDonChamSoc']) . "' class='btn btn-info btn-sm' title='Xem chi tiết đơn'><i class='fas fa-eye'></i></a>
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
        $(document).ready(function() {
            // Kiểm tra nếu đã lưu trạng thái trong localStorage
            if (localStorage.getItem('statusText')) {
                var savedStatusText = localStorage.getItem('statusText');
                $('#status-label').html('<b>&#10159; ' + savedStatusText + '</b>');
            }

            // Xử lý sự kiện khi nhấn nút lọc
            $('.filter-btn').on('click', function() {
                var statusText = $(this).data('status'); // Lấy trạng thái từ data-status

                // Hiển thị trạng thái trên breadcrumb
                $('#status-label').html('<b>&#10159; ' + statusText + '</b>');

                // Lưu trạng thái vào localStorage
                localStorage.setItem('statusText', statusText);
            });
        });
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
    <script src="main.js"></script>
    <script type="text/javascript" src="js/hours.js">
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

</body>

</html>