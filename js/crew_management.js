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

function fillCrewModal(crew) {
  document.getElementById("crew_id").value = crew.id;
  document.getElementById("ship_code").value = crew.ship_code;
  document.getElementById("last_change_date").value = crew.last_change_date;
  document.getElementById("name").value = crew.name;
  document.getElementById("passport_number").value = crew.passport_number;
  document.getElementById("employment_status").value = crew.employment_status;
  document.getElementById("entry_date").value = crew.entry_date;
  document.getElementById("foreign_number").value = crew.foreign_number;
  document.getElementById("vietnam_address").value = crew.vietnam_address;
  document.getElementById("vietnam_phone").value = crew.vietnam_phone;
  document.getElementById("education").value = crew.education;
  document.getElementById("height").value = crew.height;
  document.getElementById("weight").value = crew.weight;
  document.getElementById("marital_status").value = crew.marital_status;
  document.getElementById("family_size").value = crew.family_size;
  document.getElementById("transfer_count").value = crew.transfer_count;
  document.getElementById("reentry_status").value = crew.reentry_status;
  document.getElementById("birth_date").value = crew.birth_date;
  document.getElementById("crew_id_number").value = crew.crew_id;
  document.getElementById("foreign_registration_number").value =
    crew.foreign_registration_number;
  document.getElementById("age").value = crew.age;
}
document
  .getElementById("updateCrewForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("update_crew.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        alert(data);
        location.reload();
      })
      .catch((error) => console.error("Lỗi:", error));
  });

document.getElementById("deleteCrew").addEventListener("click", function () {
  let crewId = document.getElementById("crew_id").value;

  if (confirm("Bạn có chắc chắn muốn xóa thuyền viên này?")) {
    fetch("delete_crew.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: "id=" + encodeURIComponent(crewId),
    })
      .then((response) => response.text())
      .then((data) => {
        alert(data);
        location.reload();
      })
      .catch((error) => console.error("Lỗi:", error));
  }
});
