<h2>My Doggos</h2>

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

<p>
  <a href="index.php?sid=add-new-doggo" class="button-link">Add New Doggo</a>
</p>

<table class="table">
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
  $connection = Connection();
  // Zobrazení dat z databáze
  if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $query = "SELECT * FROM dogs WHERE dog_owner_id = '$user_id'";
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
              <a href="index.php?sid=update&dog_id=<?php echo $dog_id; ?>" class="button-link">Update</a>
              <a href="index.php?sid=delete&dog_id=<?php echo $dog_id; ?>" class="button-link">Delete</a>
            </td>
          </tr>
          <?php
        }
      } else {
        ?>
        <tr>
          <td colspan="6">No Doggo Added Yet.</td>
        </tr>
        <?php
      }
    }
  }
  ?>
</table>