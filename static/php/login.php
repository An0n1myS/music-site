<?php
session_start();

if (isset($_POST['login'])) {
    // получаем данные из формы и подключаемся к БД
    $username = $_POST['username'];
    $password = $_POST['password'];
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "music_database";
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    // проверяем подключение к БД
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // готовим запрос на поиск пользователя в БД
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) { // проверяем, что было найдено ровно 1 пользователь
        // Если запрос выполнен успешно, переадресация на страницу home
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];
        $username = $row['username'];
        $email = $row['email'];
        $avatar = $row['avatar'];
        // сохраняем данные пользователя в сессии
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['avatar'] = $avatar;
        // перенаправление на страницу home
        header("Location: /");
        exit;
    } else {
        echo "Неверное имя пользователя или пароль";
    }

    mysqli_close($conn);
}
