<?php
if (isset($_SESSION["user_id"])) {

  $connection = Connection();

  $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
  $result = $connection->query($sql);
  $user = $result->fetch_assoc();
}

// Zachycení hodnoty psa
if (isset($_GET["dog_id"])) {
  $dog_id = $_GET["dog_id"];
}

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
  // Zachycení psího jména
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

?>
<h3>Delete Doggo</h3>
<p>Do You Really Want to Delete Doggo "
  <?php echo $dog_name; ?>"?
</p>
<form action="" method="post">
  <input class="button-input" type="submit" name="delete" value="Delete">
  <input class="button-input" type="submit" name="go_back" value="Go Back">
</form>