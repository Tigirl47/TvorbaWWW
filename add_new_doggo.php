<?php
session_start();
if (isset($_SESSION["user_id"])) {
  $owner_id = $_SESSION["user_id"];
  echo "Jooooooo";
}

?>

<?php

// Zachycení údajů a vložení do proměnných
if (isset($_POST["add_dog"])) {
  $dog_name = $_POST["dog_name"];
  $dog_breed = $_POST["dog_breed"];
  $dog_age = $_POST["dog_age"];
  $dog_origin = $_POST["dog_origin"];
  $dog_description = $_POST["dog_description"];

  // Připojení k databázi
  include "db.php";
  Connection();

  // Přiřazení údajů do kolonek databáze
  $query = "INSERT INTO dogs (dog_name, dog_breed, dog_age, dog_origin, dog_description, dog_owner_id) 
          VALUES ('$dog_name', '$dog_breed', '$dog_age', '$dog_origin', '$dog_description', '$owner_id')";

  $result = mysqli_query($connection, $query);

  if ($result == true) {
    $_SESSION["add"] = "Doggo Added Successfully.";
    header('Location:my_doggos.php');
  } else {
    $_SESSION["add_fail"] = "Failed to Add Doggo.";
    header('Location:add_new_doggo.php');
  }
}

?>

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://classless.de/classless.css">
  <title>Doggos Association - My Doggos</title>
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

  <h3>Add a New Doggo</h3>

  <p>
    <?php
    if (isset($_SESSION["add_fail"])) {
      echo $_SESSION["add_fail"];
      unset($_SESSION["add_fail"]);
    }
    ?>
  </p>

  <!-- Form to add new dogs starts here -->
  <div>
    <form action="" method="post">
      <table>
        <tr>
          <td>Name:</td>
          <td><input type="text" name="dog_name" placeholder="Name" required="required" /></td>
        </tr>
        <tr>
          <td>Breed:</td>
          <td><input type="text" name="dog_breed" placeholder="Breed" required="required" /></td>
        </tr>
        <tr>
          <td>Age:</td>
          <td>
            <select name="dog_age" required="required">
              <option value="" selected disabled>Select Age</option>
              <?php
              // Generování možností pro věk psa (například od 1 do 20 let)
              for ($age = 1; $age <= 50; $age++) {
                echo "<option value=\"$age\">$age</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Place of origin:</td>
          <td><input type="text" name="dog_origin" placeholder="Place of Origin" required="required" /></td>
        </tr>
        <tr>
          <td>Description:</td>
          <td><textarea name="dog_description" placeholder="Description (Optional)"></textarea></td>
        </tr>
        <tr>
          <td><input type="submit" name="add_dog" Value="Add Doggo"></td>
        </tr>
      </table>
  </div>
  <!-- Form to add new dogs ends here -->
</body>