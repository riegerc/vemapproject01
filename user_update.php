<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = true;

// defines the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 0;

// includes base function like session handling
include "include/init.php";

// defines the name of the current page, displayed in the title and as a header on the page
$title = "User Update";
include "include/page/top.php";
$suche="%%";
if(isset($_GET["delete"])){
    $sql="DELETE FROM user 
                WHERE objectID = :user";
    $statement=connectDB()->prepare($sql);
    $statement->bindParam(":user", $_GET["delete"]);
    $statement->execute();
}
if(isset($_GET["update"])) {

}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <label for="userName">Username:
                <input type="text" name="userName" id="userName">
            </label>
            <br>
<!--            -->
<!--            <label for="userRole">Role:-->
<!--                <select name="userRole" id="userRole">-->
<!--                    --><?php
//                    $sql="SELECT name FROM roles";
//                    $statement=connectDB()->query($sql);
//                    while($row=$statement->fetch()) {
//                        echo "<option>$row[name]</option>";
//                    }
//                    ?>
<!--                </select>-->
<!--            </label>-->
<!--            <br>-->
<!--            <label for="userRights">Rights:-->
<!--                <select name="userRights" id="userRights">-->
<!--                    --><?php
//                    $sql="SELECT name FROM rights";
//                    $statement=connectDB()->query($sql);
//                    while($row=$statement->fetch()) {
//                        echo "<option>$row[name]</option>";
//                    }
//                    ?>
<!--                </select>-->
<!--            </label>-->
<!--            -->
            <br>
            <button type="submit" name="suchen">Suchen</button>
        </form>
        <?php
        if( isset( $_GET["suchen"] ) ) {
            $suche="%". $_GET["userName"] ."%";
        }
            //output
            echo "hallo";
            // SQL Statement LIKE userName SELECT
            $sql="SELECT firstName, lastName, email, roles.name AS rolesName, user.objectID, postCode
            FROM user
            LEFT JOIN roles
            ON user.rolesFID = roles.objectID
            
            WHERE firstName LIKE :suche
            OR lastName LIKE :suche
            OR telNr LIKE :suche
            OR mobilNR LIKE :suche
            ";

            $statement=connectDB()->prepare($sql);
            $statement->bindParam(":suche", $suche);
            $statement->execute();
            echo "<table>";
                echo "<tr>";
                    echo "<th>firstName:</th>";
                    echo "<th>lastName:</th>";
                    echo "<th>Email:</th>";
                    echo "<th>PLZ:</th>";
                    echo "<th>role:</th>";
                    echo "<th>Bearbeiten</th>";
                    echo "<th>Löschen</th>";
                echo "</tr>";

            while( $row=$statement->fetch() ) {
                echo "<tr>";
                echo "<td>$row[firstName]</td>";
                echo "<td>$row[lastName]</td>";
                echo "<td>$row[email]</td>";
                echo "<td>$row[postCode]</td>";
                echo "<td>$row[rolesName]</td>";
                echo "<td><a href='?update=$row[objectID]'>bearbeiten</a></td>";
                echo "<td><a href='?delete=$row[objectID]'>löschen</a></td>";
                echo "</tr>";
            }
            echo "</table>";

        ?>
    </div>
</div>

<?php include "include/page/bottom.php"; ?>