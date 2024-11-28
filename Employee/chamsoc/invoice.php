<?php
// Bắt đầu session
session_start();

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "petcenter");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin đơn hàng và khách hàng
$maDonChamSoc = $_GET['MaDonChamSoc'];
$queryOrder = "SELECT KhachHang.HoTenKH, KhachHang.DiaChi,KhachHang.SoDienThoai, KhachHang.Email FROM KhachHang
                INNER JOIN DonChamSoc ON KhachHang.MaKH = DonChamSoc.MaKH
                 WHERE MaDonChamSoc = ?";
$stmtOrder = $conn->prepare($queryOrder);
$stmtOrder->bind_param("s", $maDonChamSoc);
$stmtOrder->execute();
$order = $stmtOrder->get_result()->fetch_assoc();


$queryServices = "SELECT DichVu.TenDichVu, DichVu.GiaTien, ThuCung.TenThuCung
                    FROM DichVu
                    INNER JOIN ThuCung ON DichVu.MaDichVu = ThuCung.MaDichVu
                    INNER JOIN DonChamSoc ON ThuCung.MaDonChamSoc = DonChamSoc.MaDonChamSoc
                    WHERE DonChamSoc.MaDonChamSoc = ?";
$stmtServices = $conn->prepare($queryServices);
$stmtServices->bind_param("s", $maDonChamSoc);
$stmtServices->execute();
$resultServices = $stmtServices->get_result();
$services = [];
$totalPrice = 0;

while ($row = $resultServices->fetch_assoc()) {
    $services[] = $row;
    $totalPrice += $row['GiaTien'];
}

// Lấy danh sách sản phẩm
$queryProducts = "SELECT MaSP, TenSP, Gia FROM SanPham";
$resultProducts = $conn->query($queryProducts);

// Khởi tạo session để lưu sản phẩm đã thêm
if (!isset($_SESSION['added_products'])) {
    $_SESSION['added_products'] = [];
}

// Nếu nhân viên gửi form để thêm sản phẩm với số lượng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['products'])) {
    foreach ($_POST['products'] as $productId => $productData) {
        // Kiểm tra xem sản phẩm có được chọn hay không
        if (isset($productData['selected'])) {
            $quantity = max((int)$productData['quantity'], 1); // Đảm bảo số lượng >= 1

            // Truy vấn thông tin sản phẩm
            $querySelectedProduct = "SELECT MaSP, TenSP, Gia FROM SanPham WHERE MaSP = ?";
            $stmtProduct = $conn->prepare($querySelectedProduct);
            $stmtProduct->bind_param("i", $productId);
            $stmtProduct->execute();
            $resultProduct = $stmtProduct->get_result()->fetch_assoc();

            if ($resultProduct) {
                // Kiểm tra nếu sản phẩm đã tồn tại trong session
                if (isset($_SESSION['added_products'][$productId])) {
                    // Cập nhật số lượng và tổng giá
                    $_SESSION['added_products'][$productId]['SoLuong'] += $quantity;
                    $_SESSION['added_products'][$productId]['Gia'] += $resultProduct['Gia'] * $quantity;
                } else {
                    // Thêm sản phẩm mới
                    $_SESSION['added_products'][$productId] = [
                        'MaSP' => $resultProduct['MaSP'],
                        'TenSP' => $resultProduct['TenSP'],
                        'Gia' => $resultProduct['Gia'],
                        'SoLuong' => $quantity,
                        'Gia' => $resultProduct['Gia'] * $quantity,
                    ];
                }
            }
        }
    }
}


// Nếu nhân viên gửi yêu cầu xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product'])) {
    $productToRemove = $_POST['remove_product'];
    if (isset($_SESSION['added_products'][$productToRemove])) {
        unset($_SESSION['added_products'][$productToRemove]);
    }
}

// Gộp dịch vụ và sản phẩm để hiển thị
$services = array_merge($services, $_SESSION['added_products']);

