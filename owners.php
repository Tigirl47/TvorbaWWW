<?php
// Připojení k databázi
$connection = Connection();
$query = "SELECT users.id AS user_id, fullname, GROUP_CONCAT(dog_name SEPARATOR ', ') AS dog_names FROM users LEFT JOIN dogs ON users.id = dogs.dog_owner_id GROUP BY users.id";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<h2>List of Owners</h2>
<p>Hover to See The Owner's Doggos!</p>
<?php
// Výpis všech majitelů s informacemi o jejich psech
if ($result == true) {
  $count_rows = mysqli_num_rows($result);
  if ($count_rows > 0) {
    echo '<ul class="owner-list">';
    while ($row = mysqli_fetch_assoc($result)) {
      $fullname = htmlspecialchars($row["fullname"]);
      $dogNames = htmlspecialchars($row["dog_names"]);
      echo '<li class="owner-list-item">';
      echo '<a onmouseover="showDogInfo(this)" onmouseout="hideDogInfo(this)">' . $fullname . '</a>';
      if (!empty($dogNames)) {
        echo '<div class="dog-info">' . $dogNames . '</div>';
      }
      echo '</li>';
    }
    echo '</ul>';
  } else {
    echo "No Owners Found.";
  }
} else {
  echo "Error Executing Query.";
}
?>

<script>
  // Skrytí všech informací o psech při načtení stránky
  var dogInfos = document.getElementsByClassName('dog-info');
  for (var i = 0; i < dogInfos.length; i++) {
    dogInfos[i].style.display = "none";
  }
  // Zobrazení psa při najetí kurzorem
  function showDogInfo(element) {
    var dogInfo = element.nextElementSibling;
    dogInfo.style.display = "block";
  }
  // Skrytí psa u nenajetého políčka
  function hideDogInfo(element) {
    var dogInfo = element.nextElementSibling;
    dogInfo.style.display = "none";
  }
</script>
