<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'QuanLy') {
  header("Location: ../Auth/login_register.php");
  exit();
}

$username = $_SESSION['username'];

// Kết nối cơ sở dữ liệu
$servername = "localhost"; // hoặc địa chỉ máy chủ của bạn
$dbUsername = "root"; // tên đăng nhập của cơ sở dữ liệu
$dbPassword = ""; // mật khẩu của cơ sở dữ liệu
$dbname = "petcenter"; // tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn để lấy dữ liệu nhân viên dựa trên tên người dùng
$query = "SELECT 
              nhanvien.MaNV,
              nhanvien.AnhThe,
              nhanvien.HoTenNV,
              nhanvien.NgaySinh,
              nhanvien.GioiTinh,
              nhanvien.DiaChi,
              nhanvien.SoDienThoai,
              nhanvien.Email,
              nhanvien.SoCMND,
              nhanvien.NgayCapCMND,
              nhanvien.NoiCapCMND,           
              nhanvien.Username,
              nhanvien.MatKhau,
              nhanvien.VaiTro,
              nhanvien.NgayTao,
              nhanvien.NgayVaoLam,
              nhanvien.TrangThai
          FROM 
              nhanvien 
          INNER JOIN 
              users ON nhanvien.Username = users.Username 
          WHERE 
              users.Username = ?";
$stmt = $conn->prepare($query); // Chuẩn bị câu lệnh

// Kiểm tra nếu câu truy vấn chuẩn bị thất bại
if ($stmt === false) {
  die("Lỗi câu truy vấn: " . $conn->error); // Hiển thị lỗi nếu có
}

// Liên kết tham số và thực thi
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result(); // Lấy tập kết quả

