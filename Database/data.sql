CREATE TABLE KhachHang (
    MaKH INT AUTO_INCREMENT PRIMARY KEY,
    HoTenKH VARCHAR(100) NOT NULL,
    SoDienThoai VARCHAR(15) NOT NULL UNIQUE,
    Email VARCHAR(100) NOT NULL UNIQUE,
    DiaChi VARCHAR(255),
    NgaySinh DATE,  -- Ngày sinh của khách hàng
    GioiTinh ENUM('Nam', 'Nữ', 'Khác')  -- Giới tính của khách hàng
);

CREATE TABLE ThuCung (
    MaThuCung INT AUTO_INCREMENT PRIMARY KEY,
    TenThuCung VARCHAR(100) NOT NULL,
    LoaiThuCung VARCHAR(50) NOT NULL,
    MaKH INT,  -- Khóa ngoại liên kết với bảng KhachHang
    DichVuChon INT,  -- Khóa ngoại liên kết với bảng DichVu
    TrangThaiChuaBenh VARCHAR(50),
    ThoiGianNhan DATETIME,
    ThoiGianTra DATETIME,
    TrangThaiTra ENUM('Chưa Trả', 'Đã Trả'),  -- Trạng thái thú cưng đã được trả hay chưa
    HinhAnh BLOB,  -- Lưu trữ hình ảnh của thú cưng
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH),
    FOREIGN KEY (DichVuChon) REFERENCES DichVu(MaDV)
);

CREATE TABLE DichVu (
    MaDV INT AUTO_INCREMENT PRIMARY KEY,
    TenDichVu VARCHAR(100) NOT NULL,
    MoTa TEXT,  -- Mô tả dịch vụ
    Gia DECIMAL(10, 2) NOT NULL,  -- Giá của dịch vụ
    ThoiGianThucHien INT  -- Thời gian thực hiện dịch vụ (phút)
);

CREATE TABLE NhanVien (
    MaNV INT AUTO_INCREMENT PRIMARY KEY,
    HoTenNV VARCHAR(100) NOT NULL,
    Username VARCHAR(50) UNIQUE NOT NULL,  -- Tên đăng nhập
    MatKhau VARCHAR(255) NOT NULL,  -- Mật khẩu mã hóa
    VaiTro ENUM('LeTan', 'ChamsocThuCung', 'QuanLy', 'Admin'),  -- Phân loại nhân viên
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Ngày tạo tài khoản
    TrangThai ENUM('Hoạt Động', 'Không Hoạt Động') DEFAULT 'Hoạt Động'  -- Trạng thái hoạt động của nhân viên
);


CREATE TABLE LichHen (
    MaLH INT AUTO_INCREMENT PRIMARY KEY,
    MaKH INT,  -- Khóa ngoại từ bảng KhachHang
    MaThuCung INT,  -- Khóa ngoại từ bảng ThuCung
    MaDV INT,  -- Khóa ngoại từ bảng DichVu
    NgayHen DATETIME,  -- Ngày hẹn
    TrangThai ENUM('Chờ', 'Đã Hoàn Thành', 'Hủy'),  -- Trạng thái lịch hẹn
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH),
    FOREIGN KEY (MaThuCung) REFERENCES ThuCung(MaThuCung),
    FOREIGN KEY (MaDV) REFERENCES DichVu(MaDV)
);

CREATE TABLE HoaDon (
    MaHD INT AUTO_INCREMENT PRIMARY KEY,
    MaKH INT,  -- Khóa ngoại từ bảng KhachHang
    MaDV INT,  -- Khóa ngoại từ bảng DichVu
    NgayLap DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Ngày lập hóa đơn
    TongTien DECIMAL(10, 2),  -- Tổng tiền của hóa đơn
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH),
    FOREIGN KEY (MaDV) REFERENCES DichVu(MaDV)
);

CREATE TABLE LichSuDichVu (
    MaLSDV INT AUTO_INCREMENT PRIMARY KEY,
    MaThuCung INT,  -- Khóa ngoại từ bảng ThuCung
    MaDV INT,  -- Khóa ngoại từ bảng DichVu
    NgayThucHien DATETIME,  -- Ngày thực hiện dịch vụ
    GhiChu TEXT,  -- Ghi chú về quá trình thực hiện
    FOREIGN KEY (MaThuCung) REFERENCES ThuCung(MaThuCung),
    FOREIGN KEY (MaDV) REFERENCES DichVu(MaDV)
);

