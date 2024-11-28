<?php
include '../php/connect.php';

$query = $_GET['query'] ?? '';
if ($query) {
    $sql = "SELECT MaSP, TenSP, Gia FROM SanPham WHERE TenSP LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        echo '<div onclick="addProductToInvoice(' . $row['MaSP'] . ', \'' . htmlspecialchars($row['TenSP']) . '\', ' . $row['Gia'] . ')" class="product-item">';
        echo '<strong>' . htmlspecialchars($row['TenSP']) . '</strong> - ' . number_format($row['Gia'], 0, ',', '.') . ' VND';
        echo '</div>';
    }
    $stmt->close();
}
$conn->close();
?>
