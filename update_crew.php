<?php
include('config.php');

$id = $_POST['id'];
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

$sql = "UPDATE crew_members_additional 
        SET ship_code = '$ship_code',
            last_change_date = '$last_change_date',
            name = '$name',
            passport_number = '$passport_number',
            employment_status = '$employment_status',
            entry_date = '$entry_date',
            foreign_number = '$foreign_number',
            vietnam_address = '$vietnam_address',
            vietnam_phone = '$vietnam_phone',
            education = '$education',
            height = '$height',
            weight = '$weight',
            marital_status = '$marital_status',
            family_size = '$family_size',
            transfer_count = '$transfer_count',
            reentry_status = '$reentry_status',
            birth_date = '$birth_date',
            crew_id = '$crew_id',
            foreign_registration_number = '$foreign_registration_number',
            age = '$age'
        WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo "Cập nhật thành công!";
} else {
    echo "Lỗi: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
