
<div class="register-popup">
  <div class="register-form-container">
    <h2>Реєстрація користувача</h2>
    <form action="static/php/register.php" method="post" enctype="multipart/form-data">
      <label for="username">Логін користувача:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Пароль:</label>
      <input type="password" id="password" name="password" required>

      <label for="email">Пошта:</label>
      <input type="email" id="email" name="email" required>

      <label for="avatar">Аватар:</label>
      <input type="file" id="avatar" name="avatar" accept="image/*">

      <button type="submit" name="register">Зареєструватися</button>
    </form>
  </div>
</div>
