function AllOrders() {
  $.ajax({
    url: "./allOrders.php",
    method: "post",
    data: { record: 1 },
    success: function (data) {
      $(".allOrders").php(data);
    },
  });
}

function UpdateReturnStatus(id) {
  $.ajax({
    url: "./updateStatus.php",
    method: "post",
    data: { record: id },
    success: function (data) {
      alert(
        "Return Processed Successfully. A Confirmation email will be sent to you!"
      );
      $("form").trigger("reset");
      AllOrders();
    },
  });
}
