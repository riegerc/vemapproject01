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
$sql="
/*SELECT name FROM article
INNER JOIN orderitems 
ON article.objectID = orderitems.articleFID*/

SELECT name, price
FROM article
INNER JOIN orderitems
ON article.objectID = orderitems.articleFID
INNER JOIN order
ON order.objectID = orderitems.orderFID
";

$statement=connectDB()->query($sql);
$statement->execute();
while($row=$statement->fetch()){
    echo $row["price"];
    $articlePrice=$row["price"];
}

$amount = $_POST["amount"];
$article = $_POST["update"];
$price=$amount*$articlePrice;
$sql="INSERT INTO orderitems
    (count, articleFID, price)
    VALUES
    (:count, :articleFID, :price)";
    $statement=connectDB()->prepare($sql);
    $statement->bindParam(":count", $_POST["amount"]);
    $statement->bindParam(":articleFID", $_POST["update"]);

    $statement->execute();



?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <?php
        echo "Sie haben $amount Stück von Artikel $article bestellt";
        ?>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
