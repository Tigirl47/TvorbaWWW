<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Připojení do databáze
  $connection = Connection();

  // Kontrola, jestli je username v databázi
  $username = $connection->real_escape_string($_POST["username"]);
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  // Kontrola, jestli je heslo přiřazené k username
  if ($user) {

    $password = $_POST["password"];
    if (password_verify($password, $user["password"])) {

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
