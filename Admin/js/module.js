$(document).ready(function () {
    // Cập nhật phần xử lý xóa trong jQuery
    $(".trash").click(function () {
        var row = $(this).closest("tr"); // Lấy dòng gần nhất
        var orderId = $(this).data("id"); // Lấy ID đơn hàng từ thuộc tính data-id

        swal({
            title: "Cảnh báo",
            text: "Bạn có chắc chắn là muốn xóa đơn hàng này?",
            buttons: ["Hủy bỏ", "Đồng ý"],
        }).then((willDelete) => {
            if (willDelete) {
                // Gửi yêu cầu xóa đến server
                $.ajax({
                    type: "POST",
                    url: "./php/module.php",
                    data: { action: 'delete_pet_order', id: orderId },
                    success: function (response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            swal("Đã xóa thành công!", {
                                icon: "success",
                            });
                            // Xóa dòng trong bảng
                            row.remove();
                        } else {
                            swal("Lỗi!", result.message, "error");
                        }
                    },
                    error: function () {
                        swal("Thành công", "Đã xóa đơn hàng thành công", "success");
                        window.location.reload();
                    }
                });
            }
        });
    });
    // Khi nhấn nút sửa
    $('.edit').on('click', function () {
        var petId = $(this).data('id'); // Lấy MaThuCung từ data-id của nút đã nhấn

        // Gửi yêu cầu lấy thông tin thú cưng cần sửa
        $.ajax({
            url: './php/get_pet_info.php',
            type: 'POST',
            data: { 'MaThuCung': petId },
            dataType: 'json', // Đặt loại dữ liệu phản hồi là JSON
            success: function (data) {
                // Kiểm tra nếu dữ liệu trả về hợp lệ
                if (data) {
                    $('#editMaThuCung').val(data.MaThuCung);
                    $('#editTenThuCung').val(data.TenThuCung);
                    $('#editLoaiThuCung').val(data.LoaiThuCung);
                    $('#editDichVuChon').val(data.DichVuChon);
                    $('#editTrangThaiChuaBenh').val(data.TrangThaiChuaBenh);
                    $('#editGhiChu').val(data.GhiChu);

                    // Hiện bảng sửa
                    $('#editPetTable').css('display', 'block'); // Sử dụng jQuery để thay đổi kiểu hiển thị
                } else {
                    console.error("Dữ liệu trả về không hợp lệ.");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Lỗi khi lấy thông tin thú cưng: " + textStatus + " " + errorThrown);
                console.error("Phản hồi: " + jqXHR.responseText);
            }
        });
    });


    // Khi nhấn nút Hủy
    $('#cancelEditPet').on('click', function () {
        $('#editPetTable').hide(); // Ẩn bảng sửa
    });

    // Khi nhấn nút Lưu Thay Đổi
    $('#saveEditPet').on('click', function () {
        // Gửi yêu cầu cập nhật
        var updatedPetData = {
            'editMaThuCung': $('#editMaThuCung').val(),
            'editTenThuCung': $('#editTenThuCung').val(),
            'editLoaiThuCung': $('#editLoaiThuCung').val(),
            'editDichVuChon': $('#editDichVuChon').val(),
            'editTrangThaiChuaBenh': $('#editTrangThaiChuaBenh').val(),
            'editGhiChu': $('#editGhiChu').val()
        };

        $.ajax({
            url: './update_pet_info.php',
            type: 'POST',
            data: updatedPetData,
            success: function (response) {
                alert(response);
                $('#editPetTable').hide(); // Ẩn bảng sửa
                location.reload(); // Tải lại trang để cập nhật bảng
            }
        });
    });

});
