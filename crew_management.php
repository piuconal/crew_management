<?php
// Kết nối cơ sở dữ liệu
include('config.php');

// Lấy dữ liệu từ bảng thuyenvien mà không phân trang
$sql = "SELECT * FROM thuyenvien";
$result = mysqli_query($conn, $sql);

// Kiểm tra có dữ liệu không
if (mysqli_num_rows($result) > 0) {
    $crews = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $crews = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/crew_management.css">
</head>

<body>
  <div>
    <div class="row mb-3">
      <div class="col-md-4">
        <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm theo tên, số hộ chiếu">
      </div>
      <!-- <div class="col-md-2">
        <button class="btn btn-primary" id="searchBtn">Tìm kiếm</button>
      </div> -->
    </div>

    <!-- Bảng hiển thị thông tin thuyền viên -->
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Họ tên</th>
            <th>Số hộ chiếu</th>
            <th>Mã thuyền viên</th>
            <th>Ngày sinh</th>
            <th>Tuổi</th>
            <th>Địa chỉ</th>
            <th>Thành phố</th>
            <th>Số điện thoại</th>
            <th>Khu vực</th>
            <th>Số tàu</th>
            <th>Chiều cao</th>
            <th>Cân nặng</th>
            <th>Tình trạng hôn nhân</th>
            <th>Số thành viên gia đình</th>
            <th>Ngày sửa đổi cuối</th>
            <th>Số lần chuyển công tác</th>
            <th>Hồ sơ</th>
            <th>Trạng thái công việc</th>
            <th>Đăng ký lại</th>
            <th>Ngày hết hạn</th>
            <th>Trình độ</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($crews)) : ?>
            <?php foreach ($crews as $crew) : ?>
              <tr data-toggle="modal" data-target="#crewModal" onclick="fillCrewModal(<?php echo htmlspecialchars(json_encode($crew)); ?>)">
                <td><?php echo htmlspecialchars($crew['Name']); ?></td>
                <td><?php echo htmlspecialchars($crew['Passport_Number']); ?></td>
                <td><?php echo htmlspecialchars($crew['Seaman_ID_Number']); ?></td>
                <td><?php echo htmlspecialchars($crew['DOB']); ?></td>
                <td><?php echo htmlspecialchars($crew['Age']); ?></td>
                <td><?php echo htmlspecialchars($crew['VN_Address']); ?></td>
                <td><?php echo htmlspecialchars($crew['VN_City']); ?></td>
                <td><?php echo htmlspecialchars($crew['VN_Phone']); ?></td>
                <td><?php echo htmlspecialchars($crew['Region']); ?></td>
                <td><?php echo htmlspecialchars($crew['Ship_Number']); ?></td>
                <td><?php echo htmlspecialchars($crew['Height']); ?> m</td>
                <td><?php echo htmlspecialchars($crew['Weight']); ?> kg</td>
                <td><?php echo htmlspecialchars($crew['Marital_Status']); ?></td>
                <td><?php echo htmlspecialchars($crew['Family_Member']); ?></td>
                <td><?php echo htmlspecialchars($crew['Last_Modified_Date']); ?></td>
                <td><?php echo htmlspecialchars($crew['Num_of_Transfer']); ?></td>
                <td><?php echo htmlspecialchars($crew['Record']); ?></td>
                <td><?php echo htmlspecialchars($crew['Word_Status']); ?></td>
                <td><?php echo htmlspecialchars($crew['GF_Reentry']); ?></td>
                <td><?php echo htmlspecialchars($crew['DOE']); ?></td>
                <td><?php echo htmlspecialchars($crew['Graduation']); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="21" class="text-center">Không có thuyền viên nào.</td>
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
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="crewForm">
            <input type="hidden" id="crewID">
            <!-- Thông tin thuyền viên chia thành 3 cột -->
            <div class="row">
              <!-- Cột 1 -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="crewName">Họ tên</label>
                  <input type="text" class="form-control" id="crewName">
                </div>
                <div class="form-group">
                  <label for="crewPassportNumber">Số hộ chiếu</label>
                  <input type="text" class="form-control" id="crewPassportNumber">
                </div>
                <div class="form-group">
                  <label for="crewSeamanID">Mã thuyền viên</label>
                  <input type="text" class="form-control" id="crewSeamanID" disabled>
                </div>
                <div class="form-group">
                  <label for="crewDOB">Ngày sinh</label>
                  <input type="date" class="form-control" id="crewDOB">
                </div>
                <div class="form-group">
                  <label for="crewAge">Tuổi</label>
                  <input type="number" class="form-control" id="crewAge">
                </div>
                <div class="form-group">
                  <label for="crewVNAddress">Địa chỉ</label>
                  <input type="text" class="form-control" id="crewVNAddress">
                </div>
                <div class="form-group">
                  <label for="crewVNCity">Thành phố</label>
                  <input type="text" class="form-control" id="crewVNCity">
                </div>
              </div>
              <!-- Cột 2 -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="crewVNPhone">Số điện thoại</label>
                  <input type="text" class="form-control" id="crewVNPhone">
                </div>
                <div class="form-group">
                  <label for="crewRegion">Khu vực</label>
                  <input type="text" class="form-control" id="crewRegion">
                </div>
                <div class="form-group">
                  <label for="crewShipNumber">Số tàu</label>
                  <input type="text" class="form-control" id="crewShipNumber">
                </div>
                <div class="form-group">
                  <label for="crewHeight">Chiều cao</label>
                  <input type="number" step="0.01" class="form-control" id="crewHeight">
                </div>
                <div class="form-group">
                  <label for="crewWeight">Cân nặng</label>
                  <input type="number" class="form-control" id="crewWeight">
                </div>
                <div class="form-group">
                  <label for="crewMaritalStatus">Tình trạng hôn nhân</label>
                  <input type="text" class="form-control" id="crewMaritalStatus">
                </div>
                <div class="form-group">
                  <label for="crewFamilyMember">Số thành viên gia đình</label>
                  <input type="number" class="form-control" id="crewFamilyMember">
                </div>
              </div>
              <!-- Cột 3 -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="crewLastModifiedDate">Ngày sửa đổi cuối</label>
                  <input type="date" class="form-control" id="crewLastModifiedDate">
                </div>
                <div class="form-group">
                  <label for="crewNumOfTransfer">Số lần chuyển công tác</label>
                  <input type="number" class="form-control" id="crewNumOfTransfer">
                </div>
                <div class="form-group">
                  <label for="crewRecord">Hồ sơ</label>
                  <input type="text" class="form-control" id="crewRecord">
                </div>
                <div class="form-group">
                  <label for="crewWordStatus">Trạng thái công việc</label>
                  <input type="text" class="form-control" id="crewWordStatus">
                </div>
                <div class="form-group">
                  <label for="crewGFReentry">Đăng ký lại</label>
                  <input type="text" class="form-control" id="crewGFReentry">
                </div>
                <div class="form-group">
                  <label for="crewDOE">Ngày hết hạn</label>
                  <input type="date" class="form-control" id="crewDOE">
                </div>
                <div class="form-group">
                  <label for="crewGraduation">Trình độ</label>
                  <input type="text" class="form-control" id="crewGraduation">
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

  <button id="scrollToTopBtn" class="btn btn-primary"><i class="fa-solid fa-arrow-up"></i></button>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="js/crew_management.js"></script>

</body>

</html>
