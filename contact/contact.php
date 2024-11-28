<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/lienhe.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../Image/Logo.png" type="image/x-icon">
    <script src="../Js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/54e4f189c9.js" crossorigin="anonymous"></script>
    
    <title>Liên hệ với chúng tôi</title>
</head>
<body>
    <!-- Phần đầu trang -->
    <div class="header" id="top">
        <div class="head">
            <div class="info adr">
                <i class="fa-solid fa-house-chimney"></i>
                <span>Số 06, Trần Văn Ơn, Phú Hòa, Thủ Dầu Một, Bình Dương</span>
            </div>
            <div class="info timer">
                <i class="fa-solid fa-clock"></i>
                <span>Open Mon-Fri: 6:30AM to 7PM, Sat: 8AM to 5PM</span>
            </div>
            <div class="info mail">
                <i class="fa-solid fa-envelope"></i>
                <span>info@themerex.ne</span>
            </div>
        </div>
        <nav class="menu">
            <div class="logo">
                <a href="../Home/index.php">
                    <img src="../Image/Logo.png" alt="Trang chủ">
                </a>
            </div>
            <ul id="main-menu">
                <li class="list"><a href="../Home/index.php" >Trang Chủ</a></li>
                <li class="list"><a href="../gioithieu.php">Giới thiệu</a></li>
                <li class="list list-3">
                    <a href="">Cửa Hàng<i class="fa-sharp fa-solid fa-chevron-down"></i></a>
                    <ul class="menu-gio-hang">
                        <li><a href="">Giỏ hàng</a></li>
                        <li><a href="">Thanh toán</a></li>
                        <li><a href="">Kiểm tra đơn hàng</a></li>
                    </ul>
                </li>
                <li class="list"><a href="#">Tin tức</a></li>
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
    <!-- Phần thân trang-->
    <div id="body">
        <div class="container">
            <h1>Liên hệ</h1> 
            <div class="home-ct">
                <a href="../Home/index.php">Trang chủ</a>
                <span>/&#160;&#160; liên hệ</span>
            </div>
        </div>
        <div class="form-ct-map">
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.7725940023856!2d106.67329091394036!3d10.980529958397748!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d1085e2b1c37%3A0x73bfa5616464d0ee!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBUaOG7pyBE4bqndSBN4buZdA!5e0!3m2!1svi!2s!4v1679412165199!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="form-input">
                <div class="form-head">
                    <div class="ima-head">
                        <img src="../Image/logo-mona.png">
                    </div>
                    <div class="address">
                        <ul class="main-adr">
                            <li>
                                <img src="../Image/pin.png">
                                <span>Số 06, Trần Văn Ơn, Phú Hòa, Thủ Dầu Một, Bình Dương</span>
                            </li>
                            <li>
                                <img src="../Image/phone-call.png">
                                <a href="tel:094584395">094584395</a>
                            </li>
                            <li>
                                <img src="../Image/mail.png">
                                <a href="Mailto:tricker2017@fb.com">Tricker2017@fb.com</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="form-input-layout">
                        <form action="" id="myForm" class="form" onsubmit="return kiemtra()">
                            <h1 id="open">Liên hệ với chúng tôi</h1>
                            <div class="info info-user" >
                                <input type="text" class="ipt-set" placeholder="Họ và tên">
                                <input type="email" class="ipt-set" placeholder="Email">
                            </div>
                            <div class="info ipt-adr-tel">
                                <input type="tel" class="ipt-set" placeholder="Số điện thoại">
                                <input type="address" class="ipt-set" placeholder="Địa chỉ">
                            </div>
                            <div class="info info-textarea">
                                <textarea name="" id="" cols="30" rows="10"  placeholder="Lời nhắn"></textarea>
                            </div>
                            <div class="info submit">
                                <button id="form-btn">Gửi</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="information-ct">
            <div class="footer-logo-note">
                <div class="logo-footer">
                    <a href="../Home/index.php"><img src="../Image/Logo.png"></a>
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
                        <a href="../Home/index.php">Chăm sóc khách khàng</a>
                    </li>
                    <li class="sp-list">
                        <a href="../Home/index.php">Vận chuyển và đổi trả hàng</a>
                    </li>
                    <li class="sp-list">
                        <a href="contact.php">Liên hệ</a>
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
            <p>Bản quyền thuộc về  d    .. Thiết kế website</p>
            <span id="oclock"></span>
        </div>  
    </footer>
    <div class="back-to-top">
        <i class="fa-solid fa-arrow-up fa-xs"></i>
    </div>
    <script src="../Js/app.js"></script>
    <script src="./Js/script.js"></script>
</body>


</html>