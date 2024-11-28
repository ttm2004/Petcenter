<?php
include '../php/connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Danh sách sản phẩm</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="css/main.css">
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
        <li class="breadcrumb-item active"><a href="#"><b>Danh sách sản phẩm</b></a></li>
      </ul>
      <div id="clock"></div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="row element-button">

              <div class="col-sm-4">
                <select id="loaiSanPham" class="form-control" onchange="filterTable()">
                  <option value="">Chọn loại sản phẩm</option>
                  <?php
                  // Lấy danh sách loại sản phẩm
                  $loaiSanPhamSQL = "SELECT * FROM loaisanpham";
                  $loaiResult = $conn->query($loaiSanPhamSQL);
                  if ($loaiResult->num_rows > 0) {
                    while ($loaiRow = $loaiResult->fetch_assoc()) {
                      echo "<option value='" . $loaiRow['MaLoai'] . "'>" . $loaiRow['TenLoai'] . "</option>";
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-4">
                <select id="soLuongFilter" class="form-control" onchange="filterTable()">
                  <option value="">Tất cả số lượng</option>
                  <option value="high">Số lượng nhiều</option>
                  <option value="low">Số lượng ít</option>
                </select>
              </div>

              <div class="col-sm-12">
                <div id="productCount" class="mb-3"></div>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-add btn-sm" href="form-add-san-pham.php" title="Thêm"><i class="fas fa-plus"></i> Tạo mới sản phẩm</a>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-delete btn-sm" type="button" title="Xóa" onclick="myFunction(this)"><i class="fas fa-trash-alt"></i> Xóa tất cả</a>
              </div>
            </div>

            <div class="row mt-3 mb-3">
              <div class="col-sm-4">
                <span class="display-text">Hiển thị</span>
                <select id="recordCount" class="form-control custom-select" onchange="updateRecordCount()">
                  <option value="5">5</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                </select>
                <span class="display-text">sản phẩm</span>
              </div>
              <div class="col-sm-8"> <!-- Điều chỉnh kích thước cột ở đây -->
                <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm theo mã sản phẩm hoặc tên sản phẩm" onkeyup="searchTable()">
              </div>
            </div>



            <style>
              .display-text {
                font-size: 1rem;
                /* Font size for the text */
                margin: 0 0.5rem;
                /* Margin for spacing between text and dropdown */
                line-height: 2;
                /* Align with dropdown height */
              }

              .custom-select {
                font-size: 1rem;
                /* Font size for the dropdown */
                width: 4em;
                padding: 0.4rem 0.75rem;
                /* Adjust padding for compactness */
                height: auto;
                /* Allow auto height */
                border-radius: 0.3rem;
                /* Rounded corners */
                border: 1px solid #ced4da;
                /* Standard border color */
              }

              .custom-select:focus {
                border-color: #80bdff;
                /* Border color on focus */
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                /* Focus shadow */
              }

              @media (max-width: 768px) {
                .display-text {
                  font-size: 0.9rem;
                  /* Smaller font size on smaller screens */
                }

                .custom-select {
                  font-size: 0.9rem;
                  /* Smaller font size for dropdown */
                  padding: 0.3rem 0.6rem;
                  /* Less padding on smaller screens */
                }
              }
            </style>

            <table class="table table-hover table-bordered js-copytextarea" id="sampleTable">
              <thead>
                <tr>
                  <th width='10'><input type='checkbox' id='all' name='check1' onclick="toggleAllCheckboxes(this)"></th>
                  <th>STT</th> <!-- Thêm cột Số Thứ Tự -->
                  <th>Mã sản phẩm</th>
                  <th>Tên sản phẩm</th>
                  <th>Loại sản phẩm</th>
                  <th>Giá bán</th>
                  <th>Chi tiết</th>
                  <th>Số lượng</th>
                  <th>Hình ảnh</th>
                  <th>Chức năng</th>
                </tr>
              </thead>
              <tbody id="customerTableBody">
                <?php
                $records_per_page = 7; // Số lượng bản ghi mỗi trang
                $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($current_page - 1) * $records_per_page;
                // Join hai bảng để lấy thông tin sản phẩm và loại sản phẩm
                $sql = "SELECT sanpham.MaSP, sanpham.TenSP, sanpham.MaLoai, loaisanpham.TenLoai, sanpham.Gia, sanpham.MoTa, sanpham.SoLuong, sanpham.HinhAnh
                                  FROM sanpham 
                                  JOIN loaisanpham ON sanpham.MaLoai = loaisanpham.MaLoai";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td width='10'><input type='checkbox' name='check1' value='" . $row['MaSP'] . "'></td>" .
                      "<td></td>"; // Ô Số Thứ Tự sẽ được cập nhật bằng JavaScript
                    echo "<td>" . $row["MaSP"] . "</td>";
                    echo "<td>" . $row['TenSP'] . "</td>";
                    echo "<td>" . $row['TenLoai'] . "</td>";
                    echo "<td>" . number_format($row['Gia'], 0, ',', '.') . " VNĐ</td>";
                    echo "<td>" . $row['MoTa'] . "</td>";
                    echo "<td><input class='so--luong1' type='number' value='" . $row['SoLuong'] . "' readonly></td>"; // Sử dụng readonly
                    echo "<td><img src='" . $row['HinhAnh'] . "' alt='Ảnh sản phẩm' width='100px' height='100px'></td>";
                    echo "<td style='text-align: center; vertical-align: middle;'>
                                          <button class='btn btn-primary btn-sm trash' type='button' title='Xóa'>
                                              <i class='fas fa-trash-alt'></i>
                                          </button>
                                        </td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='10'>Không có sản phẩm nào</td></tr>";
                }
                // Đếm tổng số bản ghi để tính số trang
                $count_query = "SELECT COUNT(*) as total FROM KhachHang";
                $count_result = mysqli_query($conn, $count_query);
                $total_records = mysqli_fetch_assoc($count_result)['total'];
                $total_pages = ceil($total_records / $records_per_page);
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    // Tự động gán số thứ tự cho các hàng trong bảng
    window.onload = function() {
      const rows = document.querySelectorAll('#customerTableBody tr');
      rows.forEach((row, index) => {
        const cell = row.cells[1]; // Lấy ô số thứ tự (cột thứ 2)
        cell.textContent = index + 1; // Gán số thứ tự (index + 1)
      });
    }
  </script>

  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
  <script src="src/jquery.table2excel.js"></script>
  <script src="js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="js/plugins/pace.min.js"></script>
  <!-- Page specific javascripts-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <!-- Data table plugin-->
  <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript" src="js/hours.js"></script>
  <script type="text/javascript" src="js/menu_active.js"></script>

</body>

</html>