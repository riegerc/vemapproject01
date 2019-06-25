<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = true;
// defindes the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 0;
// includes base function like session handling
include "snippets/init.php";
// defindes the name of the current page, displayed in the title and as a header on the page
$title = "User Update";
include "snippets/header.php";
include "snippets/top.php";
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
            <label for="userRole">Role:
                <select name="userRole" id="userRole">
                    <?php
                    $sql="SELECT name FROM roles";
                    $statement=connectDB()->query($sql);
                    while($row=$statement->fetch()) {
                        echo "<option>$row[name]</option>";
                    }
                    ?>
                </select>
            </label>
            <br>
            <label for="userRights">Rights:
                <select name="userRights" id="userRights">
                    <?php
                    $sql="SELECT name FROM rights";
                    $statement=connectDB()->query($sql);
                    while($row=$statement->fetch()) {
                        echo "<option>$row[name]</option>";
                    }
                    ?>
                </select>
            </label>
            <br>
            <button type="submit" name="senden">Senden</button>
        </form>
        <?php
        if( isset( $_GET["senden"] ) ) {
            //output
            echo "hallo";
            // SQL Statement LIKE userName SELECT
            $sql="SELECT firstName, lastName, telNr, mobilNr, `roles`.name/*, `rights`.name*/
            FROM ams
            LEFT JOIN roles
            ON `roles`.objectID=`ams`.rolesFID
            LEFT JOIN rolesRights
            ON `rolesRights`.rolesFID=`roles`.objectID
            LEFT JOIN rights
            ON `rights`.objectID=`rolesRights`.rightsFID
            WHERE firstName LIKE :suche
            OR lastName LIKE :suche
            OR telNr LIKE :suche
            OR mobilNR LIKE :suche
            OR `roles`.name LIKE :suche
            ";
            $suche="%". $_GET["userName"] ."%";
            $statement=connectDB()->prepare($sql);
            $statement->bindParam(":suche", $suche);
            $statement->execute();
            echo "<table>";
                echo "<tr>";
                    echo "<th>firstName:</th>";
                    echo "<th>lastName:</th>";
                    echo "<th>telNr:</th>";
                    echo "<th>mobilNr:</th>";
                    echo "<th>role:</th>";
                    echo "<th>rights:</th>";
                echo "</tr>";
            while( $row=$statement->fetch() ) {
                echo "<tr>";
                echo "<td>$row[firstName]</td>";
                echo "<td>$row[lastName]</td>";
                echo "<td>$row[telNr]</td>";
                echo "<td>$row[mobilNr]</td>";
//                echo "<td>$row[roles.name]</td>";
                echo "<td>$row[name]</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    </div>
</div>
<?php include "snippets/bottom.php"; ?>
