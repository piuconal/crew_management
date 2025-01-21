<?php
// Lấy thông tin thuyền viên từ cơ sở dữ liệu
include('config.php');
$crewId = $_GET['crewId']; // Lấy ID của thuyền viên từ URL
$sql = "SELECT * FROM thuyenvien WHERE Seaman_ID_Number = '$crewId'"; // Sửa tên cột ở đây
$result = mysqli_query($conn, $sql);

// Kiểm tra nếu kết quả truy vấn hợp lệ
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

$crew = mysqli_fetch_assoc($result);

// Nếu không tìm thấy thuyền viên, hiển thị thông báo lỗi
if (!$crew) {
    die("Không tìm thấy thông tin thuyền viên.");
}

// Nội dung file Word
$content = "
<html xmlns:w='urn:schemas-microsoft-com:office:word'>
<head>
    <meta charset='UTF-8'>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.15;
            margin: 2cm;
        }
        h1, h2, p {
            text-align: center;
            font-size: 13pt;
        }
        .content {
            text-align: justify;
        }
    </style>
</head>
<body>
    <h1>Cộng hòa Xã hội Chủ nghĩa Việt Nam</h1>
    <h2>Độc lập - Tự do - Hạnh phúc</h2>
    <hr>
    <h1>Hủy Hợp Đồng Thuyền Viên</h1>
    <p>---***---</p>
    <div class='content'>
        <p><strong>Họ tên:</strong> " . htmlspecialchars($crew['Name']) . "</p>
        <p><strong>Số hộ chiếu:</strong> " . htmlspecialchars($crew['Passport_Number']) . "</p>
        <p><strong>Mã thuyền viên:</strong> " . htmlspecialchars($crew['Seaman_ID_Number']) . "</p>
        <p><strong>Ngày sinh:</strong> " . date('d/m/Y', strtotime($crew['DOB'])) . "</p>
        <p><strong>Tuổi:</strong> " . htmlspecialchars($crew['Age']) . "</p>
        <p><strong>Địa chỉ:</strong> " . htmlspecialchars($crew['VN_Address']) . "</p>
        <p><strong>Thành phố:</strong> " . htmlspecialchars($crew['VN_City']) . "</p>
        <p><strong>Số điện thoại:</strong> " . htmlspecialchars($crew['VN_Phone']) . "</p>
        <p><strong>Khu vực:</strong> " . htmlspecialchars($crew['Region']) . "</p>
        <p><strong>Số tàu:</strong> " . htmlspecialchars($crew['Ship_Number']) . "</p>
        <p><strong>Chiều cao:</strong> " . htmlspecialchars($crew['Height']) . "</p>
        <p><strong>Cân nặng:</strong> " . htmlspecialchars($crew['Weight']) . "</p>
        <p><strong>Tình trạng hôn nhân:</strong> " . htmlspecialchars($crew['Marital_Status']) . "</p>
        <p><strong>Số thành viên gia đình:</strong> " . htmlspecialchars($crew['Family_Member']) . "</p>
        <p><strong>Ngày sửa đổi cuối:</strong> " . date('d/m/Y', strtotime($crew['Last_Modified_Date'])) . "</p>
        <p><strong>Số lần chuyển công tác:</strong> " . htmlspecialchars($crew['Num_of_Transfer']) . "</p>
        <p><strong>Hồ sơ:</strong> " . htmlspecialchars($crew['Record']) . "</p>
        <p><strong>Trạng thái công việc:</strong> " . htmlspecialchars($crew['Word_Status']) . "</p>
        <p><strong>Đăng ký lại:</strong> " . htmlspecialchars($crew['GF_Reentry']) . "</p>
        <p><strong>Ngày hết hạn:</strong> " . date('d/m/Y', strtotime($crew['DOE'])) . "</p>
        <p><strong>Trình độ:</strong> " . htmlspecialchars($crew['Graduation']) . "</p>
    </div>
    <p style='text-align: right;'>Ngày ...... tháng ...... năm ......</p>
    <p style='text-align: right;'>Người lập báo cáo</p>
</body>
</html>
";

// Tên file Word
$filename = "HuyHopDong_" . $crew['Seaman_ID_Number'] . ".doc";

// Cấu hình header để tải về
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
header("Content-Length: " . strlen($content));

// Xuất nội dung
echo $content;
exit();
?>
