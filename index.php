<?php

session_start();

if (isset($_SESSION["user_id"])) {

    include "mysql/db.php";
    Connection();

    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";

    $result = $connection->query($sql);

    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doggos Association Homepage</title>
</head>

<body>

    <h1>Doggos Association</h1>

    <?php if (isset($user)): ?>
        <p>Hello
            <?= htmlspecialchars($user["fullname"]) ?>
        </p>
        <p><a href="logout.php">Log out</a></p>
    <?php else: ?>
        <p><a href="login.php">Log in</a> or <a href="signup.php">sign up</a></p>
    <?php endif; ?>

    <!-- Menu starts here -->
    <div class="menu">
        <a href="index.php">Home</a>

        <a href="#">List of Owners</a>
        <a href="my_doggies.php">My Doggies</a>
        <a href="login.php">Login</a>
        <a href="signup.php">Sign up</a>
    </div>
    <!-- Menu ends here -->

    <!-- Table starts here -->
    <div class="dog_table">
        <table>
            <tr>
                <th>Name</th>
                <th>Breed</th>
                <th>Age</th>
                <th>Origin</th>
                <th>Description</th>
                <th>Owners (ID)</th>
            </tr>
            <tr>
                <td>Jonášik</td>
                <td>Corgi</td>
                <td>3</td>
                <td>Maďarsko</td>
                <td>Veselý a poslušný</td>
                <td>Karolína</td>
            </tr>
        </table>
    </div>
    <!-- Table ends here -->

</body>

</html>