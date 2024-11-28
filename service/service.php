<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Dịch Vụ Chăm Sóc Thú Cưng</title>
    <!-- Thêm liên kết tới Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 50px;
            max-width: 900px;
            border-radius: 10px;
            background: #ffffff;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-custom {
            background-color: #ff6b6b;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #ff4757;
            color: white;
        }

        .form-control:focus {
            border-color: #ff6b6b;
            box-shadow: 0 0 5px rgba(255, 107, 107, 0.5);
        }

        .image-preview {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .form-row {
            margin-bottom: 15px;
        }

        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Đăng Ký Dịch Vụ Chăm Sóc Thú Cưng</h1>
        <div class="card p-4">
            <form action="process_form.php" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="hoTen">Họ và Tên:</label>
                        <input type="text" class="form-control" id="hoTen" name="hoTen" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="soDienThoai">Số Điện Thoại:</label>
                        <input type="tel" class="form-control" id="soDienThoai" name="soDienThoai" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="diaChi">Địa Chỉ:</label>
                        <input type="text" class="form-control" id="diaChi" name="diaChi" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tenThuCung">Tên Thú Cưng:</label>
                        <input type="text" class="form-control" id="tenThuCung" name="tenThuCung" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="loaiThuCung">Loại Thú Cưng:</label>
                        <select class="form-control" id="loaiThuCung" name="loaiThuCung" required>
                            <option value="Chó">Chó</option>
                            <option value="Mèo">Mèo</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="dichVuChon">Dịch Vụ Chọn:</label>
                        <select class="form-control" id="dichVuChon" name="dichVuChon" required>
                            <option value="Khám sức khỏe tổng quát định kỳ">Khám sức khỏe tổng quát định kỳ</option>
                            <option value="Xét nghiệm thú cưng">Xét nghiệm thú cưng</option>
                            <option value="Chăm sóc thú cưng">Chăm sóc thú cưng</option>
                            <option value="Tiêm ngừa vắc xin">Tiêm ngừa vắc xin</option>
                            <option value="Phẫu thuật (thai sản, triệt sản, mắt, tai,...)">Phẫu thuật</option>
                            <option value="Xuất cảnh">Xuất cảnh</option>
                            <option value="Khám bệnh & điều trị">Khám bệnh & điều trị</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="thoiGianNhan">Thời Gian Nhận:</label>
                        <input type="date" class="form-control" id="thoiGianNhan" name="thoiGianNhan" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="hinhAnh">Hình Ảnh:</label>
                        <input type="file" class="form-control" id="hinhAnh" name="hinhAnh" accept="image/*" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ghiChu">Ghi Chú:</label>
                        <textarea class="form-control" id="ghiChu" name="ghiChu" rows="2"></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-custom btn-block">Gửi Đăng Ký</button>
            </form>
        </div>
    </div>

    <!-- Thêm liên kết tới Bootstrap JS và jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
