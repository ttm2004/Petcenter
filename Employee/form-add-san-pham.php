<?php
include '../php/connect.php';

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $maSanPham = $_POST["ma_san_pham"];
  $tenSanPham = $_POST["ten_san_pham"];
  $soLuong = $_POST["so_luong"];
  $tinhTrang = $_POST["tinh_trang"];
  $danhMuc = $_POST["danh_muc"];
  $nhaCungCap = $_POST["nha_cung_cap"];
  $giaBan = $_POST["gia_ban"];
  $giaVon = $_POST["gia_von"];
  $moTa = $_POST["mo_ta"];
  $hinhAnh = $_FILES["ImageUpload"]["name"];

  // Xử lý upload ảnh
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["ImageUpload"]["name"]);
  move_uploaded_file($_FILES["ImageUpload"]["tmp_name"], $target_file);

  // Thêm sản phẩm vào cơ sở dữ liệu
  $sql = "INSERT INTO products (ma_san_pham, ten_san_pham, so_luong, tinh_trang, danh_muc, nha_cung_cap, gia_ban, gia_von, mo_ta, hinh_anh)
          VALUES ('$maSanPham', '$tenSanPham', '$soLuong', '$tinhTrang', '$danhMuc', '$nhaCungCap', '$giaBan', '$giaVon', '$moTa', '$hinhAnh')";

  if ($conn->query($sql) === TRUE) {
    echo "Thêm sản phẩm thành công!";
  } else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Thêm sản phẩm </title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <!-- or -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
  <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
  <script src="https://kit.fontawesome.com/54e4f189c9.js" crossorigin="anonymous"></script>
  <script>
    function readURL(input, thumbimage) {
      if (input.files && input.files[0]) { //Sử dụng  cho Firefox - chrome
        var reader = new FileReader();
        reader.onload = function(e) {
          $("#thumbimage").attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      } else { // Sử dụng cho IE
        $("#thumbimage").attr('src', input.value);

      }
      $("#thumbimage").show();
      $('.filename').text($("#uploadfile").val());
      $('.Choicefile').css('background', '#14142B');
      $('.Choicefile').css('cursor', 'default');
      $(".removeimg").show();
      $(".Choicefile").unbind('click');

    }
    $(document).ready(function() {
      $(".Choicefile").bind('click', function() {
        $("#uploadfile").click();

      });
      $(".removeimg").click(function() {
        $("#thumbimage").attr('src', '').hide();
        $("#myfileupload").php('<input type="file" id="uploadfile"  onchange="readURL(this);" />');
        $(".removeimg").hide();
        $(".Choicefile").bind('click', function() {
          $("#uploadfile").click();
        });
        $('.Choicefile').css('background', '#14142B');
        $('.Choicefile').css('cursor', 'pointer');
        $(".filename").text("");
      });
    })
  </script>
</head>

<body class="app sidebar-mini rtl">
  <style>
    .Choicefile {
      display: block;
      background: #14142B;
      border: 1px solid #fff;
      color: #fff;
      width: 150px;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      padding: 5px 0px;
      border-radius: 5px;
      font-weight: 500;
      align-items: center;
      justify-content: center;
    }

    .Choicefile:hover {
      text-decoration: none;
      color: white;
    }

    #uploadfile,
    .removeimg {
      display: none;
    }

    #thumbbox {
      position: relative;
      width: 100%;
      margin-bottom: 20px;
    }

    .removeimg {
      height: 25px;
      position: absolute;
      background-repeat: no-repeat;
      top: 5px;
      left: 5px;
      background-size: 25px;
      width: 25px;
      /* border: 3px solid red; */
      border-radius: 50%;

    }

    .removeimg::before {
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
      content: '';
      border: 1px solid red;
      background: red;
      text-align: center;
      display: block;
      margin-top: 11px;
      transform: rotate(45deg);
    }

    .removeimg::after {
      /* color: #FFF; */
      /* background-color: #DC403B; */
      content: '';
      background: red;
      border: 1px solid red;
      text-align: center;
      display: block;
      transform: rotate(-45deg);
      margin-top: -2px;
    }
  </style>
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
          <span class="app-menu__label">Trang Chủ</span></a></li>
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
  <main class="app-content">
    <div class="app-title">
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item">Danh sách sản phẩm</li>
        <li class="breadcrumb-item"><a href="#">Thêm sản phẩm</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Tạo mới sản phẩm</h3>
          <div class="tile-body">
            <div class="row element-button">
              <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i
                    class="fas fa-folder-plus"></i> Thêm nhà cung cấp</a>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#adddanhmuc"><i
                    class="fas fa-folder-plus"></i> Thêm danh mục</a>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#addtinhtrang"><i
                    class="fas fa-folder-plus"></i> Thêm tình trạng</a>
              </div>
            </div>
            <form class="row" method="POST" enctype="multipart/form-data">
              <div class="form-group col-md-3">
                <label class="control-label">Mã sản phẩm </label>
                <input class="form-control" type="number" name="ma_san_pham" required>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Tên sản phẩm</label>
                <input class="form-control" type="text" name="ten_san_pham" required>
              </div>

              <div class="form-group col-md-3">
                <label class="control-label">Số lượng</label>
                <input class="form-control" type="number" name="so_luong" required>
              </div>

              <div class="form-group col-md-3">
                <label for="exampleSelect1" class="control-label">Tình trạng</label>
                <select class="form-control" name="tinh_trang" required>
                  <option value="">-- Chọn tình trạng --</option>
                  <?php
                  $sql = "SELECT id, ten_tinh_trang FROM statuses";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row["id"] . "'>" . $row["ten_tinh_trang"] . "</option>";
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group col-md-3">
                <label for="exampleSelect1" class="control-label">Danh mục</label>
                <select class="form-control" name="danh_muc" required>
                  <option value="">-- Chọn danh mục --</option>
                  <?php
                  $sql = "SELECT id, ten_danh_muc FROM categories";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row["id"] . "'>" . $row["ten_danh_muc"] . "</option>";
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group col-md-3">
                <label for="exampleSelect1" class="control-label">Nhà cung cấp</label>
                <select class="form-control" name="nha_cung_cap" required>
                  <option value="">-- Chọn nhà cung cấp --</option>
                  <?php
                  $sql = "SELECT id, ten_nha_cung_cap FROM suppliers";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row["id"] . "'>" . $row["ten_nha_cung_cap"] . "</option>";
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group col-md-3">
                <label class="control-label">Giá bán</label>
                <input class="form-control" type="text" name="gia_ban" required>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Giá vốn</label>
                <input class="form-control" type="text" name="gia_von" required>
              </div>

              <div class="form-group col-md-12">
                <label class="control-label">Ảnh sản phẩm</label>
                <input type="file" id="uploadfile" name="ImageUpload" required>
              </div>

              <div class="form-group col-md-12">
                <label class="control-label">Mô tả sản phẩm</label>
                <textarea class="form-control" name="mo_ta" id="mota"></textarea>
                <script>
                  CKEDITOR.replace('mota');
                </script>
              </div>

              <button class="btn btn-save" type="submit">Lưu lại</button>
              <a class="btn btn-cancel" href="table-data-product.php">Hủy bỏ</a>
            </form>
          </div>
        </div>
  </main>


  <!--
  MODAL CHỨC VỤ 
