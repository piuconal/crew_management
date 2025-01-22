let searchTimeout;
$("#searchInput").keyup(function () {
  clearTimeout(searchTimeout);

  // Set a timeout to delay the search
  searchTimeout = setTimeout(function () {
    var searchTerm = $("#searchInput").val().toLowerCase(); // Get the search term and convert it to lowercase

    // Filter the table rows based on the search term
    $("table tbody tr").each(function () {
      var shipNameText = $(this).find("td:nth-child(2)").text().toLowerCase(); // Ship Name column (2nd column)
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
