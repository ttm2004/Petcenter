<?php

session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'QuanLy') {
  header("Location: ../Auth/login_register.php");
  exit();
}
include 'php/total.php';
include '../php/connect.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Trang dành cho Quản lý</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
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
  <style>
    #success-alert,
    #error-alert {
      animation: fadeInOut 3s forwards;
    }

    @keyframes fadeInOut {
      0% {
        opacity: 0;
      }

      10% {
        opacity: 1;
      }

      90% {
        opacity: 1;
      }

      100% {
        opacity: 0;
      }
    }
  </style>

</head>

<body onload="time()" class="app sidebar-mini rtl">
  <!-- Navbar-->
  <header class="app-header">
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
      aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">

      <div id="alert-box" style="display: none; padding: 15px; text-align: center; position: fixed; top: 10%; left: 50%; transform: translateX(-50%); z-index: 1000; border-radius: 5px;">
        <span id="alert-message"></span>
      </div>

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

      <!-- <li><a class="app-menu__item" href="table-data-money.php"><i class='app-menu__icon bx bx-dollar'></i><span
            class="app-menu__label">Bảng lương</span></a></li> -->
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
    <div class="row">
      <div class="col-md-12">
        <div class="app-title">
          <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="#"><b>Bảng điều khiển</b></a></li>
          </ul>
          <div id="clock"></div>
        </div>
      </div>
    </div>
    <div class="row">
      <!--Left-->
      <div class="col-md-12 col-lg-6">
        <div class="row">
          <!-- col-6 -->
          <div class="col-md-6">
            <div class="widget-small primary coloured-icon"><i class='icon bx bxs-user-account fa-3x'></i>
              <div class="info">
                <h4>Tổng khách hàng</h4>
                <p><b><?php echo $total_kh ?></b></p>
                <p class="info-tong">Tổng số khách hàng được quản lý.</p>
              </div>
            </div>
          </div>
          <!-- col-6 -->
          <div class="col-md-6">
            <div class="widget-small info coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
              <div class="info">
                <h4>Tổng sản phẩm</h4>
                <p><b><?php echo $total_products ?></b></p>
                <p class="info-tong">Tổng số sản phẩm được quản lý.</p>
              </div>
            </div>
          </div>
          <!-- col-6 -->
          <div class="col-md-6">
            <div class="widget-small warning coloured-icon"><i class='icon bx bxs-shopping-bags fa-3x'></i>
              <div class="info">
                <h4>Tổng hóa đơn</h4>
                <p><b><?php echo  $total_orders ?></b></p>
                <p class="info-tong">Tổng số hóa đơn chăm sóc thú cưng trong tháng.</p>
              </div>
            </div>
          </div>
          <!-- col-6 -->
          <div class="col-md-6">
            <div class="widget-small danger coloured-icon"><i class='icon bx bxs-error-alt fa-3x'></i>
              <div class="info">
                <h4>Sắp hết hàng</h4>
                <p><b id="outOfStockCount">0 sản phẩm</b></p>
                <p class="info-tong">Số sản phẩm cảnh báo hết cần nhập thêm.</p>
              </div>
            </div>
          </div>

          <!-- col-12 -->
          <div class="col-md-12">
            <div class="tile">
              <h3 class="tile-title">Tình trạng đơn hàng</h3>
              <div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>ID đơn hàng</th>
                      <th>Tên khách hàng</th>
                      <th>Tổng tiền</th>
                      <th>Trạng thái</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($orders as $order): ?>
                      <tr>
                        <td><?php echo htmlspecialchars($order['MaDH']); ?></td>
                        <td><?php echo htmlspecialchars($order['HoTenKH']); ?></td>
                        <td><?php echo number_format($order['TongTien'], 0, ',', '.') . ' đ'; ?></td>
                        <td>
                          <span class="badge <?php echo getBadgeClass($order['TrangThai']); ?>">
                            <?php echo htmlspecialchars($order['TrangThai']); ?>
                          </span>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- / div trống-->
            </div>
          </div>

          <?php
          // Hàm để xác định lớp badge dựa trên trạng thái
          function getBadgeClass($status)
          {
            switch ($status) {
              case 'Chờ xử lý':
                return 'bg-info';
              case 'Đang vận chuyển':
                return 'bg-warning';
              case 'Đã hoàn thành':
                return 'bg-success';
              case 'Đã hủy':
                return 'bg-danger';
              default:
                return '';
            }
          }
          ?>


          <!-- / col-12 -->
          <!-- col-12 -->
          <div class="col-md-12">
            <div class="tile">
              <h3 class="tile-title">Khách hàng mới</h3>
              <div>
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Tên khách hàng</th>
                      <th>Ngày sinh</th>
                      <th>Số điện thoại</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>#183</td>
                      <td>Hột vịt muối</td>
                      <td>21/7/1992</td>
                      <td><span class="tag tag-success">0921387221</span></td>
                    </tr>
                    <tr>
                      <td>#219</td>
                      <td>Bánh tráng trộn</td>
                      <td>30/4/1975</td>
                      <td><span class="tag tag-warning">0912376352</span></td>
                    </tr>
                    <tr>
                      <td>#627</td>
                      <td>Cút rang bơ</td>
                      <td>12/3/1999</td>
                      <td><span class="tag tag-primary">01287326654</span></td>
                    </tr>
                    <tr>
                      <td>#175</td>
                      <td>Hủ tiếu nam vang</td>
                      <td>4/12/20000</td>
                      <td><span class="tag tag-danger">0912376763</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
          <!-- / col-12 -->
        </div>
      </div>
      <!--END left-->
      <!--Right-->
      <div class="col-md-12 col-lg-6">
        <div class="row">
          <div class="col-md-12">
            <div class="tile">
              <h3 class="tile-title">Dữ liệu 6 tháng đầu vào</h3>
              <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="tile">
              <h3 class="tile-title">Thống kê 6 tháng doanh thu</h3>
              <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="barChartDemo"></canvas>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!--END right-->
    </div>


    <div class="text-center" style="font-size: 13px">
      <p><b>Copyright
          <script type="text/javascript">
            document.write(new Date().getFullYear());
          </script>
        </b></p>
    </div>
  </main>
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
  <script src="js/hours.js"></script>
  <script src="js/menu_active.js">

  </script>
</body>

</html>