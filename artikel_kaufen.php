<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 1; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>
<?php

    $sql="INSERT INTO orderitems
       (count, articleFID)
       VALUES
       (:count, :articleFID)";
    $statement=connectDB()->prepare($sql);
    $statement->bindParam(":count", $_POST["amount"]);
    $statement->bindParam(":articleFID", $_POST["update"]);
    $statement->execute();
    $amount = $_POST["amount"];
    echo $_POST["update"];

?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <?php
        echo "$_POST[amount] Stück bestellt";
        echo "$_POST[update] user";
        ?>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
