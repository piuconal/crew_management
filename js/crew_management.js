// Get the button
var scrollToTopBtn = document.getElementById("scrollToTopBtn");

// When the user scrolls down 100px from the top of the document, show the button
window.onscroll = function () {
  if (
    document.body.scrollTop > 100 ||
    document.documentElement.scrollTop > 100
  ) {
    scrollToTopBtn.style.display = "block";
  } else {
    scrollToTopBtn.style.display = "none";
  }
};

// When the user clicks the button, scroll to the top of the document
scrollToTopBtn.onclick = function () {
  window.scrollTo({ top: 0, behavior: "smooth" });
};

let searchTimeout;

$("#searchInput").keyup(function () {
  clearTimeout(searchTimeout);

  // Set a timeout to delay the search
  searchTimeout = setTimeout(function () {
    var searchTerm = $("#searchInput").val().toLowerCase();

    // Filter the table rows based on the search term
    $("table tbody tr").each(function () {
      var rowText = $(this).text().toLowerCase();
      if (rowText.indexOf(searchTerm) === -1) {
        $(this).hide(); // Hide rows that don't match the search term
      } else {
        $(this).show(); // Show rows that match
      }
    });
  }, 100);
});

function fillCrewModal(crew) {
  $("#crewId").val(crew.ma_thuyenvien);
  $("#crewName").val(crew.ho_ten);
  $("#crewPhone").val(crew.so_dien_thoai);
  $("#crewEmail").val(crew.email);
  $("#crewAddress").val(crew.dia_chi);
  $("#crewDOB").val(crew.ngay_sinh);
  $("#crewGender").val(crew.gioi_tinh);
  $("#crewNationality").val(crew.quoc_tich);
  $("#crewStartDate").val(crew.ngay_vao_lam);
  $("#crewPosition").val(crew.chuc_vu);
  $("#crewLicense").val(crew.so_giay_phep_lao_dong);
  $("#crewWorkTime").val(crew.thoi_gian_cong_tac);
  $("#crewExperience").val(crew.kinh_nghiem);
  $("#crewSkills").val(crew.ky_nang);
  $("#crewNotes").val(crew.ghi_chu);
  $("#crewInsurance").val(crew.bao_hiem);
  $("#crewSpecialization").val(crew.chuyen_mon);

  // Hiển thị ảnh đại diện
  if (crew.anh_dai_dien) {
    $("#crewAvatar").attr("src", crew.anh_dai_dien);
  } else {
    $("#crewAvatar").attr("src", "assets/images/default-avatar.png");
  }

  $("#crewID").val(crew.ma_thuyenvien); // Không cho phép chỉnh sửa mã thuyền viên
}

// Cancel contract function with confirmation
$("#cancelContractBtn").click(function () {
  var confirmation = confirm("Bạn có chắc chắn muốn hủy hợp đồng này không?");

  if (confirmation) {
    // Code to handle the contract cancellation (e.g., AJAX request to update the database)
    var crewId = $("#crewID").val(); // Lấy ID thuyền viên từ modal

    // Gửi yêu cầu tải file Word
    window.location.href = "generate_word.php?crewId=" + crewId; // Chuyển hướng đến trang generate_word.php để tải file

    alert("Hợp đồng đã bị hủy. File Word sẽ được tải xuống.");
  } else {
    alert("Hủy hợp đồng đã bị hủy.");
  }
});
