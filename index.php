<?php
session_start();

$pageIdx = isset($_GET['sid']) ? $_GET['sid'] : 0;

// Napojení se k databázi
include "db.php";
$connection = Connection();

$user = null;

if (isset($_SESSION["user_id"])) {
  $sql = "SELECT * FROM users WHERE id = ?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("i", $_SESSION["user_id"]);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Doggos Association</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <header class="header">
    <div>
      <img src="logo.png" alt="Logo" class="header-img">
    </div>
    <h1>Doggos Association</h1>
  </header>

  <nav>
    <!-- Menu -->
    <div class="topnav">
      <a href="index.php?sid=home">Home</a>
      <a href="index.php?sid=owners">List of Owners</a>
      <!-- Menu pro přihlášené -->
      <?php if (isset($user)): ?>
        <a href="index.php?sid=my-doggos">My Doggos</a>
        <a href="index.php?sid=logout">Log out</a>
        <a class="topnav logged">Logged in as
          <?= htmlspecialchars($user["fullname"]) ?>
        </a>
      <?php else: ?>
        <a href="index.php?sid=login">Log in</a> <a href="index.php?sid=signup">Sign up</a>
      <?php endif; ?>
      <!-- Konec menu pro přihlášené -->
    </div>
    <!-- Konec menu -->
  </nav>

  <main class="content">

    <?php
    renderDifferentPage($pageIdx);

    function renderDifferentPage($id)
    {
      switch ($id) {
        case "home":
          include("home.php");
          break;
        case "owners":
          include("owners.php");
          break;
        case "my-doggos":
          include("my_doggos.php");
          break;
        case "login":
          include("login.php");
          break;
        case "signup":
          include("signup.php");
          break;
        case "logout":
          include("logout.php");
          break;
        case "signup-success":
          include("signup_success.php");
          break;
        case "add-new-doggo":
          include("add_new_doggo.php");
          break;
        case "update":
          include("update.php");
          break;
        case "delete":
          include("deletequestion.php");
          break;
        default:
          //handling 404 error and render 404 page
          include("home.php");
      }
    }
    ?>
  </main>
  <div class="footer">
    Autor - Karolína Kunovjánková, 2023
  </div>
</body>

</html>