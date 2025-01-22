<?php
// Kết nối cơ sở dữ liệu
include('config.php');

// Lấy tổng số thuyền viên
$sql_crew = "SELECT COUNT(*) as total_crew FROM thuyenvien";
$result_crew = mysqli_query($conn, $sql_crew);
$crew_data = mysqli_fetch_assoc($result_crew);
$total_crew = $crew_data['total_crew'];

// Lấy tổng số tàu
$sql_ships = "SELECT COUNT(*) as total_ships FROM tau";
$result_ships = mysqli_query($conn, $sql_ships);
$ships_data = mysqli_fetch_assoc($result_ships);
$total_ships = $ships_data['total_ships'];

// Lấy tổng số khu vực
$sql_regions = "SELECT COUNT(*) as total_regions FROM khuvuc";
$result_regions = mysqli_query($conn, $sql_regions);
$regions_data = mysqli_fetch_assoc($result_regions);
$total_regions = $regions_data['total_regions'];

// Đóng kết nối
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/overview.css">
</head>

<body>

  <div>
    <div class="row mt-0">
      <!-- Dashboard Card for Total Crew -->
      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card dashboard-card">
          <div class="card-header">
            <i class="fas fa-users card-icon"></i> Tổng Thuyền Viên
          </div>
          <div class="card-body text-center">
            <div class="count"><?php echo $total_crew; ?></div>
            <p>Thuyền viên hiện có</p>
          </div>
        </div>
      </div>

      <!-- Dashboard Card for Total Ships -->
      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card dashboard-card">
          <div class="card-header">
            <i class="fas fa-ship card-icon"></i> Tổng Tàu
          </div>
          <div class="card-body text-center">
            <div class="count"><?php echo $total_ships; ?></div>
            <p>Tàu trong hệ thống</p>
          </div>
        </div>
      </div>

      <!-- Dashboard Card for Total Regions -->
      <div class="col-xl-4 col-md-6 mb-4">
        <div class="card dashboard-card">
          <div class="card-header">
            <i class="fas fa-map-marker-alt card-icon"></i> Tổng Khu Vực
          </div>
          <div class="card-body text-center">
            <div class="count"><?php echo $total_regions; ?></div>
            <p>Khu vực hoạt động</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5">
      <p>&copy; 2025 Ship Management System. All Rights Reserved.</p>
    </footer>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
