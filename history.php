<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>History - Crew Management</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/history.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div>
    <div class="row mb-3">
      <div class="col-md-4">
        <!-- Tìm kiếm -->
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Tìm kiếm theo hành động, người thực hiện">
      </div>
      <div class="col-md-8">
        <!-- Các nút danh mục -->
        <button class="btn btn-primary mb-3 history-category" data-category="area">Khu vực</button>
        <button class="btn btn-secondary mb-3 history-category" data-category="ship">Tàu</button>
        <button class="btn btn-secondary mb-3 history-category" data-category="crew">Thuyền viên</button>
      </div>
    </div>

    <!-- Nút lọc lịch sử -->
    <div class="mb-3">
      <button class="btn btn-primary history-filter" data-type="add">Lịch sử thêm</button>
      <button class="btn btn-warning history-filter" data-type="edit">Lịch sử thay đổi</button>
      <button class="btn btn-danger history-filter" data-type="delete">Lịch sử xóa</button>
    </div>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Tên</th>
            <th>Người phụ trách</th>
            <th>Số điện thoại</th>
            <th>Thời gian</th>
          </tr>
        </thead>
        <tbody id="historyTable">
          <tr>
            <td colspan="5" class="text-center">Chọn loại lịch sử để hiển thị.</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>

  <script>
    let currentCategory = "area"; // Mặc định là khu vực
    let currentType = "add"; // Mặc định hiển thị lịch sử thêm

    function loadHistory(category, type) {
      let filePath = `json/${category}/${type}_${category}.json`;

      console.log("Đang tải dữ liệu từ:", filePath); // Debug đường dẫn file

      fetch(filePath)
        .then(response => {
          if (!response.ok) {
            throw new Error(`Lỗi HTTP: ${response.status} - ${response.statusText}`);
          }
          return response.json();
        })
        .then(data => {
          let tableBody = document.getElementById("historyTable");
          tableBody.innerHTML = ""; // Xóa nội dung cũ
          let rows = ""; // Chuỗi chứa tất cả các dòng dữ liệu

          if (!Array.isArray(data) || data.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center">Không có dữ liệu.</td></tr>`;
            return;
          }

          data.forEach(item => {
            rows += `<tr>
              <td>${item.name || "Không có"}</td>
              <td>${item.manager_name || "Không có"}</td>
              <td>${item.phone_number || "Không có"}</td>
              <td>${item.timestamp || "Không có"}</td>
            </tr>`;
          });

          tableBody.innerHTML = rows; // Cập nhật bảng sau khi hoàn tất vòng lặp
        })
        .catch(error => {
          console.error("Lỗi tải dữ liệu:", error);
          alert(`Không thể tải dữ liệu từ ${filePath}. Kiểm tra console để biết thêm.`);
        });
    }

    $(document).ready(function () {
      // Khi nhấn vào nút danh mục (Khu vực, Tàu, Thuyền viên)
      $(".history-category").click(function () {
        $(".history-category").removeClass("btn-primary").addClass("btn-secondary"); // Reset màu
        $(this).removeClass("btn-secondary").addClass("btn-primary"); // Đánh dấu nút được chọn

        currentCategory = $(this).data("category");
        loadHistory(currentCategory, currentType);
      });

      // Khi nhấn vào nút lọc lịch sử (Thêm, Thay đổi, Xóa)
      $(".history-filter").click(function () {
        currentType = $(this).data("type");
        loadHistory(currentCategory, currentType);
      });

      // Load mặc định
      loadHistory(currentCategory, currentType);
    });
  </script>

</body>
</html>
