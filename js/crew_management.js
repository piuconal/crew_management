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
  $("#crewID").val(crew.id || "");
  $("#crewName").val(crew.name || "");
  $("#crewPassportNumber").val(crew.passport_number || "");
  $("#crewForeignNumber").val(crew.foreign_number || "");
  $("#crewBirthDate").val(crew.birth_date || "");
  $("#crewAge").val(crew.age || "");
  $("#crewVietnamAddress").val(crew.vietnam_address || "");
  $("#crewVietnamPhone").val(crew.vietnam_phone || "");
  $("#crewShipName").val(crew.ship_name || "");
  $("#crewHeight").val(crew.height || "");
  $("#crewWeight").val(crew.weight || "");
  $("#crewMaritalStatus").val(crew.marital_status || "");
  $("#crewFamilySize").val(crew.family_size || "");
  $("#crewUpdatedAt").val(
    crew.updated_at ? crew.updated_at.replace(" ", "T") : ""
  );
  $("#crewTransferCount").val(crew.transfer_count || "");
  $("#crewEmploymentStatus").val(crew.employment_status || "");
  $("#crewEntryDate").val(crew.entry_date || "");
  $("#crewEducation").val(crew.education || "");
  $("#crewReentryStatus").val(crew.reentry_status || "Không");
}

// Cancel contract function with confirmation
$("#cancelContractBtn").click(function () {
  var confirmation = confirm("Bạn có chắc chắn muốn hủy hợp đồng này không?");
  if (confirmation) {
    var crewId = $("#crewID").val(); // Lấy ID thuyền viên từ modal
    window.location.href = "generate_word.php?crewId=" + crewId; // Chuyển hướng đến trang generate_word.php
    alert("Hợp đồng đã bị hủy. File Word sẽ được tải xuống.");
  } else {
    alert("Hủy hợp đồng đã bị hủy.");
  }
});
