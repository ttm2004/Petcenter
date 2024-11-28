<?php

include '../php/connect.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Lấy dữ liệu từ form
  $HoTen = $_POST['HoTen'];
  $DiaChi = $_POST['DiaChi'];
  $Email = $_POST['Email'];
  $SoDienThoai = $_POST['SoDienThoai'];
  $MaThuCung = $_POST['MaThuCung'];

  // Chuẩn bị câu lệnh SQL để thêm khách hàng
  $sql = "INSERT INTO KhachHang (HoTen, DiaChi, Email, SoDienThoai ) 
          VALUES ('$HoTen', '$DiaChi', '$Email', '$SoDienThoai')";

  // Thực thi câu truy vấn
  if (mysqli_query($conn, $sql)) {
    echo "Thêm khách hàng mới thành công!";
  } else {
    echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bán hàng</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="../Employee/css/main.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <!-- or -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css"> -->
</head>


<body onload="time()" class="app sidebar-mini rtl">
  <!-- Navbar-->
  <header class="app-header">
    <!-- Sidebar toggle button-->
    <!-- Navbar Right Menu-->
    <ul class="app-nav">


      <!-- User Menu-->
      <li><a class="app-nav__item" href="../Auth/login_register.php"><i class='bx bx-log-out bx-rotate-180'></i> </a>

      </li>
    </ul>
  </header>
  <!-- Sidebar menu-->

  <main class="app app-ban-hang">
    <div class="row">
      <div class="col-md-12">
        <div class="app-title">
          <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="#"><b>POS bán hàng</b></a></li>
          </ul>
          <div id="clock"></div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="tile">
          <h3 class="tile-title">Phần mềm bán hàng</h3>

          <input type="text" id="myInput" onkeyup="filterProducts()" placeholder="Nhập mã sản phẩm hoặc tên sản phẩm để tìm kiếm...">

          <div class="du--lieu-san-pham">
            <table class="table table-hover table-bordered" id="sampleTable">
              <thead>
                <tr>
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
              <tbody>
                <?php
                $sql = "SELECT sanpham.MaSP, sanpham.TenSP, loaisanpham.TenLoai, sanpham.Gia, sanpham.MoTa, sanpham.SoLuong, sanpham.HinhAnh
                      FROM sanpham 
                      JOIN loaisanpham ON sanpham.MaLoai = loaisanpham.MaLoai";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr data-masp='" . $row['MaSP'] . "' data-tensp='" . $row['TenSP'] . "' data-gia='" . $row['Gia'] . "' data-hinh='" . $row['HinhAnh'] . "'>";
                    echo "<td>" . $row['MaSP'] . "</td>";
                    echo "<td>" . $row['TenSP'] . "</td>";
                    echo "<td>" . $row['TenLoai'] . "</td>";
                    echo "<td>" . number_format($row['Gia'], 0, ',', '.') . " VNĐ</td>";
                    echo "<td>" . $row['MoTa'] . "</td>";
                    echo "<td><input class='so--luong1' type='number' min='1' value='1' max='" . $row['SoLuong'] . "'></td>"; // Giới hạn số lượng
                    echo "<td><img src='" . $row['HinhAnh'] . "' alt='Ảnh sản phẩm' width='50px'></td>";
                    echo "<td style='text-align: center; vertical-align: middle;'>
                          <button class='btn btn-success btn-sm add-to-cart' type='button' title='Thêm vào giỏ hàng'>
                            <i class='fas fa-shopping-cart'></i>
                          </button>
                        </td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='8'>Không có sản phẩm nào</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="alert">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="tile">
          <h3 class="tile-title">Thông tin thanh toán</h3>
          <form action="save_invoice.php" method="POST" id="invoiceForm">
            <div id="cartItems" class="col-md-15">
              <h3 class="tile-title">Giỏ hàng</h3>
              <div id="cartContent"></div>
            </div>

            <div class="row">
              <div class="form-group col-md-12">
                <label class="control-label">Ghi chú đơn hàng</label>
                <textarea class="form-control" rows="4" placeholder="Ghi chú thêm đơn hàng" name="GhiChu" id="ghiChu"></textarea>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-12">
                <label class="control-label">Hình thức thanh toán</label>
                <select class="form-control" name="HinhThucThanhToan" id="hinhThucThanhToan" required>
                  <option value="chuyen_khoan">Thanh toán chuyển khoản</option>
                  <option value="tien_mat">Trả tiền mặt tại quầy</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Tạm tính tiền hàng:</label>
                <p class="control-all-money-tamtinh">= <span id="totalPrice">0</span> VNĐ</p>
                <input type="hidden" name="TongTien" id="tongTien" value="0">
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Giảm giá:</label>
                <input class="form-control" type="number" value="0" name="GiamGia" id="giamGia" onchange="updateFinalTotal()">
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Tổng cộng thanh toán:</label>
                <p class="control-all-money-total">= <span id="finalTotal">0</span> VNĐ</p>
                <input type="hidden" name="FinalTotal" id="finalTotalInput" value="0">
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Khách hàng đưa tiền:</label>
                <input class="form-control" type="number" value="0" name="KhachTra" id="khachTra" onchange="updateDebt()">
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Khách hàng còn nợ:</label>
                <p class="control-all-money"> - <span id="debt">0</span> VNĐ</p>
              </div>
              <div class="tile-footer col-md-12">
                <button class="btn btn-primary" type="submit">Lưu đơn hàng</button>
                <button class="btn btn-primary" type="button" id="saveAndPrintButton">Lưu và in hóa đơn</button>
                <a class="btn btn-secondary" href="employee.php">Quay về</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>




    <script>
      // Hàm lọc sản phẩm
      function filterProducts() {
        let input = document.getElementById("myInput");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("sampleTable");
        let tr = table.getElementsByTagName("tr");

        // Duyệt qua từng hàng trong bảng, bỏ qua hàng tiêu đề
        for (let i = 1; i < tr.length; i++) {
          let td1 = tr[i].getElementsByTagName("td")[1]; // Tên sản phẩm
          let td2 = tr[i].getElementsByTagName("td")[0]; // Mã sản phẩm
          if (td1 || td2) {
            let txtValue1 = td1.textContent || td1.innerText;
            let txtValue2 = td2.textContent || td2.innerText;
            // Kiểm tra xem có khớp với giá trị tìm kiếm không
            tr[i].style.display = (filter === "" ||
              txtValue1.toLowerCase().indexOf(filter) > -1 ||
              txtValue2.toLowerCase().indexOf(filter) > -1) ? "" : "none";
          }
        }
      }

      // Ẩn mặc định tất cả các sản phẩm khi tải trang
      window.onload = function() {
        let table = document.getElementById("sampleTable");
        let tr = table.getElementsByTagName("tr");
        for (let i = 1; i < tr.length; i++) {
          tr[i].style.display = "none";
        }
      };

      // Hàm định dạng tiền tệ
      function formatCurrency(value) {
        return value.toLocaleString('vi-VN', {
          style: 'currency',
          currency: 'VND'
        });
      }

      // Cập nhật tổng thanh toán cuối cùng
      function updateFinalTotal() {
        let totalPrice = parseFloat(document.getElementById("totalPrice").innerText.replace(/\./g, '').replace(' VNĐ', ''));
        let discount = parseFloat(document.getElementById("giamGia").value) || 0;
        let finalTotal = totalPrice - discount;
        finalTotal = finalTotal < 0 ? 0 : finalTotal; // Đảm bảo không âm

        // Cập nhật giá trị hiển thị trong thẻ <span>
        document.getElementById("finalTotal").innerText = formatCurrency(finalTotal);
        document.getElementById("finalTotalInput").value = finalTotal; // Cập nhật cho thẻ <input> ẩn
      }

      // Cập nhật nợ còn lại
      function updateDebt() {
        let finalTotal = parseFloat(document.getElementById("finalTotal").innerText.replace(/\./g, '').replace(' VNĐ', ''));
        let customerPaid = parseFloat(document.getElementById("khachTra").value) || 0;
        let debt = finalTotal - customerPaid;
        debt = debt < 0 ? 0 : debt;

        document.getElementById("debt").innerText = formatCurrency(debt);
      }

      // Thêm sự kiện cho nút "Thêm vào giỏ" sau khi DOM được tải
      document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.add-to-cart').forEach(button => {
          button.addEventListener('click', function() {
            let row = this.closest('tr');
            let masp = row.getAttribute('data-masp');
            let tensp = row.getAttribute('data-tensp');
            let gia = parseFloat(row.getAttribute('data-gia'));
            let soluong = 1; // Mỗi lần nhấn "Thêm vào giỏ" thì số lượng là 1

            // Cập nhật giỏ hàng
            let cartContent = document.getElementById("cartContent");
            let existingItem = Array.from(cartContent.getElementsByClassName('cart-item')).find(item => item.querySelector('input[name="tensp"]').value === tensp);

            if (existingItem) {
              // Nếu sản phẩm đã có trong giỏ, cập nhật số lượng
              let quantityInput = existingItem.querySelector('.item-quantity input');
              let currentQuantity = parseInt(quantityInput.value);
              quantityInput.value = currentQuantity + soluong; // Cập nhật số lượng

              // Cập nhật tổng giá sản phẩm
              let itemPrice = gia * (currentQuantity + soluong);
              existingItem.querySelector('.item-price').innerText = formatCurrency(itemPrice) + ' VNĐ';

              // Cập nhật tổng giá
              let currentTotal = parseFloat(document.getElementById("totalPrice").innerText.replace(/\./g, '').replace(' VNĐ', ''));
              document.getElementById("totalPrice").innerText = formatCurrency(currentTotal + (soluong * gia));
            } else {
              // Thêm sản phẩm mới vào giỏ hàng
              let item = document.createElement('div');
              item.classList.add('cart-item');
              item.innerHTML = `
            <input type="text" name="tensp" value="${tensp}" style="width: 200px; border: none; background: none;" readonly />
            - 
            <span class="item-quantity">
                <input type="number" value="1" min="1" style="width: 50px;" readonly /> 
            </span> - 
            <span class="item-price">${formatCurrency(gia * soluong)} VNĐ</span> 
            <button class="remove-item">Xóa</button>
            <br>`;
              cartContent.appendChild(item);

              // Cập nhật tổng giá
              let currentTotal = parseFloat(document.getElementById("totalPrice").innerText.replace(/\./g, '').replace(' VNĐ', ''));
              document.getElementById("totalPrice").innerText = formatCurrency(currentTotal + (soluong * gia));

              // Thêm sự kiện cho nút xóa sản phẩm
              item.querySelector('.remove-item').addEventListener('click', function() {
                let itemPrice = gia * soluong;
                let totalPrice = parseFloat(document.getElementById("totalPrice").innerText.replace(/\./g, '').replace(' VNĐ', ''));
                document.getElementById("totalPrice").innerText = formatCurrency(totalPrice - itemPrice);

                // Xóa sản phẩm khỏi giỏ hàng
                cartContent.removeChild(item);
                updateFinalTotal(); // Cập nhật tổng sau khi xóa sản phẩm
              });
            }

            updateFinalTotal(); // Cập nhật tổng sau khi thêm sản phẩm
          });
        });
      });

      // Gửi hóa đơn
      document.getElementById('submitInvoice').addEventListener('click', function() {
        // Tạo một mảng để lưu sản phẩm trong giỏ hàng
        let sanPhamBan = [];

        document.querySelectorAll('.cart-item').forEach(item => {
          let tensp = item.querySelector('input[name="tensp"]').value;
          let soluong = item.querySelector('.item-quantity input').value;
          let gia = item.querySelector('.item-price').innerText.replace(' VNĐ', '').replace(/\./g, '');

          // Thêm sản phẩm vào mảng
          sanPhamBan.push({
            ten: tensp,
            soluong: soluong,
            gia: gia
          });
        });

        // Gửi dữ liệu đến server
        fetch('save_invoice.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              TongTien: document.getElementById("totalPrice").innerText.replace(/\./g, '').replace(' VNĐ', ''),
              GiamGia: document.getElementById("giamGia").value,
              HinhThucThanhToan: yourHinhThucThanhToanValue,
              GhiChu: yourGhiChuValue,
              SanPham: sanPhamBan
            })
          })
          .then(response => response.text())
          .then(data => {
            // Xử lý phản hồi từ server
            console.log(data);
          })
          .catch(error => {
            console.error('Error:', error);
          });
      });
    </script>

  </main>

  <!-- Modal thêm khách hàng -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Thêm khách hàng</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="process_add_customer.php" method="POST">
            <div class="form-group">
              <label for="ten_khach_hang">Họ và tên:</label>
              <input type="text" class="form-control" name="ten_khach_hang" required>
            </div>
            <div class="form-group">
              <label for="so_dien_thoai">Số điện thoại:</label>
              <input type="tel" class="form-control" name="so_dien_thoai" required>
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
              <label for="dia_chi">Địa chỉ:</label>
              <input type="text" class="form-control" name="dia_chi">
            </div>
            <div class="form-group">
              <label for="ma_thu_cung">Mã thú cưng:</label>
              <input type="text" class="form-control" name="ma_thu_cung">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Lưu</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!--
  MODAL
