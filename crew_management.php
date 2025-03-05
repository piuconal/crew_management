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
  <div>
    <div class="row mb-3">
      <div class="col-md-4">
        <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm theo tên, số hộ chiếu">
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

  <!-- Modal Bootstrap -->
  <div class="modal fade" id="crewModal" tabindex="-1" role="dialog" aria-labelledby="crewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crewModalLabel">Chỉnh sửa thông tin thuyền viên</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="crewForm">
            <input type="hidden" id="crewID" name="id">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="crewName">Họ tên</label>
                  <input type="text" class="form-control" id="crewName" name="name">
                </div>
                <div class="form-group">
                  <label for="crewPassportNumber">Số hộ chiếu</label>
                  <input type="text" class="form-control" id="crewPassportNumber" name="passport_number">
                </div>
                <div class="form-group">
                  <label for="crewForeignNumber">Mã người nước ngoài</label>
                  <input type="text" class="form-control" id="crewForeignNumber" name="foreign_number">
                </div>
                <div class="form-group">
                  <label for="crewBirthDate">Ngày sinh</label>
                  <input type="date" class="form-control" id="crewBirthDate" name="birth_date">
                </div>
                <div class="form-group">
                  <label for="crewAge">Tuổi</label>
                  <input type="number" class="form-control" id="crewAge" name="age">
                </div>
                <div class="form-group">
                  <label for="crewVietnamAddress">Địa chỉ VN</label>
                  <input type="text" class="form-control" id="crewVietnamAddress" name="vietnam_address">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="crewVietnamPhone">Số điện thoại VN</label>
                  <input type="text" class="form-control" id="crewVietnamPhone" name="vietnam_phone">
                </div>
                <div class="form-group">
                  <label for="crewShipName">Tên tàu</label>
                  <input type="text" class="form-control" id="crewShipName" name="ship_name" disabled>
                </div>
                <div class="form-group">
                  <label for="crewHeight">Chiều cao (cm)</label>
                  <input type="number" step="0.01" class="form-control" id="crewHeight" name="height">
                </div>
                <div class="form-group">
                  <label for="crewWeight">Cân nặng (kg)</label>
                  <input type="number" class="form-control" id="crewWeight" name="weight">
                </div>
                <div class="form-group">
                  <label for="crewMaritalStatus">Tình trạng hôn nhân</label>
                  <input type="text" class="form-control" id="crewMaritalStatus" name="marital_status">
                </div>
                <div class="form-group">
                  <label for="crewFamilySize">Số thành viên gia đình</label>
                  <input type="number" class="form-control" id="crewFamilySize" name="family_size">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="crewUpdatedAt">Ngày sửa đổi cuối</label>
                  <input type="datetime-local" class="form-control" id="crewUpdatedAt" name="updated_at" disabled>
                </div>
                <div class="form-group">
                  <label for="crewTransferCount">Số lần chuyển tàu</label>
                  <input type="number" class="form-control" id="crewTransferCount" name="transfer_count">
                </div>
                <div class="form-group">
                  <label for="crewEmploymentStatus">Trạng thái công việc</label>
                  <input type="text" class="form-control" id="crewEmploymentStatus" name="employment_status">
                </div>
                <div class="form-group">
                  <label for="crewType">Loại</label>
                  <input type="text" class="form-control" id="crewType" name="type">
                </div>
                <div class="form-group">
                  <label for="crewEntryDate">Ngày nhập cảnh</label>
                  <input type="date" class="form-control" id="crewEntryDate" name="entry_date">
                </div>
                <div class="form-group">
                  <label for="crewEducation">Trình độ</label>
                  <input type="text" class="form-control" id="crewEducation" name="education">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="cancelContractBtn">Hủy hợp đồng</button>
          <button type="button" class="btn btn-primary" id="updateCrewBtn">Cập nhật</button>
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