// Tính tổng giá trị hóa đơn
$totalPrice = 0;
foreach ($services as $item) {
    if (isset($item['GiaTien'])) {
        $totalPrice += $item['GiaTien']; // Giá dịch vụ
    } elseif (isset($item['Gia']) && isset($item['SoLuong'])) {
        $totalPrice += $item['Gia']; // Sản phẩm
    }
}



?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        function toggleProductForm() {
            const productForm = document.getElementById('product-form');
            productForm.classList.toggle('hidden'); // Ẩn hoặc hiện form
        }
    </script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-center text-2xl font-bold text-indigo-600">Hóa Đơn</h2>
        <div class="mt-4">
            <p><b>Mã đơn chăm sóc:</b> <?php echo htmlspecialchars($maDonChamSoc, ENT_QUOTES); ?></p>
            <p><b>Họ tên khách hàng:</b> <?php echo htmlspecialchars($order['HoTenKH'], ENT_QUOTES); ?></p>
            <p><b>Địa chỉ:</b> <?php echo htmlspecialchars($order['DiaChi'], ENT_QUOTES); ?></p>
            <p><b>Số điện thoại:</b> <?php echo htmlspecialchars($order['SoDienThoai'], ENT_QUOTES); ?></p>
            <p><b>Email:</b> <?php echo htmlspecialchars($order['Email'], ENT_QUOTES); ?></p>
        </div>


        <h3 class="text-lg font-bold mt-6 text-gray-700">Chi tiết dịch vụ và sản phẩm:</h3>
        <table class="table-auto w-full mt-4 bg-white border rounded shadow">
            <thead>
                <tr class="bg-indigo-500 text-white">
                    <th class="px-4 py-2">STT</th>
                    <th class="px-4 py-2">Dịch vụ/Sản phẩm</th>
                    <th class="px-4 py-2">Số lượng</th>
                    <th class="px-4 py-2">Giá</th>
                    <th class="px-4 py-2">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stt = 1;
                foreach ($services as $item) {
                    // Lấy giá trị MaDichVu hoặc MaSP nếu tồn tại
                    $dataId = $item['MaDichVu'] ?? $item['MaSP'] ?? '';
                    $dataType = isset($item['MaDichVu']) ? 'service' : (isset($item['MaSP']) ? 'product' : '');
                    $dataName = htmlspecialchars($item['TenDichVu'] ?? $item['TenSP'] ?? '', ENT_QUOTES);
                ?>
                    <tr class="border-b" data-id="<?php echo $dataId; ?>" data-type="<?php echo $dataType; ?>" data-name="<?php echo $dataName; ?>">
                        <td class="px-4 py-2 text-center"><?php echo $stt++; ?></td>
                        <td class="px-4 py-2 text-center">
                            <?php echo htmlspecialchars($item['TenDichVu'] ?? $item['TenSP'], ENT_QUOTES); ?>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <?php echo htmlspecialchars($item['SoLuong'] ?? '1', ENT_QUOTES); ?>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <?php echo number_format($item['GiaTien'] ?? $item['Gia'], 0, ',', '.'); ?> VND
                        </td>
                        <td class="px-4 py-2 text-center">
                            <?php if (isset($item['MaSP'])) { ?>
                                <form method="POST">
                                    <button type="submit" name="remove_product" value="<?php echo $item['MaSP']; ?>" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Xóa
                                    </button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>




        </table>
        <p class="text-right font-bold mt-4">Tổng cộng: <?php echo number_format($totalPrice, 0, ',', '.'); ?> VND</p>

        <div class="mt-4 text-center">
            <button onclick="toggleProductForm()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Thêm sản phẩm
            </button>
        </div>

        <div id="product-form" class="hidden mt-6">
            <form method="POST" action="">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <?php while ($product = $resultProducts->fetch_assoc()) { ?>
                        <div class="p-4 border rounded shadow-md">
                            <p><b>Sản phẩm:</b> <?php echo htmlspecialchars($product['TenSP'], ENT_QUOTES); ?></p>
                            <p><b>Giá:</b> <?php echo number_format($product['Gia'], 0, ',', '.'); ?> VND</p>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="products[<?php echo $product['MaSP']; ?>][selected]" value="1">
                                Thêm sản phẩm này
                            </label>
                            <div class="mt-2">
                                <label for="quantity-<?php echo $product['MaSP']; ?>">Số lượng:</label>
                                <input
                                    type="number"
                                    id="quantity-<?php echo $product['MaSP']; ?>"
                                    name="products[<?php echo $product['MaSP']; ?>][quantity]"
                                    value="1"
                                    min="1"
                                    class="w-20 border rounded px-2 py-1">
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mt-4">
                    Thêm vào hóa đơn
                </button>
            </form>



        </div>
        <div class="mt-6">
            <label for="payment-method" class="font-bold">Phương thức thanh toán:</label>
            <select id="payment-method" class="border rounded px-4 py-2 mt-2" onchange="togglePaymentMethod()">
                <option value="">Chọn phương thức</option>
                <option value="cash">Tiền mặt</option>
                <option value="transfer">Chuyển khoản</option>
            </select>
        </div>

        <!-- Form thanh toán tiền mặt -->
        <div id="cash-payment-form" class="hidden mt-4">
            <h3 class="font-bold text-lg">Thanh toán tiền mặt</h3>
            <div class="mt-2">
                <label for="cash-amount" class="block">Số tiền khách đưa:</label>
                <input type="number" id="cash-amount" class="border rounded px-4 py-2 w-full" oninput="calculateChange()" placeholder="Nhập số tiền khách đưa">
            </div>
            <div class="mt-2">
                <p>Số tiền thối lại: <span id="change-amount" class="font-bold text-red-600">0 VND</span></p>
                <p>Tổng tiền đã nhận: <span id="received-total" class="font-bold text-green-600">0 VND</span></p>
            </div>
        </div>

        <div id="transfer-payment-form" class="hidden mt-4">
            <h3 class="font-bold text-lg">Chuyển khoản ngân hàng</h3>
            <div class="mt-2">
                <p><b>Người nhận:</b> Trần Trọng Mạnh</p>
                <p><b>Số tài khoản:</b> 1048299242</p>
                <p><b>Chủ tài khoản:</b> Trần Trọng Mạnh</p>
                <p><b>Chuyển khoản qua:</b> Ngân hàng TMCP Quân Đội</p>

                <p><b>Số tiền:</b> <span id="transfer-amount" class="font-bold text-indigo-600">0 VND</span></p>
                <p><b>Nội dung chuyển khoản:</b> <span id="transfer-note" class="font-bold text-gray-700"></span></p>
            </div>

            <!-- Khu vực hiển thị QR Code -->
            <div class="mt-4">
                <h4 class="font-bold text-lg">QR Code:</h4>
                <img id="qr-code-image" class="border rounded p-4" alt="QR Code Chuyển khoản">
            </div>

        </div>


        <button onclick="saveAndPrintInvoice()" class="bg-green-500 text-white px-4 py-2 rounded mt-6">In hóa đơn</button>

        <script>
            function saveAndPrintInvoice() {
                const invoiceData = {
                    maDonChamSoc: "<?php echo $maDonChamSoc; ?>", // Mã đơn chăm sóc
                    totalPrice: "<?php echo $totalPrice; ?>", // Tổng tiền
                    items: []
                };

                // Lấy danh sách các sản phẩm/dịch vụ từ bảng
                document.querySelectorAll('table tbody tr').forEach((row) => {
                    const columns = row.querySelectorAll('td');
                    const itemType = row.getAttribute('data-type');
                    const itemId = row.getAttribute('data-id'); // Lấy mã dịch vụ hoặc mã sản phẩm (nếu có)

                    if (columns.length > 0) {
                        invoiceData.items.push({
                            type: itemType, // Loại: service hoặc product
                            id: itemId, // Mã dịch vụ hoặc mã sản phẩm
                            quantity: parseInt(columns[2].innerText.trim(), 10), // Số lượng
                            price: parseFloat(columns[3].innerText.trim().replace(/,/g, '').replace(' VND', '')) // Giá
                        });
                    }
                });

                // Gửi dữ liệu hóa đơn đến PHP
                fetch('php/save_invoice.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(invoiceData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Hóa đơn đã được lưu thành công!');
                            window.print(); // In hóa đơn
                            // Sử dụng setTimeout để đảm bảo in xong mới chuyển hướng
                            setTimeout(() => {
                                window.location.href = 'donchamsoc.php'; // Chuyển hướng
                            }, 500); // Đợi 0.5 giây để đảm bảo in xong
                        } else {
                            alert('Lỗi khi lưu hóa đơn: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        alert('Không thể lưu hóa đơn!');
                    });
            }


            function togglePaymentMethod() {
                const method = document.getElementById('payment-method').value;
                const cashForm = document.getElementById('cash-payment-form');
                const transferForm = document.getElementById('transfer-payment-form');
                const totalAmount = <?php echo $totalPrice; ?>; // Tổng tiền từ PHP

                // Ẩn cả hai form trước
                cashForm.classList.add('hidden');
                transferForm.classList.add('hidden');

                if (method === 'cash') {
                    cashForm.classList.remove('hidden'); // Hiển thị form tiền mặt
                } else if (method === 'transfer') {
                    transferForm.classList.remove('hidden'); // Hiển thị form chuyển khoản

                    // Hiển thị dữ liệu chuyển khoản
                    document.getElementById('transfer-amount').textContent = totalAmount.toLocaleString() + ' VND';
                    document.getElementById('transfer-note').textContent =
                        'Hoa don ' + "<?php echo $maDonChamSoc; ?>" + ' ' + totalAmount.toLocaleString() + ' VND';

                    // Tạo QR Code
                    generateBankQRCode();
                }
            }

            function generateBankQRCode() {
                const accountNumber = "1048299242"; // Số tài khoản
                const bankCode = "VCB"; // Mã ngân hàng Vietcombank
                const accountName = "TRAN TRONG MANH"; // Chủ tài khoản
                const totalAmount = <?php echo $totalPrice; ?>; // Tổng tiền cần chuyển từ PHP
                const transferNote = "Hoa don <?php echo $maDonChamSoc; ?>"; // Nội dung chuyển khoản

                // Tạo nội dung QR Code theo chuẩn Napas
                const qrContent = `
        000201
        010211
        0210${accountNumber}
        0303${bankCode}
        52040000
        5303VND
        54${totalAmount.toString().length}${totalAmount}
        5802VN
        59${accountName.length}${accountName}
        60${transferNote.length}${transferNote}
        6304
    `.replace(/\s+/g, ''); // Xóa khoảng trắng trong chuỗi

                // Tạo QR Code dưới dạng Base64 image
                QRCode.toDataURL(qrContent, {
                    width: 200
                }, function(error, url) {
                    if (error) {
                        console.error("QR Code Error:", error);
                        return;
                    }
                    // Hiển thị QR Code trong thẻ <img>
                    const qrCodeImage = document.getElementById('qr-code-image');
                    qrCodeImage.src = url; // Gán Base64 image vào thẻ <img>
                });
            }



            // Hàm tính tiền thối lại khi thanh toán tiền mặt
            function calculateChange() {
                const totalAmount = <?php echo $totalPrice; ?>; // Tổng tiền từ PHP
                const cashGiven = parseFloat(document.getElementById('cash-amount').value) || 0; // Số tiền khách đưa

                // Tính toán hiển thị
                const change = Math.max(cashGiven - totalAmount, 0); // Tiền thối (không âm)
                const receivedTotal = Math.min(cashGiven, totalAmount); // Tổng tiền đã nhận (không vượt tổng tiền cần thanh toán)

                // Hiển thị kết quả trong giao diện
                document.getElementById('change-amount').textContent = change.toLocaleString() + ' VND';
                document.getElementById('received-total').textContent = receivedTotal.toLocaleString() + ' VND';
            }
        </script>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
</body>

</html>