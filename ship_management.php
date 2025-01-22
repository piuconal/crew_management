<?php
// Kết nối cơ sở dữ liệu
include('config.php');

// Lấy dữ liệu từ bảng tau
$sql = "SELECT * FROM tau";
$result = mysqli_query($conn, $sql);

// Kiểm tra có dữ liệu không
if (mysqli_num_rows($result) > 0) {
    $ships = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $ships = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/ship_management.css">
</head>

<body>
  <div>
    <div class="row mb-3">
        <div class="col-md-4">
            <!-- Tìm kiếm -->
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Tìm kiếm theo tên tàu, chủ sở hữu">
        </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Mã tàu</th>
            <th>Tên tàu</th>
            <th>Tên doanh nghiệp</th>
            <th>Khu vực</th>
            <th>BRN</th>
            <th>Chủ sở hữu</th>
            <th>Số điện thoại chủ</th>
            <th>Địa điểm kinh doanh</th>
            <th>Loại hình kinh doanh</th>
            <th>Trọng tải</th>
            <th>Công đoàn</th>
            <th>Số người tối đa</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($ships)) : ?>
            <?php foreach ($ships as $ship) : ?>
              <tr>
                <td><?php echo htmlspecialchars($ship['Ship_Number']); ?></td>
                <td><?php echo htmlspecialchars($ship['Ship_Name']); ?></td>
                <td><?php echo htmlspecialchars($ship['Business_Name']); ?></td>
                <td><?php echo htmlspecialchars($ship['Region']); ?></td>
                <td><?php echo htmlspecialchars($ship['BRN']); ?></td>
                <td><?php echo htmlspecialchars($ship['Owner_Name']); ?></td>
                <td><?php echo htmlspecialchars($ship['Owner_Phone_Number']); ?></td>
                <td><?php echo htmlspecialchars($ship['Business_Location']); ?></td>
                <td><?php echo htmlspecialchars($ship['Business_Type']); ?></td>
                <td><?php echo htmlspecialchars($ship['Tonnage']); ?></td>
                <td><?php echo htmlspecialchars($ship['Union_affiliation']); ?></td>
                <td><?php echo htmlspecialchars($ship['Max_People']); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="12" class="text-center">Không có tàu nào.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/ship_management.js"></script>
</body>

</html>