-->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form action="" method="POST">
            <div class="row">
              <div class="form-group col-md-12">
                <span class="thong-tin-thanh-toan">
                  <h5>Tạo mới khách hàng</h5>
                </span>
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Họ và tên</label>
                <input class="form-control" type="text" name="HoTen" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Địa chỉ</label>
                <input class="form-control" type="text" name="DiaChi" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Email</label>
                <input class="form-control" type="email" name="Email" required>
              </div>
              <!-- <div class="form-group col-md-6">
                <label class="control-label">Ngày sinh</label>
                <input class="form-control" type="date" name="NgaySinh" required>
              </div> -->
              <div class="form-group col-md-6">
                <label class="control-label">Số điện thoại</label>
                <input class="form-control" type="number" name="SoDienThoai" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Mã thú cưng</label>
                <input class="form-control" type="text" name="MaThuCung">
              </div>
            </div>
            <br>
            <button class="btn btn-save" type="submit">Lưu lại</button>
            <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
            <br>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

  <!--
MODAL
-->


  <!-- The Modal -->
  <div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">X</span>
      </div>


    </div>

  </div>
  <!-- Essential javascripts for application to work-->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="js/plugins/pace.min.js"></script>
  <!-- Page specific javascripts-->
  <!-- Data table plugin-->
  <!-- <script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script> -->
  <!-- <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script> -->
  <script type="text/javascript">
    $('#sampleTable').DataTable();
  </script>
  <script>
    function deleteRow(r) {
      var i = r.parentNode.parentNode.rowIndex;
      document.getElementById("myTable").deleteRow(i);
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
      tmp = '<span class="date"> <i class="bx bxs-calendar" ></i> ' + today + ' | <i class="fa fa-clock-o" aria-hidden="true"></i>  : ' + nowTime +
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
  <script>
    function deleteRow(r) {
      var i = r.parentNode.parentNode.rowIndex;
      document.getElementById("myTable").deleteRow(i);
    }
    jQuery(function() {
      jQuery(".trash").click(function() {
        swal({
            title: "Cảnh báo",
            text: "Bạn có chắc chắn là muốn xóa?",
            buttons: ["Đóng", "Đồng ý"],
          })
          .then((willDelete) => {
            if (willDelete) {
              swal("Đã xóa thành công.!", {});
            }
          });
      });
    });
  </script>
  <script>
    // Modal popup 
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
      modal.style.display = "block";
    }
    span.onclick = function() {
      modal.style.display = "none";
    }
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>
</body>

</html>