CREATE TABLE GhiChu (
    MaGC INT AUTO_INCREMENT PRIMARY KEY,
    MaKH INT,  -- Khóa ngoại từ bảng KhachHang
    MaThuCung INT,  -- Khóa ngoại từ bảng ThuCung
    NoiDung TEXT,  -- Nội dung ghi chú
    NgayGhi DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Ngày ghi chú
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH),
    FOREIGN KEY (MaThuCung) REFERENCES ThuCung(MaThuCung)
);

CREATE TABLE PhanHoi (
    MaPH INT AUTO_INCREMENT PRIMARY KEY,
    MaKH INT,  -- Khóa ngoại từ bảng KhachHang
    NoiDung TEXT,  -- Nội dung phản hồi
    NgayGhi DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Ngày ghi phản hồi
    FOREIGN KEY (MaKH) REFERENCES KhachHang(MaKH)
);

CREATE TABLE Users (
    MaUser INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) UNIQUE NOT NULL,  -- Tên đăng nhập
    Password VARCHAR(255) NOT NULL,  -- Mật khẩu mã hóa
    Role ENUM('Admin', 'QuanLy', 'NhanVien') NOT NULL,  -- Phân quyền người dùng
    MaNV INT,  -- Khóa ngoại liên kết với bảng NhanVien
    FOREIGN KEY (MaNV) REFERENCES NhanVien(MaNV)
);


-- Bảng HoaDon
CREATE TABLE HoaDonSP (
    MaHoaDon INT PRIMARY KEY AUTO_INCREMENT,
    NgayIn DATETIME,
    HinhThucThanhToan VARCHAR(50),
    TongTien DECIMAL(10, 2)
);


-- Bảng ChiTietHoaDon
CREATE TABLE ChiTietHoaDon (
    MaChiTiet INT PRIMARY KEY AUTO_INCREMENT,
    MaHoaDon INT,
    MaSanPham INT,
    SoLuong INT,
    ThanhTien DECIMAL(10, 2),
    FOREIGN KEY (MaHoaDon) REFERENCES HoaDonSP(MaHoaDon),
    FOREIGN KEY (MaSanPham) REFERENCES sanpham(MaSP)
);


INSERT INTO KhachHang (HoTenKH, SoDienThoai, Email, DiaChi, NgaySinh, GioiTinh)
VALUES 
('Nguyen Van A', '0909123456', 'nguyenvana@example.com', '123 Đường ABC, Quận 1', '1990-05-10', 'Nam'),
('Tran Thi B', '0912345678', 'tranthib@example.com', '456 Đường DEF, Quận 3', '1985-12-25', 'Nữ'),
('Le Van C', '0923456789', 'levanc@example.com', '789 Đường GHI, Quận 7', '2000-07-15', 'Nam');


INSERT INTO DichVu (TenDichVu, MoTa, Gia, ThoiGianThucHien)
VALUES 
('Khám sức khỏe tổng quát', 'Kiểm tra sức khỏe toàn diện cho thú cưng', 500000, 60),
('Chăm sóc thú cưng', 'Dịch vụ chăm sóc cho thú cưng toàn diện', 300000, 45),
('Tiêm ngừa vắc xin', 'Tiêm phòng các loại vắc xin cần thiết', 200000, 30);


INSERT INTO ThuCung (TenThuCung, LoaiThuCung, MaKH, DichVuChon, TrangThaiChuaBenh, ThoiGianNhan, ThoiGianTra, TrangThaiTra, HinhAnh)
VALUES 
('Milo', 'Chó', 1, 1, 'Đã chữa khỏi', '2024-10-05 09:00:00', '2024-10-07 17:00:00', 'Đã Trả', NULL),
('Bella', 'Mèo', 2, 2, 'Đang điều trị', '2024-10-06 10:00:00', NULL, 'Chưa Trả', NULL),
('Lucky', 'Chó', 3, 3, 'Đã chữa khỏi', '2024-10-04 08:00:00', '2024-10-06 15:00:00', 'Đã Trả', NULL);


