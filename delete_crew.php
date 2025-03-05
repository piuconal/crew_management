<?php
include('config.php');

$id = $_POST['id'];

$sql = "DELETE FROM crew_members_additional WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo "Xóa thành công!";
} else {
    echo "Lỗi: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
