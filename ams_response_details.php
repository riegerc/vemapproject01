<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

// TODO Abfrage das einem nur die Ausschreibungen angezeigt werden zu denen man eingeladen ist
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">

        <h2>Erstellte Ausschreibungen</h2>



        <?php
        $supplierFID=$_GET["supplierFID"];
        $tenderID=$_GET["tenderID"];
        $sql="SELECT  tendersresponse.price,tenderDetail.position FROM tendersresponse
                INNER JOIN tenderDetail
                ON tendersresponse.tenderDetailFID= tenderDetail.objectID
                WHERE tendersresponse.supplierFID=:supplierFID AND tenderDetail.tendersFID=:tenderID";
        $stmt = connectDB()->prepare($sql);
        $stmt->bindParam(":supplierFID", $supplierFID);
        $stmt->bindParam(":tenderID", $tenderID);
        $stmt->execute();
        echo "<table>
                <th>Position</th>
                <th>Preis</th>";
        while ($row=$stmt->fetch()){
            echo "<tr><td>".$row["position"]."</td>";
            echo "<td>". number_format($row["price"],2,",",".") ." €" ."</td></tr>";
        }
        ?>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