INSERT INTO NhanVien (HoTenNV, Username, MatKhau, VaiTro, NgayTao, TrangThai)
VALUES 
('Pham Van D', 'phamvand', 'hashed_password1', 'LeTan', '2024-09-15 08:00:00', 'Hoạt Động'),
('Nguyen Thi E', 'nguyenthie', 'hashed_password2', 'ChamsocThuCung', '2024-09-18 08:00:00', 'Hoạt Động'),
('Tran Van F', 'tranvanf', 'hashed_password3', 'QuanLy', '2024-09-20 08:00:00', 'Hoạt Động');


INSERT INTO LichHen (MaKH, MaThuCung, MaDV, NgayHen, TrangThai)
VALUES 
(1, 1, 1, '2024-10-10 10:00:00', 'Chờ'),
(2, 2, 2, '2024-10-11 11:00:00', 'Chờ'),
(3, 3, 3, '2024-10-12 12:00:00', 'Chờ');


INSERT INTO HoaDon (MaKH, MaDV, NgayLap, TongTien)
VALUES 
(1, 1, '2024-10-07 17:00:00', 500000),
(2, 2, '2024-10-06 14:00:00', 300000),
(3, 3, '2024-10-05 15:00:00', 200000);


INSERT INTO LichSuDichVu (MaThuCung, MaDV, NgayThucHien, GhiChu)
VALUES 
(1, 1, '2024-10-05 09:00:00', 'Khám tổng quát định kỳ, kết quả tốt'),
(2, 2, '2024-10-06 10:00:00', 'Chăm sóc thú cưng, đang điều trị'),
(3, 3, '2024-10-04 08:00:00', 'Tiêm ngừa đầy đủ');


INSERT INTO GhiChu (MaKH, MaThuCung, NoiDung)
VALUES 
(1, 1, 'Thú cưng khỏe mạnh, không có vấn đề gì'),
(2, 2, 'Thú cưng đang điều trị, cần theo dõi thêm'),
(3, 3, 'Đã tiêm ngừa đầy đủ, thú cưng khỏe mạnh');


INSERT INTO PhanHoi (MaKH, NoiDung)
VALUES 
(1, 'Dịch vụ rất tốt, tôi rất hài lòng'),
(2, 'Cần cải thiện dịch vụ chăm sóc khách hàng'),
(3, 'Thú cưng của tôi được chăm sóc rất chu đáo');


INSERT INTO Users (Username, Password, Role, MaNV)
VALUES 
('admin', 'hashed_admin_password', 'Admin', 3),
('quanly', 'hashed_quanly_password', 'QuanLy', 3),
('nhanvien', 'hashed_nhanvien_password', 'NhanVien', 2);



INSERT INTO loaisanpham (MaLoai, TenLoai) VALUES 
(1, 'Thức ăn cho chó'),
(2, 'Thức ăn cho mèo'),
(3, 'Phụ kiện cho thú cưng'),
(4, 'Đồ chơi cho thú cưng');



