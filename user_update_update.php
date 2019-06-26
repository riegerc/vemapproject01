<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 1; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = "User Update Update"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php";


?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get"><br>
            <?php
            if(isset($_GET["user"])) {
            $sql="SELECT * FROM user
            WHERE objectID = :user";
            /*$param = array(":user"=>$_GET["user"]);
            $row=readDB($sql, $param);*/

            $statement=connectDB()->prepare($sql);
            $statement->bindParam(":user", $_GET["user"]);
            $statement->execute();

            if(isset($_GET["senden"])){

            }
            }
            ?>
            <label for="firstName">Vorname : <input type="text" name="firstName" id="firstName"></label><br>
            <label for="lastName">Nachname : <input type="text" name="lastName" id="lastName"></label><br>
            <label for="role">Rolle : <input type="text" name="role" id="role"></label><br>
            <label for="email">Email : <input type="text" name="email" id="email"></label><br>
            <label for="telNr">telephone : <input type="text" name="telNr" id="telNr"></label><br>
            <label for="mobilNr">mobile : <input type="text" name="mobilNr" id="mobilNr"></label><br>
            <label for="branchName">Filiale : <input type="text" name="branchName" id="branchName"></label><br>
            <label for="street">Straße : <input type="text" name="street" id="street"></label><br>
            <label for="houseNumber">Haus nr. : <input type="text" name="houseNumber" id="houseNumber"></label><br>
            <label for="stairs">Stiege : <input type="text" name="stairs" id="stairs"></label><br>
            <label for="door">Tür : <input type="text" name="door" id="door"></label><br>
            <label for="postCode">PLZ : <input type="text" name="postCode" id="postCode"></label><br>
            <label for="city">Stadt : <input type="text" name="city" id="city"></label><br>
            <label for="country">Land : <input type="text" name="country" id="country"></label><br>
            <label for="sectorCode">Sektor : <input type="text" name="sectorCode" id="sectorCode"></label><br>

            <?php
            while( $row=$statement->fetch() ) {
                echo "User: $row[email]";
                echo "<br>";
                echo "<td>$row[firstName]</td>";
                echo "<td>$row[lastName]</td>";
                echo "<td>$row[email]</td>";
                echo "<td>$row[rolesFID]</td>";
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
                echo "<br>";
            }
            ?>
            <button type="submit" name="senden">Senden</button>
        </form>
    </div>
</div>

<?php include "include/page/bottom.php"; ?>
