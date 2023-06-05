<?php
$mysqli = new mysqli("localhost", "root", "", "music_database");

// Отримати список виконавців
$artists_query = "SELECT * FROM artists";
$artists_result = $mysqli->query($artists_query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Сторінка виконавців</title>
  <link rel="stylesheet" href="static/css/artists.css">
</head>
<body>
  <div class="container">
    <?php while ($artist = $artists_result->fetch_assoc()) { ?>
      <div class="artist">
        <h1><?= $artist['name'] ?></h1>
        <br>
        <?php
        // Отримати пісні для даного виконавця
        $artist_id = $artist['id'];
        $songs_query = "SELECT music.* FROM music 
                        INNER JOIN artists ON music.artist_id = artists.id
                        WHERE artists.id = ?";
        $songs_stmt = $mysqli->prepare($songs_query);
        $songs_stmt->bind_param("i", $artist_id);
        $songs_stmt->execute();
        $songs_result = $songs_stmt->get_result();
        ?>
        <div class="songs">
          <?php if ($songs_result->num_rows > 0) {
            while ($song = $songs_result->fetch_assoc()) {
          ?>
              <div class="song">
                <div class="song-details">
                  <div class="song-info">
                    <p class="song-title"><b><?= $song["title"] ?></b></p>
                    <p class="artist-name"><i><?= $song["artist_name"] ?></i></p>
                  </div>
                  <div class="audio-player">
                    <audio controls><source src="<?= $song["path"] ?>" type="audio/mpeg"></audio>
                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            echo "<div class='no-songs'>Нема наявних пісень для цього виконавця.</div>";
          }
          ?>
        </div>
      </div>
    <?php } ?>
  </div>
</body>
</html>
<?php
$mysqli->close();
?>