INSERT INTO sanpham (MaSP, TenSP, MaLoai, Gia, MoTa, SoLuong, HinhAnh) VALUES
(1, 'Thức ăn hạt cho chó Royal Canin', 1, 500000, 'Thức ăn hạt dinh dưỡng cho chó Royal Canin, dành cho chó con từ 1 đến 6 tháng tuổi', 100, 'images/royal_canin_dog_food.jpg'),
(2, 'Thức ăn cho chó Pedigree', 1, 300000, 'Thức ăn cho chó Pedigree, hỗ trợ sức khỏe toàn diện', 150, 'images/pedigree_dog_food.jpg'),
(3, 'Xương gặm dinh dưỡng cho chó', 1, 50000, 'Xương gặm giúp làm sạch răng và cung cấp dinh dưỡng cho chó', 200, 'images/dog_bone.jpg'),
(4, 'Snack cho chó vị thịt bò', 1, 70000, 'Snack dinh dưỡng cho chó vị thịt bò thơm ngon', 180, 'images/dog_snack_beef.jpg'),
(5, 'Pate cho chó Pedigree', 1, 40000, 'Pate cho chó, bổ sung vitamin và khoáng chất', 220, 'images/dog_pate.jpg'),
(6, 'Thức ăn hạt cho chó SmartHeart', 1, 250000, 'Thức ăn hạt cho chó, hỗ trợ tiêu hóa và lông mượt', 130, 'images/smartheart_dog_food.jpg'),
(7, 'Thức ăn hạt cho chó con Minino', 1, 350000, 'Thức ăn hạt cho chó con Minino, dễ tiêu hóa và giàu dinh dưỡng', 140, 'images/minino_dog_food.jpg'),
(8, 'Xúc xích cho chó vị gà', 1, 45000, 'Xúc xích cho chó với hương vị gà thơm ngon, dễ ăn', 170, 'images/dog_sausage.jpg'),
(9, 'Sữa cho chó con Bio Milk', 1, 90000, 'Sữa dinh dưỡng cho chó con, cung cấp vitamin và khoáng chất', 190, 'images/bio_milk_dog.jpg'),
(10, 'Thức ăn ướt cho chó Cesar', 1, 60000, 'Thức ăn ướt cho chó Cesar, vị thịt cừu và rau củ', 160, 'images/cesar_dog_food.jpg');
INSERT INTO sanpham (MaSP, TenSP, MaLoai, Gia, MoTa, SoLuong, HinhAnh) VALUES
(11, 'Thức ăn hạt cho mèo Whiskas', 2, 300000, 'Thức ăn hạt cho mèo Whiskas, hương vị cá thu', 120, 'images/whiskas_cat_food.jpg'),
(12, 'Pate cho mèo Me-O', 2, 40000, 'Pate cho mèo Me-O, bổ sung vitamin và khoáng chất', 200, 'images/meo_cat_pate.jpg'),
(13, 'Snack cho mèo vị cá hồi', 2, 60000, 'Snack dinh dưỡng cho mèo vị cá hồi', 250, 'images/cat_snack_salmon.jpg'),
(14, 'Sữa cho mèo con Lactol', 2, 100000, 'Sữa dành cho mèo con, bổ sung vitamin cần thiết', 130, 'images/lactol_milk_cat.jpg'),
(15, 'Thức ăn ướt cho mèo Royal Canin', 2, 70000, 'Thức ăn ướt Royal Canin cho mèo trưởng thành', 180, 'images/royal_canin_cat_food.jpg'),
(16, 'Thức ăn cho mèo lớn Friskies', 2, 320000, 'Thức ăn cho mèo Friskies với hương vị gà và rau củ', 140, 'images/friskies_cat_food.jpg'),
(17, 'Pate cho mèo Blisk', 2, 45000, 'Pate dinh dưỡng cho mèo Blisk, hỗ trợ tiêu hóa', 190, 'images/blisk_cat_pate.jpg'),
(18, 'Thức ăn khô cho mèo ProPlan', 2, 360000, 'Thức ăn khô cho mèo ProPlan, hỗ trợ lông mượt', 170, 'images/proplan_cat_food.jpg'),
(19, 'Súp thưởng cho mèo Inaba', 2, 55000, 'Súp thưởng dành cho mèo Inaba, vị gà nướng', 160, 'images/inaba_cat_soup.jpg'),
(20, 'Snack mềm cho mèo Ciao', 2, 45000, 'Snack mềm cho mèo, hỗ trợ chăm sóc răng miệng', 150, 'images/ciao_cat_snack.jpg');
INSERT INTO sanpham (MaSP, TenSP, MaLoai, Gia, MoTa, SoLuong, HinhAnh) VALUES
(21, 'Dây dắt chó điều chỉnh độ dài', 3, 150000, 'Dây dắt chó có thể điều chỉnh độ dài, làm từ nylon chắc chắn', 80, 'images/dog_leash.jpg'),
(22, 'Lồng vận chuyển cho mèo', 3, 250000, 'Lồng vận chuyển cho mèo, an toàn và thoải mái', 60, 'images/cat_carrier.jpg'),
(23, 'Vòng cổ cho chó', 3, 70000, 'Vòng cổ da mềm dành cho chó', 100, 'images/dog_collar.jpg'),
(24, 'Bàn cào móng cho mèo', 3, 120000, 'Bàn cào móng giúp mèo giải trí và mài móng', 90, 'images/cat_scratching_board.jpg'),
(25, 'Bát ăn cho thú cưng', 3, 50000, 'Bát ăn chất liệu inox chống rỉ cho chó mèo', 200, 'images/pet_bowl.jpg'),
(26, 'Áo khoác cho chó', 3, 100000, 'Áo khoác giữ ấm cho chó trong mùa đông', 70, 'images/dog_coat.jpg'),
(27, 'Lược chải lông cho thú cưng', 3, 80000, 'Lược chải lông giúp loại bỏ lông rụng cho thú cưng', 150, 'images/pet_brush.jpg'),
(28, 'Giường ngủ cho chó', 3, 300000, 'Giường ngủ êm ái cho chó, chất liệu vải cao cấp', 50, 'images/dog_bed.jpg'),
(29, 'Túi vận chuyển cho thú cưng', 3, 200000, 'Túi vận chuyển thời trang dành cho chó mèo', 60, 'images/pet_carrier_bag.jpg'),
(30, 'Khay vệ sinh cho mèo', 3, 90000, 'Khay vệ sinh kèm cát cho mèo tiện lợi', 110, 'images/cat_litter_box.jpg');
INSERT INTO sanpham (MaSP, TenSP, MaLoai, Gia, MoTa, SoLuong, HinhAnh) VALUES
(31, 'Bóng đồ chơi cho mèo', 4, 50000, 'Bóng nhỏ cho mèo chơi, giúp giải trí và vận động', 120, 'images/cat_ball_toy.jpg'),
(32, 'Gậy lông vũ cho mèo', 4, 60000, 'Gậy lông vũ cho mèo, giúp mèo săn mồi và vui chơi', 140, 'images/cat_feather_toy.jpg'),
(33, 'Xương đồ chơi cho chó', 4, 70000, 'Xương đồ chơi làm từ cao su an toàn cho chó', 130, 'images/dog_chew_toy.jpg'),
(34, 'Chuột đồ chơi cho mèo', 4, 40000, 'Chuột giả cho mèo vui chơi và săn mồi', 150, 'images/cat_mouse_toy.jpg'),
(35, 'Đĩa bay cho chó', 4, 80000, 'Đĩa bay giúp chó tập thể dục và chơi đùa ngoài trời', 110, 'images/dog_frisbee.jpg'),
(36, 'Búp bê đồ chơi cho chó', 4, 75000, 'Búp bê mềm dành cho chó, giúp giảm stress', 160, 'images/dog_doll.jpg'),
(37, 'Trụ cào móng cho mèo', 4, 180000, 'Trụ cào móng cho mèo, làm từ sợi đay tự nhiên', 80, 'images/cat_scratching_post.jpg'),
(38, 'Đồ chơi phát sáng cho chó', 4, 90000, 'Đồ chơi phát sáng giúp chó chơi đùa vào ban đêm', 90, 'images/glowing_dog_toy.jpg'),
(39, 'Cần câu đồ chơi cho mèo', 4, 60000, 'Cần câu đồ chơi giúp mèo vận động và săn mồi', 170, 'images/cat_fishing_rod_toy.jpg'),
(40, 'Bóng gặm phát tiếng cho chó', 4, 95000, 'Bóng gặm phát ra tiếng kêu khi chó chơi', 100, 'images/noisy_dog_ball.jpg');























