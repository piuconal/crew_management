<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $company_name = $_POST['company_name'] ?? '';
    $owner_name = $_POST['owner_name'] ?? '';
    $ship_type = $_POST['ship_type'] ?? '';
    $ship_code = $_POST['ship_code'] ?? '';
    $area_id = $_POST['area_id'] ?? '';
    $company_id = $_POST['company_id'] ?? '';  // Trường mới
    $company_address = $_POST['company_address'] ?? '';  // Trường mới

    if (empty($name) || empty($area_id)) {
        echo json_encode(["success" => false, "message" => "Tên tàu và khu vực là bắt buộc."]);
        exit;
    }

    $sql = "INSERT INTO ships (name, company_name, owner_name, ship_type, ship_code, area_id,company_id,company_address) 
            VALUES ('$name', '$company_name', '$owner_name', '$ship_type', '$ship_code', '$area_id','$company_id','$company_address')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Lỗi khi thêm tàu."]);
    }
    exit;
}
?>
