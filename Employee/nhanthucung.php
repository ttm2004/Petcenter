<?php
session_start();
$conn = new mysqli("localhost", "root", "", "petcenter");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (!isset($_GET['MaDonChamSoc'])) {
    die("<div class='bg-red-500 text-white p-4 rounded'>Không tìm thấy mã đơn chăm sóc.</div>");
}

$maDonChamSoc = $_GET['MaDonChamSoc'];
$message = '';

// Xử lý form khi người dùng nhấn nút để thêm tất cả thú cưng vào chuồng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['MaThuCung']) && isset($_POST['MaChuong'])) {
    // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
    $conn->begin_transaction();
    try {
        // Duyệt qua tất cả các thú cưng và chuồng được gửi qua form
        foreach ($_POST['MaThuCung'] as $index => $maThuCung) {
            $maChuong = $_POST['MaChuong'][$index];

            // Cập nhật vị trí của thú cưng
            $sql_update_thucung = "UPDATE ThuCung SET ViTri = (SELECT TenChuong FROM Chuong WHERE MaChuong = ?) WHERE MaThuCung = ?";
            $stmt_update_thucung = $conn->prepare($sql_update_thucung);
            $stmt_update_thucung->bind_param("ii", $maChuong, $maThuCung);
            if (!$stmt_update_thucung->execute()) {
                throw new Exception("Cập nhật vị trí thú cưng thất bại cho thú cưng $maThuCung.");
            }

            // Cập nhật trạng thái chuồng thành "Đã Có Thú Cưng"
            $sql_update_chuong = "UPDATE Chuong SET TrangThai = 'Đã Có Thú Cưng', MaThuCung = ? WHERE MaChuong = ?";
            $stmt_update_chuong = $conn->prepare($sql_update_chuong);
            $stmt_update_chuong->bind_param("ii", $maThuCung, $maChuong);
            if (!$stmt_update_chuong->execute()) {
                throw new Exception("Cập nhật trạng thái chuồng thất bại cho chuồng $maChuong.");
            }

            // Đóng statement sau mỗi lần cập nhật
            $stmt_update_thucung->close();
            $stmt_update_chuong->close();
        }

        // Commit transaction nếu tất cả các cập nhật thành công
        $conn->commit();
        $message = "<div class='bg-green-500 text-white p-4 rounded'>Thêm tất cả thú cưng vào chuồng thành công!</div>";
        header("Location: details-invoice.php?MaDonChamSoc=" . $maDonChamSoc);
        exit;
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        $conn->rollback();
        $message = "<div class='bg-red-500 text-white p-4 rounded'>Lỗi: " . $e->getMessage() . "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Nhận Thú Cưng vào Chuồng</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h2 class="text-3xl font-bold text-gray-700 mb-4 max-w-md mx-auto">Nhận Thú Cưng vào Chuồng</h2>
        <h3 class="text-xl font-bold text-gray-700 mb-4 max-w-md mx-auto">Mã đơn chăm sóc: <span><?php echo " " . $maDonChamSoc ?></span></h3>
        <!-- Hiển thị thông báo nếu có -->
        <?php if ($message) echo $message; ?>

        <form method="POST" class="mt-4 max-w-md mx-auto">
            <?php
            // Truy vấn chỉ lấy các thú cưng có mã đơn chăm sóc cụ thể
            $sql = "SELECT 
            ThuCung.MaThuCung, 
            ThuCung.TenThuCung, 
            ThuCung.LoaiThuCung,
            ThuCung.MauSac,
            ThuCung.CanNang,
            ThuCung.HinhAnh,
            DichVu.TenDichVu
        FROM 
            ThuCung
        INNER JOIN 
            DichVu ON ThuCung.MaDichVu = DichVu.MaDichVu
        WHERE 
            ThuCung.MaDonChamSoc = ?";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Lỗi truy vấn: " . $conn->error);
            }

            $stmt->bind_param("s", $maDonChamSoc);
            $stmt->execute();
            $result = $stmt->get_result();


            if ($result->num_rows > 0) {
                // Duyệt qua từng thú cưng trong đơn chăm sóc
                while ($row = $result->fetch_assoc()) {
                    $maThuCung = $row['MaThuCung'];
                    $tenThuCung = $row['TenThuCung'];
                    $tenDichVu = $row['TenDichVu'];
            ?>
                    <div class="bg-white shadow-md rounded p-4 mb-4">
                        <h5 class="text-lg font-semibold text-gray-800">Thú Cưng: <?php echo htmlspecialchars($tenThuCung); ?></h5>
                        <input type="hidden" name="MaThuCung[]" value="<?php echo $maThuCung; ?>">
                        <p>Tên dịch vụ: <span></span><?php echo $tenDichVu; ?></p>

                        <!-- Danh sách chuồng trống -->
                        <div class="mb-4">
                            <label for="MaChuong_<?php echo $maThuCung; ?>" class="block text-sm font-medium text-gray-700">Chọn Chuồng Trống:</label>
                            <select name="MaChuong[]" id="MaChuong_<?php echo $maThuCung; ?>" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <?php
                                // Truy vấn các chuồng trống
                                $result_chuong = $conn->query("SELECT MaChuong, TenChuong FROM Chuong WHERE TrangThai = 'trong'");
                                while ($row_chuong = $result_chuong->fetch_assoc()) {
                                    echo "<option value='{$row_chuong['MaChuong']}'>{$row_chuong['TenChuong']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='bg-yellow-100 text-yellow-800 p-4 rounded mb-4'>Không tìm thấy thú cưng trong đơn chăm sóc.</div>";
            }

            $stmt->close();
            ?>

            <!-- Nút Gửi để thêm tất cả thú cưng vào chuồng -->
            <div class="text-center mt-6">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600 transition">
                    Thêm tất cả thú cưng vào chuồng
                </button>
            </div>
        </form>
    </div>
</body>

</html>

<?php
// Đóng kết nối sau khi hiển thị danh sách chuồng và thú cưng
$conn->close();
?>