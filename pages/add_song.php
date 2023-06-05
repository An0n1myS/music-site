<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "music_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Запрос на получение списка исполнителей из базы данных
$artist_query = "SELECT * FROM artists";
$artist_result = $conn->query($artist_query);

// Запрос на получение списка жанров из базы данных
$genre_query = "SELECT * FROM genres";
$genre_result = $conn->query($genre_query);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Додати пісню</title>
    <link rel="stylesheet" href="static/css/add_song.css">
</head>
<body class="add-song-file">
    <h1 style="text-align: center;">Додати пісню</h1>
    <form class="add-song-form" method="post" action="static/php/add-song-script.php">
        <label>Назва пісні:</label><br>
        <input type="text" name="title"><br><br>
        <label>Виконавець:</label><br>
        <select name="artist_id">
            <?php
            if ($artist_result->num_rows > 0) {
                while ($row = $artist_result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                }
            }
            ?>
        </select><br><br>
        <label>Жанр:</label><br>
        <select name="genre_id">
            <?php
            if ($genre_result->num_rows > 0) {
                while ($row = $genre_result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                }
            }
            ?>
        </select><br><br>
        <label>Шлях до файлу:</label><br>
        <input type="text" name="path"><br><br>
        <input type="submit" value="Додати пісню">
    </form>
</body>
</html>