-->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
          <div class="row">
            <div class="form-group  col-md-12">
              <span class="thong-tin-thanh-toan">
                <h5>Thêm mới nhà cung cấp</h5>
              </span>
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Nhập tên chức vụ mới</label>
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



  <!--
  MODAL DANH MỤC
-->
  <div class="modal fade" id="adddanhmuc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
          <div class="row">
            <div class="form-group  col-md-12">
              <span class="thong-tin-thanh-toan">
                <h5>Thêm mới danh mục </h5>
              </span>
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Nhập tên danh mục mới</label>
              <input class="form-control" type="text" required>
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Danh mục sản phẩm hiện đang có</label>
              <ul style="padding-left: 20px;">
                <li>Thức ăn cho chó</li>
                <li>Thức ăn cho mèo</li>
                <li>Thức ăn cho động vật nhỏ khác</li>
                <li>Dụng cụ chăm sóc lông</li>
                <li>Chuồng, lồng và đệm nằm</li>
                <li>Dây dắt và vòng cổ</li>
                <li>Đồ chơi cho chó</li>
                <li>Đồ chơi cho mèo</li>
                <li>Đồ chơi cho chuột hamster</li>
                <li>Thuốc ngừa ve, bọ chét</li>
                <li>Thuốc bổ và vitamin</li>
                <li>Sản phẩm vệ sinh</li>
                <li>Quần áo thời trang</li>
                <li>Giày dép cho thú cưng</li>
                <li>Mũ và khăn</li>
                <li>Thức ăn thưởng</li>
                <li>Bát ăn và bình nước</li>
                <li>Vận chuyển thú cưng</li>
              </ul>
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




  <!--
  MODAL TÌNH TRẠNG
-->
  <div class="modal fade" id="addtinhtrang" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
          <div class="row">
            <div class="form-group  col-md-12">
              <span class="thong-tin-thanh-toan">
                <h5>Thêm mới tình trạng</h5>
              </span>
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Nhập tình trạng mới</label>
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



  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/plugins/pace.min.js"></script>
  <script>
    const inpFile = document.getElementById("inpFile");
    const loadFile = document.getElementById("loadFile");
    const previewContainer = document.getElementById("imagePreview");
    const previewImage = previewContainer.querySelector(".image-preview__image");
    const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");
    inpFile.addEventListener("change", function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        previewDefaultText.style.display = "none";
        previewImage.style.display = "block";
        reader.addEventListener("load", function() {
          previewImage.setAttribute("src", this.result);
        });
        reader.readAsDataURL(file);
      }
    });
  </script>
</body>

</html>