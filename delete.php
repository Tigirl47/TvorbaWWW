<?php
session_start();

if (isset($_GET["dog_id"])) {

  $dog_id = $_GET["dog_id"];

  // Připojení k databázi
  include "mysql/db.php";
  Connection();

  // Výběr dat z databáze na odstranění a exekuce
  $query = "DELETE FROM dogs WHERE dog_id=?";
  $stmt = $connection->prepare($query);
  $stmt->bind_param("i", $dog_id);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {

    $_SESSION["delete"] = "Doggo Deleted Sucessfully.";
    header("Location: my_doggos.php");

  } else {

    $_SESSION["delete_fail"] = "Failed to Delete Doggo.";
    header("Location: my_doggos.php");

  }

} else {
  header("Location: my_doggos.php");
}
?>