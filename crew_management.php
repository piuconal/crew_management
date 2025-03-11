<?php
include('config.php');

// Sửa truy vấn để dùng bảng crew_members_additional
$sql = "SELECT cma.*, s.name AS ship_name 
        FROM crew_members_additional cma 
        LEFT JOIN ships s ON cma.ship_code = s.ship_code
        WHERE cma.updated_at = (
            SELECT MAX(updated_at) 
            FROM crew_members_additional sub 
            WHERE sub.passport_number = cma.passport_number
        )";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $crews = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $crews = [];
}
// Lấy danh sách khu vực
$area_query = "SELECT id, name FROM area";
$area_result = $conn->query($area_query);
$areas = [];
while ($row = $area_result->fetch_assoc()) {
    $areas[$row['id']] = $row['name'];
}

// Lấy danh sách tàu
$ship_query = "SELECT ship_code, area_id, name FROM ships";
$ship_result = $conn->query($ship_query);
$ships = $ship_result->fetch_all(MYSQLI_ASSOC);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crew Management - Crew Management System</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/crew_management.css">
</head>

<body>
  <div class="row mb-3">
    <div class="col-md-4">
      <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm theo tên, số hộ chiếu">
    </div>
    <div class="col-md-2">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCrewModal">
        Thêm thuyền viên
      </button>
    </div>
  </div>

  <!-- Bảng hiển thị thông tin thuyền viên -->
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Số hộ chiếu</th>
                <th>Mã người nước ngoài</th>
                <th>Ngày sinh</th>
                <th>Tuổi</th>
                <th>Địa chỉ VN</th>
                <th>Số điện thoại VN</th>
                <th>Tên tàu</th>
                <th>Chiều cao</th>
                <th>Cân nặng</th>
                <th>Tình trạng hôn nhân</th>
                <th>Số thành viên gia đình</th>
                <th>Ngày sửa đổi cuối</th>
                <th>Số lần chuyển tàu</th>
                <th>Trạng thái công việc</th>
                <th>Ngày nhập cảnh</th>
                <th>Trình độ</th>
                <th>Tái nhập cảnh</th> <!-- Thêm cột mới -->
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($crews)) : ?>
                <?php foreach ($crews as $crew) : ?>
                    <tr data-toggle="modal" data-target="#crewModal" onclick="fillCrewModal(<?php echo htmlspecialchars(json_encode($crew)); ?>)">
                        <td><?php echo htmlspecialchars($crew['name']); ?></td>
                        <td><?php echo htmlspecialchars($crew['passport_number']); ?></td>
                        <td><?php echo htmlspecialchars($crew['foreign_number'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($crew['birth_date'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($crew['age'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($crew['vietnam_address'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($crew['vietnam_phone'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($crew['ship_name'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($crew['height'] ?? 'Chưa có'); ?> cm</td>
                        <td><?php echo htmlspecialchars($crew['weight'] ?? 'Chưa có'); ?> kg</td>
                        <td><?php echo htmlspecialchars($crew['marital_status'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($crew['family_size'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($crew['updated_at']); ?></td>
                        <td><?php echo htmlspecialchars($crew['transfer_count'] ?? '0'); ?></td>
                        <td><?php echo htmlspecialchars($crew['employment_status'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($crew['entry_date'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($crew['education'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($crew['reentry_status'] ?? 'Không'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="18" class="text-center">Không có thuyền viên nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
  </div>

  <!-- Modal Chi Tiết Thuyền Viên -->
  <div class="modal fade" id="crewModal" tabindex="-1">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Chi tiết thuyền viên</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                  <form id="updateCrewForm">
                      <input type="hidden" id="crew_id" name="id">
                      
                      <div class="row">
                          <div class="col-md-4">
                              <label>Tên tàu - Khu vực:</label>
                              <select id="ship_code" name="ship_code" class="form-control">
                                    <?php foreach ($ships as $ship) : ?>
                                        <option value="<?= $ship['ship_code'] ?>">
                                            <?= $ship['name'] ?> - <?= $areas[$ship['area_id']] ?? 'Không xác định' ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                              
                              <label>Ngày thay đổi cuối:</label>
                              <input type="date" id="last_change_date" name="last_change_date" class="form-control">
                              
                              <label>Tên thuyền viên:</label>
                              <input type="text" id="name" name="name" class="form-control">
                              
                              <label>Số hộ chiếu:</label>
                              <input type="text" id="passport_number" name="passport_number" class="form-control" readonly>
                              
                            <label>Trạng thái làm việc:</label>
                            <select id="employment_status" name="employment_status" class="form-control">
                                <option value="근무" <?= $crew['employment_status'] == '근무' ? 'selected' : '' ?>>근무</option>
                                <option value="하선(고용중단)" <?= $crew['employment_status'] == '하선(고용중단)' ? 'selected' : '' ?>>하선(고용중단)</option>
                                <option value="근무지이탈" <?= $crew['employment_status'] == '근무지이탈' ? 'selected' : '' ?>>근무지이탈</option>
                                <option value="강제출국(이탈)" <?= $crew['employment_status'] == '강제출국(이탈)' ? 'selected' : '' ?>>강제출국(이탈)</option>
                                <option value="자진출국" <?= $crew['employment_status'] == '자진출국' ? 'selected' : '' ?>>자진출국</option>
                                <option value="사망" <?= $crew['employment_status'] == '사망' ? 'selected' : '' ?>>사망</option>
                            </select>
              
                              <label>Ngày nhập cảnh:</label>
                              <input type="date" id="entry_date" name="entry_date" class="form-control">
                              
                              <label>Mã số người nước ngoài:</label>
                              <input type="text" id="foreign_number" name="foreign_number" class="form-control">
                          </div>

                          <div class="col-md-4">
                              <label>Địa chỉ VN:</label>
                              <input type="text" id="vietnam_address" name="vietnam_address" class="form-control">
                              
                              <label>Số điện thoại VN:</label>
                              <input type="text" id="vietnam_phone" name="vietnam_phone" class="form-control">
                              
                              <label>Học vấn:</label>
                              <input type="text" id="education" name="education" class="form-control">
                              
                              <label>Chiều cao (cm):</label>
                              <input type="number" id="height" name="height" class="form-control">
                              
                              <label>Cân nặng (kg):</label>
                              <input type="number" id="weight" name="weight" class="form-control">
                              
                              <label>Tình trạng hôn nhân:</label>
                              <select id="marital_status" name="marital_status" class="form-control">
                                  <option value="Đã kết hôn">Đã kết hôn</option>
                                  <option value="Chưa kết hôn">Chưa kết hôn</option>
                              </select>
                          </div>

                          <div class="col-md-4">
                              
                              <label>Số người trong gia đình:</label>
                              <input type="number" id="family_size" name="family_size" class="form-control">
                              
                              <label>Số lần chuyển tàu:</label>
                              <input type="number" id="transfer_count" name="transfer_count" class="form-control">
                              
                              <label>Tái nhập cảnh:</label>
                              <select id="reentry_status" name="reentry_status" class="form-control">
                                  <option value="Có">Có</option>
                                  <option value="Không">Không</option>
                              </select>
                              
                              <label>Ngày sinh:</label>
                              <input type="date" id="birth_date" name="birth_date" class="form-control">
                              
                              <label>ID thuyền viên:</label>
                              <input type="text" id="crew_id_number" name="crew_id" class="form-control">
                              
                              <label>Số ID ngoại quốc:</label>
                              <input type="text" id="foreign_registration_number" name="foreign_registration_number" class="form-control">
                              
                              <label>Tuổi:</label>
                              <input type="number" id="age" name="age" class="form-control">
                          </div>
                      </div>
                      <br>
                      <button type="submit" class="btn btn-primary">Cập nhật</button>
                      <button type="button" class="btn btn-danger" id="deleteCrew">Xóa</button>
                      <button type="button" class="btn btn-warning" id="cancelContractBtn">Hủy hợp đồng</button>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <!-- Modal Thêm Thuyền Viên -->
  <div class="modal fade" id="addCrewModal" tabindex="-1">
      <div class="modal-dialog modal-xl"> <!-- modal-xl để mở rộng modal -->
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Thêm thuyền viên mới</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                  <form action="add_crew.php" method="POST">
                      <div class="row">
                          <!-- CỘT 1 -->
                          <div class="col-md-4">
                              <label>Mã tàu:</label>
                              <select id="ship_code" name="ship_code" class="form-control">
                                  <?php foreach ($ships as $ship) : ?>
                                      <option value="<?= $ship['ship_code'] ?>"><?= $ship['ship_code'] ?> - <?= $ship['name'] ?></option>
                                  <?php endforeach; ?>
                              </select>
                              
                              <label>Ngày thay đổi cuối:</label>
                              <input type="date" name="last_change_date" class="form-control" required>
                              
                              <label>Tên thuyền viên:</label>
                              <input type="text" name="name" class="form-control" required>
                              
                              <label>Số hộ chiếu:</label>
                              <input type="text" name="passport_number" class="form-control" required>
                              
                              <label>Trạng thái làm việc:</label>
                                <select id="employment_status" name="employment_status" class="form-control">
                                    <option value="근무" <?= $crew['employment_status'] == '근무' ? 'selected' : '' ?>>근무</option>
                                    <option value="하선(고용중단)" <?= $crew['employment_status'] == '하선(고용중단)' ? 'selected' : '' ?>>하선(고용중단)</option>
                                    <option value="근무지이탈" <?= $crew['employment_status'] == '근무지이탈' ? 'selected' : '' ?>>근무지이탈</option>
                                    <option value="강제출국(이탈)" <?= $crew['employment_status'] == '강제출국(이탈)' ? 'selected' : '' ?>>강제출국(이탈)</option>
                                    <option value="자진출국" <?= $crew['employment_status'] == '자진출국' ? 'selected' : '' ?>>자진출국</option>
                                    <option value="사망" <?= $crew['employment_status'] == '사망' ? 'selected' : '' ?>>사망</option>
                                </select>
                              
                              <label>Ngày nhập cảnh:</label>
                              <input type="date" name="entry_date" class="form-control">

                              <label>Mã số người nước ngoài:</label>
                              <input type="text" name="foreign_number" class="form-control">
                          </div>

                          <!-- CỘT 2 -->
                          <div class="col-md-4">
                              
                              <label>Địa chỉ VN:</label>
                              <input type="text" name="vietnam_address" class="form-control">
                              
                              <label>Số điện thoại VN:</label>
                              <input type="text" name="vietnam_phone" class="form-control">
                              
                              <label>Học vấn:</label>
                              <input type="text" name="education" class="form-control">
                              
                              <label>Chiều cao (cm):</label>
                              <input type="number" name="height" class="form-control">
                              
                              <label>Cân nặng (kg):</label>
                              <input type="number" name="weight" class="form-control">

                              <label>Tình trạng hôn nhân:</label>
                              <select name="marital_status" class="form-control">
                                  <option value="Đã kết hôn">Đã kết hôn</option>
                                  <option value="Chưa kết hôn">Chưa kết hôn</option>
                              </select>
                          </div>

                          <!-- CỘT 3 -->
                          <div class="col-md-4">
                              
                              <label>Số người trong gia đình:</label>
                              <input type="number" name="family_size" class="form-control">
                              
                              <label>Số lần chuyển tàu:</label>
                              <input type="number" name="transfer_count" class="form-control">
                              
                              <label>Tái nhập cảnh:</label>
                              <select name="reentry_status" class="form-control">
                                  <option value="Có">Có</option>
                                  <option value="Không">Không</option>
                              </select>
                              
                              <label>Ngày sinh:</label>
                              <input type="date" name="birth_date" class="form-control">
                              
                              <label>ID thuyền viên:</label>
                              <input type="text" name="crew_id" class="form-control">
                              
                              <label>Số ID ngoại quốc:</label>
                              <input type="text" name="foreign_registration_number" class="form-control">
                              
                              <label>Tuổi:</label>
                              <input type="number" name="age" class="form-control">
                          </div>
                      </div>
                      <br>
                      <button type="submit" class="btn btn-success">Thêm thuyền viên</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
  
  <button id="scrollToTopBtn" class="btn btn-primary" style="display: none;"><i class="fa-solid fa-arrow-up"></i></button>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/crew_management.js"></script>
</body>

</html>