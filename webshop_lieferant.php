<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = PERM_CED_SUPPLIER; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = "Bestellungen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
        <?php
        $userID= $_SESSION[USER_ID];
        /*SQL Abfrage  */
        $db = connectDB();

        if (isset($_GET['order'])) {
            $order_id = (int)$_GET['order'];
            $sql = "UPDATE orderitems SET ordered='1' WHERE objectID=$order_id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(":objectID", $order_id);
            $stmt->execute();
        }
            //Lieferant darf nur seine eigenen Daten sehen
        $sql = "SELECT 
            article.objectID as article_id, 
            article.name as article_name, 
            article.articleGroupFID as article_groupFID, 
            article.price as article_price, 
            article.description article_description, 
            orderitems.objectID as order_id, 
            orderitems.orderFID as orderFID, 
            orderitems.articleFID as order_articleFID, 
            orderitems.count as order_count, 
            orderitems.price as order_price,
            orderitems.ordered as ordered
            FROM article, orderitems
            
            WHERE article.objectID=orderitems.articleFID AND $userID=article.supplierUserFID;";

           //wenn SuperAdmin dann darf er alle Einträge sehen und bearbeiten
        if($_SESSION[USER_ROLE]==2){
            $sql = "SELECT 
            article.objectID as article_id, 
            article.name as article_name, 
            article.articleGroupFID as article_groupFID, 
            article.price as article_price, 
            article.description article_description, 
            orderitems.objectID as order_id, 
            orderitems.orderFID as orderFID, 
            orderitems.articleFID as order_articleFID, 
            orderitems.count as order_count, 
            orderitems.price as order_price,
            orderitems.ordered as ordered
            FROM article, orderitems, user
            
            WHERE article.objectID=orderitems.articleFID AND user.objectID=article.supplierUserFID;";
        }

        $auswahl = "";
        foreach ($db->query($sql) as $row) {
            
            $auswahl .= "    <tr>\n";
            $auswahl .= "    <td>" . $row['article_name'] . "</td>\n";
            $auswahl .= "    <td>" . number_format($row['article_price'],2,',','.') . " &euro;" . "</td>\n";
            $auswahl .= "    <td>" . $row['order_count']. "</td>\n";
            $auswahl .= "    <td>" . number_format($row['article_price'] * $row['order_count'],2,',','.') . " &euro;" . "</td>\n";

            if ($row['ordered'] == 1) {
                $auswahl .= "<td><span class='btn form-button'><i class='fas fa-check-circle'></i> Bestätigt</span></td>\n";
            } else {
                $auswahl .= "<td> <a class='btn btn-success form-button' href='?order=".$row['order_id']."'><i class='fas fa-check-circle'></i> Bestätigen</a><br></td>\n";
            }
            $auswahl .= "    </tr>";
        }
        //budget aus DB befüllen
        $sql = "SELECT user.budget FROM `user` WHERE user.objectID= $userID";
        foreach ($db->query($sql) as $row) {
           $buget = $row['budget'];
        }
        ?>
        <h4>Kontostand: <?php echo number_format($buget,2,',','.'); ?>&euro;</h4>
        <div class="row">
            <div class="col-md-12">

                    <div class="table-responsive-lg">
                        <?php
                        echo "<table class='table table-bordered table-striped table-hover' id='dataTable'>";
                        echo "<thead>";
                        echo "    <tr>";
                        echo "        <th>Artikel Name</th>";
                        echo "        <th>Preis pro Stück</th>";
                        echo "        <th>Stückanzahl</th>";
                        echo "        <th>Gesamtpreis</th>";
                        echo "        <th>Lieferung</th>";
                        echo "    </tr>";
                        echo "</thead>";

                        echo "<tbody>";
                        echo $auswahl;
                        echo "</tbody>";
                        echo "</table>";
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
