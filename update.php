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
        $dog_breed = $row["dog_breed"];
        $dog_age = $row["dog_age"];
        $dog_origin = $row["dog_origin"];
        $dog_description = $row["dog_description"];
      }

      if (isset($_POST["update"])) {

        $dog_name = mysqli_real_escape_string($connection, $_POST["dog_name"]);
        $dog_breed = mysqli_real_escape_string($connection, $_POST["dog_breed"]);
        $dog_age = mysqli_real_escape_string($connection, $_POST["dog_age"]);
        $dog_origin = mysqli_real_escape_string($connection, $_POST["dog_origin"]);
        $dog_description = mysqli_real_escape_string($connection, $_POST["dog_description"]);

        // Připojení do databáze
        $connection = Connection();

        // Přiřazení údajů do kolonek databáze
        $query = "UPDATE dogs SET dog_name=?, dog_breed=?, dog_age=?, dog_origin=?, dog_description=? WHERE dog_id=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sssssi", $dog_name, $dog_breed, $dog_age, $dog_origin, $dog_description, $dog_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
          $_SESSION["update"] = "Doggo Updated Successfully.";
          header("Location: index.php?sid=my-doggos");
        } else {
          $_SESSION["update_fail"] = "Failed to Update Doggo.";
          header("Location: index.php?sid=update&dog_id=$dog_id");
        }
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

<h3>Update Doggo</h3>

<p>
  <?php
  if (isset($_SESSION["update_fail"])) {
    echo htmlspecialchars($_SESSION["update_fail"]);
    unset($_SESSION["update_fail"]);
  }
  ?>
</p>

<form action="" method="post">
  <table class="form-table">
    <tr>
      <td>Name:</td>
      <td><input type="text" name="dog_name" value="<?php echo htmlspecialchars($dog_name) ?>" required="required" />
      </td>
    </tr>
    <tr>
      <td>Breed:</td>
      <td><input type="text" name="dog_breed" value="<?php echo htmlspecialchars($dog_breed) ?>" required="required" />
      </td>
    </tr>
    <tr>
      <td>Age:</td>
      <td>
        <select name="dog_age" required="required">
          <option value="" selected disabled>Select Age</option>
          <?php
          // Generování možností pro věk psa
          for ($age = 1; $age <= 50; $age++) {
            $selected = ($age == $dog_age) ? "selected" : ""; // Porovnání s hodnotou pro předvyplnění
            echo "<option value=\"$age\" $selected>$age</option>";
          }
          ?>
        </select>
      </td>
    </tr>
    <td>Place of Origin:</td>
    <td><input type="text" name="dog_origin" value="<?php echo htmlspecialchars($dog_origin) ?>" required="required" />
    </td>
    </tr>
    <tr>
      <td>Description:</td>
      <td><textarea name="dog_description"><?php echo htmlspecialchars($dog_description) ?></textarea></td>
    </tr>
    <tr>
      <td><input type="submit" name="update" Value="Update Doggo"></td>
    </tr>
  </table>
</form>
