<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Připojení do databáze
  $connection = Connection();

  // Kontrola, jestli je username v databázi
  $sql = sprintf(
    "SELECT * FROM users WHERE username = '%s'",
    $connection->real_escape_string($_POST["username"])
  );

  $result = $connection->query($sql);
  $user = $result->fetch_assoc();

  // Kontrola, jestli je heslo přiřazené k username
  if ($user) {

    if (password_verify($_POST["password"], $user["password"])) {

      session_start();
      session_regenerate_id();

      $_SESSION["user_id"] = $user["id"];
      header("Location: index.php");
      exit;
    }
  }
  $is_invalid = true;
}
?>

<h2>Login</h2>

<?php if ($is_invalid): ?>
  <em>Invalid Login</em>
<?php endif; ?>


<form action="" method="post">
  <div class="login-form-input">
    <input type="text" name="username" placeholder="Username">
  </div>
  <div class="login-form-input">
    <input type="password" name="password" placeholder="Password">
  </div>
  <div class="login-form-input">
    <input type="submit" value="Login" name="login">
  </div>
</form>