<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Angebot abgeben"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

$tenderFID = (int)$_GET["tenderID"];


if (isset($_POST["Absenden"])) {

    $price[] = htmlspecialchars($_POST["price$row[detailID]"]);
    foreach ($_POST as $value) {
        $sql = "INSERT INTO tendersresponse (supplierFID, tenderDetailFID, price, timeOfResponse, dateOfResponse, description)
                  VALUES (:supplierFID, :tenderDetailFID,:price,:timeOfResponse,:dateOfResponse,:description)";

        $stmt = connectDB()->prepare($sql);
        $stmt->bindParam(":supplierFID", $row["supplierFID"]);
        $stmt->bindParam(":tenderDetailFID", $row["detailID"]);
//                    $stmt->bindParam(":price", $row["price"]);
        $stmt->bindParam(":timeOfResponse", $time);
        $stmt->bindParam(":dateOfResponse", $date);
        $stmt->bindParam(":description", $row["supplierFID"]);
        $stmt->execute();
        echo "IN DATENBANK GESPEICHERT!";
    }
}

?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="row">
            <div class="col-md-6">
                <a href="tender_detail.php"><h6>&#8636 Zurück zur Ausschreibung</h6></a>
            </div>
            <div class="form-group form-button-wrap">
                <input type="submit" class="btn btn-primary form-button" name="send" value="Angebot absenden">
            </div>
        </div>

        <table class="table table-bordered" id="dataTable">
            <thead>
            <th>Pos. Nr.:</th>
            <th>Position</th>
            <th>Ihr Gebot</th>
            <th>Langtext</th>
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

            $posnr = 1;
            var_dump($_POST);
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td> 1.$posnr";
                echo "<td>" . $row["position"] . "</td>";
                echo "<td><input name='price$row[detailID]' id='price$row[detailID]' type='number'>\n";
                echo "<td>" . $row["longtext"] . "</td>";
                echo "</tr>";
                $posnr++;

            }




            ?>
        </table>
    </form>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
