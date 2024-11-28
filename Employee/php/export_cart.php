<?php
// Giả sử bạn đã kết nối đến cơ sở dữ liệu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ giỏ hàng
    $products = json_decode($_POST['products'], true); // Dữ liệu sản phẩm từ giỏ hàng
    $paymentMethod = $_POST['paymentMethod']; // Hình thức thanh toán
    $totalAmount = $_POST['totalAmount']; // Tổng số tiền phải trả
    $salesPerson = $_POST['salesPerson']; // Nhân viên bán hàng
    $saleTime = date("Y-m-d H:i:s"); // Thời gian bán hàng

    // Cập nhật số lượng sản phẩm trong kho
    foreach ($products as $product) {
        $productId = $product['MaSP'];
        $quantitySold = $product['SoLuong'];

        $query = "UPDATE sanpham SET SoLuong = SoLuong - ? WHERE MaSP = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $quantitySold, $productId);
        $stmt->execute();
    }

    // Lưu thông tin hóa đơn vào cơ sở dữ liệu
    $invoiceQuery = "INSERT INTO hoadon (total_amount, PhuongThucThanhToan, NgayLap, sales_person) VALUES (?, ?, ?, ?)";
    $invoiceStmt = $conn->prepare($invoiceQuery);
    $invoiceStmt->bind_param("isss", $totalAmount, $paymentMethod, $saleTime, $salesPerson);
    $invoiceStmt->execute();

    // Lấy ID của hóa đơn mới
    $invoiceId = $conn->insert_id;

    // Lưu chi tiết hóa đơn
    foreach ($products as $product) {
        $productId = $product['MaSP'];
        $quantitySold = $product['SoLuong'];

        $detailQuery = "INSERT INTO chitiethoadon (MaHoaDon, MaSP, SoLuong) VALUES (?, ?, ?)";
        $detailStmt = $conn->prepare($detailQuery);
        $detailStmt->bind_param("iii", $invoiceId, $productId, $quantitySold);
        $detailStmt->execute();
    }

    // Thực hiện in hóa đơn (nếu cần)
    // Bạn có thể sử dụng thư viện PDF để tạo và in hóa đơn

    echo "Hóa đơn đã được lưu thành công!";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="invoice" style="display: none;">
        <h2>HÓA ĐƠN</h2>
        <p>Thời gian bán: <span id="saleTime"></span></p>
        <p>Nhân viên bán: <span id="salesPerson"></span></p>
        <h3>Thông tin sản phẩm</h3>
        <table>
            <thead>
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody id="productDetails"></tbody>
        </table>
        <h3>Chi tiết hóa đơn</h3>
        <p>Số tiền phải trả: <span id="totalAmount"></span></p>
        <p>Hình thức thanh toán: <span id="paymentMethod"></span></p>
        <p>Ghi chú: <span id="note"></span></p>
        <button onclick="printInvoice()">In hóa đơn</button>
    </div>

    <script>
        function saveAndPrintInvoice() {
            // Lấy thông tin từ giỏ hàng
            const products = getCartProducts(); // Hàm này lấy sản phẩm từ giỏ hàng
            const totalAmount = calculateTotalAmount(products); // Hàm tính tổng tiền
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value; // Hình thức thanh toán
            const salesPerson = document.getElementById("salesPersonInput").value; // Nhân viên bán hàng

            // Gửi dữ liệu đến máy chủ
            const formData = new FormData();
            formData.append("products", JSON.stringify(products));
            formData.append("totalAmount", totalAmount);
            formData.append("paymentMethod", paymentMethod);
            formData.append("salesPerson", salesPerson);

            fetch("path/to/your/php/script.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Hiển thị hóa đơn
                    document.getElementById("saleTime").innerText = new Date().toLocaleString();
                    document.getElementById("salesPerson").innerText = salesPerson;
                    document.getElementById("totalAmount").innerText = totalAmount;
                    document.getElementById("paymentMethod").innerText = paymentMethod;

                    // Ghi chú nếu là chuyển khoản
                    document.getElementById("note").innerText = paymentMethod === "Chuyển khoản" ? "Ảnh chụp màn hình" : "";

                    const productDetails = document.getElementById("productDetails");
                    productDetails.innerHTML = "";
                    products.forEach(product => {
                        productDetails.innerHTML += `
                    <tr>
                        <td>${product.MaSP}</td>
                        <td>${product.TenSP}</td>
                        <td>${product.SoLuong}</td>
                    </tr>
                `;
                    });

                    // Hiển thị hóa đơn
                    document.getElementById("invoice").style.display = "block";
                })
                .catch(error => console.error("Error:", error));
        }

        function printInvoice() {
            // Bạn có thể sử dụng window.print() để in hóa đơn
            window.print();
        }

        function getCartProducts() {
            // Đây là hàm giả định, bạn cần viết logic để lấy sản phẩm từ giỏ hàng của bạn
            return [{
                    MaSP: 1,
                    TenSP: 'Sản phẩm A',
                    SoLuong: 2
                },
                {
                    MaSP: 2,
                    TenSP: 'Sản phẩm B',
                    SoLuong: 1
                }
            ];
        }

        function calculateTotalAmount(products) {
            // Hàm giả định, bạn cần viết logic để tính tổng tiền
            return products.reduce((total, product) => total + (product.Gia * product.SoLuong), 0);
        }
    </script>
</body>

</html>