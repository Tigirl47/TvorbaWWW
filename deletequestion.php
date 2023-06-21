<?php

if (isset($_SESSION["user_id"])) {

  $connection = Connection();

  $user_id = $_SESSION["user_id"];
  $sql = "SELECT id FROM users WHERE id=?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
  } else {
    // Uživatel s daným ID neexistuje v databázi
    $_SESSION["delete_fail"] = "Something Went Wrong... Please Try Again. (1)";
    header("Location: index.php?sid=my-doggos");
    exit;
  }
}

// Zachycení id určitého psa
if (isset($_GET["dog_id"])) {
  $dog_id = $_GET["dog_id"];

  // Připojení k databázi
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

      // Připojení k databázi
      $connection = Connection();

      // Výběr dat z databáze na odstranění a exekuce
      $query = "SELECT * FROM dogs WHERE dog_id=?";
      $stmt = $connection->prepare($query);
      $stmt->bind_param("i", $dog_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dog_name = $row["dog_name"];
      } else {
        // Pes s daným ID neexistuje v databázi
        $_SESSION["delete_fail2"] = "Something Went Wrong... Please Try Again.";
        header("Location: index.php?sid=my-doggos");
        exit;
      }

      if (isset($_POST["delete"])) {
        header("Location: delete.php?dog_id=" . $dog_id);
      }
      if (isset($_POST["go_back"])) {
        header("Location: index.php?sid=my-doggos");
      }

    } else {
      $_SESSION["unauthorized_entry"] = "What Are You Trying To Do?";
      header("Location: index.php?sid=home");
    }

  } else {
    $_SESSION["unauthorized_entry"] = "What Are You Trying To Do?";
    header("Location: index.php?sid=home");
  }
}

?>
<h3>Delete Doggo</h3>
<p>Do You Really Want to Delete Doggo "
  <?php echo htmlspecialchars($dog_name); ?>"?
</p>
<form action="" method="post">
  <input class="button-input" type="submit" name="delete" value="Delete">
  <input class="button-input" type="submit" name="go_back" value="Go Back">
</form>