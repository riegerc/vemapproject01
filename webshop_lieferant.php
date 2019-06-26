<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 1; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

require_once("include/database.php");
include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
      
<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
<h3>Lieferant Ansicht | Kontostand:53,941&euro;</h3> 

<?php
$db=connectDB();
$sql="SELECT 
article.objectID as article_id, 
article.name as article_name, 
article.articleGroupFID as article_groupFID, 
article.price as article_price, 
article.description article_description, 
orderitems.objectID as order_id, 
orderitems.orderFID as orderFID, 
orderitems.articleFID as order_articleFID, 
orderitems.count as order_count, 
orderitems.price as order_price 
FROM article, orderitems

WHERE article.objectID=orderitems.articleFID;";

echo "    <table>\n";
echo "    <tr>\n";
echo "    <th>Artikel Name</th>\n";
echo "    <th>Preis Je</th>\n";
echo "    <th>Stück</th>\n";
echo "    <th>Gesamt Preis</th>\n";
echo "    <th>Lieferung</th>\n";
echo "    </tr>";

foreach($db->query($sql) as $row){
    echo "    <tr>\n";
    echo "    <td>".$row['article_name']."<br>";
    echo "    <td>".$row['article_price']."&euro;"."<br>";
    echo "    <td>".$row['order_count']."<br>";
    echo "    <td>".$row['article_price']*$row['order_count']."&euro;"."<br>";
    echo "    <td> <a href='#'>Bestätigen</a><br>";
    echo "    </tr>";}

?>


    </div>
</div>



<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
