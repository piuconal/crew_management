<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $manager = $_POST['manager'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO area (name, manager_name, phone_number) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $manager, $phone);

    if ($stmt->execute()) {
        // Lấy dữ liệu cũ từ file JSON (nếu có)
        $file_path = 'json/area/add_area.json';
        $data = [];

        if (file_exists($file_path)) {
            $json = file_get_contents($file_path);
            $data = json_decode($json, true) ?? [];
        }

        // Thêm dữ liệu mới vào danh sách
        $new_entry = [
            "name" => $name,
            "manager_name" => $manager,
            "phone_number" => $phone,
            "timestamp" => date("Y-m-d H:i:s")
        ];
        $data[] = $new_entry;

        // Ghi lại vào file JSON
        file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));

        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
