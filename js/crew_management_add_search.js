$(document).ready(function () {
  const openShipModal = $("#openShipModal");
  const shipModal = $("#shipModal");
  const shipSearch = $("#shipSearch");
  const shipList = $("#shipList");
  const selectedShipCode = $("#selectedShipCode");

  openShipModal.click(function () {
    shipModal.modal("show");
  });

  shipSearch.on("input", function () {
    const filter = $(this).val().toUpperCase();
    shipList.find("li").each(function () {
      const text = $(this).text().toUpperCase();
      if (text.indexOf(filter) > -1) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  shipList.on("click", "li", function () {
    const shipCode = $(this).data("ship-code");
    selectedShipCode.val(shipCode);
    openShipModal.text($(this).text());
    shipModal.modal("hide");
  });
});