INSERT INTO sanpham (TenSP, MaLoai, HinhAnh, SoLuong, Gia, MoTa)
VALUES
    ('Thức ăn khô cho chó Pedigree', 1, 'pedigree_dog_food.jpg', 120, 450000.00, 'Thức ăn khô cho chó Pedigree, giàu dinh dưỡng và giúp duy trì sức khỏe răng miệng.'),
    ('Thức ăn ướt cho mèo Friskies', 2, 'friskies_cat_food.jpg', 100, 320000.00, 'Thức ăn ướt Friskies với hương vị hấp dẫn, cung cấp năng lượng cho mèo.'),
    ('Vòng cổ phản quang cho chó', 3, 'reflective_dog_collar.jpg', 150, 170000.00, 'Vòng cổ phản quang giúp chó dễ nhận diện trong đêm, an toàn hơn khi đi dạo.'),
    ('Cây cào móng đa năng cho mèo', 4, 'multi_scratching_tree.jpg', 30, 600000.00, 'Cây cào móng tích hợp nơi nghỉ ngơi và leo trèo cho mèo, giúp giảm stress.'),
    ('Bánh thưởng cho chó vị bò', 1, 'beef_dog_treats.jpg', 200, 100000.00, 'Bánh thưởng cho chó với hương vị bò, bổ sung dinh dưỡng và hỗ trợ huấn luyện.'),
    ('Sữa bột cho mèo con', 2, 'kitten_milk.jpg', 80, 250000.00, 'Sữa bột dành cho mèo con, giúp bổ sung dưỡng chất cần thiết trong giai đoạn đầu.'),
    ('Dây nịt cho chó lớn', 3, 'large_dog_harness.jpg', 50, 300000.00, 'Dây nịt chắc chắn dành cho chó lớn, giúp dễ dàng kiểm soát khi dắt đi dạo.'),
    ('Đĩa bay đồ chơi cho chó', 4, 'dog_frisbee.jpg', 100, 70000.00, 'Đĩa bay đồ chơi giúp chó tăng cường vận động và giải trí.'),
    ('Thức ăn hữu cơ cho chó', 1, 'organic_dog_food.jpg', 90, 600000.00, 'Thức ăn hữu cơ với thành phần tự nhiên, an toàn cho chó, không chứa chất bảo quản.'),
    ('Thức ăn khô cho mèo Royal Canin Kitten', 2, 'royal_canin_kitten.jpg', 70, 400000.00, 'Thức ăn khô cho mèo con Royal Canin, hỗ trợ phát triển và sức khỏe đường ruột.'),
    ('Vòng cổ da cho mèo', 3, 'leather_cat_collar.jpg', 130, 90000.00, 'Vòng cổ da mềm mại dành cho mèo, thiết kế thời trang và dễ điều chỉnh.'),
    ('Đồ chơi bóng rung cho mèo', 4, 'cat_jingle_ball.jpg', 60, 80000.00, 'Bóng rung với tiếng kêu thu hút mèo, giúp tăng cường vận động và chơi đùa.'),
    ('Bánh xương cho chó vị gà', 1, 'chicken_bone_treat.jpg', 160, 110000.00, 'Bánh xương vị gà dành cho chó, cung cấp canxi và dưỡng chất.'),
    ('Thức ăn đóng hộp cho mèo Me-O', 2, 'meo_canned_food.jpg', 140, 350000.00, 'Thức ăn đóng hộp Me-O, tiện lợi và giàu dinh dưỡng cho mèo.'),
    ('Dây dắt cho mèo', 3, 'cat_leash.jpg', 120, 75000.00, 'Dây dắt dễ điều chỉnh cho mèo, giúp dẫn mèo đi dạo một cách an toàn.'),
    ('Lưới cào móng treo tường cho mèo', 4, 'wall_scratching_pad.jpg', 80, 220000.00, 'Lưới cào móng treo tường, tiết kiệm không gian và giúp mèo giải tỏa căng thẳng.'),
    ('Thức ăn cho chó nhỏ Purina', 1, 'purina_small_dog.jpg', 130, 480000.00, 'Thức ăn dành riêng cho chó nhỏ Purina, hỗ trợ phát triển và sức khỏe răng miệng.'),
    ('Thức ăn cho mèo vị cá ngừ', 2, 'tuna_cat_food.jpg', 150, 280000.00, 'Thức ăn cho mèo vị cá ngừ, giàu protein và omega-3, tốt cho sức khỏe lông da.'),
    ('Vòng cổ có chuông cho mèo', 3, 'cat_bell_collar.jpg', 110, 50000.00, 'Vòng cổ có chuông giúp dễ dàng xác định vị trí của mèo trong nhà.'),
    ('Đồ chơi chuột giả cho mèo', 4, 'toy_mouse.jpg', 90, 60000.00, 'Chuột giả với thiết kế sinh động, thu hút sự chú ý và kích thích bản năng săn mồi của mèo.'),
    ('Thức ăn hạt cho chó trưởng thành', 1, 'adult_dog_kibble.jpg', 200, 550000.00, 'Thức ăn hạt dành cho chó trưởng thành, cung cấp đầy đủ dưỡng chất thiết yếu.'),
    ('Pate cho mèo vị gan', 2, 'liver_cat_pate.jpg', 140, 320000.00, 'Pate cho mèo với hương vị gan, giàu dinh dưỡng và dễ ăn.'),
    ('Bàn chải lông cho chó', 3, 'dog_brush.jpg', 70, 150000.00, 'Bàn chải lông mềm mại, giúp chăm sóc lông cho chó một cách hiệu quả.'),
    ('Đồ chơi mèo cào', 4, 'cat_scratching_toy.jpg', 60, 180000.00, 'Đồ chơi cào cho mèo, thiết kế đa năng vừa làm đồ chơi vừa là nơi cào móng.'),
    ('Thức ăn dinh dưỡng cho chó con', 1, 'puppy_nutrition.jpg', 85, 520000.00, 'Thức ăn chuyên biệt dành cho chó con, hỗ trợ phát triển xương và răng.'),
    ('Sữa mèo dạng lỏng', 2, 'liquid_cat_milk.jpg', 95, 270000.00, 'Sữa dạng lỏng dành cho mèo, bổ sung dinh dưỡng và dễ tiêu hóa.'),
    ('Áo cho chó nhỏ', 3, 'small_dog_shirt.jpg', 40, 90000.00, 'Áo cho chó nhỏ với chất liệu mềm mại, giữ ấm và tạo phong cách cho thú cưng.'),
    ('Đồ chơi lục lạc cho mèo', 4, 'cat_rattle_toy.jpg', 100, 70000.00, 'Đồ chơi lục lạc giúp mèo giải trí, kích thích vận động và phản xạ nhanh nhẹn.'),
    ('Thức ăn khô cho chó vị cừu', 1, 'lamb_dog_kibble.jpg', 130, 610000.00, 'Thức ăn khô vị cừu, cung cấp dưỡng chất và hỗ trợ hệ tiêu hóa của chó.'),
    ('Thức ăn đóng hộp cho mèo vị cá hồi', 2, 'salmon_canned_cat_food.jpg', 160, 340000.00, 'Thức ăn đóng hộp vị cá hồi, bổ sung omega-3 giúp lông mèo bóng mượt.'),
    ('Dây nịt phản quang cho chó', 3, 'reflective_dog_harness.jpg', 75, 260000.00, 'Dây nịt phản quang giúp chó an toàn hơn khi đi dạo vào buổi tối.'),
    ('Nhà cây cho mèo', 4, 'cat_tree_house.jpg', 25, 800000.00, 'Nhà cây với nhiều tầng giúp mèo leo trèo và nghỉ ngơi, giảm căng thẳng.'),
    ('Thức ăn cho chó nhạy cảm', 1, 'sensitive_dog_food.jpg', 60, 650000.00, 'Thức ăn chuyên dụng cho chó có hệ tiêu hóa nhạy cảm, không chứa chất gây dị ứng.'),
    ('Thức ăn hạt cho mèo lông dài', 2, 'long_hair_cat_food.jpg', 90, 450000.00, 'Thức ăn hạt hỗ trợ sức khỏe lông cho mèo lông dài, giúp lông mượt và ít rụng.'),
    ('Dây dắt tự động cho chó', 3, 'automatic_dog_leash.jpg', 55, 180000.00, 'Dây dắt tự động kéo dài, dễ sử dụng cho chó đi dạo.'),
    ('Bàn chải răng cho chó', 3, 'dog_toothbrush.jpg', 150, 50000.00, 'Bàn chải răng giúp vệ sinh răng miệng cho chó, ngăn ngừa bệnh nha chu.'),
    ('Đồ chơi mèo có đèn laser', 4, 'cat_laser_toy.jpg', 90, 210000.00, 'Đồ chơi laser tạo ánh sáng di chuyển, thu hút sự chú ý và chơi đùa của mèo.'),
    ('Thức ăn hữu cơ cho mèo', 2, 'organic_cat_food.jpg', 80, 550000.00, 'Thức ăn hữu cơ không chứa chất bảo quản, tốt cho sức khỏe toàn diện của mèo.'),
    ('Thức ăn khô cho chó vị thịt bò', 1, 'beef_dog_kibble.jpg', 100, 570000.00, 'Thức ăn khô vị thịt bò, bổ sung protein và năng lượng cho chó vận động.'),
    ('Lồng vận chuyển cho chó và mèo', 3, 'pet_carrier.jpg', 35, 750000.00, 'Lồng vận chuyển an toàn, tiện lợi cho việc di chuyển chó và mèo.'),
    ('Bánh thưởng cho mèo vị cá hồi', 2, 'salmon_cat_treats.jpg', 140, 90000.00, 'Bánh thưởng hương vị cá hồi, giúp bổ sung omega-3 và dưỡng chất cho mèo.'),
    ('Vòng cổ điều chỉnh được cho chó', 3, 'adjustable_dog_collar.jpg', 200, 110000.00, 'Vòng cổ có thể điều chỉnh, phù hợp với nhiều kích cỡ chó.'),
    ('Bàn cào cho mèo có đồ chơi treo', 4, 'cat_scratching_board_with_toy.jpg', 50, 270000.00, 'Bàn cào tích hợp đồ chơi treo, giúp mèo giải trí và duy trì thói quen cào móng.'),
    ('Thức ăn đặc biệt cho chó già', 1, 'senior_dog_food.jpg', 70, 590000.00, 'Thức ăn dành cho chó lớn tuổi, giúp hỗ trợ xương khớp và sức khỏe tổng thể.'),
    ('Thức ăn mềm cho mèo con', 2, 'soft_kitten_food.jpg', 120, 240000.00, 'Thức ăn mềm dành cho mèo con, dễ tiêu hóa và phù hợp với mèo mới tập ăn.');