if ($result->num_rows > 0) {
  // Có dữ liệu, thực hiện xử lý
  $employeeData = $result->fetch_assoc(); // Lấy dữ liệu nhân viên
  $_SESSION['manv'] = $employeeData['MaNV'];
  $_SESSION['anhthe'] = $employeeData['AnhThe'];
} else {
  echo "Không tìm thấy thông tin nhân viên."; // Thông báo nếu không có dữ liệu
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Thông tin cá nhân</title>
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
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <script src="https://kit.fontawesome.com/54e4f189c9.js" crossorigin="anonymous"></script>

</head>

<body onload="time()" class="app sidebar-mini rtl">

  <header class="app-header">
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
      aria-label="Hide Sidebar"></a>
    <ul class="app-nav">
      <div id="alert-box" style="display: none; padding: 15px; text-align: center; position: fixed; top: 10%; left: 50%; transform: translateX(-50%); z-index: 1000; border-radius: 5px;">
        <span id="alert-message"></span>
      </div>

      <li><a class="app-nav__item" href="../Auth/login_register.php"><i class='bx bx-log-out bx-rotate-180'></i> </a>
      </li>
    </ul>
  </header>
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
        <li class="breadcrumb-item active"><a href="#"><b>Thông tin cá nhân</b></a></li>
      </ul>
      <div id="clock"></div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="row">
              <?php
              // Hiển thị thông tin nhân viên đã đăng nhập
              if (isset($employeeData)) {
                // Mảng thông tin nhân viên
                $infoItems = [
                  'Mã Nhân viên' => $employeeData['MaNV'],
                  'Họ và tên' => $employeeData['HoTenNV'],
                  'Ngày sinh' => date("d/m/Y", strtotime($employeeData['NgaySinh'])),
                  'Giới tính' => ($employeeData['GioiTinh']),
                  'Địa chỉ' => $employeeData['DiaChi'],
                  'Số điện thoại' => $employeeData['SoDienThoai'],
                  'Email' => $employeeData['Email'],
                  'Số Căn cước công dân' => $employeeData['SoCMND'],
                  'Ngày cấp' => date("d/m/Y", strtotime($employeeData['NgayCapCMND'])),
                  'Nơi cấp' => $employeeData['NoiCapCMND'],
                  'Tên đăng nhập' => $employeeData['Username'],
                  'Mật khẩu' => $employeeData['MatKhau'],
                  'Vai trò' => $employeeData['VaiTro'],
                  'Ngày tạo' => date("d/m/Y", strtotime($employeeData['NgayTao'])),
                  'Ngày vào làm' => date("d/m/Y", strtotime($employeeData['NgayVaoLam'])),
                  'Trạng thái' => $employeeData['TrangThai'] ? 'Hoạt động' : 'Ngừng hoạt động',
                ];

                // Hiển thị ảnh đại diện
                echo '<div class="col-md-3 mb-4">';
                echo '<div class="bg-white border border-gray-200 rounded-lg p-4 shadow text-center">';
                echo '<img class="w-32 h-32 object-cover rounded-full mx-auto" src="' . $employeeData['AnhThe'] . '" alt="Ảnh nhân viên ' . $employeeData['HoTenNV'] . '">';
                echo '</div>';
                echo '</div>';

                // Hiển thị thông tin nhân viên
                foreach ($infoItems as $label => $value) {
                  echo '<div class="col-md-3 mb-4">';
                  echo '<div class="bg-white border border-gray-200 rounded-lg p-4 shadow">';
                  echo '<h6 class="text-gray-600 font-semibold">' . $label . ':</h6>';
                  echo '<p class="text-gray-700" style="word-break: break-all;">' . $value . '</p>';
                  echo '</div>';
                  echo '</div>';
                }

                // Thêm nút sửa thông tin
                echo '<div class="col-md-12 text-center mt-4">';
                echo '<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" title="Sửa thông tin cá nhân" id="show-emp" data-toggle="modal" data-target="#ModalUP">';
                echo '<i class="fas fa-edit"></i> Sửa thông tin cá nhân</button>'; // Đóng nút sau phần nội dung

                // Thêm khoảng cách cho nút thứ hai
                echo '<button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2" title="Sửa thông tin đăng nhập" id="show-login" data-toggle="modal" data-target="#ModalDown">';
                echo '<i class="fas fa-edit"></i> Sửa thông tin đăng nhập</button>'; // Đóng nút sau phần nội dung
                echo '</div>';
              } else {
                echo '<div class="col-md-12 text-center py-4 text-gray-500">Không có thông tin nhân viên.</div>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>




  <!--
  MODAL
-->
  <div class="modal fade" id="ModalUP" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form method="POST" action="php/edit-info.php"> <!-- Update action to your processing file -->
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-md-12">
                <h1 style="font-size: 1.5rem; color: #000000; text-align: center; font-weight: bold; margin-top: 20px; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                  Chỉnh sửa thông tin nhân viên
                </h1>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label class="control-label">ID nhân viên</label>
                <input class="form-control" type="text" name="MaNV" value="<?php echo $employeeData['MaNV']; ?>" readonly>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Họ và tên</label>
                <input class="form-control" type="text" name="HoTenNV" value="<?php echo $employeeData['HoTenNV']; ?>" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Ngày sinh</label>
                <input class="form-control" type="date" name="NgaySinh" value="<?php echo date('Y-m-d', strtotime($employeeData['NgaySinh'])); ?>" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Giới tính</label>
                <select class="form-control" name="GioiTinh" required>
                  <option value="<?php echo ($employeeData['GioiTinh']) ?>" id="active-opt" style="display:none;"><?php echo ($employeeData['GioiTinh']) ?></option>
                  <option value="Nam">Nam</option>
                  <option value="Nữ">Nữ</option>>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Địa chỉ</label>
                <input class="form-control" type="text" name="DiaChi" value="<?php echo $employeeData['DiaChi']; ?>" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Số điện thoại</label>
                <input class="form-control" type="tel" name="SoDienThoai" value="<?php echo $employeeData['SoDienThoai']; ?>" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Email</label>
                <input class="form-control" type="email" name="Email" value="<?php echo $employeeData['Email']; ?>" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Số Căn cước công dân</label>
                <input class="form-control" type="text" name="SoCMND" value="<?php echo $employeeData['SoCMND']; ?>" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Ngày cấp</label>
                <input class="form-control" type="date" name="NgayCapCMND" value="<?php echo date('Y-m-d', strtotime($employeeData['NgayCapCMND'])); ?>" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Nơi cấp</label>
                <input class="form-control" type="text" name="NoiCapCMND" value="<?php echo $employeeData['NoiCapCMND']; ?>" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Vai trò</label>
                <input class="form-control" type="text" name="VaiTro" value="<?php echo $employeeData['VaiTro']; ?>" readonly>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Ngày tạo</label>
                <input class="form-control" type="date" name="NgayTao" value="<?php echo date('Y-m-d', strtotime($employeeData['NgayTao'])); ?>" readonly>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Trạng thái</label>
                <input class="form-control" type="text" value="<?php echo ($employeeData['TrangThai']); ?>" readonly>
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
  <div class="modal fade" id="ModalDown" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form method="POST" action="php/edit-info-login.php"> <!-- Update action to your processing file -->
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-md-12">
                <h1 style="font-size: 1.5rem; color: #000000; text-align: center; font-weight: bold; margin-top: 20px; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                  Chỉnh sửa thông tin đăng nhập
                </h1>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label class="control-label">Tên đăng nhập</label>
                <input class="form-control" type="text" name="Username" value="<?php echo $employeeData['Username']; ?>" readonly>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Mật khẩu</label>
                <input class="form-control" type="password" name="Password" value="<?php echo $employeeData['MatKhau']; ?>">
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
  <!--
  MODAL
-->

  <!-- Essential javascripts for application to work-->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="src/jquery.table2excel.js"></script>
  <script src="js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="js/plugins/pace.min.js"></script>
  <!-- Page specific javascripts-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <!-- Data table plugin-->
  <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
  <script src="js/hours.js"></script>
  <script src="js/menu_active.js">
    // Hiển thị thông báo
    function showAlert(status, message) {
      const alertBox = document.getElementById('alert-box');
      const alertMessage = document.getElementById('alert-message');

      // Đặt màu nền dựa trên trạng thái
      if (status === "success") {
        alertBox.style.backgroundColor = "#4caf50"; // Màu xanh
        alertBox.style.color = "white";
      } else if (status === "error") {
        alertBox.style.backgroundColor = "#f44336"; // Màu đỏ
        alertBox.style.color = "white";
      }

      // Hiển thị thông báo
      alertMessage.textContent = message;
      alertBox.style.display = "block";

      // Tự động ẩn sau 3 giây
      setTimeout(() => {
        alertBox.style.display = "none";
      }, 3000);
    }

    // Kiểm tra trạng thái từ PHP
    <?php if (isset($_SESSION['status']) && isset($_SESSION['message'])): ?>
      showAlert("<?php echo $_SESSION['status']; ?>", "<?php echo $_SESSION['message']; ?>");
      <?php unset($_SESSION['status'], $_SESSION['message']); // Xóa trạng thái sau khi hiển thị 
      ?>
    <?php endif; ?>
  </script>

</body>

</html>