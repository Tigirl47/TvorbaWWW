<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Připojení do databáze
  include "db.php";
  Connection();

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
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://classless.de/classless.css">
  <title>Login</title>
</head>

<body>

  <h1>Login</h1>

  <?php if ($is_invalid): ?>
    <em>Invalid login</em>
  <?php endif; ?>

  <div>
    <form action="login.php" method="post">
      <div>
        <input type="text" name="username" placeholder="Username">
      </div>
      <div>
        <input type="password" name="password" placeholder="Password">
      </div>
      <div>
        <input type="submit" value="Login" name="login">
      </div>
    </form>
  </div>
</body>

</html>