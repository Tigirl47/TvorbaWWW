<?php
//session_start();
//if (isset($_SESSION["user"])) {
//  header("Location:index.php");
//}
?>

<?php

// připojení do databáze
include "mysql/db.php";
Connection();
if (isset($_POST["submit"])) {
  AddFun();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://classless.de/classless.css">
  <title>Signup</title>
</head>


<body>
  <h1>Sign up</h1>
  <form action="signup.php" method="post">
    <div>
      <input type="text" name="username" placeholder="Username">
    </div>
    <div>
      <input type="text" name="fullname" placeholder="Full Name">
    </div>
    <div>
      <input type="password" name="password" placeholder="Password">
    </div>
    <div>
      <input type="password" name="repeat_password" placeholder="Repeat Password">
    </div>
    <div>
      <input type="submit" name="submit" value="Sign up">
    </div>
  </form>

</body>

</html>