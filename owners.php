<?php
//Připojení k databázi
$connection = Connection();
$query = "SELECT fullname FROM users";
$result = mysqli_query($connection, $query);
?>

<h2>List of Owners</h2>

<?php
// Výpis všech "fullname" z databáze
if ($result == true) {
  $count_rows = mysqli_num_rows($result);
  if ($count_rows > 0) {
    echo '<ul class="owner-list">';
    while ($row = mysqli_fetch_assoc($result)) {
      $fullname = $row["fullname"];
      echo '<li class="owner-list-item"><a>' . $fullname . '</a></li>';
    }
    echo '</ul>';
  } else {
    echo "No Owners Found.";
  }
} else {
  echo "Error Executing Query.";
}
?>