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
    $timestamp = date("Y-m-d H:i:s");

    // Lấy dữ liệu cũ từ database
    $oldDataSql = "SELECT name, manager_name, phone_number FROM area WHERE id = ?";
    $stmt = $conn->prepare($oldDataSql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $oldData = $result->fetch_assoc();
    $stmt->close();

    if (!$oldData) {
        echo "error: data not found";
        exit;
    }

    // Cập nhật vào CSDL
    $updateSql = "UPDATE area SET name = ?, manager_name = ?, phone_number = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("sssi", $name, $manager, $phone, $id);

    if ($stmt->execute()) {
        updateJSON($oldData, $name, $manager, $phone, $timestamp);
        echo "success";
    } else {
        echo "error: database update failed";
    }

    $stmt->close();
    $conn->close();
}

// Hàm cập nhật file JSON
function updateJSON($oldData, $name, $manager, $phone, $timestamp) {
    $jsonFile = "json/area/edit_area.json";

    // Đọc dữ liệu từ file JSON
    if (file_exists($jsonFile)) {
        $data = json_decode(file_get_contents($jsonFile), true);
    } else {
        $data = [];
    }

    // Tạo bản ghi mới với sự khác biệt được đánh dấu
    $newRecord = [
        "name" => formatChange($oldData['name'], $name),
        "manager_name" => formatChange($oldData['manager_name'], $manager),
        "phone_number" => formatChange($oldData['phone_number'], $phone),
        "timestamp" => $timestamp
    ];

    // Thêm vào mảng
    $data[] = $newRecord;

    // Ghi dữ liệu đã cập nhật trở lại file JSON
    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Hàm đánh dấu sự thay đổi
function formatChange($oldValue, $newValue) {
    return ($oldValue !== $newValue) ? "<span class='text-danger'>$newValue</span>" : $newValue;
}
?>
