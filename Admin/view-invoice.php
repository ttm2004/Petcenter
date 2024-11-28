<?php
// Kết nối cơ sở dữ liệu
include '../php/connect.php';
// Kiểm tra xem MaThuCung có trong URL không
if (!isset($_GET['MaThuCung'])) {
    echo "Mã thú cưng không hợp lệ.";
    exit();
}

$MaThuCung = $conn->real_escape_string($_GET['MaThuCung']);

// Xử lý cập nhật tổng tiền
if (isset($_POST['update_total'])) {
    $TongTien = $conn->real_escape_string($_POST['TongTien']);

    $sql_update = "UPDATE hoadon SET TongTien = '$TongTien' WHERE MaThuCung = '$MaThuCung'";
    if ($conn->query($sql_update) === TRUE) {
        echo "Cập nhật tổng tiền thành công.";
    } else {
        echo "Lỗi khi cập nhật tổng tiền: " . $conn->error;
    }
}

// Xử lý thêm dịch vụ
if (isset($_POST['add_service'])) {
    $MaDV = $conn->real_escape_string($_POST['MaDV']);

    $sql_check = "SELECT * FROM hoadon WHERE MaThuCung = '$MaThuCung' AND MaDV = '$MaDV'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 0) {
        $sql_add_service = "INSERT INTO hoadon (MaThuCung, MaDV) VALUES ('$MaThuCung', '$MaDV')";
        if ($conn->query($sql_add_service) === TRUE) {
            echo "Dịch vụ đã được thêm vào hóa đơn.";
        } else {
            echo "Lỗi khi thêm dịch vụ: " . $conn->error;
        }
    } else {
        echo "Dịch vụ này đã tồn tại trong hóa đơn.";
    }
}

// Xử lý xóa dịch vụ
if (isset($_GET['delete_service'])) {
    $MaDV = $conn->real_escape_string($_GET['delete_service']);

    $sql_delete_service = "DELETE FROM hoadon WHERE MaThuCung = '$MaThuCung' AND MaDV = '$MaDV'";
    if ($conn->query($sql_delete_service) === TRUE) {
        echo "Dịch vụ đã được xóa khỏi hóa đơn.";
    } else {
        echo "Lỗi khi xóa dịch vụ: " . $conn->error;
    }
}

// Truy vấn thông tin hóa đơn và dịch vụ
$sql_invoice_info = "SELECT * FROM hoadon WHERE MaThuCung = '$MaThuCung'";
$result_invoice = $conn->query($sql_invoice_info);
$row_invoice = $result_invoice->fetch_assoc();

$sql_invoice_services = "SELECT hoadon.MaDV, dichvu.TenDichVu
                         FROM hoadon
                         INNER JOIN dichvu ON hoadon.MaDV = DichVu.MaDV
                         WHERE hoadon.MaThuCung = '$MaThuCung'";
$result_services = $conn->query($sql_invoice_services);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Hóa Đơn</title>
</head>
<body>
    <h1>Chi Tiết Hóa Đơn</h1>
    <p>Mã thú cưng: <?php echo $MaThuCung; ?></p>
    <form method="post" action="">
        <label for="TongTien">Tổng tiền:</label>
        <input type="number" name="TongTien" id="TongTien" value="<?php echo $row_invoice['TongTien']; ?>" required>
        <button type="submit" name="update_total">Cập nhật tổng tiền</button>
    </form>

    <h2>Danh sách dịch vụ</h2>
    <table border="1">
        <tr>
            <th>Tên dịch vụ</th>
            <th>Hành động</th>
        </tr>
        <?php
        if ($result_services->num_rows > 0) {
            while ($row_service = $result_services->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row_service['TenDichVu'] . "</td>";
                echo "<td><a href='invoice-detail.php?MaThuCung=" . $MaThuCung . "&delete_service=" . $row_service['MaDV'] . "'>Xóa</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Không có dịch vụ nào trong hóa đơn.</td></tr>";
        }
        ?>
    </table>

    <h2>Thêm dịch vụ vào hóa đơn</h2>
    <form method="post" action="">
        <label for="MaDV">Chọn dịch vụ:</label>
        <select name="MaDV" id="MaDV" required>
            <?php
            // Truy vấn danh sách dịch vụ
            $sql_services = "SELECT * FROM DichVu";
            $result_all_services = $conn->query($sql_services);
            while ($service = $result_all_services->fetch_assoc()) {
                echo "<option value='" . $service['MaDV'] . "'>" . $service['TenDichVu'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="add_service">Thêm dịch vụ</button>
    </form>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
