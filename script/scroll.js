const button = document.getElementById("back-to-top");

window.addEventListener("scroll", function () {
  if (window.pageYOffset > 300) {
    button.classList.add("show");
  } else {
    button.classList.remove("show");
  }
});

button.addEventListener("click", function () {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});
