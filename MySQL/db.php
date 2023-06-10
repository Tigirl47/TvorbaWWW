<?php
// připojení do databáze
function Connection()
{
  global $connection;
  $connection = mysqli_connect("localhost", "root", "", "loginapplication");

  if ($connection) {
    echo "Jsme připojení s databází";
  } else {
    die("Něco se pokazilo");
  }
}

// Přidání dat do databáze
function AddFun()
{
  global $connection;
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Escapování inputů
  $username = mysqli_real_escape_string($connection, $username);
  $password = mysqli_real_escape_string($connection, $password);

  // Hashování hesla
  $hashFormat = "$2y$10$";
  $salt = "D4uhLk3avQDCvb08GVtBay";
  $hashFormat_salt = $hashFormat . $salt;
  $password = crypt($password, $hashFormat_salt);

  // Uložení dat do databáze
  $query = "INSERT INTO users(username,password) VALUES('$username','$password')";

  $result = mysqli_query($connection, $query);

  if (!$result) {
    die("Nepodařilo se data zapsat do databáze.");
  }
}
?>