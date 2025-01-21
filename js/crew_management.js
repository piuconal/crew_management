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
      var nameText = $(this).find("td:nth-child(1)").text().toLowerCase(); // Họ tên column
      var passportNumberText = $(this)
        .find("td:nth-child(2)")
        .text()
        .toLowerCase(); // Số hộ chiếu column

      if (
        nameText.indexOf(searchTerm) === -1 &&
        passportNumberText.indexOf(searchTerm) === -1
      ) {
        $(this).hide(); // Hide rows that don't match the search term
      } else {
        $(this).show(); // Show rows that match
      }
    });
  }, 100);
});

function fillCrewModal(crew) {
  // Populate modal fields with the crew information
  $("#crewName").val(crew.Name); // Họ tên
  $("#crewPassportNumber").val(crew.Passport_Number); // Số hộ chiếu
  $("#crewSeamanID").val(crew.Seaman_ID_Number); // Mã thuyền viên (disabled)
  $("#crewDOB").val(crew.DOB); // Ngày sinh
  $("#crewAge").val(crew.Age); // Tuổi
  $("#crewVNAddress").val(crew.VN_Address); // Địa chỉ
  $("#crewVNCity").val(crew.VN_City); // Thành phố
  $("#crewVNPhone").val(crew.VN_Phone); // Số điện thoại
  $("#crewRegion").val(crew.Region); // Khu vực
  $("#crewShipNumber").val(crew.Ship_Number); // Số tàu
  $("#crewHeight").val(crew.Height); // Chiều cao
  $("#crewWeight").val(crew.Weight); // Cân nặng
  $("#crewMaritalStatus").val(crew.Marital_Status); // Tình trạng hôn nhân
  $("#crewFamilyMember").val(crew.Family_Member); // Số thành viên gia đình
  $("#crewLastModifiedDate").val(crew.Last_Modified_Date); // Ngày sửa đổi cuối
  $("#crewNumOfTransfer").val(crew.Num_of_Transfer); // Số lần chuyển công tác
  $("#crewRecord").val(crew.Record); // Hồ sơ
  $("#crewWordStatus").val(crew.Word_Status); // Trạng thái công việc
  $("#crewGFReentry").val(crew.GF_Reentry); // Đăng ký lại
  $("#crewDOE").val(crew.DOE); // Ngày hết hạn
  $("#crewGraduation").val(crew.Graduation); // Trình độ

  $("#crewID").val(crew.Seaman_ID_Number);
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
