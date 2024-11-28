<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'guest'; 
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
    <link rel="shortcut icon" href="../Image/Logo.png" type="image/x-icon" />
    <script src="../Js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.js"
        integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/54e4f189c9.js" crossorigin="anonymous"></script>
    <title>Trang Chủ</title>
</head>

<body>
    <div class="header">
        <div class="head">
            <div class="info adr">
                <i class="fa-solid fa-house-chimney "
                    style="--fa-primary-color: dodgerblue;"></i>
                <span>Vì Sức Khỏe Thú Cưng</span>
            </div>
            <div class="info timer">
                <i class="fa-solid fa-clock" style="--fa-primary-color: dodgerblue;"></i>
                <span>Open Mon-Fri: 6:30AM to 7PM, Sat: 8AM to 5PM</span>
            </div>
            <div class="info mail">
                <i class="fa-solid fa-envelope"></i>
                <span>info@themerex.ne</span>
            </div>
            <div class="info login">
                <a href="../Auth/login_register.php">
                    <i class="fa-solid fa-right-to-bracket">Đăng nhập</i>
                </a>
            </div>
        </div>
        <nav class="menu">
            <div class="logo">
                <a href="trangchu.php">
                    <img src="../Image/Logo.png" alt="Trang chủ" />
                </a>
            </div>
            <ul id="main-menu">
                <li class="list"><a href="../Home/trangchu.php">Trang Chủ</a></li>
                <li class="list"><a href="../gioithieu.html">Giới thiệu</a></li>
                <li class="list list-3">
                    <a href="">Dịch vụ<i class="fa-sharp fa-solid fa-chevron-down"></i></a>
                    <ul class="menu-gio-hang">
                        <li><a href="">Giỏ hàng</a></li>
                        <li><a href="">Thanh toán</a></li>
                        <li><a href="">Kiểm tra đơn hàng</a></li>
                        <li><a href="">Giỏ hàng</a></li>
                        <li><a href="">Thanh toán</a></li>
                        <li><a href="">Kiểm tra đơn hàng</a></li>

                    </ul>
                </li>
                <li class="list"><a href="Tin-tuc/">Tin tức</a></li>
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
    <main class="body">
        <div class="slides">
            <div class="slide slide1">
                <div class="slide-content">
                    <h1>Yêu thú cưng của bạn</h1>
                    <h1>Hãy chăm sóc chúng</h1>
                    <p>Vì thời gian bạn dành cho chúng là</p>
                    <b>Không bao giờ thừa thải</b>
                    <button id="btn-slide1-cnt"><a href="../book/book.php">Đặt cuộc hẹn</a></button>
                </div>
                <div class="img-animal">
                    <img src="../Image/slider-dog-small.png" alt="" />
                </div>
                <form class="form-slide">
                    <h2>Tư vấn miễn phí</h2>
                    <input type="text" placeholder="Họ và tên" />
                    <input type="email" placeholder="Email" />
                    <textarea name="" id="" cols="10" rows="5" placeholder="Lời nhắn"></textarea>
                    <button id="btn-slide1-cnt">Gửi</button>
                </form>
            </div>
            <div class="slide slide2">
                <div class="slide-content">
                    <h1>Giám sát miễn phí</h1>
                    <h1>Cho thú cưng của bạn</h1>
                    <p>Chúng tôi luôn giữ an toàn và tiện nghi<br><br> cho
                        thú cưng của bạn</p>
                    <b>Dịch vụ luôn 24/7</b>
                    <button id="btn-slide2-cnt">Đặt cuộc hẹn</button>
                </div>
                <div class="img-animal">
                    <img src="../Image/slider-dog.png" alt="" />
                </div>
                <form class="form-slide">
                    <h2>Tư vấn miễn phí</h2>
                    <input type="text" placeholder="Họ và tên" />
                    <input type="email" placeholder="Email" />
                    <textarea name="" id="" cols="10" rows="5" placeholder="Lời nhắn"></textarea>
                    <button id="btn-slide2-cnt">Gửi</button>
                </form>
            </div>
            <div class="slide slide3">
                <div class="slide-content">
                    <h1>Bệnh viện động vật</h1>
                    <h1>Kiểm tra lần đầu</h1>
                    <p>Mạng lưới trung tâm thú y</p>
                    <b>Năng lực và chuyên môn cao</b>
                    <button id="btn-slide3-cnt">Đặt cuộc hẹn</button>
                </div>
                <div class="img-animal">
                    <img src="../Image/slider-cat.png" alt="" />
                </div>
                <form class="form-slide">
                    <h2>Tư vấn miễn phí</h2>
                    <input type="text" placeholder="Họ và tên" />
                    <input type="email" placeholder="Email" />
                    <textarea name="" id="" cols="10" rows="5" placeholder="Lời nhắn"></textarea>
                    <button id="btn-slide3-cnt">Gửi</button>
                </form>
            </div>
            <button id="btn-prev" onclick="previousDiv()">
                <i class="fa-solid fa-angle-left fa-xl"></i>
            </button>
            <button id="btn-next" onclick="nextDiv()">
                <i class="fa-solid fa-chevron-right fa-xl"></i>
            </button>
            <div class="dots1">
                <div class="dot1"></div>
                <div class="dot1"></div>
                <div class="dot1"></div>
            </div>
        </div>
        <div class="content-top">
            <div class="cnt-top-head">
                <h1>Chúng tôi làm gì?</h1>
                <p>&#8604; &#8605;</p>
                <p>Thú cưng của bạn đang ở trong tay tốt với đội ngũ chuyên nghiệp của chúng tôi.</p>
                <p>Chúng tôi luôn đề cao chất lượng và dịch vụ hàng đầu</p>
            </div>
            <div class="image-content">
                <div class="image-cnt">
                    <a href=""><img src="../Image/pets4.jpg"></a>
                </div>
                <div class="image-cnt">
                    <a href=""><img src="../Image/my-cat.jpg"></a>
                </div>
                <div class="image-cnt">
                    <a href=""><img src="../Image/fosterling.jpg"></a>
                </div>
                <div class="image-cnt">.
                    <a href=""><img src="../Image/parrot.jpg"></a>
                </div>
            </div>
        </div>
        <div class="content-center">
            <div class="image-cat-center">
                <img src="../Image/international-cat-day1-scaled.jpg">
            </div>
            <div class="content-cent">
                <h3>Chúng tôi là ai</h3>
                <p>Chăm sóc thú cưng không chỉ là những gì chúng ta làm, mà là những gì chúng ta yêu thích và đam mê.
                    Chúng tôi cung cấp cho thú cưng của bạn an toàn, thoải mái cho thú cưng và các dịch vụ dưới sự giám
                    sát 24/7.</p>
                <p class="paw-cnt-cent">
                </p>
            </div>
        </div>
        <div class="content-bottom">
            <div class="cnt-btm-head">
                <h3>Chúng tôi yêu thú cưng của bạn</h3>
                <span></span>
                <p class="paw-cnt-cent">
                    Công ty chúng tôi sẽ làm thú cưng của bạn được hạnh phúc.<br>
                    Hãy để thú cưng của bạn đạt được mức độ chăm sóc cao nhất từ các chuyên gia của chúng tôi
                </p>
            </div>
            <div class="cnt-btm-dog">
                <div class="cnt-btm-note-left">
                    <div class="note-left">
                        <div class="text-cap">
                            <h3>điều trị thú cưng</h3>
                            <p>Chăm sóc thú cưng không chỉ là những gì chúng ta làm, mà là những gì chúng ta yêu thích
                                và đam mê.</p>
                        </div>
                        <div class="note-img-left" style="margin-left:15px;">
                            <img class="img-cnt-lr" src="../Image/1.png">
                        </div>
                    </div>
                    <div class="note-left">
                        <div class="text-cap">
                            <h3>chải chuốt</h3>
                            <p>Đội ngũ các nhà tạo mẫu tóc thú cưng của chúng tôi rất vui khi làm cho con vật yêu quý
                                của bạn trông thật xinh đẹp</p>
                        </div>
                        <div class="note-img-left" style="margin-left:15px;">
                            <img class="img-cnt-lr" src="../Image/2.png">
                        </div>
                    </div>
                    <div class="note-left">
                        <div class="text-cap">
                            <h3>cửa hàng</h3>
                            <p>Nhận các phụ kiện thú cưng tốt nhất trong cửa hàng của chúng tôi để chăm sóc thú cưng của
                                bạn và làm cho nó hạnh phúc.</p>
                        </div>
                        <div class="note-img-left" style="margin-left:15px;">
                            <img class="img-cnt-lr" src="../Image/3.png">
                        </div>
                    </div>
                </div>
                <div class="cnt-btm-note-center">
                    <img src="../Image/dog-ps.jpg">
                </div>
                <div class="cnt-btm-note-right">
                    <div class="note-right">
                        <div class="note-img-right">
                            <img class="img-cnt-lr" src="../Image/6.png">
                        </div>
                        <div class="text-cap">
                            <h3>cho thú cưng</h3>
                            <p>Nếu bạn đang cân nhắc việc nuôi thú cưng, chúng tôi sẽ hướng dẫn bạn cách làm cho cuộc
                                sống của anh ấy thoải mái.</p>
                        </div>
                    </div>
                    <div class="note-right">
                        <div class="note-img-right">
                            <img src="../Image/4.png">
                        </div>
                        <div class="text-cap">
                            <h3>khách sạn thú cưng</h3>
                            <p>Chúng tôi cung cấp cho thú cưng của bạn an toàn, thoải mái cho thú cưng và các dịch vụ
                                dưới sự giám sát 24/7.</p>
                        </div>
                    </div>
                    <div class="note-right">
                        <div class="note-img-right">
                            <img class="img-cnt-lr" src="../Image/5.png">
                        </div>
                        <div class="text-cap">
                            <h3>thú y</h3>
                            <p>Chúng tôi cung cấp nhiều dịch vụ y tế cho thú cưng yêu quý của bạn để sống cuộc sống hạnh
                                phúc lâu dài trong nhà của bạn.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-rate">
            <div class="rate-head">
                <h1>Phản hồi của khách hàng</h1>
            </div>
            <div class="content-rate-items">

                <div class="rate-item active">
                    <div class="item-content">
                        <div class="content-rate-item-top">
                            <img src="../Image/testimonials_1-70x70.jpg"
                                style="border-radius: 50%;height:80px;width:80px;">
                        </div>
                        <p style="display: flex;"><i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                        </p>
                        <span>Thông Nguyễn, TP.HCM</span>
                        <p>Tôi tải xuống điều này chỉ cần ngày khác sau khi gửi một trang web yêu cầu để quyết định giữa
                            nó và một cách tuyệt vời của người khác. H sup trợ với các trách nhiệm nhanh chóng và cạnh
                            tranh. Hãy tiếp tục phát huy!</p>
                    </div>
                </div>
                <div class="rate-item">
                    <div class="item-content">
                        <div class="content-rate-item-top">
                            <img src="../Image/testimonials_2-70x70.jpg"
                                style="border-radius: 50%;height:80px;width:80px;">
                        </div>
                        <p style="display: flex;"><i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                        </p>
                        <span>Thanh Hà, Bình Dương</span>
                        <p>NẾU BẠN ĐANG TÌM KIẾM CV NHIỆM VỤ BẠN CÓ QUYỀN TẠI ĐÂY. MUA VÀ KIẾM TIỀN VỀ XỬ LÝ VÀ H SUP
                            TRỢ NHANH CHÓNG. RAT KHUYEN KHICH.</p>
                    </div>
                </div>
                <div class="rate-item">
                    <div class="item-content">
                        <div class="content-rate-item-top">
                            <img src="../Image/testimonials_3-70x70.jpg"
                                style="border-radius: 50%;height:80px;width:80px;">
                        </div>
                        <p style="display: flex;"><i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                            <i class="fa-solid fa-star fa-xl" style="color:orange;"></i>
                        </p>
                        <span>Thanh Ngân, Đồng Nai</span>
                        <p>ĐỀ TÀI NÀY LÀ CHẤT LƯỢNG HÀNG ĐẦU. TÌM KIẾM? LÀM VIỆC KHÔNG, VÌ SAO HPORT TRỢ RATNG NHÓM NÀY
                            CUNG CẤP LÀ TUYỆT VỜI! TÔI KHÔNG NÊN KIẾN NGHỊ ĐỀ TÀI NÀY CHO DỰ ÁN TIẾP THEO CỦA BẠN HOẶC
                            BẤT KEM ĐỀ TÀI NÀO KHÁC TỪ AXIOM CHO VẤN ĐỀ.</p>
                    </div>
                </div>
                <button id="prev" style="z-index: 10;"><i class="fa-solid fa-chevron-left fa-xl"
                        style="color:#fff;"></i></button>
                <button id="btn" style="z-index: 10;"><i class="fa-solid fa-chevron-right fa-xl"
                        style="color:#fff;"></i></button>
                <div class="dots">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>

        </div>
        <div class="content-new">
            <h1>Tin tức</h1>
            <div class="cnt-new-box">
                <a href="" class="new-box newbox1">
                    <div class="new-box1-img">
                        <img src="../Image/nursling1-1170x814.jpg" alt="">
                    </div>
                    <div class="newbox-cnt">
                        <span>tin tức</span>
                        <h3>Lịch tiêm phòng cho chó</h3>
                        <p><i class="fa-solid fa-calendar-days" style="color:rgb(245, 192, 93);"></i><span>8 Tháng Ba,
                                2018</span></p>
                        <p>Lịch tiêm phòng cho chó Qua nhiều năm, tôi sẽ đến, ai sẽ nostrud aliquip ...</p>
                    </div>
                </a>
                <a href="" class="new-box new-box2">
                    <div class="new-box2-img">
                        <img src="../Image/Pets-1170x718.jpg" alt="">
                    </div>
                    <div class="newbox-cnt">
                        <span>tin tức</span>
                        <h3>Một khoảnh khắc tạm thời</h3>
                        <p><i class="fa-solid fa-calendar-days" style="color:rgb(245, 192, 93);"></i><span>8 Tháng Ba,
                                2018</span></p>
                        <p>Một khoảnh khắc tạm thời Đối với giá của một cái hồ, ti-vi khối lượng ...</p>
                    </div>
                </a>
                <a href="" class="new-box new-box3">
                    <div class="new-box3-img">
                        <img src="../Image/pets3-1170x965.jpg" alt="">
                    </div>
                    <div class="newbox-cnt">
                        <span>tin tức</span>
                        <h3>Chăm sóc mắt cho chó</h3>
                        <p><i class="fa-solid fa-calendar-days" style="color:rgb(245, 192, 93);"></i><span>8 Tháng Ba,
                                2018</span></p>
                        <p>Chăm sóc mắt cho chó Qua nhiều năm, tôi sẽ đến, ai sẽ nostrud aliquip ...</p>
                    </div>
                </a>
            </div>
        </div>
    </main>
    <footer>
        <div class="information-ct">
            <div class="footer-logo-note">
                <div class="logo-footer">
                    <a href="/trangchu.php"><img src="../Image/Logo.png"></a>
                </div>
                <div class="note">
                    <p width=10px style="overflow-y: auto;">Thú cưng của bạn đang ở trong tay tốt với đội ngũ bác sĩ thú
                        y, chú rể và huấn
                        luyện viên chuyên nghiệp của chúng tôi. Chúng tôi cung cấp động vật của bạn chỉ là một dịch vụ
                        chất lượng hàng đầu.</p>
                    <ul>
                        <li class="note-list1"><a href="https://www.facebook.com/zuck"><i
                                    class="fa-brands fa-facebook-f fa-1x" style="color:#fff;"
                                    title="Follow on Facebook"></i></a></li>
                        <li class="note-list2"><a href=""><i class="fa-brands fa-instagram fa-1x" style="color:#fff;"
                                    title="Follow on Instagram"></i></i></a></li>
                        <li class="note-list3"><a href=""><i class="fa-brands fa-twitter" style="color:#fff;"
                                    title="Follow on Twitter"></i></a></li>
                        <li class="note-list4"><a href=""><i class="fa-brands fa-flickr" style="color:#07f21b;"
                                    title="Follow on Facebook"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="contact">
                <h2>Liên hệ</h2>
                <ul class="main-adr">
                    <li class="cpr-list">
                        <img src="../Image/pin.png">
                        <a href="https://goo.gl/maps/NTwx9nRC73ZsRojv5">Số 06, Trần Văn Ơn, Phú Hòa, Thủ Dầu Một, Bình
                            Dương</a>
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
                        <a href="/trangchu.php">Chăm sóc khách khàng</a>
                    </li>
                    <li class="sp-list">
                        <a href="/trangchu.php">Vận chuyển và đổi trả hàng</a>
                    </li>
                    <li class="sp-list">
                        <a href="../contact.html">Liên hệ</a>
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
    <div class="back-to-top">
        <i class="fa-solid fa-arrow-up fa-xs"></i>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
    crossorigin="anonymous"></script>
<script src="../Js/script.js"></script>

</html>