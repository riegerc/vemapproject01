<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 1; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
include "include/helper.inc.php"; // top-part of html-template (stylesheets, navigation, ..)
require_once("classes/repository.inc.php");


$rep=new Repository();
$fragen=$rep->readFragebogen();
$lieferantid=0;
if(isset($_GET["lieferantid"])){
	$lieferantid=(int)Helper::sanitize($_GET["lieferantid"]);	
}
if(isset($_POST["senden"])){
	echo "<h1>adsfasdf</h1>";
	echo "<pre>";
	var_dump($_POST);
	echo "</pre>";
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <h1></h1>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
		<input type="hidden" value="<?php echo $lieferantid; ?>">
		<?php
			foreach($fragen as $frage){
				 echo "<h2>".$frage->getName()."</h2>";
				 echo "<ul>";
				 foreach($frage->getKriterien() as $kriterium){
					echo $kriterium;
				 }
				 echo "</ul>";
			}
		?>
		<button type="submit" value="senden">Senden</button>
		</form>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
