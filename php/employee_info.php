<?php
session_start();
include '../php/connect.php';
// Kiểm tra quyền truy cập
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../Auth/login_register.php");
    exit;
}

$notification = ""; // Khai báo biến thông báo

// Thêm nhân viên
if (isset($_POST['add_employee'])) {
    $EmployeeID = $_POST['EmployeeID'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $DateOfBirth = $_POST['DateOfBirth'];
    $Gender = $_POST['Gender'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];
    $Address = $_POST['Address'];
    $Salary = $_POST['Salary'];
    $DateHired = $_POST['DateHired'];
    $Status = $_POST['Status'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $img_employee = $_POST['img_employee'];


    // Kiểm tra quyền trước khi thêm
    if ($_SESSION['role'] == 'Admin') {
        $stmt = $conn->prepare("INSERT INTO employees (EmployeeID, FirstName, LastName, DateOfBirth, Gender, Email, Phone, Address, Salary, DateHired, Status, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("issssssssssss", $EmployeeID, $FirstName, $LastName, $DateOfBirth, $Gender, $Email, $Phone, $Address, $Salary, $DateHired, $Status, $username, $password);

            if ($stmt->execute()) {
                $notification = "Thêm nhân viên thành công!";
            } else {
                $notification = "Lỗi: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $notification = "Lỗi trong câu lệnh SQL: " . $conn->error;
        }
    } else {
        $notification = "Bạn không có quyền thêm nhân viên.";
    }
}
// Cập nhật nhân viên
if (isset($_POST['update_employee'])) {
    $EmployeeID = $_POST['EmployeeID'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $DateOfBirth = $_POST['DateOfBirth'];
    $Gender = $_POST['Gender'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];
    $Address = $_POST['Address'];
    $Salary = $_POST['Salary'];
    $DateHired = $_POST['DateHired'];
    $Status = $_POST['Status'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $img_employee = $_POST['img_employee'];

    // Kiểm tra quyền trước khi cập nhật
    if (isset($_POST['update_employee'])) {
        // ... (initialization code remains unchanged)

        if ($_SESSION['role'] == 'Admin') {
            $stmt = $conn->prepare("UPDATE employees SET FirstName=?, LastName=?, DateOfBirth=?, Gender=?, Email=?, Phone=?, Address=?, Salary=?, DateHired=?, Status=?, username=?, password=? WHERE EmployeeID=?");

            if ($stmt) {
                $stmt->bind_param("ssssssssssss", $FirstName, $LastName, $DateOfBirth, $Gender, $Email, $Phone, $Address, $Salary, $DateHired, $Status, $username, $password);

                if ($stmt->execute()) {
                    $notification = "Cập nhật nhân viên thành công!";
                } else {
                    $notification = "Lỗi: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $notification = "Lỗi trong câu lệnh SQL: " . $conn->error;
            }
        } else {
            $notification = "Bạn không có quyền cập nhật nhân viên.";
        }
    }
}


// Xóa nhân viên
if (isset($_GET['delete_id'])) {
    $EmployeeID = $_GET['delete_id']; // Lưu EmployeeID dưới dạng chuỗi

    // Kiểm tra quyền trước khi xóa
    if ($_SESSION['role'] == 'Admin') {
        $stmt = $conn->prepare("DELETE FROM employees WHERE EmployeeID=?");

        if ($stmt) {
            $stmt->bind_param("s", $EmployeeID); // Sử dụng "s" để bind tham số kiểu chuỗi

            if ($stmt->execute()) {
                $notification = "Xóa nhân viên thành công!";
                header("Location: employee_info.php?page=1"); // Chuyển hướng sau khi xóa
                exit(); // Dừng script
            } else {
                $notification = "Lỗi: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $notification = "Lỗi trong câu lệnh SQL: " . $conn->error;
        }
    } else {
        $notification = "Bạn không có quyền xóa nhân viên.";
    }
}


// Tìm kiếm nhân viên
$searchQuery = "";
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search_query'];
}

// Phân trang
$limit = 10; // Số bản ghi mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Lấy danh sách nhân viên với tìm kiếm và phân trang
$stmt = $conn->prepare("SELECT * FROM employees WHERE FirstName LIKE ? OR LastName LIKE ? LIMIT ? OFFSET ?");
$searchTerm = "%$searchQuery%";
$stmt->bind_param("ssii", $searchTerm, $searchTerm, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Lấy tổng số nhân viên
$totalStmt = $conn->prepare("SELECT COUNT(*) as total FROM employees WHERE FirstName LIKE ? OR LastName LIKE ?");
$totalStmt->bind_param("ss", $searchTerm, $searchTerm);
$totalStmt->execute();
$totalResult = $totalStmt->get_result()->fetch_assoc();
$totalEmployees = $totalResult['total'];
$totalPages = ceil($totalEmployees / $limit);

$stmt->close();
$totalStmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/employee_management.css"> <!-- Liên kết CSS -->
    <title>Quản lý Nhân viên</title>
    <script>
        function toggleForms() {
            const forms = document.getElementById('add-form');
            forms.style.display = (forms.style.display === 'none' || forms.style.display === '') ? 'block' : 'none';
        }

        function showEditForm(employeeID) {
            // Lấy thông tin nhân viên từ row và điền vào form chỉnh sửa
            const row = document.getElementById('row-' + employeeID);
            document.getElementById('edit_id').value = employeeID;
            document.getElementById('edit_EmployeeID').value = row.dataset.employeeid;
            document.getElementById('edit_FirstName').value = row.dataset.firstname;
            document.getElementById('edit_LastName').value = row.dataset.lastname;
            document.getElementById('edit_DateOfBirth').value = row.dataset.dateofbirth;
            document.getElementById('edit_Gender').value = row.dataset.gender;
            document.getElementById('edit_Email').value = row.dataset.email;
            document.getElementById('edit_Phone').value = row.dataset.phone;
            document.getElementById('edit_Address').value = row.dataset.address;
            document.getElementById('edit_Salary').value = row.dataset.salary;
            document.getElementById('edit_DateHired').value = row.dataset.datehired;
            document.getElementById('edit_Status').value = row.dataset.status;
            document.getElementById('edit_username').value = row.dataset.username;

            // Hiển thị form chỉnh sửa
            document.getElementById('edit-form').style.display = 'block';
        }

        function delete_id(employeeID) {
            if (confirm("Bạn có chắc chắn muốn xóa nhân viên này không?")) {
                // Gửi yêu cầu xóa đến server qua một URL (nên thay đổi nếu cần)
                window.location.href = 'employee_info.php?action=delete&EmployeeID=' + employeeID;
            }
        }


        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }
    </script>
</head>

<body>
    <h1>Quản lý Nhân viên</h1>
    <div id="notification" class="notification" style="display:none;"><?php echo $notification; ?></div>

    <button onclick="toggleForms()">Thêm Nhân viên</button>
    
    <form method="POST" action="">
        <input type="text" name="search_query" placeholder="Tìm kiếm theo mã nhân viên hoặc họ tên" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" name="search">Tìm kiếm</button>
    </form>
    <div id="add-form" style="display:none;">
        <h3>Thêm Nhân viên</h3>
        <?php
        ?>
        <form action="" method="POST">
            <!-- Các trường input cho thông tin nhân viên -->
            <label for="edit_EmployeeID">Mã nhân viên:</label>
            <input type="text" name="EmployeeID" required>
            <label for="FirstName">Họ:</label>
            <input type="text" name="FirstName" required>
            <label for="LastName">Tên:</label>
            <input type="text" name="LastName" required>
            <label for="DateOfBirth">Ngày sinh:</label>
            <input type="date" name="DateOfBirth" required>
            <label for="Gender">Giới tính:</label>
            <select name="Gender">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
            <label for="Email">Email:</label>
            <input type="email" name="Email" required>
            <label for="Phone">Điện thoại:</label>
            <input type="tel" name="Phone" required>
            <label for="Address">Địa chỉ:</label>
            <input type="text" name="Address" required>
            <label for="Salary">Lương:</label>
            <input type="number" name="Salary" required>
            <label for="DateHired">Ngày tuyển dụng:</label>
            <input type="date" name="DateHired" required>
            <label for="Status">Trạng thái:</label>
            <select name="Status" id="edit_Status">
                <option value="Đang làm">Đang làm</option>
                <option value="Nghỉ việc">Nghỉ việc</option>
            </select>
            <label for="username">Tên đăng nhập:</label>
            <input type="text" name="username" required>
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" required>
            <button type="submit" name="add_employee">Thêm</button>
        </form>
    </div>
    <!-- Form cập nhật nhân viên -->
    <div id="edit-form" style="display:none;">
        <h2>Cập nhật Nhân viên</h2>
        <form method="POST" action="">
            <input type="hidden" name="EmployeeID" id="edit_id">

            <label for="edit_EmployeeID">Mã nhân viên:</label>
            <input type="text" name="EmployeeID" id="edit_EmployeeID" required placeholder="Mã nhân viên">

            <label for="edit_FirstName">Tên:</label>
            <input type="text" name="FirstName" id="edit_FirstName" required placeholder="Tên">

            <label for="edit_LastName">Họ:</label>
            <input type="text" name="LastName" id="edit_LastName" required placeholder="Họ">

            <label for="edit_DateOfBirth">Ngày sinh:</label>
            <input type="date" name="DateOfBirth" id="edit_DateOfBirth" required>

            <label for="edit_Gender">Giới tính:</label>
            <select name="Gender" id="edit_Gender">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>

            <label for="edit_Email">Email:</label>
            <input type="email" name="Email" id="edit_Email" required placeholder="Email">

            <label for="edit_Phone">Số điện thoại:</label>
            <input type="tel" name="Phone" id="edit_Phone" required placeholder="Số điện thoại">

            <label for="edit_Address">Địa chỉ:</label>
            <input type="text" name="Address" id="edit_Address" required placeholder="Địa chỉ">

            <label for="edit_Salary">Lương:</label>
            <input type="number" name="Salary" id="edit_Salary" required placeholder="Lương">

            <label for="edit_DateHired">Ngày vào làm:</label>
            <input type="date" name="DateHired" id="edit_DateHired" required>

            <label for="edit_Status">Trạng thái:</label>
            <select name="Status" id="edit_Status">
                <option value="Đang làm">Đang làm</option>
                <option value="Nghỉ việc">Nghỉ việc</option>
            </select>

            <label for="edit_username">Tên đăng nhập:</label>
            <input type="text" name="username" id="edit_username" required placeholder="Tên đăng nhập">

            <label for="edit_password">Mật khẩu:</label>
            <input type="password" name="password" placeholder="Mật khẩu (để cập nhật)">

            <button type="submit" name="update_employee">Cập nhật</button>
            <button type="button" onclick="document.getElementById('edit-form').style.display='none'">Hủy</button>
        </form>
    </div>


    <!-- Hiển thị danh sách nhân viên -->
    <table>
        <thead>
            <tr>
                <th>STT</th> <!-- Thêm cột số thứ tự -->
                <th>ID</th> <!-- Thêm cột ID -->
                <th>Họ</th>
                <th>Tên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Địa chỉ</th>
                <th>Lương</th>
                <th>Ngày tuyển dụng</th>
                <th>Trạng thái</th>
                <th>Tên đăng nhập</th>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stt = ($page - 1) * $limit; // Tính số thứ tự bắt đầu từ 1
            while ($employee = $result->fetch_assoc()): ?>
                <tr id="row-<?php echo $employee['EmployeeID']; ?>"
                    data-firstname="<?php echo $employee['FirstName']; ?>"
                    data-lastname="<?php echo $employee['LastName']; ?>"
                    data-dateofbirth="<?php echo $employee['DateOfBirth']; ?>"
                    data-gender="<?php echo $employee['Gender']; ?>"
                    data-email="<?php echo $employee['Email']; ?>"
                    data-phone="<?php echo $employee['Phone']; ?>"
                    data-address="<?php echo $employee['Address']; ?>"
                    data-salary="<?php echo $employee['Salary']; ?>"
                    data-datehired="<?php echo $employee['DateHired']; ?>"
                    data-status="<?php echo $employee['Status']; ?>"
                    data-username="<?php echo $employee['username']; ?>"
                    data-password="<?php echo $employee['password']; ?>"> <!-- Chỉ hiển thị username -->
                    <td><?php echo $stt; ?></td> <!-- Hiển thị số thứ tự -->
                    <td><?php echo $employee['EmployeeID']; ?></td>
                    <td><?php echo $employee['FirstName']; ?></td>
                    <td><?php echo $employee['LastName']; ?></td>
                    <td><?php echo $employee['DateOfBirth']; ?></td>
                    <td><?php echo $employee['Gender']; ?></td>
                    <td><?php echo $employee['Email']; ?></td>
                    <td><?php echo $employee['Phone']; ?></td>
                    <td><?php echo $employee['Address']; ?></td>
                    <td><?php echo $employee['Salary']; ?></td>
                    <td><?php echo $employee['DateHired']; ?></td>
                    <td><?php echo $employee['Status']; ?></td>
                    <td><?php echo $employee['username']; ?></td>
                    <td>
                        <button onclick="showEditForm('<?php echo $employee['EmployeeID']; ?>')">Sửa</button>
                        <button onclick="delete_id(<?php echo $employee['EmployeeID']; ?>)">Xóa</button>
                    </td>
                </tr>
            <?php
                $stt++; // Tăng số thứ tự
            endwhile; ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
    <button onclick="window.location.href='../Admin/admin.php'">Về trang chủ</button>
</body>

</html>