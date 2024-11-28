<?php
include '../php/connect.php';

if (isset($_POST['save_order'])) {
    // Kết nối đến cơ sở dữ liệu
    $conn = new mysqli("localhost", "root", "", "petcenter");
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Lấy dữ liệu từ form
    $MaKH = $_POST['MaKH'];
    $received_time = $_POST['received_time'];
    $return_time = $_POST['return_time'];
    $notes = $_POST['notes'];

    // Tạo mã đơn chăm sóc duy nhất
    $MaDonChamSoc = 'DCS' . date("YmdHis") . rand(100, 999);

    // Thêm đơn chăm sóc vào bảng donchamsoc
    $sql_order = "INSERT INTO donchamsoc (MaDonChamSoc, MaKH, NgayBatDau, NgayKetThuc, TinhTrangDon, GhiChu, NgayTaoDon) 
                  VALUES (?, ?, ?, ?, 'Đang xử lý', ?, NOW())";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("sssss", $MaDonChamSoc, $MaKH, $received_time, $return_time, $notes);

    if (!$stmt_order->execute()) {
        die("Lỗi khi thêm đơn chăm sóc: " . $stmt_order->error);
    }

    // Kiểm tra nếu thư mục Image tồn tại, nếu không thì tạo
    $upload_dir = 'Image/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    foreach ($_POST['pet_name'] as $index => $pet_name) {
        $pet_type = $_POST['pet_type'][$index];
        $pet_color = $_POST['pet_color'][$index];
        $pet_status = $_POST['pet_status'][$index];
        $pet_weight = $_POST['pet_weight'][$index];
        $DichVuChon = $_POST['DichVuChon'][$index]; // Get service for the pet

        // Xử lý ảnh thú cưng
        $image_name = $_FILES['pet_image']['name'][$index];
        $image_temp = $_FILES['pet_image']['tmp_name'][$index];

        // Đường dẫn đầy đủ của ảnh
        $image_path = $upload_dir . basename($image_name);
        if (!move_uploaded_file($image_temp, $image_path)) {
            echo "<div class='alert alert-danger'>Không thể tải ảnh lên: $image_name</div>";
            continue; // Bỏ qua vòng lặp nếu không tải được ảnh
        }

        // Thêm thú cưng vào bảng thucung với đường dẫn ảnh
        $sql_pet = "INSERT INTO ThuCung (TenThuCung, MaKH, TinhTrang, MauSac, CanNang, HinhAnh, NgayTiepNhan, GhiChu, MaDonChamSoc, LoaiThuCung, MaDichVu) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)";
        $stmt_pet = $conn->prepare($sql_pet);
        $stmt_pet->bind_param("sissssssis", $pet_name, $MaKH, $pet_status, $pet_color, $pet_weight, $image_path, $notes, $MaDonChamSoc, $pet_type, $DichVuChon);

        if ($stmt_pet->execute()) {
            echo "<div class='alert alert-success'>Thêm thú cưng thành công!</div>";
            header('Location: inphieuhen.php?MaDonChamSoc=' . $MaDonChamSoc);
        } else {
            echo "<div class='alert alert-danger'>Lỗi khi thêm thú cưng: " . $stmt_pet->error . "</div>";
        }
    }

    // Đóng kết nối
    $stmt_order->close();
    $stmt_pet->close();
    $conn->close();
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
  <title>Tạo mới đơn chăm sóc</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

  <!-- Boxicons -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

  <!-- jQuery Confirm CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

  <!-- Select2 CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

  <!-- Main CSS -->
  <link rel="stylesheet" type="text/css" href="css/main.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

  <!-- Select2 JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <!-- jQuery Confirm JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

  <!-- SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Font Awesome Kit -->
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
        <li class="breadcrumb-item">Danh sách đơn chăm sóc</li>
        <li class="breadcrumb-item"><a href="#">Thêm đơn chăm sóc</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Tạo mới đơn chăm sóc</h3>
          <div class="tile-body">
            <form class="row g-3" action="" method="POST" enctype="multipart/form-data">
              <div class="form-group col-md-6">
                <label class="control-label">Mã Khách hàng</label>
                <select class="form-control" name="MaKH" required>
                  <option value="">-- Chọn khách hàng --</option>
                  <?php
                  $query = "SELECT MaKH, HoTenKH FROM khachhang";
                  $result = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['MaKH']}'>{$row['HoTenKH']}</option>";
                  }
                  ?>
                </select>
              </div>
              <!-- <div class="form-group col-md-6">
                <label class="control-label">Dịch vụ</label>
                <select class="form-control" name="DichVuChon" required>
                  <option value="">-- Chọn dịch vụ --</option>
                  
                </select>

              </div>  -->
              <div class="form-group col-md-6">
                <label class="control-label">Thời gian nhận</label>
                <input class="form-control" type="datetime-local" name="received_time" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Thời gian trả</label>
                <input class="form-control" type="datetime-local" name="return_time" required>
              </div>



              <div class="col-12">
                <h4>Thông tin thú cưng</h4>
                <div id="petContainer" class="mb-3">
                  <div class="row pet-group border rounded p-3 mb-3">
                    <div class="form-group col-md-4">
                      <label class="control-label">Tên thú cưng</label>
                      <input class="form-control" type="text" name="pet_name[]" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label">Loại thú cưng</label>
                      <select class="form-control" name="pet_type[]" required>
                        <option value="">-- Chọn loại thú cưng --</option>
                        <?php
                        $query = "SELECT MaLoaiThuCung, TenLoaiThuCung FROM loaithucung";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<option value='{$row['MaLoaiThuCung']}'>{$row['TenLoaiThuCung']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label">Dịch vụ</label>
                      <select class="form-control" name="DichVuChon[]" required>
                        <option value="">-- Chọn dịch vụ --</option>
                        <?php
                        $query = "SELECT MaDichVu, TenDichVu FROM dichvu";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<option value='{$row['MaDichVu']}'>{$row['TenDichVu']}</option>";
                        }
                        ?>
                      </select>
                    </div>

                    <div class="form-group col-md-4">
                      <label class="control-label">Hình ảnh</label>
                      <input class="form-control" type="file" name="pet_image[]" accept="image/*" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label">Màu sắc</label>
                      <input class="form-control" type="text" name="pet_color[]" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label">Tình trạng</label>
                      <input class="form-control" type="text" name="pet_status[]" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label">Cân nặng</label>
                      <input class="form-control" type="number" name="pet_weight[]" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label class="control-label">Ghi chú</label>
                      <textarea class="form-control" rows="4" name="notes" required></textarea>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-secondary mb-3" onclick="addPet()">Thêm thú cưng</button>
              </div>

              <div class="col-12 text-end">
                <button class="btn btn-primary" type="submit" name="save_order">Lưu lại</button>
                <a class="btn btn-danger" href="../Employee/table-data-oder.php">Hủy bỏ</a>
              </div>
            </form>

            <script>
              function addPet() {
                const petContainer = document.getElementById("petContainer");
                const petGroup = document.createElement("div");
                petGroup.className = "row pet-group border rounded p-3 mb-3";
                petGroup.innerHTML = `
                <div class="form-group col-md-4">
                      <label class="control-label">Tên thú cưng</label>
                      <input class="form-control" type="text" name="pet_name[]" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label">Loại thú cưng</label>
                      <select class="form-control" name="pet_type[]" required>
                        <option value="">-- Chọn loại thú cưng --</option>
                        <?php
                        $query = "SELECT MaLoaiThuCung, TenLoaiThuCung FROM loaithucung";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<option value='{$row['MaLoaiThuCung']}'>{$row['TenLoaiThuCung']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Dịch vụ</label>
                        <select class="form-control" name="DichVuChon[]" required>
                            <option value="">-- Chọn dịch vụ --</option>
                            <?php
                            $query = "SELECT MaDichVu, TenDichVu FROM dichvu";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                              echo "<option value='{$row['MaDichVu']}'>{$row['TenDichVu']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                      <label class="control-label">Hình ảnh</label>
                      <input class="form-control" type="file" name="pet_image[]" accept="image/*" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label">Màu sắc</label>
                      <input class="form-control" type="text" name="pet_color[]" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label">Tình trạng</label>
                      <input class="form-control" type="text" name="pet_status[]" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label">Cân nặng</label>
                      <input class="form-control" type="number" name="pet_weight[]" required>
                    </div>
                    `;
                petContainer.appendChild(petGroup);
              }
            </script>
          </div>
        </div>
      </div>
    </div>
  </main>





  <script>
    $(document).ready(function() {
      $('#customerSelect').select2({
        placeholder: "-- Chọn khách hàng --", // Placeholder cho dropdown
        allowClear: true // Cho phép người dùng xóa lựa chọn
      });
    });

    function setCurrentDateTime() {
      var now = new Date(); // Lấy ngày giờ hiện tại
      var year = now.getFullYear();
      var month = ('0' + (now.getMonth() + 1)).slice(-2); // Thêm số 0 phía trước nếu cần
      var day = ('0' + now.getDate()).slice(-2);
      var hours = ('0' + now.getHours()).slice(-2);
      var minutes = ('0' + now.getMinutes()).slice(-2);

      var formattedDateTime = year + '-' + month + '-' + day + 'T' + hours + ':' + minutes;

      // Điền giá trị vào ô nhập liệu
      document.getElementById('received_time').value = formattedDateTime;
    }

    // Gọi hàm để set giá trị ngày giờ khi tải trang
    window.onload = setCurrentDateTime;
  </script>

  <!-- Essential javascripts for application to work-->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="js/plugins/pace.min.js"></script>
</body>

</html>