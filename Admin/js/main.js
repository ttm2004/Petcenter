(function () {
	"use strict";

	var treeviewMenu = $('.app-menu');

	// Toggle Sidebar
	$('[data-toggle="sidebar"]').click(function (event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});

	// Activate sidebar treeview toggle
	$("[data-toggle='treeview']").click(function (event) {
		event.preventDefault();
		if (!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	// Set initial active toggle
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();

})();
function searchTable() {
	var input, filter, table, tr, td, i, txtValue1, txtValue2;
	input = document.getElementById("searchInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("sampleTable");
	tr = table.getElementsByTagName("tr");
	var noDataRow = document.getElementById("noDataRow");
	let found = false;
	for (i = 1; i < tr.length; i++) {
		tr[i].style.display = "none";
		td1 = tr[i].getElementsByTagName("td")[1];
		td2 = tr[i].getElementsByTagName("td")[2];

		if (td1 && td2) {
			txtValue1 = td1.textContent || td1.innerText;
			txtValue2 = td2.textContent || td2.innerText;

			if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
				found = true;
			}
		}
	}

	// Kiểm tra xem có tìm thấy khách hàng nào không
	if (!found) {
		noDataRow.style.display = ""; // Hiển thị thông báo không có dữ liệu
	} else {
		noDataRow.style.display = "none"; // Ẩn thông báo không có dữ liệu
	}
}

function toggleAllCheckboxes(source) {
	checkboxes = document.getElementsByName('check1');
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].checked = source.checked;
	}
}

// Hàm kiểm tra và hiển thị/ẩn nút xóa
function toggleDeleteButton() {
	const checkboxes = document.querySelectorAll('input[name="check1"]');
	const deleteButton = document.getElementById('deleteBtn');
	const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

	// Hiển thị nút xóa nếu có ít nhất một checkbox được chọn
	deleteButton.style.display = anyChecked ? 'block' : 'none';
}


let idsToDelete = []; // Biến lưu trữ ID khách hàng sẽ xóa

function deleteSelectedCustomers() {
	const checkboxes = document.querySelectorAll('input[name="check1"]:checked');
	idsToDelete = Array.from(checkboxes).map(checkbox => checkbox.value);

	if (idsToDelete.length === 0) {
		showNotification("Vui lòng chọn khách hàng cần xóa!");
		return;
	}

	// Hiển thị modal xác nhận
	document.getElementById("deleteConfirmationModal").style.display = "block";
	document.getElementById("overlay").style.display = "block";


}
// Gọi hàm toggleDeleteButton mỗi khi checkbox thay đổi
document.querySelectorAll('input[name="check1"]').forEach(checkbox => {
	checkbox.addEventListener('change', toggleDeleteButton);
});
function confirmDeletion() {
	// Gửi yêu cầu xóa đến server
	fetch('./php/delete-customers.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify({ ids: idsToDelete })
	})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				showNotification("Đã xóa khách hàng thành công!");
				location.reload(); // Tải lại trang sau khi xóa thành công
			} else {
				alert('Xóa khách hàng không thành công: ' + data.message);
			}
		})
		.catch(error => console.error('Error:', error));
}

function closeModal() {
	document.getElementById("deleteConfirmationModal").style.display = "none";
	document.getElementById("overlay").style.display = "none";
}

// Thêm sự kiện cho nút xác nhận xóa
document.getElementById("confirmDelete").onclick = confirmDeletion;

function showNotification(message) {
	const notification = document.getElementById("notification");
	notification.textContent = message;  // Cập nhật nội dung thông báo
	notification.style.display = "block"; // Hiển thị thông báo

	// Ẩn thông báo sau 3 giây
	setTimeout(() => {
		notification.style.display = "none";
		location.reload();
	}, 3000);
}


function updateRecordCount() {
    const recordCount = parseInt(document.getElementById('recordCount').value);
    const table = document.getElementById('customerTableBody');
    const rows = table.getElementsByTagName('tr');
    
    // Ẩn tất cả hàng
    for (let i = 0; i < rows.length; i++) {
        rows[i].style.display = 'none';
    }

    // Hiển thị số lượng hàng dựa trên lựa chọn
    for (let i = 0; i < recordCount && i < rows.length; i++) {
        rows[i].style.display = '';
    }

    // Cập nhật thông báo số lượng sản phẩm hiển thị
    document.getElementById('productCount').innerText = `Hiện ${Math.min(recordCount, rows.length)} danh mục`;
}

// Gọi hàm updateRecordCount khi tải trang
document.addEventListener('DOMContentLoaded', function() {
    updateRecordCount();
});


