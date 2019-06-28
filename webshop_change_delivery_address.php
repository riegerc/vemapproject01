<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
require_once ("include/database.php");
$db=connectDB();
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
    <title>Kurs</title>
</head>
<body>
       <div class="container">



       <?php

                $objectID=$_SESSION[USER_ID];
            if(isset($_POST['change_address'])){
             $street=htmlspecialchars(trim($_POST['street']));
             $houseNumber=htmlspecialchars(trim($_POST['houseNumber']));
             $stairs=htmlspecialchars(trim($_POST['stairs']));
             $door=htmlspecialchars(trim($_POST['door']));
             $postCode=htmlspecialchars(trim($_POST['postCode']));
             $city=htmlspecialchars(trim($_POST['city']));
             $country=htmlspecialchars(trim($_POST['country']));
         
             $sql="UPDATE user SET
             street=:street,
             houseNumber=:houseNumber,
             stairs=:stairs,
             door=:door,
             postCode=:postCode,
             city=:city,
             country=:country
             WHERE objectID=$objectID";
         
          $stmt = $db->prepare($sql);
             $stmt->bindParam(":street",$street);
             $stmt->bindParam(":houseNumber",$houseNumber);
             $stmt->bindParam(":stairs",$stairs);
             $stmt->bindParam(":door",$door);
             $stmt->bindParam(":postCode",$postCode);
             $stmt->bindParam(":city",$city);
             $stmt->bindParam(":country",$country);
         
             $stmt->execute();}
        ?>

            <?php
                 $sql="SELECT * FROM user WHERE objectID=$objectID";
                 $stmt=$db->prepare($sql);
                 $stmt->execute();
                 $row=$stmt->fetch();   
            ?>

    <div class="row">
         <form class="form-horizontal">
            <fieldset>
            <label>Straße</label><br>
            <input name="street" type="text" value='<?php echo $row['street']?>'><br>
            <label>Hausnummer</label><br>
            <input name="houseNumber" type="number" value='<?php echo $row['houseNumber']?>'><br>
            <label>Stiege</label><br>
            <input name="stairs" type="number" value='<?php echo $row['stairs']?>'><br>
            <label>Türnummer</label><br>
            <input name="door" type="number" value='<?php echo $row['door']?>'><br>
            <label>Postleitzahl</label><br>
            <input name="postCode" type="number" value='<?php echo $row['postCode']?>'><br>
            <label>Stadt</label><br>
            <input name="city" type="text" value='<?php echo $row['city']?>'><br>
            <label>Land</label><br>
            <input name="country" type="text>" value='<?php echo $row['country']?>'><br><br>

            <input type='submit' name='change_address' value='Adresse ändern'>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
