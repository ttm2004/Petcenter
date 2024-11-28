<?php
session_start();
include("../php/connect.php");

// Kiểm tra xem phương thức yêu cầu có tồn tại không
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'] ?? '';
  $tel = $_POST['tel'] ?? '';
  $type_of_pet = $_POST['type_of_pet'] ?? ''; // Đảm bảo đúng tên
  $service = $_POST['service'] ?? '';
  $days = $_POST['days'] ?? '';
  $time_cloumn = $_POST['time_cloumn'] ?? ''; // Đảm bảo đúng tên
  $detail = $_POST['detail'] ?? '';

  // Chuyển định dạng ngày tháng
  $days = date("Y-m-d", strtotime($days));
  $id = rand(10000000, 50000000);

  // Chuẩn bị câu lệnh SQL an toàn
  $sql = "INSERT INTO scheduling (id, name, tel, type_of_pet, service, days, time_cloumn, detail)
            VALUES ('$id', '$name', '$tel', '$type_of_pet', '$service', '$days', '$time_cloumn', '$detail')";
  if ($conn->query($sql) === TRUE) {
    echo $id;
    exit;
  } else {
    echo "Lỗi: " . $conn->error;
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/lienhe.css">
  <link rel="stylesheet" href="../book/book.css">
  <link rel="shortcut icon" href="../Image/Logo.png" type="image/x-icon" />
  <script src="app.js"></script>
  <script src="../Js/script.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
  <script
    src="https://kit.fontawesome.com/54e4f189c9.js"
    crossorigin="anonymous"></script>
  <title>Đặt cuộc hẹn</title>
</head>

<body>
  <div class="header">
    <div class="head">
      <div class="info adr">
        <i class="fa-solid fa-house-chimney " style="--fa-primary-color: dodgerblue; --fa-secondary-color: gold; --fa-secondary-opacity: 1.0;"></i>
        <span>Vì Sức Khỏe Thú Cưng</span>
      </div>
      <div class="info timer">
        <i class="fa-solid fa-clock"></i>
        <span>Open Mon-Fri: 6:30AM to 7PM, Sat: 8AM to 5PM</span>
      </div>
      <div class="info mail">
        <i class="fa-solid fa-envelope"></i>
        <span>info@themerex.ne</span>
      </div>
      <div class="info login">
        <a href="">
          <i class="fa-solid fa-right-to-bracket"></i>
          <span>Login</span>
        </a>
      </div>
    </div>
    <nav class="menu">
      <div class="logo">
        <a href="php">
          <img src="../Image/Logo.png" alt="Trang chủ" />
        </a>
      </div>
      <ul id="main-menu">
        <li class="list"><a href="../Home/trangchu.php">Trang Chủ</a></li>
        <li class="list"><a href="../gioithieu.php">Giới thiệu</a></li>
        <li class="list list-3">
          <a href="">Cửa Hàng<i class="fa-sharp fa-solid fa-chevron-down"></i></a>
          <ul class="menu-gio-hang">
            <li><a href="">Giỏ hàng</a></li>
            <li><a href="">Thanh toán</a></li>
            <li><a href="">Kiểm tra đơn hàng</a></li>
          </ul>
        </li>
        <li class="list"><a href="../Tin-tuc/">Tin tức</a></li>
        <li class="list"><a href="../contact/contact.php">Liên hệ</a></li>
        <li class="list">
          <div class="icon-search">
            <input type="text" placeholder="Tìm kiếm...">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </li>
      </ul>
    </nav>
  </div>
  </div>
  </div>

  <div class="wrapper_book">
    <div class="container">
      <div class="left-section">
        <img src="../Image/book_img.png" alt="Chăm sóc thú cưng" style="width:50px; height:50px;">
        <h2>CHÚNG TÔI Ở ĐÂY CHĂM SÓC THÚ CƯNG CỦA BẠN!</h2>
        <p>Vui lòng điền thông tin vào biểu mẫu để đặt lịch khám cho thú cưng của bạn tại phòng khám Thú Y Tên Lửa.</p>
        <p>Sau khi nhận được yêu cầu, nhân viên của chúng tôi sẽ liên hệ xác nhận với bạn qua điện thoại. Ngoài ra, bạn cũng có thể:</p>
        <ul>
          <li>✔ Đặt hẹn khám qua hotline 097 3333 409 - 070 3333 409.</li>
          <li>✔ Trong trường hợp cần khám gấp, vui lòng đưa thú cưng đến trực tiếp phòng khám tại địa chỉ: 234 Tên Lửa, P. Bình Trị Đông B, Q. Bình Tân, TP. Hồ Chí Minh.</li>
        </ul>
      </div>
      <div class="right-section">
        <form action="" method="POST">
          <div class="content_form">
            <div class="form-group-left">
              <div class="form-left">
                <label for="name">Họ tên *</label>
                <input type="text" id="name" name="name" placeholder="Nhập họ tên" required>
              </div>
              <div class="form-left">
                <label for="pet-type">Loại thú cưng</label>
                <div class="select-wrapper">
                  <select id="pet-type" name="type_of_pet">
                    <option value="" disabled selected>-- Chọn loại thú cưng --</option>
                    <option value="dog">Chó</option>
                    <option value="cat">Mèo</option>
                    <option value="other">Khác</option>
                  </select>
                </div>
              </div>
              <div class="form-left">
                <label for="date">Ngày khám</label>
                <input type="date" id="date" name="days">
              </div>
            </div>

            <div class="form-group-right">
              <div class="form-right">
                <label for="phone">Điện thoại *</label>
                <input type="tel" id="phone" name="tel" placeholder="Nhập số điện thoại" required>
              </div>
              <div class="form-right">
                <label for="service">Dịch vụ</label>
                <div class="select-wrapper">
                  <select id="service" name="service">
                    <option value="" disabled selected>-- Chọn dịch vụ --</option>
                    <option value="Khám tống quát">Khám tổng quát</option>
                    <option value="Tiêm chủng">Tiêm phòng</option>
                    <option value="Phẫu thuật">Phẫu thuật</option>
                  </select>
                </div>
              </div>
              <div class="form-right">
                <label for="time_cloumn">Giờ khám</label>
                <div class="select-wrapper">
                  <select id="time_cloumn" name="time_cloumn">
                    <option value="" disabled selected>-- Chọn giờ khám --</option>
                    <option value="8:00">8:00</option>
                    <option value="10:00">10:00</option>
                    <option value="12:00">12:00</option>
                    <option value="15:00">14:00</option>
                    <option value="18:00">10:00</option>
                    <option value="20:00">20:00</option>

                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group-detail">
            <div class="form-group">
              <label for="additional-info">Thông tin thêm</label>
              <textarea id="additional-info" name="detail" placeholder="Nhập thông tin thêm"></textarea>
            </div>
          </div>
          <button type="submit" class="btn">Đặt hẹn</button>
          <p id="appointment-count" name="id" style="display:none;"></p>
        </form>

      </div>
    </div>
  </div>


  <!-- Phần chân trang -->

  <footer>
    <div class="information-ct">
      <div class="footer-logo-note">
        <div class="logo-footer">
          <a href="../Home/trangchu.php"><img src="../Image/Logo.png"></a>
        </div>
        <div class="note">
          <p width=10px style="overflow-y: auto;">Thú cưng của bạn đang ở trong tay tốt với đội ngũ bác sĩ thú y, chú rể và huấn
            luyện viên chuyên nghiệp của chúng tôi. Chúng tôi cung cấp động vật của bạn chỉ là một dịch vụ chất lượng hàng đầu.</p>
          <ul>
            <li class="note-list1"><a href="https://www.facebook.com/zuck"><i class="fa-brands fa-facebook-f fa-1x" style="color:#fff;" title="Follow on Facebook"></i></a></li>
            <li class="note-list2"><a href=""><i class="fa-brands fa-instagram fa-1x" style="color:#fff;" title="Follow on Instagram"></i></i></a></li>
            <li class="note-list3"><a href=""><i class="fa-brands fa-twitter" style="color:#fff;" title="Follow on Twitter"></i></a></li>
            <li class="note-list4"><a href=""><i class="fa-brands fa-flickr" style="color:#07f21b;" title="Follow on Facebook"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="contact">
        <h2>Liên hệ</h2>
        <ul class="main-adr">
          <li class="cpr-list">
            <img src="../Image/pin.png">
            <a href="https://goo.gl/maps/NTwx9nRC73ZsRojv5">Số 06, Trần Văn Ơn, Phú Hòa, Thủ Dầu Một, Bình Dương</a>
          </li>
          <li class="cpr-list">
            <img src="../Image/phone-call.png">
            <a href="tel:094584395">094584395</a>
          </li>
          <li class="cpr-list">
            <img src="../Image/mail.png">
            <a href="Mailto:tricker2017@fb.com">Tricker2017@fb.com</a>
          </li>
        </ul>
      </div>
      <div class="support">
        <h2>Hỗ trợ</h2>
        <ul class="main-adr">
          <li class="sp-list">
            <a href="">FAQ</a>
          </li>
          <li class="sp-list">
            <a href="../Home/trangchu.php">Chăm sóc khách khàng</a>
          </li>
          <li class="sp-list">
            <a href="../Home/trangchu.php">Vận chuyển và đổi trả hàng</a>
          </li>
          <li class="sp-list">
            <a href="../contact/contact.php">Liên hệ</a>
          </li>
        </ul>
      </div>
      <div class="news">
        <h2>Tin tức</h2>
        <div class="new-content">
          <a href="/" class="new-post new-post1">
            <img src="../Image/pets3-1170x965.jpg">
            <div class="post1-content">
              <h5>Chăm sóc mắt cho chó</h5>
              <span style="display: block;
                          background-color: var(--cl-head);
                          width:2em;
                          height:2px; margin:0.5em 0;"></span>
              <p>Chăm sóc mắt cho chó...</p>
            </div>
          </a>
          <a href="/" class="new-post new-post2">
            <img src="../Image/parrot.jpg">
            <div class="post2-content">
              <h5>Chăm sóc mỏ chim...</h5>
              <span style="display: block;
                          background-color: var(--cl-head);
                          width:2em;
                          height:2px; margin:0.5em 0;box-sizing:border-box;"></span>
              <p>Qua nhiều năm, tôi sẽ ...</p>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="copyright">
      <p style="padding: 5px 0 0 0;">Bản quyền thuộc về d .. Thiết kế website</p>
      <span id="oclock"></span>
    </div>
  </footer>
  <script>
    document.querySelector('form').onsubmit = function(event) {
      event.preventDefault(); // Ngăn gửi form theo cách thông thường
      const formData = new FormData(this);
      fetch(this.action, {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          // Hiển thị số yêu cầu trong thẻ p
          document.getElementById('appointment-count').innerText = "Số đặt hẹn của bạn là: " + data;
          document.getElementById('appointment-count').style.display = 'block';
        })
        .catch(error => console.error('Error:', error));
    };
  </script>

</body>

</html>