<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Benutzerdaten ändern"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

if(isset($_GET["user"])){
    $user=$_GET["user"];
}else {
    echo "Kein Benutzer ausgewählt";
}
if(isset($_GET["senden"])) {
    foreach($_GET as $key=>$value) {
        if($key!=="") {
            if($key=="user") {
                echo "UserID: $value";
            }elseif($key=="rolesFID"){
                echo $value;
            }elseif($key=="senden") {

            }
            //Budget ist integer also kein Leerstring erlaubt
            elseif($key=="budget" AND $value=="") {

            }
            elseif($key=="rolesFID") {
                $key=0;
            }
            else {
                $sql="UPDATE user
                SET $key=:param
                WHERE objectID=$user";

                $statement=connectDB()->prepare($sql);
                $statement->bindParam(":param", $value);
                $statement->execute();

                echo "$key : $value";
            }
        }

    }
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <?php
            if(isset($_GET["user"])) {
                $sql = "SELECT * FROM user
                WHERE objectID = :user";
                $statement = connectDB()->prepare($sql);
                $statement->bindParam(":user", $_GET["user"]);
                $statement->execute();
                while( $row=$statement->fetch() ) {
                    $fname=$row["firstName"];
                    $lname=$row["lastName"];

                    $role=$row["rolesFID"];

                    $email=$row["email"];
                    $budget=$row["budget"];
                    $tel=$row["telNr"];
                    $mobil=$row["mobilNr"];
                    $branch=$row["branchName"];
                    $street=$row["street"];
                    $house=$row["houseNumber"];
                    $stairs=$row["stairs"];
                    $door=$row["door"];
                    $post=$row["postCode"];
                    $city=$row["city"];
                    $country=$row["country"];
                    $sector=$row["sectorCode"];
                }

                if (isset($_GET["senden"])) {

                }
                ?>
                <label for="firstName">Vorname : <input type="text" name="firstName" id="firstName" value="<?php echo $fname;?>"></label><br>
                <label for="lastName">Nachname : <input type="text" name="lastName" id="lastName" value="<?php echo $lname;?>"></label><br>

                <label for="rolesFID">Rolle :
                    <select name="rolesFID">
                        <?php
                        $sql="SELECT DISTINCT * FROM roles";
                        $statement=connectDB()->prepare($sql);
                        $statement->execute();
                        while($row=$statement->fetch()){
                            $selected="";
                            if($row["objectID"]==$role){
                                $selected="selected";
                            }
                            echo "<option value='$row[objectID]' $selected>$row[name]</option>";
                        }
                        ?>
                    </select>
                </label><br>

                <label for="email">Email : <input type="email" name="email" id="email" value="<?php echo $email;?>"></label><br>
                <label for="budget">Budget : <input type="number" name="budget" id="budget" value="<?php echo $budget;?>"></label><br>
                <label for="telNr">telephone : <input type="text" name="telNr" id="telNr" value="<?php echo $tel;?>"></label><br>
                <label for="mobilNr">mobile : <input type="text" name="mobilNr" id="mobilNr" value="<?php echo $mobil;?>"></label><br>
                <label for="branchName">Filiale : <input type="text" name="branchName" id="branchName" value="<?php echo $branch;?>"></label><br>
                <label for="street">Straße : <input type="text" name="street" id="street" value="<?php echo $street;?>"></label><br>
                <label for="houseNumber">Haus nr. : <input type="text" name="houseNumber" id="houseNumber" value="<?php echo $house;?>"></label><br>
                <label for="stairs">Stiege : <input type="text" name="stairs" id="stairs" value="<?php echo $stairs;?>"></label><br>
                <label for="door">Tür : <input type="text" name="door" id="door" value="<?php echo $door;?>"></label><br>
                <label for="postCode">PLZ : <input type="text" name="postCode" id="postCode" value="<?php echo $post;?>"></label><br>
                <label for="city">Stadt : <input type="text" name="city" id="city" value="<?php echo $city;?>"></label><br>
                <label for="country">Land : <input type="text" name="country" id="country" value="<?php echo $country;?>"></label><br>
                <label for="sectorCode">Sektor : <input type="text" name="sectorCode" id="sectorCode" value="<?php echo $sector;?>"></label><br>

                <button type="submit" name="senden">Senden</button>
                <?php
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
            }
            ?>
            <input type="hidden" name="user" value="<?php echo htmlspecialchars($_GET['user']);?>">
        </form>
    </div>
</div>
<?php include "include/page/bottom.php"; ?>
