<?php

include('../../php/connect.php');
include('get_pet_info.php');
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    // Hàm xử lý thêm đơn chăm sóc thú cưng
    if ($action == 'add_pet_order') {
        $tenThuCung = $_POST['TenThuCung'] ?? '';
        $loaiThuCung = $_POST['LoaiThuCung'] ?? '';
        $maKH = $_POST['MaKH'] ?? '';
        $dichVuChon = $_POST['DichVuChon'] ?? '';
        $trangThaiChuaBenh = $_POST['TrangThaiChuaBenh'] ?? '';
        $thoiGianNhan = $_POST['ThoiGianNhan'] ?? '';
        $thoiGianTra = $_POST['ThoiGianTra'] ?? '';
        $ghiChu = $_POST['GhiChu'] ?? '';

        // Kiểm tra xem hình ảnh có được tải lên không
        if (isset($_FILES['Hinhanh']) && $_FILES['Hinhanh']['error'] == 0) {
            $hinhAnh = file_get_contents($_FILES['Hinhanh']['tmp_name']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Vui lòng tải lên hình ảnh.']);
            exit();
        }

        // Thực hiện thêm dữ liệu vào bảng thucung
        $stmt = $conn->prepare("INSERT INTO thucung (TenThuCung, LoaiThuCung, MaKH, DichVuChon, TrangThaiChuaBenh, ThoiGianNhan, ThoiGianTra, HinhAnh, GhiChu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $tenThuCung, $loaiThuCung, $maKH, $dichVuChon, $trangThaiChuaBenh, $thoiGianNhan, $thoiGianTra, $hinhAnh, $ghiChu);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Thêm đơn chăm sóc thú cưng thành công!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi khi thêm đơn chăm sóc: ' . $stmt->error]);
        }

        $stmt->close();
    }

    // Hàm xử lý xóa đơn chăm sóc thú cưng
    else if ($action == 'delete_pet_order') {
        $order_id = $_POST['id'] ?? '';
        if (!empty($order_id)) {
            // Kiểm tra xem có bản ghi nào trong bảng khachhang tham chiếu đến MaThuCung không
            $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM khachhang WHERE MaThuCung = ?");
            $stmtCheck->bind_param("i", $order_id);
            $stmtCheck->execute();
            $stmtCheck->bind_result($count);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($count > 0) {
                // Nếu có bản ghi trong bảng khachhang, không cho phép xóa
                echo json_encode(['status' => 'error', 'message' => 'Không thể xóa vì có đơn hàng phụ thuộc.']);
            } else {
                // Nếu không có bản ghi nào tham chiếu, tiến hành xóa trong bảng thucung
                $stmt = $conn->prepare("DELETE FROM thucung WHERE MaThuCung = ?");
                $stmt->bind_param("i", $order_id);

                if ($stmt->execute()) {
                    // Nếu xóa thành công, trả về thông báo thành công
                    echo json_encode(['status' => 'success', 'message' => 'Xóa đơn chăm sóc thú cưng thành công!']);
                } else {
                    // Nếu có lỗi khi xóa, trả về thông báo lỗi
                    echo json_encode(['status' => 'success', 'message' => 'Xóa đơn chăm sóc thú cưng thành công!']);
                }
                header("Location: ./table-data-oder.php");
                $stmt->close();
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy ID đơn chăm sóc để xóa.']);
        }
    }


    // Hàm xử lý sửa đơn chăm sóc thú cưng
    elseif ($action == 'edit_pet_order') {
        $order_id = $_POST['id'] ?? '';
        $tenThuCung = $_POST['TenThuCung'] ?? '';
        $loaiThuCung = $_POST['LoaiThuCung'] ?? '';
        $maKH = $_POST['MaKH'] ?? '';
        $dichVuChon = $_POST['DichVuChon'] ?? '';
        $trangThaiChuaBenh = $_POST['TrangThaiChuaBenh'] ?? '';
        $thoiGianNhan = $_POST['ThoiGianNhan'] ?? '';
        $thoiGianTra = $_POST['ThoiGianTra'] ?? '';
        $ghiChu = $_POST['GhiChu'] ?? '';

        // Kiểm tra dữ liệu đầu vào
        if (empty($order_id) || empty($tenThuCung) || empty($loaiThuCung) || empty($maKH) || empty($dichVuChon) || empty($trangThaiChuaBenh)) {
            echo json_encode(['status' => 'error', 'message' => 'Vui lòng điền đầy đủ thông tin.']);
            exit;
        }

        if (!empty($order_id)) {
            // Nếu có hình ảnh được tải lên
            if (isset($_FILES['Hinhanh']) && $_FILES['Hinhanh']['error'] == 0) {
                // Kiểm tra định dạng hình ảnh
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['Hinhanh']['type'], $allowed_types)) {
                    // Kiểm tra kích thước hình ảnh (ví dụ: tối đa 2MB)
                    if ($_FILES['Hinhanh']['size'] <= 2 * 1024 * 1024) {
                        $hinhAnh = file_get_contents($_FILES['Hinhanh']['tmp_name']);
                        $stmt = $conn->prepare("UPDATE thucung SET TenThuCung = ?, LoaiThuCung = ?, MaKH = ?, DichVuChon = ?, TrangThaiChuaBenh = ?, ThoiGianNhan = ?, ThoiGianTra = ?, HinhAnh = ?, GhiChu = ? WHERE MaThuCung = ?");
                        $stmt->bind_param("sssssssssi", $tenThuCung, $loaiThuCung, $maKH, $dichVuChon, $trangThaiChuaBenh, $thoiGianNhan, $thoiGianTra, $hinhAnh, $ghiChu, $order_id);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Kích thước hình ảnh không được vượt quá 2MB.']);
                        exit;
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Định dạng hình ảnh không hợp lệ.']);
                    exit;
                }
            } else {
                // Nếu không có hình ảnh, không cập nhật cột HinhAnh
                $stmt = $conn->prepare("UPDATE thucung SET TenThuCung = ?, LoaiThuCung = ?, MaKH = ?, DichVuChon = ?, TrangThaiChuaBenh = ?, ThoiGianNhan = ?, ThoiGianTra = ?, GhiChu = ? WHERE MaThuCung = ?");
                $stmt->bind_param("ssssssssi", $tenThuCung, $loaiThuCung, $maKH, $dichVuChon, $trangThaiChuaBenh, $thoiGianNhan, $thoiGianTra, $ghiChu, $order_id);
            }

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Cập nhật đơn chăm sóc thú cưng thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Lỗi khi cập nhật đơn chăm sóc: ' . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy ID đơn chăm sóc để sửa.']);
        }
    }


    // Nếu action không hợp lệ
    else {
        echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ.']);
    }

    // Đóng kết nối
    $conn->close();
}
