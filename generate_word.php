<?php
// Lấy thông tin thuyền viên từ cơ sở dữ liệu
include('config.php');
$crewId = $_GET['crewId']; // Lấy ID của thuyền viên từ URL
$sql = "SELECT * FROM thuyenvien WHERE ma_thuyenvien = '$crewId'";
$result = mysqli_query($conn, $sql);
$crew = mysqli_fetch_assoc($result);

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
            font-size: 13;
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
        <p><strong>Họ tên:</strong> " . $crew['ho_ten'] . "</p>
        <p><strong>Mã thuyền viên:</strong> " . $crew['ma_thuyenvien'] . "</p>
        <p><strong>Ngày sinh:</strong> " . $crew['ngay_sinh'] . "</p>
        <p><strong>Chức vụ:</strong> " . $crew['chuc_vu'] . "</p>
        <p><strong>Email:</strong> " . $crew['email'] . "</p>
        <p><strong>Số điện thoại:</strong> " . $crew['so_dien_thoai'] . "</p>
        <p><strong>Địa chỉ:</strong> " . $crew['dia_chi'] . "</p>
        <p><strong>Lý do hủy hợp đồng:</strong> ..............................................................</p>
    </div>
    <p style='text-align: right;'>Ngày ...... tháng ...... năm ......</p>
    <p style='text-align: right;'>Người lập báo cáo</p>
</body>
</html>
";

// Tên file Word
$filename = "HuyHopDong_" . $crew['ma_thuyenvien'] . ".doc";

// Cấu hình header để tải về
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=" . $filename);
header("Content-Length: " . strlen($content));

// Xuất nội dung
echo $content;
exit();
?>
