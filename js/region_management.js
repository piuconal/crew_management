let searchTimeout;
$("#searchInput").keyup(function () {
  clearTimeout(searchTimeout);

  // Set a timeout to delay the search
  searchTimeout = setTimeout(function () {
    var searchTerm = $("#searchInput").val().toLowerCase(); // Get the search term and convert it to lowercase

    // Filter the table rows based on the search term
    $("table tbody tr").each(function () {
      var regionText = $(this).find("td:nth-child(1)").text().toLowerCase(); // Region column (1st column)
      var personText = $(this).find("td:nth-child(2)").text().toLowerCase(); // Responsible Person column (2nd column)

      // If the region, responsible person, phone number, or mail doesn't match the search term, hide the row
      if (
        regionText.indexOf(searchTerm) === -1 &&
        personText.indexOf(searchTerm) === -1
      ) {
        $(this).hide(); // Hide rows that don't match the search term
      } else {
        $(this).show(); // Show rows that match
      }
    });
  }, 300); // 300 ms delay for better performance while typing
});

$(document).ready(function () {
  $("table tbody tr").click(function () {
    var row = $(this);
    var id = row.data("id");
    var name = row.find("td:nth-child(1)").text();
    var manager = row.find("td:nth-child(2)").text();
    var phone = row.find("td:nth-child(3)").text();

    $("#editId").val(id);
    $("#editName").val(name);
    $("#editManager").val(manager);
    $("#editPhone").val(phone);

    $("#editModal").modal("show");
  });

  $("#editForm").submit(function (e) {
    e.preventDefault();

    var id = $("#editId").val();
    var name = $("#editName").val();
    var manager = $("#editManager").val();
    var phone = $("#editPhone").val();

    fetch("update_area.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${id}&name=${encodeURIComponent(
        name
      )}&manager=${encodeURIComponent(manager)}&phone=${encodeURIComponent(
        phone
      )}`,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data.trim() === "success") {
          alert("Cập nhật thành công!");
          location.reload();
        } else {
          alert("Có lỗi xảy ra!");
        }
      })
      .catch((error) => console.error("Lỗi:", error));
  });
});
$(document).ready(function () {
  $("#addAreaForm").submit(function (e) {
    e.preventDefault();

    var areaName = $("#areaName").val();
    var managerName = $("#managerName").val();
    var phoneNumber = $("#phoneNumber").val();

    fetch("add_area.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `name=${encodeURIComponent(areaName)}&manager=${encodeURIComponent(
        managerName
      )}&phone=${encodeURIComponent(phoneNumber)}`,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data.trim() === "success") {
          alert("Thêm khu vực thành công!");
          location.reload();
        } else {
          alert("Có lỗi xảy ra!");
        }
      })
      .catch((error) => console.error("Lỗi:", error));
  });
});
$(document).ready(function () {
  $("table tbody tr").click(function () {
    var row = $(this);
    var id = row.data("id");
    var name = row.find("td:nth-child(1)").text();
    var manager = row.find("td:nth-child(2)").text();
    var phone = row.find("td:nth-child(3)").text();

    $("#editId").val(id);
    $("#editName").val(name);
    $("#editManager").val(manager);
    $("#editPhone").val(phone);

    $("#editModal").modal("show");
  });

  // Xử lý sự kiện khi nhấn nút Xóa
  $("#deleteAreaBtn").click(function () {
    var id = $("#editId").val();
    if (confirm("Bạn có chắc muốn xóa khu vực này không?")) {
      fetch("delete_area.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}`,
      })
        .then((response) => response.text())
        .then((data) => {
          if (data.trim() === "success") {
            alert("Xóa khu vực thành công!");
            location.reload();
          } else {
            alert("Có lỗi xảy ra!");
          }
        })
        .catch((error) => console.error("Lỗi:", error));
    }
  });
});
