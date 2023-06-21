<?php
session_start();

if (isset($_GET["dog_id"])) {

  $dog_id = $_GET["dog_id"];

  // Připojení k databázi
  include "db.php";
  $connection = Connection();

  $sql = "SELECT dog_id FROM dogs WHERE dog_owner_id = ?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("s", $_SESSION['user_id']);
  $stmt->execute();
  $result = $stmt->get_result();

  // Kontrola, zda je uživatel povolený
  if ($result->num_rows > 0) {

    $dogFound = false;
    while ($row = $result->fetch_assoc()) {
      if ($row['dog_id'] == $dog_id) {
        $dogFound = true;
        break;
      }
    }
    if ($dogFound) {

      // Výběr dat z databáze na odstranění a exekuce
      $query = "DELETE FROM dogs WHERE dog_id=?";
      $stmt = $connection->prepare($query);
      $stmt->bind_param("i", $dog_id);
      $stmt->execute();

      if ($stmt->affected_rows > 0) {

        $_SESSION["delete"] = "Doggo Deleted Sucessfully.";
        header("Location: index.php?sid=my-doggos");

      } else {

        $_SESSION["delete_fail"] = "Failed to Delete Doggo.";
        header("Location: index.php?sid=my-doggos");

      }

    } else {
      $_SESSION["unauthorized_entry"] = "What Are You Trying To Do?";
      header("Location: index.php?sid=home");
    }
  } else {
    $_SESSION["delete_fail2"] = "Something Went Wrong... Please Try Again.";
    header("Location: index.php?sid=my-doggos");
  }
} else {
  header("Location: index.php?sid=my-doggos");
}
?>