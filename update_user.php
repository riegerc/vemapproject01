<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Benutzerdaten ändern"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

if (isset($_POST["user"])) {
    $user = $_POST["user"];
} else {
    echo "Kein Benutzer ausgewählt";
}
if (isset($_POST["senden"])) {
    foreach ($_POST as $key => $value) {
        if ($key !== "") {
            if ($key == "user") {
                /*echo "UserID: $value";*/
            } elseif ($key == "rolesFID") {
                /*echo $value;*/
            } elseif ($key == "senden") {

            } //Budget ist integer also kein Leerstring erlaubt
            elseif ($key == "budget" AND $value == "") {

            } elseif ($key == "rolesFID") {
                $key = 0;
            } else {
                $sql = "UPDATE user
                SET $key=:param
                WHERE objectID=$user";

                $statement = connectDB()->prepare($sql);
                $statement->bindParam(":param", $value);
                $statement->execute();

                /*echo "$key : $value";*/
            }
        }

    }
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <a href='http://localhost/vemapproject01/user.php'>Zurück zur Übersicht</a>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php
            if (isset($_POST["user"])) {
                $sql = "SELECT * FROM user
                WHERE objectID = :user";
                $statement = connectDB()->prepare($sql);
                $statement->bindParam(":user", $user);
                $statement->execute();
                while ($row = $statement->fetch()) {
                    $fname = $row["firstName"];
                    $lname = $row["lastName"];

                    $role = $row["rolesFID"];

                    $email = $row["email"];
                    $budget = $row["budget"];
                    $tel = $row["telNr"];
                    $mobil = $row["mobilNr"];
                    $branch = $row["branchName"];
                    $street = $row["street"];
                    $house = $row["houseNumber"];
                    $stairs = $row["stairs"];
                    $door = $row["door"];
                    $post = $row["postCode"];
                    $city = $row["city"];
                    $country = $row["country"];
                    $sector = $row["sectorCode"];
                }
                ?>
                <div class="form-group">
                    <label for="firstName">Vorname</label>
                    <input class="form-control" type="text" name="firstName" id="firstName" value="<?php echo $fname; ?>"></label>
                </div>
                <div class="form-group">
                    <label for="lastName">Nachname</label>
                    <input class="form-control" type="text" name="lastName" id="lastName" value="<?php echo $lname; ?>"></label>
                </div>
                <div class="form-group">
                    <label for="rolesFID">Rolle</label>
                    <select name="rolesFID" class="form-control">
                        <?php
                        $sql = "SELECT DISTINCT * FROM roles";
                        $statement = connectDB()->prepare($sql);
                        $statement->execute();

                        while ($row = $statement->fetch()) {
                            $selected = "";
                            if ($row["objectID"] == $role) {
                                $selected = "selected";
                            }
                            //value=RoleID, inhalt ist RoleName
                            echo "<option value='$row[objectID]' $selected>$row[name]</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
                    <label for="budget">Budget</label>
                    <input class="form-control" type="number" name="budget" id="budget" value="<?php echo $budget; ?>">
                </div>
                <div class="form-group">
                    <label for="telNr">telephone</label>
                    <input class="form-control" type="text" name="telNr" id="telNr" value="<?php echo $tel; ?>">
                </div>
                <div class="form-group">
                    <label for="mobilNr">mobile</label>
                    <input class="form-control" type="text" name="mobilNr" id="mobilNr" value="<?php echo $mobil; ?>">
                </div>
                <div class="form-group">
                    <label for="branchName">Filiale</label>
                    <input class="form-control" type="text" name="branchName" id="branchName" value="<?php echo $branch; ?>">
                </div>
                <div class="form-group">
                    <label for="street">Straße</label>
                    <input class="form-control" type="text" name="street" id="street" value="<?php echo $street; ?>">
                </div>
                <div class="form-group">
                    <label for="houseNumber">Haus</label>
                    <input class="form-control" type="text" name="houseNumber" id="houseNumber" value="<?php echo $house; ?>">
                </div>
                <div class="form-group">
                    <label for="stairs">Stiege</label>
                    <input class="form-control" type="text" name="stairs" id="stairs" value="<?php echo $stairs; ?>">
                </div>
                <div class="form-group">
                    <label for="door">Tür</label>
                    <input class="form-control" type="text" name="door" id="door" value="<?php echo $door; ?>">
                </div>
                <div class="form-group">
                    <label for="postCode">PLZ</label>
                    <input class="form-control" type="text" name="postCode" id="postCode" value="<?php echo $post; ?>">
                </div>
                <div class="form-group">
                    <label for="city">Stadt</label>
                    <input class="form-control" type="text" name="city" id="city" value="<?php echo $city; ?>">
                </div>
                <div class="form-group">
                    <label for="country">Land</label>
                    <input class="form-control" type="text" name="country" id="country" value="<?php echo $country; ?>">
                </div>
                <div class="form-group">
                    <label for="sectorCode">Sektor</label>
                    <input class="form-control" type="text" name="sectorCode" id="sectorCode" value="<?php echo $sector; ?>">
                </div>

                <button type="submit" class="btn btn-primary form-button" name="senden">Senden</button>
                <?php
                /*echo "<table>";
                $sql="SELECT * FROM user";
                $statement=connectDB()->query($sql);
                $statement->execute();
                while ($row = $statement->fetch()) {
                    echo "User: $row[email]";
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
                }
                echo "</table>";*/
            }
            ?>
            <input type="hidden" name="user" value="<?php echo htmlspecialchars($_POST['user']); ?>">
        </form>
    </div>
</div>
<?php include "include/page/bottom.php"; ?>
