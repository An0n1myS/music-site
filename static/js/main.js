
function open_like_modal(music_id) {

  var likeButtons = document.querySelectorAll('.like-button');
  var closeBtn = document.querySelector('.close');
  var modalAddToPlaylist = document.querySelector("modal-" + music_id);

  likeButtons.forEach(function(likeButton) {
    likeButton.addEventListener('click', function() {
      modalAddToPlaylist.style.display = 'block';
    });
  });

  closeBtn.addEventListener('click', function() {
    modalAddToPlaylist.style.display = 'none';
  });

}


function open_playlist_modal() {  

  var addButtons = document.querySelectorAll('.new-playlist-button');
  var closeBtn = document.querySelector('.close-2');
  var modalAddPlaylist = document.querySelector('.modal-02');

  addButtons.forEach(function(addButton) {
    addButton.addEventListener('click', function() {
      modalAddPlaylist.style.display = 'block';
    });
  });


  closeBtn.addEventListener('click', function() {
    modalAddPlaylist.style.display = 'none';
  });

}

function search_content() {
  var searchValue = document.querySelector('input[name="search"]').value;
  var matches = document.querySelectorAll('.song .song-title');
  var matchFound = false;
  for (var i = 0; i < matches.length; i++) {
    if (matches[i].innerHTML.includes(searchValue)) {
      var songDiv = matches[i].closest('.song');
      var songDivRect = songDiv.getBoundingClientRect();
      var halfWindowHeight = window.innerHeight / 2;
      var songDivCenterY = songDivRect.top + (songDivRect.height / 2);
      var scrollToY = songDivCenterY - halfWindowHeight;
      window.scrollTo(0, scrollToY);
      matchFound = true;
      break;
    }
  }
  if (!matchFound) {
    alert('Совпадения не найдены');
  }
}


