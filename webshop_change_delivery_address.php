<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
require_once ("include/database.php");

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
            if(isset($_POST['change_address'])){
             $sql='UPDATE user SET ';   
            }
        ?>



    <div class="row">
         <form class="form-horizontal">
            <fieldset>
            <label>Straße</label><br>
            <input id="postal-code" name="street" type="number" placeholder="Straße"><br>
            <label>Hausnummer</label><br>
            <input id="postal-code" name="houseNumber" type="number" placeholder="Hausnummer"><br>
            <label>Stiege</label><br>
            <input id="postal-code" name="stairs" type="number" placeholder="Stiege"><br>
            <label>Türnummer</label><br>
            <input id="postal-code" name="door" type="number" placeholder="Türnummer"><br>
            <label>Postleitzahl</label><br>
            <input id="postal-code" name="postCode" type="number" placeholder="Postleitzahl"><br>
            <label>Stadt</label><br>
            <input id="postal-code" name="city" type="number" placeholder="Stadt"><br>
            <label>Land</label><br>
            <input id="postal-code" name="country" type="number" placeholder="Land"><br><br>

            <input type='submit' value='Adresse ändern'>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
