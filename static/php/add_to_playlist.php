<?php
if (isset($_POST["add_to_playlist_button"])) {
  $music_id = $_POST["music_id"];
  $user_id = $_POST["user_id"];
  $playlist_id = $_POST["playlist_id"];


  // Подключаемся к базе данных
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "music_database";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Проверка наличия песни в плейлисте
  $check_query = "SELECT * FROM playlist_music WHERE playlist_id = $playlist_id AND music_id = $music_id";
  $check_result = $conn->query($check_query);
  if ($check_result->num_rows > 0) {
    // Выводим уведомление, если песня уже есть в плейлисте
    echo ("<script>alert('Пісня вже додана до цього плейліста');</script>");
  } else {
    // Добавление песни в плейлист в базу данных
    $sql = "INSERT INTO playlist_music (playlist_id, music_id) VALUES ('$playlist_id', '$music_id')";
    if ($conn->query($sql) === TRUE) {
      header("Location: /");
      exit();
    } else {
      echo "Помилка при додаванні пісні до плейліста: " . $conn->error;
      header("Location: /");
      exit();
    }
  }
}

?>
