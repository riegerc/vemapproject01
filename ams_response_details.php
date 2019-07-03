<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Erstellte Ausschreibungen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Position</th>
                <th>Preis per Stück</th>
                <th>Menge</th>
                <th>Gesamtpreis</th>
                <th>Preis inkl. Mwst.</th>

            </tr>
            </thead>
            <tbody>
            <?php
            $supplierFID = (int) $_GET["supplierFID"];
            $tenderID = (int) $_GET["tenderID"];
            $sql = "SELECT  tendersresponse.price,tenderDetail.position, tenderDetail.amount FROM tendersresponse
                INNER JOIN tenderDetail
                ON tendersresponse.tenderDetailFID= tenderDetail.objectID
                WHERE tendersresponse.supplierFID=:supplierFID AND tenderDetail.tendersFID=:tenderID";
            $stmt = connectDB()->prepare($sql);
            $stmt->bindParam(":supplierFID", $supplierFID);
            $stmt->bindParam(":tenderID", $tenderID);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $proPiece = (float)$row["price"];
                $amount = (float) $row["amount"];
                $total = $proPiece * $amount;
                echo "<tr><td>" . $row["position"] . "</td>";
                echo "<td>" . number_format($proPiece, 2, ",", ".") . " €" . "</td>";
                echo "<td>$amount</td>";
                echo "<td>" . number_format($total, 2, ",", ".") . " €" . "</td>";
                echo "<td>" . number_format($total * 1.2, 2, ",", ".") . " €" . "</td></tr>";

            }
            ?>
            </tbody>
        </table>
        <div class="alert alert-primary" role="alert">
            <p class="font-weight-light">Mehrwertsteuersatz = 20%</p>
        </div>
    </div>
</div>
<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
