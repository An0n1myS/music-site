<?php
$mysqli = new mysqli("localhost", "root", "", "music_database");

// Отримати список жанрів
$genres_query = "SELECT * FROM genres";
$genres_result = $mysqli->query($genres_query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Сторінка жанрів</title>
  <link rel="stylesheet" href="static/css/genres.css">
</head>
<body>
  <div class="container">
    <?php while ($genre = $genres_result->fetch_assoc()) { ?>
      <div class="genre">
        <h3><?= $genre['name'] ?></h3>
        <?php
        // Отримати пісні для даного жанру
        $genre_id = $genre['id'];
        $songs_query = "SELECT music.* FROM music 
                        INNER JOIN artists ON music.artist_id = artists.id
                        INNER JOIN genres ON music.genre_id = genres.id
                        WHERE genres.id = ?";
        $songs_stmt = $mysqli->prepare($songs_query);
        $songs_stmt->bind_param("i", $genre_id);
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
            echo "<div class='no-songs'>Нема наявних пісень для цього жанру.</div>";
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
