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
$amount = $_POST["amount"];
$update = $_POST["update"];
$userFID= $_SESSION[USER_ID];

/*$sql="SELECT * FROM user
WHERE objectID = :userFID";

$statement=connectDB()->prepare($sql);
$statement->bindParam(":userFID", $userFID);
$statement->execute();

while($row=$statement->fetch()) {
    $employee = $row["objectID"];
}

$employee=99;
$sql="INSERT INTO order
(employeeUserFID)
VALUE
($employee)
WHERE order.objectID=2";
$statement=connectDB()->query($sql);
//$statement->bindParam(":employee", $employee);
$statement->execute();*/

$sql="SELECT name,article.price FROM article

INNER JOIN orderitems

ON article.objectID = orderitems.articleFID
WHERE article.objectID=$update
";

$statement=connectDB()->query($sql);
$statement->execute();

while($row=$statement->fetch()){
    $articleName=$row["name"];
    $price=$row["price"];
}
$wholeAmount=$price*$amount;
$sql="INSERT INTO orderitems

  (count, articleFID, price, orderFID)

  VALUES

  (:count, :articleFID, :price, :order)";

$statement=connectDB()->prepare($sql);

$statement->bindParam(":count", $_POST["amount"]);
$statement->bindParam(":articleFID", $_POST["update"]);
$statement->bindParam(":price", $wholeAmount);
$statement->bindParam(":order", $orderID);

$statement->execute();

$article = $_POST["update"];?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>

    <div class="content">

        <!-- Content -->

        <?php

//        echo "Sie haben $amount Stück von Artikel $article bestellt";
        echo "Stück: $amount";
        echo "Artikel: $articleName";
        echo "Preis: $wholeAmount";

        ?>

    </div>

</div><?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
