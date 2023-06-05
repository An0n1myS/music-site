<?php
session_start();

if (isset($_POST['logout'])) {
  // удаляем данные сессии
  session_unset();
  session_destroy();
  
  // перенаправляем на главную страницу
  header("Location: /home");
  exit();
}
?>
