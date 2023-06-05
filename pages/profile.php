<?php
$mysqli = new mysqli("localhost", "root", "", "music_database");

$query = "SELECT * FROM user WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<link rel="stylesheet" href="static/css/profile.css">

<body>
  <div class="container">
    <div class="profile">
      <img class="profile-img" src="data:image/jpeg;base64,<?= base64_encode($user['avatar']) ?>" alt="Аватар пользователя">
      <h2 class="profile-username"> <?= $user['username'] ?></h2>
      <p class="profile-email">Пошта: <?= $user['email'] ?></p>
      <p class="profile-date">Дата реєстрації: <?= $user['created_at'] ?></p>
    </div>
    <div class="modal-content-2">
      <h3>Додати плейліст</h3>
      <form class="create_playlist_form" method="post" id="create_playlist_form" style="display:block">
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
        <input type="text" name="playlist_name" placeholder="Назва нового плейліста" required>
        <input type="submit" name="create_playlist" value="Створити плейліст">
      </form>
    </div>
    <div class="playlists">
      <h3>Список плейлистів користувача:</h3>
      <?php
      $user_id = $_SESSION['user_id'];
      $playlists_query = "SELECT * FROM playlist WHERE user_id = ?";
      $playlists_stmt = $mysqli->prepare($playlists_query);
      $playlists_stmt->bind_param("i", $user_id);
      $playlists_stmt->execute();
      $playlists_result = $playlists_stmt->get_result();
      while ($playlist = $playlists_result->fetch_assoc()) {
        $playlist_id = $playlist['id'];
        $playlist_name = $playlist['name'];
      ?>
        <div class="playlist">
          <h4><?= $playlist_name ?></h4>
          <?php
          $music_query = "SELECT music.* FROM music INNER JOIN playlist_music ON music.id = playlist_music.music_id WHERE playlist_music.playlist_id = ?";
          $music_stmt = $mysqli->prepare($music_query);
          $music_stmt->bind_param("i", $playlist_id);
          $music_stmt->execute();
          $music_result = $music_stmt->get_result();
          $num_music = 1;
          ?>
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
                    <form method="post">
                      <input type="hidden" name="music_id" value="<?= $row["id"] ?>">
                      <input type="hidden" name="user_id" value="<?= $user_id ?>">
                      <input type="hidden" name="playlist_id" value="<?= $playlist_id ?>">
                      <button class="delete-button" type="submit" name="delete_music_id" value="<?= $music_id ?>"> - </button>
                    </form>
                  </div>
                </div>
                <?php $num_music++;
              }
            } else { ?>
              <div class="no-songs">Нема наявних пісень.</div>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</body>

<?php
if (isset($_POST['delete_music_id'])) {
  $delete_music_id = $_POST['delete_music_id'];
  $delete_user_id = $_POST['user_id'];
  $delete_playlist_id = $_POST['playlist_id'];

  $delete_query = "DELETE FROM playlist_music WHERE music_id = ? AND playlist_id = ? AND playlist_id IN (SELECT id FROM playlist WHERE user_id = ?)";
  $delete_stmt = $mysqli->prepare($delete_query);
  $delete_stmt->bind_param("iii", $delete_music_id, $delete_playlist_id, $delete_user_id);
  $delete_stmt->execute();
  $delete_stmt->close();
}
if (isset($_POST["create_playlist"])) {
  $playlist_name = $_POST["playlist_name"];
  $user_id = $_POST["user_id"];

  // Валідація даних
  if (!empty($playlist_name)) {
    $existing_query = "SELECT * FROM playlist WHERE name = ? AND user_id = ?";
    $existing_stmt = $mysqli->prepare($existing_query);
    $existing_stmt->bind_param("si", $playlist_name, $user_id);
    $existing_stmt->execute();
    $existing_result = $existing_stmt->get_result();
    if ($existing_result->num_rows > 0) {
      echo "<script>alert('Плейліст з такою назвою уже існує');</script>";
    } else {
      // Додавання плейлиста до бази даних
      $create_query = "INSERT INTO playlist (name, user_id) VALUES (?, ?)";
      $create_stmt = $mysqli->prepare($create_query);
      $create_stmt->bind_param("si", $playlist_name, $user_id);
      if ($create_stmt->execute()) {
        echo "<script>alert('Плейліст успішно створено');</script>";
        header("Location: profile.php"); // Перенаправлення на профіль після створення плейлиста
        exit();
      } else {
        echo "<script>alert('Помилка при створенні плейлиста: " . $mysqli->error . "');</script>";
      }
    }
    $existing_stmt->close();
    $create_stmt->close();
  } else {
    echo "<script>alert('Назва плейлиста не може бути порожньою');</script>";
  }
}

$mysqli->close();
?>
