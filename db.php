<?php
// připojení do databáze
function Connection()
{
  global $connection;
  //$connection = mysqli_connect("sql5.webzdarma.cz", "doggoskunovj9512", "	.p7fT5y2C2iuyY2", "doggoskunovj9512");
  $connection = mysqli_connect("localhost", "root", "", "loginapplication");

  if (!$connection) {
    die("Something Went Wrong (1)...");
  }
  return $connection;
}

// Přidání dat do databáze
function AddFun()
{
  global $connection;
  $fullname = $_POST["fullname"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $passwordRepeat = $_POST["repeat_password"];

  // Kontrola polí, jestli jsou vyplněné
  if (empty($fullname) or empty($username) or empty($password) or empty($passwordRepeat)) {
    //array_push($errors, "All fields are required");
    echo "All Fields Are Required.";
    return;
  }
  // Kontrola hesla, jestli je delší jak 6 znaků
  if (strlen($password) < 6) {
    //array_push($errors, "Password must be at least 6 characters long");
    echo "Password Must Be at Least 6 Characters Long.";
    return;
  }
  // Kontrola správně napsaného druhého hesla
  if ($password !== $passwordRepeat) {
    //array_push($errors, "Password does not match");
    echo "Password Does Not Match.";
    return;
  }
  //Kontrola username, jestli už náhodou není v databázi
  if ($stmt = mysqli_prepare($connection, 'SELECT id, password FROM users WHERE username = ?')) {
    mysqli_stmt_bind_param($stmt, 's', $_POST['username']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
      echo "Username Already Exists. Try Again.";
      return;
    }
  }

  // Escapování inputů (proti sql injection)
  $fullname = mysqli_real_escape_string($connection, $fullname);
  $username = mysqli_real_escape_string($connection, $username);
  $password = mysqli_real_escape_string($connection, $password);

  // Hashování hesla
  $hashFormat = "$2y$10$";
  $salt = "D4uhLk3avQDCvb08GVtBay";
  $hashFormat_salt = $hashFormat . $salt;
  $passwordHash = crypt($password, $hashFormat_salt);

  // Uložení dat do databáze
  $query = "INSERT INTO users(fullname,username,password) VALUES(?,?,?)";
  $stmt = mysqli_stmt_init($connection);
  $prepareStmt = mysqli_stmt_prepare($stmt, $query);
  if ($prepareStmt) {
    mysqli_stmt_bind_param($stmt, "sss", $fullname, $username, $passwordHash);
    mysqli_stmt_execute($stmt);
    header('Location: index.php?sid=signup-success');
  } else {
    die("Something Went Wrong (2)...");
  }
}
?>