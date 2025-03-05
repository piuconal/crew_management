<?php
// Kết nối cơ sở dữ liệu
include('config.php');

// Lấy dữ liệu từ bảng area
$sql = "SELECT * FROM area";
$result = mysqli_query($conn, $sql);

// Kiểm tra có dữ liệu không
if (mysqli_num_rows($result) > 0) {
    $areas = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $areas = [];
}

// Đóng kết nối
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Region Management - Crew Management</title>
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
      <div class="col-md-2">
        <button id="addAreaBtn" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addAreaModal">
          Thêm Khu Vực
        </button>
      </div>
    </div>


    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Khu vực</th>
            <th>Người phụ trách</th>
            <th>Số điện thoại</th>
            <!-- <th>Trạng thái</th> -->
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($areas)) : ?>
            <?php foreach ($areas as $area) : ?>
              <tr data-id="<?php echo $area['id']; ?>">
                <td><?php echo htmlspecialchars($area['name']); ?></td>
                <td><?php echo htmlspecialchars($area['manager_name'] ?? 'Chưa có'); ?></td>
                <td><?php echo htmlspecialchars($area['phone_number'] ?? 'Chưa có'); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="3" class="text-center">Không có khu vực nào.</td>
            </tr>
          <?php endif; ?>
        </tbody>

      </table>
    </div>
  </div>

  <!-- Modal Chỉnh Sửa Khu Vực -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Chỉnh Sửa Khu Vực</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editForm">
            <input type="hidden" id="editId">
            <div class="form-group">
              <label for="editName">Tên Khu Vực</label>
              <input type="text" class="form-control" id="editName" required>
            </div>
            <div class="form-group">
              <label for="editManager">Người Phụ Trách</label>
              <input type="text" class="form-control" id="editManager" required>
            </div>
            <div class="form-group">
              <label for="editPhone">Số Điện Thoại</label>
              <input type="text" class="form-control" id="editPhone" required>
            </div>
            <button type="submit" class="btn btn-success">Cập Nhật</button>
            <button type="button" class="btn btn-danger" id="deleteAreaBtn">Xóa</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Thêm Khu Vực -->
  <div class="modal fade" id="addAreaModal" tabindex="-1" aria-labelledby="addAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addAreaModalLabel">Thêm Khu Vực Mới</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addAreaForm">
            <div class="form-group">
              <label for="areaName">Tên Khu Vực</label>
              <input type="text" class="form-control" id="areaName" required>
            </div>
            <div class="form-group">
              <label for="managerName">Người Phụ Trách</label>
              <input type="text" class="form-control" id="managerName" required>
            </div>
            <div class="form-group">
              <label for="phoneNumber">Số Điện Thoại</label>
              <input type="text" class="form-control" id="phoneNumber" required>
            </div>
            <button type="submit" class="btn btn-success">Thêm</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/region_management.js"></script>
</body>

</html>