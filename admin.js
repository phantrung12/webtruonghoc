function chonNganh() {
  var x = document.getElementById("nganh").value;
  $.ajax({
    url: "xulibang.php",
    method: "POST",
    data: {
      id: x,
    },
    success: function (data) {
      $("#ans").html(data);
    },
  });
}
