<?php
require "config.php"; // Kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ship_code = $_POST['ship_code'];
    $last_change_date = $_POST['last_change_date'];
    $name = $_POST['name'];
    $passport_number = $_POST['passport_number'];
    $employment_status = $_POST['employment_status'];
    $entry_date = $_POST['entry_date'];
    $foreign_number = $_POST['foreign_number'];
    $vietnam_address = $_POST['vietnam_address'];
    $vietnam_phone = $_POST['vietnam_phone'];
    $education = $_POST['education'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $marital_status = $_POST['marital_status'];
    $family_size = $_POST['family_size'];
    $transfer_count = $_POST['transfer_count'];
    $reentry_status = $_POST['reentry_status'];
    $birth_date = $_POST['birth_date'];
    $crew_id = $_POST['crew_id'];
    $foreign_registration_number = $_POST['foreign_registration_number'];
    $age = $_POST['age'];

    $sql = "INSERT INTO crew_members_additional 
        (ship_code, last_change_date, name, passport_number, employment_status, entry_date, foreign_number, vietnam_address, vietnam_phone, education, height, weight, marital_status, family_size, transfer_count, reentry_status, birth_date, crew_id, foreign_registration_number, age) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ssssssssssddsisiissi", 
            $ship_code, $last_change_date, $name, $passport_number, $employment_status,
            $entry_date, $foreign_number, $vietnam_address, $vietnam_phone, $education,
            $height, $weight, $marital_status, $family_size, $transfer_count,
            $reentry_status, $birth_date, $crew_id, $foreign_registration_number, $age
        );

        if ($stmt->execute()) {
            header("Location: http://127.0.0.1/crew_management/admin.php?page=crew_management");
            exit();
        } else {
            echo "Lỗi: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Lỗi chuẩn bị SQL: " . $conn->error;
    }

    $conn->close();
}
?>
