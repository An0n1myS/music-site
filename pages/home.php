<?php
// Підключення до бази даних
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "music_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Помилка підключення до бази даних: " . $conn->connect_error);
}

// Запит для отримання всіх пісень з бази даних
$music_query = "SELECT music.id, music.title, artists.name as artist_name, genres.name as genre_name, music.path, music.avatar FROM music INNER JOIN artists ON music.artist_id = artists.id INNER JOIN genres ON music.genre_id = genres.id";
$music_result = $conn->query($music_query);
$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/home.css">
    <title>Document</title>
</head>
<body style="margin-top:8%;">
  <div class="home-content">
    <div class="songs">
      <?php if ($music_result->num_rows > 0) {
        $num_music = 1;
        while ($row = $music_result->fetch_assoc()) {
          $music_id = $row["id"];
      ?>
          <div class="song">
            <div class="song-details">
              <div class="song-info">
                <p class="song-title"><b><?= $num_music ?>. &nbsp<?= $row["title"] ?></b></p>
                <p class="artist-name"><i><?= $row["artist_name"] ?></i></p>
              </div>
              <div class="audio-player">
                <audio controls><source src="../<?= $row["path"] ?>" type="audio/mpeg"></audio>
              </div>
              <div class="modal-content">
                <form method="post" action="static/php/add_to_playlist.php">
                <input type="hidden" name="music_id" value="<?= $music_id ?>">
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                <select name="playlist_id">
                  <?php
                  $playlist_query = "SELECT * FROM playlist WHERE user_id=$user_id";
                  $playlist_result = $conn->query($playlist_query);
                  if ($playlist_result->num_rows > 0) {
                    while ($playlist_row = $playlist_result->fetch_assoc()) {
                      echo "<option value='" . $playlist_row["id"] . "'>" . $playlist_row["name"] . "</option>";
                    }
                  } else {
                    echo "<option value='' disabled>У вас немає створених плейлистів</option>";
                  }
                  ?>
                </select>
                <input type="submit" name="add_to_playlist_button" value="&#129293">
              </form>
              </div>
              
            </div>
          </div>
      <?php
          $num_music++;
        }
      } else {
      ?>
        <div class="no-songs">Немає наявних пісень</div>
      <?php
      }
      ?>
    </div>
  </div>

<script src="static/js/main.js"></script>
</body>
</html>


