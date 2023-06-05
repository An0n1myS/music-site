<div class="login-popup">
  <div class="login-form-container">
    <h2>Авторизація користувача</h2>
    <form action="static/php/login.php" method="POST">
      <label for="username">Ім'я користувача:</label><br>
      <input type="text" id="username" name="username" required><br>

      <label for="password">Пароль:</label><br>
      <input type="password" id="password" name="password" required><br>

      <button type="submit" name='login'class="login-btn">Увійти</button>
    </form>
  </div>
</div>