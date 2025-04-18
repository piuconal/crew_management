let searchTimeout;
$("#searchInput").keyup(function () {
  clearTimeout(searchTimeout);

  // Set a timeout to delay the search
  searchTimeout = setTimeout(function () {
    var searchTerm = $("#searchInput").val().toLowerCase(); // Get the search term and convert it to lowercase

    // Filter the table rows based on the search term
    $("table tbody tr").each(function () {
      var shipNameText = $(this).find("td:nth-child(1)").text().toLowerCase(); // Ship Name column (2nd column)
      var ownerNameText = $(this).find("td:nth-child(6)").text().toLowerCase(); // Owner Name column (6th column)

      // If the ship name or owner name doesn't match the search term, hide the row
      if (
        shipNameText.indexOf(searchTerm) === -1 &&
        ownerNameText.indexOf(searchTerm) === -1
      ) {
        $(this).hide(); // Hide rows that don't match the search term
      } else {
        $(this).show(); // Show rows that match
      }
    });
  }, 300); // 300 ms delay for better performance while typing
});

document.getElementById("addShipForm").addEventListener("submit", function (e) {
  e.preventDefault();

  let formData = new FormData(this);

  fetch("add_ship.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json()) // Giả sử `add_ship.php` trả về JSON
    .then((data) => {
      if (data.success) {
        location.reload();
      } else {
        alert("Lỗi: " + data.message);
      }
    })
    .catch((error) => console.error("Lỗi:", error));
});

document.addEventListener("DOMContentLoaded", function () {
  // Khi click vào hàng
  document.querySelectorAll(".ship-row").forEach((row) => {
    row.addEventListener("click", function () {
      let modal = document.getElementById("shipModal");

      // Gán dữ liệu vào modal
      document.getElementById("editShipId").value = this.dataset.id;
      document.getElementById("editShipName").value = this.dataset.name;
      document.getElementById("editCompanyName").value = this.dataset.company;
      document.getElementById("editOwnerName").value = this.dataset.owner;
      document.getElementById("editShipType").value = this.dataset.type;
      document.getElementById("editShipCode").value = this.dataset.code;
      document.getElementById("editAreaId").value = this.dataset.area;
      document.getElementById("editCompanyId").value = this.dataset.companyId; // Mới thêm
      document.getElementById("editCompanyAddress").value = this.dataset.companyAddress; // Mới thêm
      // Lưu ID tàu vào nút xóa
      document
        .getElementById("btnDeleteShip")
        .setAttribute("data-id", this.dataset.id);

      // Hiển thị modal
      $("#shipModal").modal("show");
    });
  });

  // Khi submit form cập nhật
  document.getElementById("editShipForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("update_ship.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Cập nhật trực tiếp dòng trong bảng
          const shipId = formData.get("id");
          const row = document.querySelector(`tr[data-id='${shipId}']`);
          if (row) {
            row.dataset.name = formData.get("name");
            row.dataset.company = formData.get("company_name");
            row.dataset.owner = formData.get("owner_name");
            row.dataset.type = formData.get("ship_type");
            row.dataset.code = formData.get("ship_code");
            row.dataset.area = formData.get("area_id");
            row.dataset.companyId = formData.get("company_id");
            row.dataset.companyAddress = formData.get("company_address");

            // Cập nhật luôn nội dung hiển thị trong các cột (nếu có hiển thị trong bảng)
            row.querySelector("td:nth-child(1)").textContent = formData.get("name");
            row.querySelector("td:nth-child(6)").textContent = formData.get("owner_name");
          }

          // Ẩn modal sau khi cập nhật
          $("#shipModal").modal("hide");
        } else {
          alert("Lỗi: " + data.message);
        }
      })
      .catch((error) => console.error("Lỗi:", error));
  });

  // Khi click vào nút "Xóa"
  document
    .getElementById("btnDeleteShip")
    .addEventListener("click", function () {
      let shipId = this.getAttribute("data-id");

      if (confirm("Bạn có chắc chắn muốn xóa tàu này?")) {
        fetch("delete_ship.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: "id=" + encodeURIComponent(shipId),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              location.reload();
            } else {
              alert("Lỗi: " + data.message);
            }
          })
          .catch((error) => console.error("Lỗi:", error));
      }
    });
});
