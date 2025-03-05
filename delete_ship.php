<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    $stmt = $conn->prepare("DELETE FROM ships WHERE id=?");
    $stmt->bind_param("i", $id);

    echo json_encode(["success" => $stmt->execute()]);
}
?>
