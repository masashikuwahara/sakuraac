function showAllSongs() {
  document.querySelectorAll('.song-item').forEach(item => {
    item.style.display = 'list-item';
  });
}

function showCenterSongs() {
  document.querySelectorAll('.song-item').forEach(item => {
    if (item.classList.contains('center-song')) {
      item.style.display = 'list-item';
    } else {
      item.style.display = 'none';
    }
  });
}