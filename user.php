<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Benutzer"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

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
        <?php
        // SQL Statement LIKE userName SELECT
        // Suchfunktion
        $sql="SELECT firstName, lastName, email, telNr, mobilNr, branchName, street, houseNumber, stairs, door, postCode, city, country, sectorCode, roles.name AS roleName, user.objectID, budget
              FROM user
              LEFT JOIN roles
              ON user.rolesFID = roles.objectID";

        $statement=connectDB()->prepare($sql);
        $statement->bindParam(":suche", $suche);
        $statement->execute();
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-striped table-hover' id='shortTable'>";
        echo "<thead>";
        echo "<tr>";
            echo "<th>Bearbeiten</th>";
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
            echo "<th>Löschen</th>";
        echo "</tr>";
        echo "</thead>";

        while( $row=$statement->fetch() ) {
            echo "<tr>";
            echo "<td><a href='update_user.php?user=$row[objectID]'>bearbeiten</a></td>";
            echo "<td>$row[firstName]</td>";
            echo "<td>$row[lastName]</td>";
            echo "<td>$row[email]</td>";
            echo "<td>$row[roleName]</td>";
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
            echo "<td><a href='?delete=$row[objectID]'>löschen</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        ?>
    </div>
</div>

<?php include "include/page/bottom.php"; ?>