document.addEventListener("DOMContentLoaded", function () {
  const table = document.querySelector(".table");
  const headers = table.querySelectorAll("th");
  let sortDirections = {};

  headers.forEach((header, index) => {
    header.style.cursor = "pointer";
    header.addEventListener("click", function () {
      sortTable(index);
      resetHeaderColors();
      header.style.color = "red";
    });
  });

  function sortTable(columnIndex) {
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));

    const isAscending = !sortDirections[columnIndex];
    sortDirections[columnIndex] = isAscending;

    rows.sort((rowA, rowB) => {
      const cellA = rowA.cells[columnIndex].textContent.trim();
      const cellB = rowB.cells[columnIndex].textContent.trim();

      if (!isNaN(cellA) && !isNaN(cellB)) {
        return isAscending ? cellA - cellB : cellB - cellA;
      }
      return isAscending
        ? cellA.localeCompare(cellB)
        : cellB.localeCompare(cellA);
    });

    tbody.innerHTML = "";
    rows.forEach((row) => tbody.appendChild(row));
  }

  function resetHeaderColors() {
    headers.forEach((header) => (header.style.color = ""));
  }
});
