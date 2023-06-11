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
    <link rel="stylesheet" href="https://classless.de/classless.css">
    <title>Doggos Association Homepage</title>
</head>

<body>

    <h1>Doggos Association</h1>
    <!-- Menu for user starts here-->
    <?php if (isset($user)): ?>
        <p>Hello
            <?= htmlspecialchars($user["fullname"]) ?>
        </p>
        <p><a href="logout.php">Log out</a></p>
        <p><a href="my_doggos.php">My Doggos</a></p>
    <?php else: ?>
        <p><a href="login.php">Log in</a> or <a href="signup.php">sign up</a></p>
    <?php endif; ?>
    <!-- Menu for user ends here -->

    <!-- Menu starts here -->
    <div class="menu">
        <a href="index.php">Home</a>
        <a href="#">List of Owners</a>
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
            <?php
            // Zobrazení dat z databáze psů
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
                                <?php echo "Majitel" ?>
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
    <!-- Table with ends here -->

</body>

</html>