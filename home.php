<h2>List of Doggos</h2>

<table class="table">
    <tr>
        <th>Name</th>
        <th>Breed</th>
        <th>Age</th>
        <th>Origin</th>
        <th>Description</th>
        <th>Owner</th>
    </tr>
    <?php
    // Zobrazení dat z databáze psů
    $connection = Connection();
    $query = "SELECT dogs.*, users.fullname AS owner_name
          FROM dogs
          LEFT JOIN users ON dogs.dog_owner_id = users.id";
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
                $dog_owner = $row["owner_name"];
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
                        <?php echo $dog_owner ?>
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
    ?>
</table>