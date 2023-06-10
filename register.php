<?php

// připojení do databáze
include "mysql/db.php";
Connection();
if (isset($_POST["submit"])) {
  AddFun();
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="styles.css"> <!-- Připojení externího CSS souboru -->
  <script src="script.js"></script> <!-- Připojení externího JavaScript souboru -->
</head>

<body>
  <form action="index.php" method="post">
    <input type="text" name="username" placeholder="Uživatelské jméno">
    <br>
    <input type="password" name="password" placeholder="Heslo">
    <br>
    <input type="submit" name="submit" placeholder="Odeslat">
  </form>

</body>

</html>