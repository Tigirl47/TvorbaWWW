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
    echo "Please Fill in All the Fields.";
    return;
  }
  // Kontrola hesla, jestli je delší jak 6 znaků
  if (strlen($password) < 6) {
    echo "Password Must Be at Least 6 Characters Long.";
    return;
  }
  // Kontrola správně napsaného druhého hesla
  if ($password !== $passwordRepeat) {
    echo "Passwords Do Not Match.";
    return;
  }

  // Kontrola, zda uživatelské jméno již existuje v databázi
  $sql = "SELECT id FROM users WHERE username = ?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo "Username Already Exists. Please Choose a Different Username.";
    return;
  }

  // // Hashování hesla (Používáno zpočátku)
  // $hashFormat = "$2y$10$";
  // $salt = "D4uhLk3avQDCvb08GVtBay";
  // $hashFormat_salt = $hashFormat . $salt;
  // $passwordHash = crypt($password, $hashFormat_salt);

  // Hashování hesla
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Uložení dat do databáze
  $sql = "INSERT INTO users (fullname, username, password) VALUES (?, ?, ?)";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("sss", $fullname, $username, $hashed_password);

  if ($stmt->execute()) {
    header('Location: index.php?sid=signup-success');
  } else {
    die("Something Went Wrong (2)...");
  }
}
