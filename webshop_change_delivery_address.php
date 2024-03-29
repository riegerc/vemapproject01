<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";
require_once "include/database.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
$db = connectDB();
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
        <div class="content">
            <?php
            $objectID = $_SESSION[USER_ID];
            if (isset($_POST['change_address'])) {
                $street = htmlspecialchars(trim($_POST['street']));
                $houseNumber = htmlspecialchars(trim($_POST['houseNumber']));
                $stairs = htmlspecialchars(trim($_POST['stairs']));
                $door = htmlspecialchars(trim($_POST['door']));
                $postCode = htmlspecialchars(trim($_POST['postCode']));
                $city = htmlspecialchars(trim($_POST['city']));
                $country = htmlspecialchars(trim($_POST['country']));

                $sql = "UPDATE user SET
             street=:street,
             houseNumber=:houseNumber,
             stairs=:stairs,
             door=:door,
             postCode=:postCode,
             city=:city,
             country=:country
             WHERE objectID=$objectID";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(":street", $street);
                $stmt->bindParam(":houseNumber", $houseNumber);
                $stmt->bindParam(":stairs", $stairs);
                $stmt->bindParam(":door", $door);
                $stmt->bindParam(":postCode", $postCode);
                $stmt->bindParam(":city", $city);
                $stmt->bindParam(":country", $country);

                $stmt->execute();

               echo "<meta http-equiv='refresh' content='0; url=webshop_kaufen.php?update=".(int)$_SESSION['artikelID']."'>";  //up
            }
            ?>

            <?php
            $sql = "SELECT * FROM user WHERE objectID=$objectID";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            ?>

            <form class="form-horizontal">
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Straße</label>
                                <input class="form-control" name="street" type="text" value='<?php echo $row['street'] ?>'>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Hausnummer</label>
                                <input class="form-control" name="houseNumber" type="number"
                                       value='<?php echo $row['houseNumber'] ?>'>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Stiege</label>
                                <input class="form-control" name="stairs" type="number"
                                       value='<?php echo $row['stairs'] ?>'>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Türnummer</label>
                                <input class="form-control" name="door" type="number" value='<?php echo $row['door'] ?>'>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Postleitzahl</label>
                                <input class="form-control" name="postCode" type="number"
                                       value='<?php echo $row['postCode'] ?>'>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Stadt</label>
                                <input class="form-control" name="city" type="text" value='<?php echo $row['city'] ?>'>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Land</label>
                                <input class="form-control" name="country" type="text"
                                       value='<?php echo $row['country'] ?>'>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary form-button" type='submit' name='change_address'>
                            <i class="far fa-save"></i> Adresse ändern
                        </button>
                    </div>

                </fieldset>
            </form>
    </form>
</div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
