<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = false;

// defines the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned

// includes base function like session handling
include "include/init.php";

// defines the name of the current page, displayed in the title and as a header on the page
$title = "Benutzer";
include "include/page/top.php";
$suche="%%";
if(isset($_GET["delete"])){
    $sql="DELETE FROM user 
                WHERE objectID = :user";
    $statement=connectDB()->prepare($sql);
    $statement->bindParam(":user", $_GET["delete"]);
    $statement->execute();
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <label for="userName">Suche:
                <input type="text" name="userName" id="userName">
            </label>
            <button type="submit" name="suchen">Suchen</button>
            <br>
            <a href="create_user.php">Neuer Benutzer</a>
        </form>

        <?php
        if( isset( $_GET["suchen"] ) ) {
            $suche="%". $_GET["userName"] ."%";
        }
        // SQL Statement LIKE userName SELECT
        // Suchfunktion
        $sql="SELECT firstName, lastName, email, telNr, mobilNr, branchName, street, houseNumber, stairs, door, postCode, city, country, sectorCode, roles.name AS rolesName, user.objectID, budget
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
                echo "<th>Vorname:</th>";
                echo "<th>Nachname:</th>";
                echo "<th>Email:</th>";
                echo "<th>role:</th>";
                echo "<th>Budget:</th>";
                echo "<th>Telefon:</th>";
                echo "<th>Mobil:</th>";
                echo "<th>Filiale:</th>";
                echo "<th>Straße:</th>";
                echo "<th>Haus Nr.:</th>";
                echo "<th>Stiege:</th>";
                echo "<th>Tür:</th>";
                echo "<th>PLZ:</th>";
                echo "<th>Stadt:</th>";
                echo "<th>Land:</th>";
                echo "<th>Sektor:</th>";
                echo "<th>Bearbeiten</th>";
                echo "<th>Löschen</th>";
            echo "</tr>";

        while( $row=$statement->fetch() ) {
            echo "<tr>";
            echo "<td>$row[firstName]</td>";
            echo "<td>$row[lastName]</td>";
            echo "<td>$row[email]</td>";
            echo "<td>$row[rolesName]</td>";
            echo "<td>$row[budget]</td>";
            echo "<td>$row[telNr]</td>";
            echo "<td>$row[mobilNr]</td>";
            echo "<td>$row[branchName]</td>";
            echo "<td>$row[street]</td>";
            echo "<td>$row[houseNumber]</td>";
            echo "<td>$row[stairs]</td>";
            echo "<td>$row[door]</td>";
            echo "<td>$row[postCode]</td>";
            echo "<td>$row[city]</td>";
            echo "<td>$row[country]</td>";
            echo "<td>$row[sectorCode]</td>";
            echo "<td><a href='update_user.php?user=$row[objectID]'>bearbeiten</a></td>";
            echo "<td><a href='?delete=$row[objectID]'>löschen</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </div>
</div>

<?php include "include/page/bottom.php"; ?>