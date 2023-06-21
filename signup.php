<h2>Sign up</h2>

<p>
  <?php
  // připojení do databáze
  $connection = Connection();
  if (isset($_POST["submit"])) {
    AddFun();
  }
  ?>
</p>

<form action="" method="post">
  <div class="form-input">
    <input type="text" name="username" placeholder="Username">
  </div>
  <div class="form-input">
    <input type="text" name="fullname" placeholder="Full Name">
  </div>
  <div class="form-input">
    <input type="password" name="password" placeholder="Password">
  </div>
  <div class="form-input">
    <input type="password" name="repeat_password" placeholder="Repeat Password">
  </div>
  <div class="form-input">
    <input type="submit" name="submit" value="Sign up">
  </div>
</form>