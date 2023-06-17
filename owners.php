<?php
include "db.php";
Connection();

$query = "SELECT fullname FROM users";
$result = mysqli_query($connection, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://classless.de/classless.css">
  <title>Doggos Association - List of Owners</title>
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

  <h3>List of Owners</h3>

  <div class="owner_list">
    <?php
    if ($result == true) {
      $count_rows = mysqli_num_rows($result);
      if ($count_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $fullname = $row["fullname"];
          echo $fullname . "<br>";
        }
      } else {
        echo "No owners found.";
      }
    } else {
      echo "Error executing query.";
    }
    ?>
  </div>

</body>

</html>