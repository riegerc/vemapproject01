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
            $sql="SELECT objectID, tender FROM tenders ";
            $st = connectDB()->query($sql);
            echo "<table>";

            while($id=$st->fetch()){
                $tenderID=(int)$id["objectID"];
                $ten=$id["tender"];
                $sql="SELECT tenders.objectID AS tenderID,tendersresponse.supplierFID AS supplierFID,tenders.tender,user.branchName,SUM(tendersresponse.price) As TotalPrice,supplierselect.userFID FROM tendersresponse
                INNER JOIN user
                ON tendersresponse.supplierFID = user.objectID
                INNER JOIN supplierselect
                ON tendersresponse.supplierFID = supplierselect.userFID
                INNER join tenders
                ON supplierselect.tenderFID = tenders.objectID
                WHERE tenders.objectID=:tenderID
                GROUP BY tendersresponse.supplierFID,tenders.tender";
                $stmt = connectDB()->prepare($sql);
                $stmt->bindParam(":tenderID", $tenderID);
                $stmt->execute();
                $row = $stmt->fetch();
                if(!$row) continue;
                #var_dump($row);
                echo "<tr><th colspan='3'>$ten</th></tr>";
                echo "<th>Firma</th>
                <th>Preis</th>
                <th>Details</th><tr>";

                do{
                    #echo $row["tender"];
                    echo "";
                    echo "
                        <td>$row[branchName]</td>" .
                        "<td>" . number_format($row["TotalPrice"],2,",",".") ." €" ."</td>".
                        "<td><a href='ams_response_details.php?supplierFID=$row[supplierFID]&tenderID=$row[tenderID]' class='btn btn-info'>Details</a></td></tr>";
                }while ($row = $stmt->fetch());

                echo "<tr><td>&nbsp;</td></tr>";
            }
            echo "</table>";

            ?>

        </div>
        <div class="alert alert-primary" role="alert">
            <p class="font-weight-light">Mehrwertsteuersatz = 20%</p>
        </div>
    </div>


<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>