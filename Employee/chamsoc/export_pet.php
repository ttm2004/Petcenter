<?php
include 'php/connect.php';

// Lấy mã đơn chăm sóc từ URL
$maDonChamSoc = $_GET['MaDonChamSoc'];

// Câu truy vấn dữ liệu
$sql = "SELECT 
            DonChamSoc.MaDonChamSoc,
            KhachHang.MaKH,
            KhachHang.HoTenKH,
            KhachHang.DiaChi,
            KhachHang.SoDienThoai,
            KhachHang.Email,
            ThuCung.MaThuCung,
            ThuCung.TenThuCung,
            ThuCung.LoaiThuCung,
            ThuCung.MauSac,
            ThuCung.CanNang,
            ThuCung.HinhAnh,
            ThuCung.ViTri,
            ThuCung.NgayTiepNhan,
            ThuCung.GhiChu AS GhiChuThuCung,
            DonChamSoc.NgayBatDau,
            DonChamSoc.NgayKetThuc,
            DichVu.TenDichVu,
            DonChamSoc.TinhTrangDon,
            DonChamSoc.ChiPhi,
            DonChamSoc.GhiChu AS GhiChuDon,
            DonChamSoc.NgayTaoDon,
            NhanVien.HoTenNV
        FROM 
            DonChamSoc
        INNER JOIN 
            KhachHang ON DonChamSoc.MaKH = KhachHang.MaKH
        LEFT JOIN 
            ThuCung ON DonChamSoc.MaDonChamSoc = ThuCung.MaDonChamSoc
        LEFT JOIN
            DichVu ON ThuCung.MaDichVu = DichVu.MaDichVu
        LEFT JOIN
            PhanCong ON DonChamSoc.MaDonChamSoc = PhanCong.MaDonChamSoc
        LEFT JOIN
            NhanVien ON PhanCong.MaNV = NhanVien.MaNV
        WHERE 
            DonChamSoc.MaDonChamSoc = ?";

// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $maDonChamSoc);
$stmt->execute();
$result = $stmt->get_result();

// Lưu kết quả vào một mảng
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Kiểm tra nếu không có dữ liệu
if (count($data) === 0) {
    die("Không tìm thấy thông tin đơn chăm sóc.");
}

// Thông tin cơ bản
$order = $data[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Trả Thú Cưng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <div id="notification" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 max-w-4xl mx-auto">
        <strong class="font-bold">Thành công!</strong>
        <span class="block sm:inline" id="notification-message">Đã cập nhật trạng thái đơn.</span>
    </div>

    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
        <h1 class="text-2xl font-bold text-blue-600 mb-4">Phiếu Trả Thú Cưng</h1>

        <!-- Thông Tin Đơn Chăm Sóc -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Thông Tin Đơn Chăm Sóc</h2>
            <p><strong class="text-gray-600">Mã đơn:</strong> <?= $order['MaDonChamSoc'] ?></p>
            <p><strong class="text-gray-600">Ngày bắt đầu:</strong> <?= $order['NgayBatDau'] ?></p>
            <p><strong class="text-gray-600">Ngày kết thúc:</strong> <?= $order['NgayKetThuc'] ?></p>
            <p><strong class="text-gray-600">Trạng thái:</strong> <?= $order['TinhTrangDon'] ?></p>
            <p><strong class="text-gray-600">Ghi chú:</strong> <?= $order['GhiChuDon'] ?></p>
        </div>


        <!-- Danh Sách Thú Cưng -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Danh Sách Thú Cưng</h2>
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">Tên thú cưng</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Loài</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Màu sắc</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Cân nặng</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Dịch vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $pet): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2"><?= $pet['TenThuCung'] ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $pet['MauSac'] ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $pet['CanNang'] ?> kg</td>
                            <td class="border border-gray-300 px-4 py-2"><?= $pet['TenDichVu'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center">
            <button onclick="updateStatusAndPrint()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 focus:outline-none">In Phiếu</button>
        </div>

    </div>
    <script>
        function updateStatusAndPrint() {
            const maDonChamSoc = "<?= $order['MaDonChamSoc'] ?>"; // Mã đơn từ PHP

            // Gửi yêu cầu AJAX cập nhật trạng thái đơn
            fetch('php/update_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        MaDonChamSoc: maDonChamSoc,
                        TinhTrangDon: 'Khách hàng đã xác nhận thú cưng thành công'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hiển thị khối thông báo
                        const notification = document.getElementById('notification');
                        const notificationMessage = document.getElementById('notification-message');
                        notificationMessage.innerText = 'Đã cập nhật trạng thái đơn. Bắt đầu in phiếu!';
                        notification.classList.remove('hidden');

                        // Chạy in phiếu
                        window.print();

                        // Chuyển hướng tới trang details-invoice.php sau khi in xong
                        setTimeout(() => {
                            window.location.href = 'details-invoice.php?MaDonChamSoc=' + maDonChamSoc;
                        }, 500); // Đợi 0.5 giây để đảm bảo lệnh in hoàn thành
                    } else {
                        // Hiển thị thông báo lỗi
                        const notification = document.getElementById('notification');
                        const notificationMessage = document.getElementById('notification-message');
                        notificationMessage.innerText = 'Cập nhật trạng thái thất bại: ' + data.message;
                        notification.classList.remove('hidden');
                        notification.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    // Hiển thị thông báo lỗi
                    const notification = document.getElementById('notification');
                    const notificationMessage = document.getElementById('notification-message');
                    notificationMessage.innerText = 'Đã xảy ra lỗi khi cập nhật trạng thái.';
                    notification.classList.remove('hidden');
                    notification.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
                });
        }
    </script>


</body>

</html>