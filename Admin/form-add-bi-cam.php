<?php
session_start();
// Kết nối đến cơ sở dữ liệu
$servername = "localhost"; // Thay đổi nếu cần
$username = "root"; // Thay đổi tên người dùng của bạn
$password = ""; // Thay đổi mật khẩu của bạn
$dbname = "petcenter"; // Thay đổi tên cơ sở dữ liệu của bạn

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Kết nối không thành công: " . $conn->connect_error);
}
$username = $_SESSION['username'];
$sql = "SELECT MaNV FROM users WHERE Username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($employee_id);
$stmt->fetch();
// Kiểm tra xem có dữ liệu được gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Lấy dữ liệu từ formx`
  $maNV = $_POST['MaNV'];
  $ngayBatDau = $_POST['NgayBatDau'];
  $ngayKetThuc = $_POST['NgayKetThuc'];
  $soNgayNghi = $_POST['SoNgayNghi'];
  $ngayDiLam = $_POST['NgayDiLam'];
  $lyDo = $_POST['LyDo'];

  // Chuẩn bị truy vấn SQL để thêm dữ liệu
  $sql = "INSERT INTO nghiphep (MaNV, NgayBatDau, NgayKetThuc, SoNgayNghi,NgayDiLam, LyDo)
            VALUES (?, ?, ?, ?, ?,?)";

  // Sử dụng prepared statement để tránh SQL injection
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssiss", $maNV, $ngayBatDau, $ngayKetThuc, $soNgayNghi, $ngayDiLam, $lyDo);

  // Thực hiện truy vấn và kiểm tra kết quả
  if ($stmt->execute()) {
    echo "Yêu cầu nghỉ phép đã được thêm thành công.";
    header("location: table-data-banned.php");
  } else {
    echo "Lỗi: " . $stmt->error;
  }

  // Đóng statement
  $stmt->close();
}

// Đóng kết nối
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <title>Danh sách đơn hàng | Quản trị Admin</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="./css/main.css">
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
      <li><a class="app-menu__item" href="form-table-customer.php"><i class='app-menu__icon fa-solid fa-user'></i><span
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
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item">Quản lý nội bộ</li>
        <li class="breadcrumb-item"><a href="#">Tạo mới</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Tạo mới yêu cầu xin nghỉ phép</h3>
          <div class="tile-body">
            <form class="row" action="" id="leaveRequestForm" method="POST">
              <div class="form-group col-md-1" style="display: none;">
                <label class="control-label">Mã Ng</label>
                <input class="form-control" type="text" name="MaNg" id="MaNg" value="AUTO_GENERATED_ID" readonly>
              </div>
              <div class="form-group col-md-2" style="display:none;">
                <label class="control-label">Mã NV</label>
                <input class="form-control" type="text" name="MaNV" id="MaNV" value="<?php echo htmlspecialchars($employee_id); ?>" readonly>
              </div>

              <div class="form-group col-md-2">
                <label class="control-label">Ngày bắt đầu</label>
                <input class="form-control" type="date" name="NgayBatDau" id="NgayBatDau" required onchange="calculateDays();">
              </div>
              <div class="form-group col-md-2">
                <label class="control-label">Ngày kết thúc</label>
                <input class="form-control" type="date" name="NgayKetThuc" id="NgayKetThuc" required onchange="calculateDays();">
              </div>
              <div class="form-group col-md-2">
                <label class="control-label">Số ngày nghỉ</label>
                <input class="form-control" type="number" name="SoNgayNghi" id="SoNgayNghi" readonly>
              </div>
              <div class="form-group col-md-2">
                <label class="control-label">Ngày đi làm</label>
                <input class="form-control" type="date" name="NgayDiLam" id="NgayDiLam" readonly>
              </div>
              <div class="form-group col-md-4"> <!-- Thay đổi từ col-md-4 thành col-md-8 -->
                <label class="control-label">Lý do</label>
                <textarea class="form-control" name="LyDo" rows="4" required></textarea>
              </div>
              <div class="tile-footer col-md-12">
                <button class="btn btn-save" type="button">Lưu lại</button>
                <a class="btn btn-cancel" href="table-data-banned.php">Hủy bỏ</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      function calculateDays() {
        const startDate = new Date(document.getElementById('NgayBatDau').value);
        const endDate = new Date(document.getElementById('NgayKetThuc').value);
        const timeDiff = endDate - startDate;

        if (timeDiff >= 0) {
          const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // Include the end date
          document.getElementById('SoNgayNghi').value = daysDiff;

          // Tính toán và thiết lập ngày đi làm
          const workingDay = new Date(endDate);
          workingDay.setDate(workingDay.getDate() + 1); // Thêm 1 ngày
          document.getElementById('NgayDiLam').value = workingDay.toISOString().split('T')[0]; // Chuyển đổi thành định dạng YYYY-MM-DD
        } else {
          document.getElementById('SoNgayNghi').value = 0; // Reset nếu ngày không hợp lệ
          document.getElementById('NgayDiLam').value = ''; // Reset ngày đi làm
        }
      }
    </script>




  </main>

  <!--
  MODAL
-->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
          <div class="row">
            <div class="form-group  col-md-12">
              <span class="thong-tin-thanh-toan">
                <h5>Tạo trình trạng mới</h5>
              </span>
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Nhập tình trạng</label>
              <input class="form-control" type="text" required>
            </div>
          </div>
          <BR>
          <button class="btn btn-save" type="button">Lưu lại</button>
          <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
          <BR>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!--
MODAL
-->

  <!-- Essential javascripts for application to work-->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="js/plugins/pace.min.js"></script>

</body>

</html>