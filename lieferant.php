<?php
/*
Autoren: Sharokh Torkan,David Naunkovic
*/
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = true; // defines if the page is restricted to logged-in Users only
$userLevel = PERM_MAKE_REVIEW; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Lieferanten Übersicht"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
include "include/helper.inc.php"; // top-part of html-template (stylesheets, navigation, ..)
$seite=0;
if(isset($_GET["what"])){
	$what=(int)Helper::sanitize($_GET["what"]);
	switch($what){
		case 1:
			$seite="fragebogen";
			break;
		case 2:
			$seite="bewertung";
			break;
	}
}
else{
	exit();
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <?php
        $db=connectDB();
        $rolesFID=4;
        $sql="SELECT objectID, branchName
        FROM user
        WHERE rolesFID=:rolesFID";
        $stmt=$db->prepare($sql);
        $stmt->bindParam(":rolesFID",$rolesFID);
        $stmt->execute();
        while ( $row=$stmt->fetch()){

                echo "<a href='$seite.php?lieferantid=$row[objectID]'>$row[branchName]</a><br>";
        }
        ?>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
