<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Artikel kaufen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<?php
$amount = $_POST["amount"];
$update = $_POST["update"];
$userFID= $_SESSION[USER_ID];
$employee=$userFID;

// Time and Date
$time=time();
$date=date("Y-m-d",$time);

$sql="INSERT INTO `order`
(employeeUserFID, dateTime)
VALUES
(:employee, :date)
";

$db = connectDB();
$statement=$db->prepare($sql);
$statement->bindParam(":employee", $employee);
$statement->bindParam(":date", $date);
$statement->execute();
$orderID=$db->lastInsertId();
echo $orderID;

//Name und Wert des Artikels aus der DB
$sql="SELECT name, article.price as articlePrice FROM article
INNER JOIN orderitems
ON article.objectID = orderitems.articleFID
WHERE article.objectID=$update
";

$statement=connectDB()->query($sql);
$statement->execute();

while($row=$statement->fetch()){
    $articleName=$row["name"];
    $articlePrice=$row["articlePrice"];
}
$wholeAmount=$articlePrice*$amount;

// Bestellung in die Datenbank einfügen
$sql="INSERT INTO orderitems
(count, articleFID, price, orderFID)
VALUES
(:count, :articleFID, :price, :order)";

$statement=connectDB()->prepare($sql);

$statement->bindParam(":count", $_POST["amount"]);
$statement->bindParam(":articleFID", $_POST["update"]);
$statement->bindParam(":price", $wholeAmount);
$statement->bindParam(":order", $orderID);

$statement->execute();

$article = $_POST["update"];

$sql="SELECT * FROM user 
WHERE objectID=$userFID";

$statement=connectDB()->query($sql);
$statement->execute();
while($row=$statement->fetch()) {
    $email=$row["email"];
    $branchName=$row["branchName"];
    $street=$row["street"];
    $house=$row["houseNumber"];
    $stairs=$row["stairs"];
    $door=$row["door"];
    $PLZ=$row["postCode"];
    $city=$row["city"];
    $country=$row["country"];
}
?>

<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>

<div class="content">

    <!-- Content -->

    <?php

    echo "Stück: $amount <br>";
    echo "Artikel: $articleName <br>";
    echo "Stückpreis: $articlePrice <br>";
    echo "Gesamtpreis: $wholeAmount <br>";
    echo "Benutzer: $email <br>";
    echo "Filiale: $branchName <br>";
    echo "Adresse: $street $house / $stairs / $door, $PLZ $city $country";

    ?>

</div>

</div><?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
