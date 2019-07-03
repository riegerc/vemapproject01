<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Bestellübersicht"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

//POST & SESSION
$amount = $_POST["amount"];
$articleID = $_POST["update"];
$employee=$_SESSION[USER_ID];

// Time and Date
$time = time();
$date = date("Y-m-d", $time);

//SQL Abfragen und Variable $orderID befüllen
   
    //Name und Wert des Artikels und LieferantenID aus der DB auslesen
    $sql = "SELECT  article.name , article.price, article.supplierUserFID as supplier FROM  article WHERE article.objectID=$articleID ";
    $db = connectDB();
    $statement = $db->query($sql);

    while ($row = $statement->fetch()) {
        $supplierID = $row["supplier"];
        $articleName = $row["name"];
        $articlePrice = $row["price"];
    }

    $wholeAmount = $articlePrice * $amount;

    //Bestellerdaten auslesen (user)
    $sql = "SELECT  user.branchName, user.email, user.street, user.houseNumber,user.stairs, user.door, user.postCode, user.city, user.country, user.budget FROM user 
    WHERE objectID=$employee";

    $statement = $db->query($sql);


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
        $budget = $row['budget'];
    }

    //order Tabelle befüllen
    $sql = "INSERT INTO `order`
    (employeeUserFID, dateTime, supplierUserFID)
    VALUES
    (:employee, :date, :supplier)";

    $statement = $db->prepare($sql);

    $statement->bindParam(":employee", $employee);
    $statement->bindParam(":supplier", $supplierID);
    $statement->bindParam(":date", $date);

    $statement->execute();
    //orderID abfragen
    $orderID = $db->lastInsertId();

    // Bestellung in die orderitems Tabelle einfügen
    $sql = "INSERT INTO orderitems
    (count, articleFID, price, orderFID)
    VALUES
    (:count, :articleFID, :price, :order)";

    $statement = $db->prepare($sql);

    $statement->bindParam(":count",$amount);
    $statement->bindParam(":articleFID", $articleID);
    $statement->bindParam(":price", $wholeAmount);
    $statement->bindParam(":order", $orderID);

    $statement->execute();
    
    //budget aktualisieren
    
    $budget-=($articlePrice*$amount);
    $sql="UPDATE `user` SET `budget`=:budget WHERE `objectID`=:userID ";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":budget", $budget);
    $stmt->bindParam(":userID", $employee);
    $stmt->execute();
    
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
                        <td><?php echo number_format($articlePrice,2,',','\'')." €"; ?></td>
                    </tr>
                    <tr>
                        <th>Gesamtpreis</th>
                        <td><?php echo number_format($wholeAmount,2,',','\'')." €"; ?></td>
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
                        <td><?php echo "$street $house , $PLZ $city $country"; ?></td>
                    </tr>
                </table>
                <hr>
                <form action="DOMpdf.php" target="_blank" method="POST">
                    <input type="hidden" name="orderID" value="<?php echo $orderID ?>">
                    <button name="pdf" title="PDF Datei: Bestellung, öffnet in neuem Fenster." class="btn btn-danger form-button">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
