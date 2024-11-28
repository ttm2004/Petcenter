<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../Auth/login_register.php");
    exit();
}

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "petcenter";

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_POST['save_changes'])) {
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $MaNv = $_SESSION['manv'];


    // Câu lệnh SQL để cập nhật thông tin nhân viên trong bảng `nhanvien`
    $query1 = "UPDATE nhanvien SET Username = ?, MatKhau = ? WHERE MaNV = ?";
    $query2 = "UPDATE users SET Username = ?, MatKhau = ? WHERE MaNv = ?";

    // Chuẩn bị và thực thi câu lệnh SQL cho bảng `nhanvien`
    if ($stmt = $conn->prepare($query1)) {
        // Gán tham số cho câu lệnh SQL
        $stmt->bind_param("ssi", $username, $password, $MaNv);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            // Tiếp tục cập nhật trong bảng `users`
            if ($stmt2 = $conn->prepare($query2)) {
                $stmt2->bind_param("ssi", $username, $password, $MaNv);

                if ($stmt2->execute()) {
                    // Cập nhật thành công
                    echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='../table-data-table.php';</script>";
                } else {
                    echo "<script>alert('Có lỗi xảy ra khi cập nhật thông tin trong bảng users.');</script>";
                }
                $stmt2->close();
            }
        } else {
            // Thất bại khi cập nhật
            echo "<script>alert('Có lỗi xảy ra khi cập nhật thông tin trong bảng nhanvien.');</script>";
        }

        // Đóng câu lệnh
        $stmt->close();
    } else {
        // Lỗi trong quá trình chuẩn bị câu lệnh
        echo "<script>alert('Có lỗi xảy ra trong quá trình chuẩn bị câu lệnh.');</script>";
    }
}

// Đóng kết nối
$conn->close();
?>
