var selected = document.querySelector("[name='radio']");
var proceedBtn = document.querySelector(".input-btn");

proceedBtn.addEventListener("click", loadPage);

function loadPage() {
  if (document.getElementById("declaration").checked == true) {
    location.href = "/declaration.html";
  } else if (document.getElementById("register").checked == true) {
    location.href = "/register.html";
  } else if (
    (document.getElementById("alert-msg").innerHTML =
      "Error!!! Please select one of the above options.")
  ) {
  }
}
