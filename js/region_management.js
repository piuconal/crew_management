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
