<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Truy vấn để lấy thông tin khu vực trước khi xóa
    $sql_select = "SELECT name, manager_name, phone_number FROM area WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $area = $result->fetch_assoc();
    $stmt_select->close();

    if ($area) {
        // Thực hiện xóa khu vực
        $sql_delete = "DELETE FROM area WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            // Lấy dữ liệu cũ từ file JSON (nếu có)
            $file_path = 'json/area/delete_area.json';
            $data = [];

            if (file_exists($file_path)) {
                $json = file_get_contents($file_path);
                $data = json_decode($json, true) ?? [];
            }

            // Thêm dữ liệu khu vực bị xóa vào danh sách
            $deleted_entry = [
                "id" => $id,
                "name" => $area["name"],
                "manager_name" => $area["manager_name"] ?? "Chưa có",
                "phone_number" => $area["phone_number"] ?? "Chưa có",
                "timestamp" => date("Y-m-d H:i:s")
            ];
            $data[] = $deleted_entry;

            // Ghi lại vào file JSON
            file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));

            echo "success";
        } else {
            echo "error";
        }

        $stmt_delete->close();
    } else {
        echo "not_found"; // Trường hợp không tìm thấy ID
    }

    $conn->close();
}
?>