CREATE TABLE donhang (
    MaDH INT AUTO_INCREMENT PRIMARY KEY,      -- Mã đơn hàng (Khóa chính)
    MaKH INT,                                 -- Mã khách hàng (Khóa ngoại liên kết với bảng khachhang)
    TongTien DECIMAL(10, 2) NOT NULL,        -- Tổng tiền đơn hàng
    TrangThai ENUM('Chưa Xử Lý', 'Đang Giao', 'Đã Giao', 'Hủy') DEFAULT 'Chưa Xử Lý',  -- Trạng thái đơn hàng
    NgayDat DATETIME DEFAULT CURRENT_TIMESTAMP, -- Ngày đặt hàng
    FOREIGN KEY (MaKH) REFERENCES khachhang(MaKH)  -- Ràng buộc khóa ngoại với bảng khachhang
);
INSERT INTO donhang (MaKH, TongTien, TrangThai, NgayDat) VALUES
(1, 250000.00, 'Chưa Xử Lý', '2024-10-20 10:00:00'),  -- Order for customer ID 1
(2, 150000.00, 'Đang Giao', '2024-10-21 11:00:00'),   -- Order for customer ID 2
(3, 300000.00, 'Đã Giao', '2024-10-22 12:30:00'),    -- Order for customer ID 3
(1, 50000.00,  'Hủy', '2024-10-23 09:15:00'),         -- Order for customer ID 1
(4, 450000.00, 'Chưa Xử Lý', '2024-10-24 14:45:00'),  -- Order for customer ID 4
(2, 120000.00, 'Đang Giao', '2024-10-25 08:30:00'),   -- Order for customer ID 2
(5, 700000.00, 'Đã Giao', '2024-10-26 16:00:00'),     -- Order for customer ID 5
(3, 350000.00, 'Chưa Xử Lý', '2024-10-27 10:05:00');  -- Order for customer ID 3


