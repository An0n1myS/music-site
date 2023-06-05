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

// Обработка отправки формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $title = $_POST["title"];
    $artist_id = $_POST["artist_id"];
    $genre_id = $_POST["genre_id"];
    $path = addslashes($_POST["path"]); // экранирование специальных символов в строке

    // Запрос на добавление песни в базу данных
    $song_query = "INSERT INTO `music` (title, artist_id, genre_id, path) VALUES ('$title', $artist_id, $genre_id, '$path')";
    
    if ($conn->query($song_query) === TRUE) {
        // Если запрос выполнен успешно, переадресация на страницу home
        header("Location: /");
        exit();
    } else {
        // Если произошла ошибка, вывод ее сообщения
        echo "Error: " . $song_query . "<br>" . $conn->error;
    }
}

$conn->close();
?>
