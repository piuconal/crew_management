<?php
// Kết nối cơ sở dữ liệu
include('config.php');

// Lấy dữ liệu từ bảng khuvuc
$sql = "SELECT * FROM khuvuc";
$result = mysqli_query($conn, $sql);

// Kiểm tra có dữ liệu không
if (mysqli_num_rows($result) > 0) {
    $regions = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $regions = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/region_management.css">
</head>

<body>
  <div>
    <div class="row mb-3">
        <div class="col-md-4">
            <!-- Tìm kiếm -->
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Tìm kiếm theo tên khu vực, người phụ trách">
        </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Khu vực</th>
            <th>Người phụ trách</th>
            <th>Số điện thoại</th>
            <th>Mail</th>
            <th>Fax</th>
            <th>Địa điểm</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($regions)) : ?>
            <?php foreach ($regions as $region) : ?>
              <tr>
                <td><?php echo htmlspecialchars($region['Region']); ?></td>
                <td><?php echo htmlspecialchars($region['Responsible_Person']); ?></td>
                <td><?php echo htmlspecialchars($region['Phone_Number']); ?></td>
                <td><?php echo htmlspecialchars($region['Mail']); ?></td>
                <td><?php echo htmlspecialchars($region['Fax']); ?></td>
                <td><?php echo htmlspecialchars($region['Location']); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="6" class="text-center">Không có khu vực nào.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/region_management.js"></script>
</body>

</html>
