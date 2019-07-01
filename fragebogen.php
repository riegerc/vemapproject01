<?php
/*
 Autoren: Christian Riedler, Lubomir Mitana
 */

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
//$userLevel = PERM_MAKE_REVIEW; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Bewertung Lieferant"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
include "include/helper.inc.php"; // top-part of html-template (stylesheets, navigation, ..)
include "classes/types/fragebogen.inc.php"; // top-part of html-template (stylesheets, navigation, ..)
require_once("classes/repository.inc.php");
$userId=$_SESSION[USER_ID];
$rep=new Repository();
$fragen=$rep->readFragebogen();
$lieferantid=0;
if(isset($_GET["lieferantid"])){
	$lieferantid=(int)Helper::sanitize($_GET["lieferantid"]);	
}
if(isset($_POST["senden"])){
	$lieferantid=$_POST["lieferantid"];
	unset($_POST["lieferantid"]);
	unset($_POST["senden"]);
	$antworten=array();
	foreach($_POST as $key=>$val){
		$key=Helper::getId($key,"sld");
		$antworten[$key]=(float)Helper::sanitize($val);
	}
	$rep->createAnswers(new Fragebogen($userId, $lieferantid, $antworten));
}
?>
<link rel="stylesheet" type="text/css" href="css/reviews.css" media="all" />
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <h1></h1>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
		<input type="hidden" value="<?php echo $lieferantid; ?>" name="lieferantid">
		<?php
			foreach($fragen as $frage){
				 echo "<h2>".$frage->getName()."</h2>";
				 echo "<ul class='no-style' id='slds".$frage->getId()."'>";
				 foreach($frage->getKriterien() as $kriterium){
					echo $kriterium;
				 }
				 echo "</ul>";
			}
		?>
		<button type="submit" name="senden">Senden</button>
    </div>
	
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
<script src="js/review.js"></script>

