<?php
// Kết nối cơ sở dữ liệu
include('config.php');

// Xác định số dòng mỗi trang
$items_per_page = 5;

// Lấy số trang từ POST (mặc định là trang 1 nếu không có tham số page)
$page = isset($_POST['page_number']) ? (int)$_POST['page_number'] : 1;
$start_from = ($page - 1) * $items_per_page;

// Lấy dữ liệu từ bảng thuyenvien với phân trang
$sql = "SELECT * FROM thuyenvien LIMIT $start_from, $items_per_page";
$result = mysqli_query($conn, $sql);

// Kiểm tra có dữ liệu không
if (mysqli_num_rows($result) > 0) {
    $crews = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $crews = [];
}

// Lấy tổng số thuyền viên để tính số trang
$total_sql = "SELECT COUNT(*) FROM thuyenvien";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_array($total_result);
$total_items = $total_row[0];
$total_pages = ceil($total_items / $items_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý Thuyền viên</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="assets/images/logo.png">
  <link rel="stylesheet" href="css/crew_management.css">
</head>

<body>
  <div>
    <h2>Quản lý thuyền viên</h2>

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

    <!-- Phân trang -->
    <form method="POST" action="">
      <div class="pagination">
        <ul class="pagination justify-content-center">
          <?php if ($page > 1) : ?>
          <li class="page-item">
            <button class="page-link" type="submit" name="page_number" value="<?php echo $page - 1; ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </button>
          </li>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
          <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
            <button class="page-link" type="submit" name="page_number" value="<?php echo $i; ?>">
              <?php echo $i; ?>
            </button>
          </li>
          <?php endfor; ?>

          <?php if ($page < $total_pages) : ?>
          <li class="page-item">
            <button class="page-link" type="submit" name="page_number" value="<?php echo $page + 1; ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </button>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </form>
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
          <button type="button" class="btn btn-danger" id="cancelContractBtn">Hủy hợp đồng</button>
          <button type="button" class="btn btn-primary" id="updateCrewBtn">Cập nhật</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>  
    function fillCrewModal(crew) {
      $('#crewId').val(crew.ma_thuyenvien);
      $('#crewName').val(crew.ho_ten);
      $('#crewPhone').val(crew.so_dien_thoai);
      $('#crewEmail').val(crew.email);
      $('#crewAddress').val(crew.dia_chi);
      $('#crewDOB').val(crew.ngay_sinh);
      $('#crewGender').val(crew.gioi_tinh);
      $('#crewNationality').val(crew.quoc_tich);
      $('#crewStartDate').val(crew.ngay_vao_lam);
      $('#crewPosition').val(crew.chuc_vu);
      $('#crewLicense').val(crew.so_giay_phep_lao_dong);
      $('#crewWorkTime').val(crew.thoi_gian_cong_tac);
      $('#crewExperience').val(crew.kinh_nghiem);
      $('#crewSkills').val(crew.ky_nang);
      $('#crewNotes').val(crew.ghi_chu);
      $('#crewInsurance').val(crew.bao_hiem);
      $('#crewSpecialization').val(crew.chuyen_mon);

      // Hiển thị ảnh đại diện
      if (crew.anh_dai_dien) {
        $('#crewAvatar').attr('src', crew.anh_dai_dien);
      } else {
        $('#crewAvatar').attr('src', 'assets/images/default-avatar.png');
      }

      $('#crewID').val(crew.ma_thuyenvien); // Không cho phép chỉnh sửa mã thuyền viên
    }

    // Cancel contract function with confirmation
    $('#cancelContractBtn').click(function() {
      var confirmation = confirm('Bạn có chắc chắn muốn hủy hợp đồng này không?');

      if (confirmation) {
        // Code to handle the contract cancellation (e.g., AJAX request to update the database)
        alert('Contract has been canceled.');
      } else {
        alert('Cancellation aborted.');
      }
    });
  </script>

</body>

</html>
