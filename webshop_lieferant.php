<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = PERM_CED_SUPPLIER; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = "Lieferant Ansicht"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <h4>Kontostand: 53,941&euro;</h4>
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="table-responsive-lg">
                        <table class='table table-bordered' id='dataTable'>
                            <?php
                            $db = connectDB();
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
                            
                            WHERE article.objectID=orderitems.articleFID;";

                            echo "<thead>";
                            echo "    <tr>";
                            echo "        <th>Artikel Name</th>";
                            echo "        <th>Preis Je</th>";
                            echo "        <th>Stück</th>";
                            echo "        <th>Gesamt Preis</th>";
                            echo "        <th>Lieferung</th>";
                            echo "    </tr>";
                            echo "</thead>";

                            echo "<tbody>";
                            foreach ($db->query($sql) as $row) {
                                echo "    <tr>\n";
                                echo "    <td>" . $row['article_name'] . "</td>\n";
                                echo "    <td>" . $row['article_price'] . "&euro;" . "</td>\n";
                                echo "    <td>" . $row['order_count'] . "</td>\n";
                                echo "    <td>" . $row['article_price'] * $row['order_count'] . "&euro;" . "</td>\n";

                                if ($row['ordered'] == 1) {
                                    echo "<td><br>Bestätigt<br></td>\n";
                                } else {
                                    echo "<td> <a href='?order=" . $row['order_id'] . "'>Bestätigen</a><br></td>\n";
                                }
                                echo "    </tr>";
                            }
                            echo "</tbody>";

                            if (isset($_GET['order'])) {
                                $order_id = (int)$_GET['order'];
                                $sql = "UPDATE orderitems SET ordered='1' WHERE objectID=$order_id";

                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(":objectID", $order_id);
                                $stmt->execute();
                            }
                            ?>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
