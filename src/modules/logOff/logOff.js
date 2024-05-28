document.addEventListener("DOMContentLoaded", () => {

  const btn = document.getElementById("logOff");
  btn.addEventListener("click", function () {
      window.location = "./modules/logOff/logOff.php";
  });
});