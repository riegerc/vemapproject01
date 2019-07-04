<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Angebot abgeben"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

    $tenderFID = (int)$_GET["tenderID"];
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?tenderID=".$tenderFID); ?>" method="POST">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="submit" class="btn btn-primary float-right" name="send" value="Angebot absenden">
                    <a href="overview_tenders.php"><h6>&#8636 Zurück zur Ausschreibung</h6></a>

                </div>
            </div>
        </div>

        <table class="table table-bordered">

            <thead>
            <tr>
            <th>Pos.Nr.</th>
            <th>Position</th>
            <th>Menge</th>
            <th>Ihr Preis pro Stück</th>
            <th>Beschreibung</th>
            </tr>
            </thead>
            <?php
            $date = date("Y-m-d");
            $time = date("H:i:s");

            $sql = "SELECT *,tenderDetail.objectID AS detailID
                    FROM tenderDetail LEFT JOIN tenders ON tendersFID = tenders.objectID
                    WHERE tendersFID = :tenderFID";
            $stmt = connectDB()->prepare($sql);
            $stmt->bindParam(":tenderFID", $tenderFID);
            $stmt->execute();
            $row = $stmt->fetch();
            echo "<h2>$row[tender]</h2>";
            $stmt = NULL;

            $sql = "SELECT *,tenderDetail.objectID AS detailID
                    FROM tenderDetail LEFT JOIN tenders ON tendersFID = tenders.objectID
                    WHERE tendersFID = :tenderFID";
            $stmt = connectDB()->prepare($sql);

            $stmt->bindParam(":tenderFID", $tenderFID);
            $stmt->execute();



            //$posnr = 0;

            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $row["posNr"] . "</td>";
                echo "<td>" . $row["position"] . "</td>";
               echo "<td>" . $row["amount"] . "</td>";
                echo "<td><input class='form-control' name='price' " . $row["posNr"] . " id='price' ". $row["posNr"] . " type='number' min='0'>\n"; //input für Preis
                echo "<td>" . $row["longtext"] . "</td>";
                echo "</tr>";


                if (isset($_POST["send"])) {
                    if (isset($_POST["price".$row["posNr"]]) AND $_POST["price".$row["posNr"]] != "") {
                        $price = htmlspecialchars($_POST["price".$row["posNr"]]);

                        $sqlInsert = "INSERT INTO tendersresponse (supplierFID, tenderDetailFID, price, timeOfResponse, dateOfResponse, description)
                  VALUES (:supplierFID, :tenderDetailFID,:price,:timeOfResponse,:dateOfResponse,:description)";
                        $stmtInsert = connectDB()->prepare($sqlInsert);
                        $stmtInsert->bindParam(":supplierFID", $_SESSION[USER_ID]);
                        $stmtInsert->bindParam(":tenderDetailFID", $row["detailID"]);
                        $stmtInsert->bindParam(":price", $price);
                        $stmtInsert->bindParam(":timeOfResponse", $time);
                        $stmtInsert->bindParam(":dateOfResponse", $date);
                        $stmtInsert->bindParam(":description", $row["description"]);

                        $stmtInsert->execute();
                    }
                    //$posnr++;
                }
            }
            ?>
        </table>

        <div class="alert alert-primary" role="alert">
        <p class="font-weight-light">Mehrwertsteuersatz = 20%</p>
        </div>

    </form>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
