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
    $company_id = $_POST['company_id']; // Mới thêm
    $company_address = $_POST['company_address']; // Mới thêm

    // Cập nhật câu lệnh SQL để bao gồm company_id và company_address
    $stmt = $conn->prepare("UPDATE ships SET name=?, company_name=?, owner_name=?, ship_type=?, ship_code=?, area_id=?, company_id=?, company_address=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $name, $company_name, $owner_name, $ship_type, $ship_code, $area_id, $company_id, $company_address, $id);

    echo json_encode(["success" => $stmt->execute()]);
}
?>
