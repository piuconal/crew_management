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
  <title>Crew Management</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="assets/images/logo.png">
  <link rel="stylesheet" href="css/crew_management.css">
</head>

<body>
  <div>
    <div class="row mb-3">
      <div class="col-md-4">
        <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm theo tên, email, hoặc chức vụ">
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
            <th>Ảnh đại diện</th>
            <th>Mã thuyền viên</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>Quốc tịch</th>
            <th>Ngày vào làm</th>
            <th>Chức vụ</th>
            <th>Số giấy phép lao động</th>
            <th>Thời gian công tác</th>
            <th>Trình độ</th>
            <th>Kinh nghiệm</th>
            <th>Kỹ năng</th>
            <th>Trạng thái</th>
            <th>Ghi chú</th>
            <th>Bảo hiểm</th>
            <th>Chuyên môn</th>
            <th>Địa chỉ làm việc</th>
            <th>Thông tin hợp đồng</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($crews)) : ?>
            <?php foreach ($crews as $crew) : ?>
              <tr data-toggle="modal" data-target="#crewModal" onclick="fillCrewModal(<?php echo htmlspecialchars(json_encode($crew)); ?>)">
                <td>
                  <?php if ($crew['anh_dai_dien']) : ?>
                    <img src="<?php echo htmlspecialchars($crew['anh_dai_dien']); ?>" alt="Avatar">
                  <?php else : ?>
                    <img src="assets/images/default-avatar.png" alt="Default Avatar">
                  <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($crew['ma_thuyenvien']); ?></td>
                <td><?php echo htmlspecialchars($crew['ho_ten']); ?></td>
                <td><?php echo htmlspecialchars($crew['email']); ?></td>
                <td><?php echo htmlspecialchars($crew['so_dien_thoai']); ?></td>
                <td><?php echo htmlspecialchars($crew['dia_chi']); ?></td>
                <td><?php echo htmlspecialchars($crew['ngay_sinh']); ?></td>
                <td><?php echo htmlspecialchars($crew['gioi_tinh']); ?></td>
                <td><?php echo htmlspecialchars($crew['quoc_tich']); ?></td>
                <td><?php echo htmlspecialchars($crew['ngay_vao_lam']); ?></td>
                <td><?php echo htmlspecialchars($crew['chuc_vu']); ?></td>
                <td><?php echo htmlspecialchars($crew['so_giay_phep_lao_dong']); ?></td>
                <td><?php echo htmlspecialchars($crew['thoi_gian_cong_tac']); ?> tháng</td>
                <td><?php echo htmlspecialchars($crew['trinh_do']); ?></td>
                <td><?php echo htmlspecialchars($crew['kinh_nghiem']); ?> năm</td>
                <td><?php echo htmlspecialchars($crew['ky_nang']); ?></td>
                <td><?php echo htmlspecialchars($crew['trang_thai']); ?></td>
                <td><?php echo htmlspecialchars($crew['ghi_chu']); ?></td>
                <td><?php echo htmlspecialchars($crew['bao_hiem']); ?></td>
                <td><?php echo htmlspecialchars($crew['chuyen_mon']); ?></td>
                <td><?php echo htmlspecialchars($crew['dia_chi_lam_viec']); ?></td>
                <td><?php echo htmlspecialchars($crew['thong_tin_hop_dong']); ?></td>
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
            <input type="hidden" id="crewId">
            <!-- Thông tin thuyền viên chia thành 3 cột -->
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <div class="text-center">
                    <label for="crewAvatar">Ảnh đại diện</label>
                  </div>
                  <div class="text-center">
                      <img id="crewAvatar" src="" alt="Avatar" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="crewName">Họ tên</label>
                  <input type="text" class="form-control" id="crewName">
                </div>
                <div class="form-group">
                  <label for="crewPhone">Số điện thoại</label>
                  <input type="text" class="form-control" id="crewPhone">
                </div>
                <div class="form-group">
                  <label for="crewGender">Giới tính</label>
                  <input type="text" class="form-control" id="crewGender">
                </div>
                <div class="form-group">
                  <label for="crewNationality">Quốc tịch</label>
                  <input type="text" class="form-control" id="crewNationality">
                </div>
                <div class="form-group">
                  <label for="crewPosition">Chức vụ</label>
                  <input type="text" class="form-control" id="crewPosition">
                </div>
                <div class="form-group">
                  <label for="crewExperience">Kinh nghiệm</label>
                  <input type="text" class="form-control" id="crewExperience">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="crewEmail">Email</label>
                  <input type="email" class="form-control" id="crewEmail">
                </div>
                <div class="form-group">
                  <label for="crewAddress">Địa chỉ</label>
                  <input type="text" class="form-control" id="crewAddress">
                </div>
                <div class="form-group">
                  <label for="crewDOB">Ngày sinh</label>
                  <input type="date" class="form-control" id="crewDOB">
                </div>
                <div class="form-group">
                  <label for="crewStartDate">Ngày vào làm</label>
                  <input type="date" class="form-control" id="crewStartDate">
                </div>
                <div class="form-group">
                  <label for="crewWorkTime">Thời gian công tác</label>
                  <input type="text" class="form-control" id="crewWorkTime">
                </div>
                <div class="form-group">
                  <label for="crewInsurance">Bảo hiểm</label>
                  <input type="text" class="form-control" id="crewInsurance">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="crewID">Mã thuyền viên</label>
                  <input type="text" class="form-control" id="crewID" disabled>
                </div>
                <div class="form-group">
                  <label for="crewLicense">Số giấy phép lao động</label>
                  <input type="text" class="form-control" id="crewLicense">
                </div>
                <div class="form-group">
                  <label for="crewNotes">Ghi chú</label>
                  <input type="text" class="form-control" id="crewNotes">
                </div>
                <div class="form-group">
                  <label for="crewSkills">Kỹ năng</label>
                  <input type="text" class="form-control" id="crewSkills">
                </div>
                <div class="form-group">
                  <label for="crewSpecialization">Chuyên môn</label>
                  <input type="text" class="form-control" id="crewSpecialization">
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