CREATE TABLE chitiethoadon (
    MaCT INT AUTO_INCREMENT PRIMARY KEY,       -- Mã chi tiết hóa đơn (Khóa chính)
    MaHoaDon int(11),                       -- Mã hóa đơn (Khóa ngoại tham chiếu đến bảng hoadon)
    MaSP int(11),                        -- Mã sản phẩm (Khóa ngoại tham chiếu đến bảng sản phẩm)
    SoLuong INT,                                -- Số lượng sản phẩm
    Gia DECIMAL(10,2),                          -- Giá sản phẩm
    FOREIGN KEY (MaHoaDon) REFERENCES hoadonsp(MaHoaDon), -- Khóa ngoại liên kết đến bảng hoadon
    FOREIGN KEY (MaSP) REFERENCES sanpham(MaSP) -- Khóa ngoại liên kết đến bảng sản phẩm
);


CREATE Table nghiphep(
    MaNg INT AUTO_INCREMENT PRIMARY KEY,      -- Mã nhập hàng (Khóa chính)
    MaNV,
    NgayBatDau DATE,
    NgayKetThuc DATE,
    SoNgayNghi int(31),
    LyDo VARCHAR(255),
    FOREIGN KEY (MaNV) REFERENCES nhanvien(MaNV)   -- Khóa ngoại liên kết đến bảng nhân viên

);

