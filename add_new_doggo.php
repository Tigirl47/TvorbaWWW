<?php
if (isset($_SESSION["user_id"])) {
  $owner_id = $_SESSION["user_id"];
}
?>

<?php
// Zachycení údajů a vložení do proměnných
if (isset($_POST["add_dog"])) {
  $dog_name = mysqli_real_escape_string($connection, $_POST["dog_name"]);
  $dog_breed = mysqli_real_escape_string($connection, $_POST["dog_breed"]);
  $dog_age = mysqli_real_escape_string($connection, $_POST["dog_age"]);
  $dog_origin = mysqli_real_escape_string($connection, $_POST["dog_origin"]);
  $dog_description = mysqli_real_escape_string($connection, $_POST["dog_description"]);

  // Připojení k databázi
  $connection = Connection();

  // Přiřazení údajů do kolonek databáze
  $query = "INSERT INTO dogs (dog_name, dog_breed, dog_age, dog_origin, dog_description, dog_owner_id) 
          VALUES ('$dog_name', '$dog_breed', '$dog_age', '$dog_origin', '$dog_description', '$owner_id')";

  $result = mysqli_query($connection, $query);

  if ($result == true) {
    $_SESSION["add"] = "Doggo Added Successfully.";
    header('Location: index.php?sid=my-doggos');
  } else {
    $_SESSION["add_fail"] = "Failed to Add Doggo.";
    header('Location: index.php?sid=add-new-doggo');
  }
}
?>

<h2>Add a New Doggo</h2>

<p>
  <?php
  if (isset($_SESSION["add_fail"])) {
    echo htmlspecialchars($_SESSION["add_fail"]);
    unset($_SESSION["add_fail"]);
  }
  ?>
</p>

<form action="" method="post">
  <table class="form-table">
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
            echo "<option value=\"" . htmlspecialchars($age) . "\">$age</option>";
          }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>Place of Origin:</td>
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