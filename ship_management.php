<?php
// Kết nối cơ sở dữ liệu
include('config.php');

// Lấy dữ liệu từ bảng ships và area
$sql = "SELECT ships.*, area.name AS area_name FROM ships 
        LEFT JOIN area ON ships.area_id = area.id";
$result = mysqli_query($conn, $sql);

$sql_area = "SELECT * FROM area";
$result_area = mysqli_query($conn, $sql_area);
$areas = mysqli_fetch_all($result_area, MYSQLI_ASSOC);

// Kiểm tra có dữ liệu không
$ships = mysqli_num_rows($result) > 0 ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="vi">

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
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Tìm kiếm theo tên tàu, chủ sở hữu">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addShipModal">Thêm tàu</button>
        </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <!-- <th>ID</th> -->
            <th>Tên tàu</th>
            <th>Tên công ty</th>
            <th>Chủ sở hữu</th>
            <th>Loại nghề</th>
            <th>Mã số tàu</th>
            <th>Khu vực</th>
            <!-- <th>Trạng thái nổi bật</th> -->
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($ships)) : ?>
            <?php foreach ($ships as $ship) : ?>
              <tr class="ship-row" 
                data-id="<?php echo $ship['id']; ?>" 
                data-name="<?php echo htmlspecialchars($ship['name']); ?>" 
                data-company="<?php echo htmlspecialchars($ship['company_name']); ?>"
                data-owner="<?php echo htmlspecialchars($ship['owner_name']); ?>"
                data-type="<?php echo htmlspecialchars($ship['ship_type']); ?>"
                data-code="<?php echo htmlspecialchars($ship['ship_code']); ?>"
                data-area="<?php echo $ship['area_id']; ?>">
                <!-- <td><?php echo htmlspecialchars($ship['id']); ?></td> -->
                <td><?php echo htmlspecialchars($ship['name']); ?></td>
                <td><?php echo htmlspecialchars($ship['company_name']); ?></td>
                <td><?php echo htmlspecialchars($ship['owner_name']); ?></td>
                <td><?php echo htmlspecialchars($ship['ship_type']); ?></td>
                <td><?php echo htmlspecialchars($ship['ship_code']); ?></td>
                <td><?php echo htmlspecialchars($ship['area_name']); ?></td>
                <!-- <td><?php echo $ship['outstanding_status'] ? 'Có' : 'Không'; ?></td> -->
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="8" class="text-center">Không có tàu nào.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="addShipModal" tabindex="-1" aria-labelledby="addShipModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm tàu mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form id="addShipForm">
                  <div class="form-group">
                      <label for="shipName">Tên tàu</label>
                      <input type="text" class="form-control" id="shipName" name="name" required>
                  </div>
                  <div class="form-group">
                      <label for="companyName">Tên công ty</label>
                      <input type="text" class="form-control" id="companyName" name="company_name">
                  </div>
                  <div class="form-group">
                      <label for="ownerName">Chủ sở hữu</label>
                      <input type="text" class="form-control" id="ownerName" name="owner_name">
                  </div>
                  <div class="form-group">
                      <label for="shipType">Loại nghề</label>
                      <input type="text" class="form-control" id="shipType" name="ship_type">
                  </div>
                  <div class="form-group">
                      <label for="shipCode">Mã số tàu</label>
                      <input type="text" class="form-control" id="shipCode" name="ship_code">
                  </div>
                  <div class="form-group">
                      <label>Khu vực</label>
                      <select name="area_id" class="form-control" required>
                          <option value="">Chọn khu vực</option>
                          <?php foreach ($areas as $area) : ?>
                              <option value="<?php echo $area['id']; ?>">
                                  <?php echo htmlspecialchars($area['name']); ?>
                              </option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <button type="submit" class="btn btn-success">Thêm</button>
              </form>
            </div>
        </div>
    </div>
  </div>

  <div id="shipModal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Chi tiết tàu</h5>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <form id="editShipForm">
                      <input type="hidden" id="editShipId" name="id">
                      <div class="form-group">
                          <label>Tên tàu</label>
                          <input type="text" class="form-control" id="editShipName" name="name">
                      </div>
                      <div class="form-group">
                          <label>Tên công ty</label>
                          <input type="text" class="form-control" id="editCompanyName" name="company_name">
                      </div>
                      <div class="form-group">
                          <label>Chủ sở hữu</label>
                          <input type="text" class="form-control" id="editOwnerName" name="owner_name">
                      </div>
                      <div class="form-group">
                          <label>Loại nghề</label>
                          <input type="text" class="form-control" id="editShipType" name="ship_type">
                      </div>
                      <div class="form-group">
                          <label>Mã số tàu</label>
                          <input type="text" class="form-control" id="editShipCode" name="ship_code">
                      </div>
                      <div class="form-group">
                          <label>Khu vực</label>
                          <select id="editAreaId" name="area_id" class="form-control">
                              <?php foreach ($areas as $area) : ?>
                                  <option value="<?php echo $area['id']; ?>">
                                      <?php echo htmlspecialchars($area['name']); ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>
                      </div>
                  </form>
              </div>
              <div class="modal-footer">
                  <button id="btnDeleteShip" class="btn btn-danger">Xóa</button>
                  <button type="submit" class="btn btn-success" form="editShipForm">Cập nhật</button>
              </div>
          </div>
      </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/ship_management.js"></script>
</body>

</html>