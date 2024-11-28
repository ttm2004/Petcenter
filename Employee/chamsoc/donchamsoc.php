<?php
include "php/care_filter.php";
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'BacSi') {
    header("Location: ../../Auth/login_register.php");
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script src="https://kit.fontawesome.com/54e4f189c9.js" crossorigin="anonymous"></script>


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
            <li><a class="app-menu__item active" href="dashbroad.php"><i class='app-menu__icon bx bx-tachometer'></i><span
                        class="app-menu__label">Bảng điều khiển</span></a></li>
            <li><a class="app-menu__item " href="info_user.php"><i class='app-menu__icon bx bx-id-card'></i> <span
                        class="app-menu__label">Thông tin cá nhân</span></a></li>
            <li><a class="app-menu__item" href="custumer.php"><i class='app-menu__icon bx bx-user-voice'></i><span
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
                    <span id="status-label"><b>&#10159; Tất cả</b></span>
                </li>
            </ul>
            <div id="clock"></div>
        </div>
        <div class="row">
            <div class="filter-buttons mb-3 ml-3">
                <a href="donchamsoc.php?status=tat-ca" class="btn btn-primary filter-btn" data-status="Tất cả">Tất cả</a>
                <a href="donchamsoc.php?status=dang-xu-ly" class="btn btn-secondary filter-btn" data-status="Chưa chăm sóc">Các đơn chưa chăm sóc</a>
                <a href="donchamsoc.php?status=dang-cham-soc" class="btn btn-warning filter-btn" data-status="Đang chăm sóc">Các đơn đang chăm sóc</a>
                <a href="donchamsoc.php?status=da-cham-soc" class="btn btn-success filter-btn" data-status="Đã chăm sóc">Các đơn đã chăm sóc</a>
            </div>


            <div class="col-md-12">
                <div class="tile">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th width='10'><input type='checkbox' id='all' name='check1' onclick="toggleAllCheckboxes(this)"></th>
                                <th>STT</th>
                                <th>Mã đơn chăm sóc</th>
                                <th>Khách hàng</th>
                                <th>Tên thú cưng</th>
                                <th>Tên dịch vụ đã chọn</th>
                                <th>Tình trạng đơn</th>
                                <th>Tùy chọn</th>
                            </tr>
                        </thead>
                        <tbody id="customerTableBody">
                            <?php
                            if ($result2 && mysqli_num_rows($result2) > 0) {
                                $index = 1;
                                while ($row = $result2->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td width='10'><input type='checkbox' name='check1' value='" . $row['MaDonChamSoc'] . "'></td>";
                                    echo "<td>" . $index++ . "</td>";
                                    echo "<td>" . htmlspecialchars($row['MaDonChamSoc']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['HoTenKH']) . " (" . htmlspecialchars($row['MaKH']) . ")</td>";
                                    echo "<td>" . htmlspecialchars($row['TenThuCung']) . " (" . htmlspecialchars($row['MaThuCung']) . ")</td>";
                                    echo "<td>" . htmlspecialchars($row['TenDichVu']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["TinhTrangDon"]) . "</td>";
                                    echo "<td>
                                            <a href='details-invoice.php?MaDonChamSoc=" . $row['MaDonChamSoc'] . "' class='btn btn-info btn-sm'>Xem Chi Tiết</a><br>";
                                            
                                            if ($row['TinhTrangDon'] === 'Đang chăm sóc') {
                                                echo "<a href='quatrinhchamsoc.php?MaDonChamSoc=" . $row['MaDonChamSoc'] . "' class='btn btn-warning btn-sm'>Chăm sóc</a>";
                                            } 
                                                else if($row['TinhTrangDon'] === 'Đã chăm sóc'){    
                                            echo "<a href='export_pet.php?MaDonChamSoc=" . $row['MaDonChamSoc'] . "' class='btn btn-info btn-sm'>In piếu trả thú cưng</a><br>";
                                            }
                                                else if ($row['TinhTrangDon'] === 'Đang xử lý'){
                                                echo "<a href='javascript:void(0);' class='btn btn-info btn-sm' onclick='updateStatus(\"" . $row['MaDonChamSoc'] . "\")'>Xác nhận chăm sóc</a>";
                                            }
                                            else if ($row["TinhTrangDon"] === "Đã chăm sóc"){
                                                
                                                echo "<a href='invoice.php?MaDonChamSoc=" . $row['MaDonChamSoc'] . "' class='btn btn-warning btn-sm'>Xuất hóa đơn</a>";
                                            }
                                            else if ($row["TinhTrangDon"] === "Đã in hóa đơn"){
                                                
                                                echo "<a href='details.php?MaDonChamSoc=" . $row['MaDonChamSoc'] . "' class='btn btn-warning btn-sm'>Chi tiết hóa đơn</a>";
                                            }
                                            
                                            else if ($row["TinhTrangDon"] === "Đã in phiếu trả thú cưng"){
                                                echo "". $row[""] . "";
                                            }


                                    echo "</td>";
                                    echo "</tr>";

                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>Không có đơn chăm sóc nào được phân công cho bạn.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <style>
        /* Căn giữa nội dung trong bảng */
        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        /* Tùy chỉnh màu nền của tiêu đề bảng */
        .table thead th {
            background-color: #f2f2f2;
        }

        .app-breadcrumb {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 10px 15px;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .breadcrumb-item a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .breadcrumb-item a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        #status-label {
            font-weight: normal;
            color: #6c757d;
            margin-left: 10px;
            font-size: 0.95rem;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
        }

        .filter-buttons .btn {
            font-size: 14px;
            font-weight: bold;
            padding: 8px 16px;
            transition: background-color 0.3s ease;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table thead th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#sampleTable').DataTable({
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ dòng",
                    "zeroRecords": "Không tìm thấy kết quả",
                    "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                    "infoEmpty": "Hiển thị 0 đến 0 của 0 mục",
                    "infoFiltered": "(lọc từ _MAX_ tổng số mục)",
                    "search": "Tìm kiếm:",
                    "paginate": {
                        "first": "Đầu",
                        "last": "Cuối",
                        "next": "Tiếp",
                        "previous": "Trước"
                    }
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 6]
                }]
            });
        });
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

        function updateStatus(maDonChamSoc) {
            // Gửi yêu cầu AJAX
            $.ajax({
                url: 'php/update_status.php',
                type: 'POST',
                data: {
                    MaDonChamSoc: maDonChamSoc,
                    status: 'Đang chăm sóc'
                },
                success: function(response) {
                    if (response == 'success') {
                        alert('Tình trạng đơn đã được cập nhật thành "Đang chăm sóc".');
                        location.reload(); // Tải lại trang để cập nhật tình trạng
                    } else {
                        alert('Có lỗi xảy ra khi cập nhật tình trạng đơn.');
                    }
                },
                error: function() {
                    alert('Lỗi kết nối với máy chủ.');
                }
            });
        }
    </script>

</body>
<script src="js/main.js"></script>
<script src="js/hours.js"></script>
<script src="js/menu_active.js"></script>


</html>