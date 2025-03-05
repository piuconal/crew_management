<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        echo "error: missing id";
        exit;
    }

    $id = $_POST['id'];
    $name = $_POST['name'];
    $manager = $_POST['manager'];
    $phone = $_POST['phone'];

    $sql = "UPDATE area SET name = ?, manager_name = ?, phone_number = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $manager, $phone, $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: database update failed";
    }

    $stmt->close();
    $conn->close();
}
?>
