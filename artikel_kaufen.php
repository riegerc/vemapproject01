<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Bestellübersicht"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

$amount = $_POST["amount"];
$update = $_POST["update"];
$userFID = $_SESSION[USER_ID];
$employee = $userFID;


//Name und Wert des Artikels aus der DB
$sql = "SELECT name, article.price as articlePrice, article.supplierUserFID FROM article
INNER JOIN orderitems
ON article.objectID = orderitems.articleFID
WHERE article.objectID=$update
";

$statement = connectDB()->query($sql);
$statement->execute();

while ($row = $statement->fetch()) {
    $supplierID = $row["supplierUserFID"];
    $articleName = $row["name"];
    $articlePrice = $row["articlePrice"];
}
$wholeAmount = $articlePrice * $amount;

// Time and Date
$time = time();
$date = date("Y-m-d", $time);

$sql = "INSERT INTO `order`
(employeeUserFID, dateTime, supplierUserFID)
VALUES
(:employee, :date, :supplier)
";

$db = connectDB();
$statement = $db->prepare($sql);
$statement->bindParam(":employee", $employee);
$statement->bindParam(":supplier", $supplierID);
$statement->bindParam(":date", $date);
$statement->execute();
$orderID = $db->lastInsertId();
//echo $orderID;

// Bestellung in die Datenbank einfügen
$sql = "INSERT INTO orderitems
(count, articleFID, price, orderFID)
VALUES
(:count, :articleFID, :price, :order)";

$statement = connectDB()->prepare($sql);

$statement->bindParam(":count", $_POST["amount"]);
$statement->bindParam(":articleFID", $_POST["update"]);
$statement->bindParam(":price", $wholeAmount);
$statement->bindParam(":order", $orderID);

$statement->execute();

$article = $_POST["update"];

$sql = "SELECT * FROM user 
WHERE objectID=$userFID";

$statement = connectDB()->query($sql);
$statement->execute();
while ($row = $statement->fetch()) {
    $email = $row["email"];
    $branchName = $row["branchName"];
    $street = $row["street"];
    $house = $row["houseNumber"];
    $stairs = $row["stairs"];
    $door = $row["door"];
    $PLZ = $row["postCode"];
    $city = $row["city"];
    $country = $row["country"];
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <div class="row">
            <div class="col-md-4">
                <!-- Content -->
                <table id="overview">
                    <tr>
                        <th>Stück</th>
                        <td><?php echo $amount ?></td>
                    </tr>
                    <tr>
                        <th>Artikel</th>
                        <td><?php echo $articleName ?></td>
                    </tr>
                    <tr>
                        <th>Stückpreis</th>
                        <td><?php echo $articlePrice ?></td>
                    </tr>
                    <tr>
                        <th>Gesamtpreis</th>
                        <td><?php echo $wholeAmount ?></td>
                    </tr>
                    <tr>
                        <th>Benutzer</th>
                        <td><?php echo $email ?></td>
                    </tr>
                    <tr>
                        <th>Filiale</th>
                        <td><?php echo $branchName ?></td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td><?php echo "$street $house / $stairs / $door, $PLZ $city $country"; ?></td>
                    </tr>
                </table>
                <hr>
                <form action="DOMpdf.php" method="POST">
                    <input type="hidden" name="orderID" value="<?php echo $orderID ?>">
                    <button name="pdf" class="btn btn-danger form-button">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
