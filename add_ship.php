<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $company_name = $_POST['company_name'] ?? '';
    $owner_name = $_POST['owner_name'] ?? '';
    $ship_type = $_POST['ship_type'] ?? '';
    $ship_code = $_POST['ship_code'] ?? '';
    $area_id = $_POST['area_id'] ?? '';

    if (empty($name) || empty($area_id)) {
        echo json_encode(["success" => false, "message" => "Tên tàu và khu vực là bắt buộc."]);
        exit;
    }

    $sql = "INSERT INTO ships (name, company_name, owner_name, ship_type, ship_code, area_id) 
            VALUES ('$name', '$company_name', '$owner_name', '$ship_type', '$ship_code', '$area_id')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Lỗi khi thêm tàu."]);
    }
    exit;
}
?>
