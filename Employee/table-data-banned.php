<?php
session_start(); // Bắt đầu phiên làm việc

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Danh sách đơn hàng | Quản trị Admin</title>
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
            class="app-menu__label" style="white-space: wrap;">Đơn dịch vụ thú cưng</a></li>
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
        <li class="breadcrumb-item active"><a href="#"><b>Quản lý nội bộ</b></a></li>
      </ul>
      <div id="clock"></div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">
            <div class="row element-button">
              <div class="col-sm-2">

                <a class="btn btn-add btn-sm" href="form-add-bi-cam.php" title="Thêm"><i class="fas fa-plus"></i>
                  Tạo mới</a>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập" onclick="myFunction(this)"><i
                    class="fas fa-file-upload"></i> Tải từ file</a>
              </div>

              <div class="col-sm-2">
                <a class="btn btn-delete btn-sm print-file" type="button" title="In" onclick="myApp.printTable()"><i
                    class="fas fa-print"></i> In dữ liệu</a>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-delete btn-sm print-file js-textareacopybtn" type="button" title="Sao chép"><i
                    class="fas fa-copy"></i> Sao chép</a>
              </div>

              <div class="col-sm-2">
                <a class="btn btn-excel btn-sm" href="" title="In"><i class="fas fa-file-excel"></i> Xuất Excel</a>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i
                    class="fas fa-file-pdf"></i> Xuất PDF</a>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-delete btn-sm" type="button" title="Xóa" onclick="myFunction(this)"><i
                    class="fas fa-trash-alt"></i> Xóa tất cả </a>
              </div>
            </div>
            <table class="table table-hover table-bordered" id="sampleTable">
              <thead>
                <tr>
                  <th width="10"><input type="checkbox" id="all"></th>
                  <th>Họ và tên</th>
                  <th>Vai trò</th>
                  <th>Ngày bắt đầu</th>
                  <th>Ngày kết thúc</th>
                  <th>Số ngày nghỉ</th>
                  <th>Lý do</th>
                  <th>Chức năng</th>
                </tr>
              </thead>
              <tbody>
                <?php


                
                $username = $_SESSION['username']; // Lấy tên người dùng từ phiên làm việc

                // Câu lệnh SQL để lấy dữ liệu của nhân viên đã đăng nhập
                $sql = "SELECT nhanvien.MaNV, nhanvien.HoTenNV, nhanvien.VaiTro, nghiphep.NgayBatDau, nghiphep.NgayKetThuc, nghiphep.SoNgayNghi, nghiphep.LyDo 
                        FROM nghiphep 
                        JOIN nhanvien ON nghiphep.MaNV = nhanvien.MaNV 
                        JOIN Users ON Users.Username = nhanvien.Username 
                        WHERE Users.Username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username); // Ràng buộc biến
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                  // Lặp qua từng dòng dữ liệu
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td width='10'><input type='checkbox' name='check1' value='" . $row['MaNV'] . "'></td>";
                    echo "<td>" . $row['HoTenNV'] . "</td>";
                    echo "<td>" . $row['VaiTro'] . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row['NgayBatDau'])) . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row['NgayKetThuc'])) . "</td>";
                    echo "<td>" . $row['SoNgayNghi'] . "</td>";
                    echo "<td>" . $row['LyDo'] . "</td>";
                    echo "<td>
                <button class='btn btn-primary btn-sm trash' type='button' title='Xóa'><i class='fas fa-trash-alt'></i></button>
                <button class='btn btn-primary btn-sm edit' type='button' title='Sửa'><i class='fa fa-edit'></i></button>
              </td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='8'>Không có dữ liệu nào.</td></tr>"; // Cập nhật số cột
                }

                // Đóng câu lệnh và kết nối
                $stmt->close();
                $conn->close();
                ?>

              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </main>
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
  <script type="text/javascript">
    $('#sampleTable').DataTable();
  </script>
  <script src="js/">
    function deleteRow(r) {
      var i = r.parentNode.parentNode.rowIndex;
      document.getElementById("myTable").deleteRow(i);
    }
    jQuery(function() {
      jQuery(".trash").click(function() {
        swal({
            title: "Cảnh báo",

            text: "Bạn có chắc chắn là muốn xóa?",
            buttons: ["Hủy bỏ", "Đồng ý"],
          })
          .then((willDelete) => {
            if (willDelete) {
              swal("Đã xóa thành công.!", {

              });
            }
          });
      });
    });
    oTable = $('#sampleTable').dataTable();
    $('#all').click(function(e) {
      $('#sampleTable tbody :checkbox').prop('checked', $(this).is(':checked'));
      e.stopImmediatePropagation();
    });

    EXCEL
    $(document).ready(function() {
      $('#').DataTable({

        dom: 'Bfrtip',
        "buttons": [
          'excel'
        ]
      });
    });

    function stt() {
      var stt = document.getElementById('stt');
      stt = 0;
      $('#sampleTable tr').each(function() {
        stt++;
        $(this).find('td:first').text(stt);
      });
    }
    //Thời Gian
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
    //In dữ liệu
    var myApp = new function() {
      this.printTable = function() {
        var tab = document.getElementById('sampleTable');
        var win = window.open('', '', 'height=700,width=700');
        win.document.write(tab.outerHTML);
        win.document.close();
        win.print();
      }
    }
    //     //Sao chép dữ liệu
    //     var copyTextareaBtn = document.querySelector('.js-textareacopybtn');

    // copyTextareaBtn.addEventListener('click', function(event) {
    //   var copyTextarea = document.querySelector('.js-copytextarea');
    //   copyTextarea.focus();
    //   copyTextarea.select();

    //   try {
    //     var successful = document.execCommand('copy');
    //     var msg = successful ? 'successful' : 'unsuccessful';
    //     console.log('Copying text command was ' + msg);
    //   } catch (err) {
    //     console.log('Oops, unable to copy');
    //   }
    // });


    //Modal
    $("#show-emp").on("click", function() {
      $("#ModalUP").modal({
        backdrop: false,
        keyboard: false
      })
    });
  </script>
</body>

</html>