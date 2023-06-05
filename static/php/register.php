<?php
// Подключаемся к БД
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "music_database";
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Проверяем, что форма была отправлена
if (isset($_POST['register'])) {
  // Получаем данные из формы
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $avatar = $_FILES['avatar']['name'];
  $created_at = date("Y-m-d H:i:s");

  // Загружаем аватар пользователя на сервер
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $extensions_arr = array("jpg","jpeg","png","gif");
  if (in_array($imageFileType, $extensions_arr)) {
    move_uploaded_file($_FILES['avatar']['tmp_name'], $target_dir.$avatar);
  }

  // Добавляем данные в БД
  $sql = "INSERT INTO user (username, password, email, avatar, created_at)
          VALUES ('$username', '$password', '$email', '$avatar', '$created_at')";
  if ($conn->query($sql) === TRUE) {
    header("Location: /");
  } else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
  }

  // Закрываем соединение с БД
  $conn->close();
}
?>
