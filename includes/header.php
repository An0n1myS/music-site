<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Назва музичного сайту</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="static/css/log-reg-forms.css">
    <script src="static/js/main.js"></script>
  </head>
  <body>
    <header class="header">
      <nav class="header-nav">
        <ul>
          <li><a href="/">Головна</a></li>
          <li><a href="/genres">Жанри</a></li>
          <li><a href="/artists">Виконавці</a></li>
        </ul>
      </nav>
      <div class="search-header">
        <form action="#" method="get">
          <input type="text" name="search" placeholder="Пошук...">
          <button type="submit" onclick="event.preventDefault(); search_content();">Пошук</button>
        </form>
      </div>
      <?php if (isset($_SESSION['user_id'])) : ?>
        <?php
          // Создаем соединение с базой данных
          $mysqli = new mysqli("localhost", "root", "", "music_database");

          // Выполняем запрос на выборку данных, соответствующих аватару пользователя
          $query = "SELECT avatar FROM user WHERE id = ?";
          $stmt = $mysqli->prepare($query);
          $stmt->bind_param("i", $_SESSION['user_id']);
          $stmt->execute();
          $stmt->bind_result($avatar);
          $stmt->fetch();
          $stmt->close();
        ?>
        <div class='profile-header'>
          <?php if ($avatar !== null) : ?>
            <?php
              $avatar_base64 = base64_encode($avatar);
              echo "<a href='/profile'><img src='data:image/jpeg;base64," . $avatar_base64 . "' alt='Аватар користувача'></a>";
            ?>
          <?php else : ?>
            Аватар не знайдено
          <?php endif; ?>
          <form action='static/php/exit.php' method='post'>
            <button type='submit' name='logout'>Вийти</button>
          </form>
        </div>
      <?php else : ?>
        <div class='auth-header'>
          <a href='/login'> Авторизація</a>
          <a href='/register'> Реєстрація</a>
        </div>
      <?php endif; ?>
    </header>

