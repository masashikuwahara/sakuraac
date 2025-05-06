document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.querySelector('.accordion-toggle');
  const sortButtons = document.querySelector('.sort-buttons');

  toggle.addEventListener('click', function () {
    if (sortButtons.classList.contains('show')) {
      // 閉じる
      sortButtons.style.maxHeight = null;
      sortButtons.classList.remove('show');
    } else {
      // 開く
      sortButtons.style.maxHeight = sortButtons.scrollHeight + "px";
      sortButtons.classList.add('show');
    }
  });
});