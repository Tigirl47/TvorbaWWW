<?php
session_start();

// zachycení id určitého psa
if (isset($_GET["dog_id"])) {
  $dog_id = $_GET["dog_id"];

  // Připojení k databázi
  include "db.php";
  Connection();

  $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
  $result = $connection->query($sql);
  $user = $result->fetch_assoc();
}

Connection();

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

  $dog_name = $_POST["dog_name"];
  $dog_breed = $_POST["dog_breed"];
  $dog_age = $_POST["dog_age"];
  $dog_origin = $_POST["dog_origin"];
  $dog_description = $_POST["dog_description"];
  // Připojení do databáze
  Connection();

  // Přiřazení údajů do kolonek databáze
  $query = "UPDATE dogs SET dog_name='$dog_name', dog_breed='$dog_breed', dog_age='$dog_age',
   dog_origin='$dog_origin', dog_description='$dog_description' WHERE dog_id='$dog_id'";
  // Provedení Query
  $result = mysqli_query($connection, $query);

  if ($result == true) {
    $_SESSION["update"] = "Doggo Updated Successfully.";
    header('Location:my_doggos.php');
  } else {
    $_SESSION["update_fail"] = "Failed to Update Doggo.";
    header('Location:update_doggo.php?dog_id=$dog_id');
  }
}

?>

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://classless.de/classless.css">
  <title>Doggos Association - Update</title>
</head>

<body>

  <h1>Doggos Association</h1>

  <!-- Menu starts here -->
  <div class="menu">
    <a href="index.php">Home</a>

    <a href="owners.php">List of Owners</a>
    <a href="my_doggos.php">My Doggos</a>
  </div>
  <!-- Menu ends here -->

  <h3>Update Doggo</h3>

  <p>
    <?php
    if (isset($_SESSION["update_fail"])) {
      echo $_SESSION["update_fail"];
      unset($_SESSION["update_fail"]);
    }
    ?>
  </p>

  <!-- Form to update dogs starts here -->
  <div>
    <form action="" method="post">
      <table>
        <tr>
          <td>Name:</td>
          <td><input type="text" name="dog_name" value="<?php echo $dog_name ?>" required="required" /></td>
        </tr>
        <tr>
          <td>Breed:</td>
          <td><input type="text" name="dog_breed" value="<?php echo $dog_breed ?>" required="required" /></td>
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
        <td>Place of origin:</td>
        <td><input type="text" name="dog_origin" value="<?php echo $dog_origin ?>" required="required" /></td>
        </tr>
        <tr>
          <td>Description:</td>
          <td><textarea name="dog_description"><?php echo $dog_description ?></textarea></td>
        </tr>
        <tr>
          <td><input type="submit" name="update" Value="Update Doggo"></td>
        </tr>
      </table>
  </div>
  <!-- Form to update dogs ends here -->
</body>