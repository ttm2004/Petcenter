<?php
include('../../php/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maThuCung = $_POST['MaThuCung'] ?? '';
    $stmt = $conn->prepare("SELECT * FROM thucung WHERE MaThuCung = ?");
    $stmt->bind_param("s", $maThuCung);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([]);
    }
}
?>
