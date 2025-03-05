<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $company_name = $_POST['company_name'] ?? '';
    $owner_name = $_POST['owner_name'] ?? '';
    $ship_type = $_POST['ship_type'] ?? '';
    $ship_code = $_POST['ship_code'] ?? '';
    $area_id = $_POST['area_id'] ?? '';

    $stmt = $conn->prepare("UPDATE ships SET name=?, company_name=?, owner_name=?, ship_type=?, ship_code=?, area_id=? WHERE id=?");
    $stmt->bind_param("ssssssi", $name, $company_name, $owner_name, $ship_type, $ship_code, $area_id, $id);

    echo json_encode(["success" => $stmt->execute()]);
}
?>
