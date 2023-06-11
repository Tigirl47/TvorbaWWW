<?php
session_start();
?>

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://classless.de/classless.css">
  <title>My Doggos</title>
</head>

<body>

  <h1>Doggos Association</h1>

  <!-- Menu starts here -->
  <div class="menu">
    <a href="index.php">Home</a>

    <a href="#">List of Owners</a>
    <a href="my_doggos.php">My Doggos</a>
  </div>
  <!-- Menu ends here -->
  <h3>My Doggies</h3>

  <p>
    <?php
    // Kontrola session pro přidání psa
    if (isset($_SESSION["add"])) {
      echo $_SESSION["add"];
      unset($_SESSION["add"]);
    }
    // Kontrola session pro odstranění psa
    if (isset($_SESSION["delete"])) {
      echo $_SESSION["delete"];
      unset($_SESSION["delete"]);
    }
    // Kontrola session pro updatování psa
    if (isset($_SESSION["update"])) {
      echo $_SESSION["update"];
      unset($_SESSION["update"]);
    }
    if (isset($_SESSION["delete_fail"])) {
      echo $_SESSION["delete_fail"];
      unset($_SESSION["delete_fail"]);
    }
    if (isset($_SESSION["delete_fail2"])) {
      echo $_SESSION["delete_fail2"];
      unset($_SESSION["delete_fail2"]);
    }
    ?>
  </p>
  <!-- Table with my dogs starts here -->
  <div class="my_dog_table">
    <a href="add_new_doggo.php">Add New Doggie</a>
    <table>
      <tr>
        <th>Name</th>
        <th>Breed</th>
        <th>Age</th>
        <th>Origin</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>

      <?php
      // Připojení k databázi
      include "mysql/db.php";
      Connection();
      // Zobrazení dat z databáze
      $query = "SELECT * FROM dogs";
      $result = mysqli_query($connection, $query);

      if ($result == true) {
        $count_rows = mysqli_num_rows($result);
        if ($count_rows > 0) {

          while ($row = mysqli_fetch_assoc($result)) {
            $dog_name = $row["dog_name"];
            $dog_breed = $row["dog_breed"];
            $dog_age = $row["dog_age"];
            $dog_origin = $row["dog_origin"];
            $dog_description = $row["dog_description"];
            $dog_id = $row["dog_id"];
            ?>
            <tr>
              <td>
                <?php echo $dog_name ?>
              </td>
              <td>
                <?php echo $dog_breed ?>
              </td>
              <td>
                <?php echo $dog_age ?>
              </td>
              <td>
                <?php echo $dog_origin ?>
              </td>
              <td>
                <?php echo $dog_description ?>
              </td>
              <td>
                <a href="update.php?dog_id=<?php echo $dog_id; ?>">Update</a>
                <a href="deletequestion.php?dog_id=<?php echo $dog_id; ?>">Delete</a>
              </td>
            </tr>
            <?php
          }
        } else {
          ?>
          <tr>
            <td colspan="3">No Doggo Added Yet.</td>
          </tr>
          <?php
        }
      }
      ?>
    </table>
  </div>
  <!-- Table with my dogs ends here -->

</body>

</html>