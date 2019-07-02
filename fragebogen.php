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
$isFormSubmitted=false;
$userId=$_SESSION[USER_ID];
$rep=new Repository();
$fragen=$rep->readFragebogen();
$lieferantid=0;
if(isset($_GET["lieferantid"])){
	$lieferantid=(int)Helper::sanitize($_GET["lieferantid"]);	
}
if(isset($_POST["senden"])){
	$isFormSubmitted=true;
	echo "<pre>";
	//print_r($_POST);
	echo "</pre>";
	$month=$_POST["month"];
	//JUST 4 TEST !!!!!!!!!!
	if($month<1){
		exit();
	}
	$lieferantid=$_POST["lieferantid"];
	unset($_POST["lieferantid"]);
	unset($_POST["senden"]);
	// JUST 4 TEST !!!!!!!!!!!
	unset($_POST["month"]);
	$antworten=array();
	$toComment=array();
	$fkKategorie=0;
	foreach($_POST as $key=>$val){
		if(strpos($key, "fk_kategorie")===0){
			$fkKategorie=$val;
			unset($_POST[$key]);
		}else{
			$key=Helper::getId($key,"sld");
			$antworten[$key]=["maincategory"=>$fkKategorie, "val"=>(float)Helper::sanitize($val)];
		}
	}
		foreach($antworten as $antwort){
			if($antwort["val"]<1){
				if(!in_array($antwort["maincategory"],$toComment)){
					array_push($toComment,$antwort["maincategory"]);
				}
			}
		}
	echo "<pre>";
	print_r($toComment);
	echo "</pre>";
	//$rep->createAnswers(new Fragebogen($userId, $lieferantid, $antworten),$month);
}

?>
<link rel="stylesheet" type="text/css" href="css/reviews.css" media="all" />
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
	<h1 style="color:red">Under construction</h1>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
			<label class="mth-label">Just 4 Test - Monat: </label> <input class="mth-inp" type="number" min="1" max="6" name="month">
			<input type="hidden" value="<?php echo $lieferantid; ?>" name="lieferantid">
				<?php
				$shouldComment=false;
				
					foreach($fragen as $frage) {

						echo "<h2>" . $frage->getName() . "</h2>\n";
						echo "<ul class='list-group list-group-flush' id='slds" . $frage->getId() . "'>\n";
						foreach($frage->getKriterien() as $kriterium) {
							echo "<li class='list-group-item'>";
							
							$maxInputRange=round($kriterium->getPrzt(),0);
							
							echo "<div class='form-group'>\n";
						    echo "<label for='sld" . $kriterium->getId() . "'>" . $kriterium->getName() . "</label>\n";
							echo "<input type='hidden' name='fk_kategorie".$kriterium->getFkKriterium()."' value='".$kriterium->getFkKriterium()."'>";
							echo "<input type='range' class='form-control-range custom-range' id='sld" . $kriterium->getId() . "' min='0' max='$maxInputRange' value='0' step='0.001' name='sld" . $kriterium->getId() . "' onchange='setLabelText(" . $kriterium->getId() . "," . $kriterium->getFkKriterium() . ")'>\n";
							
							echo "<span class='float-left'>0</span>\n";
							echo "<span class='float-right'>" . $maxInputRange . "</span>\n";
							
							echo "</div>";
							
							echo "</li>";
						}
						echo "</ul>\n";
				
						echo "<div id='lbl" . $kriterium->getFkKriterium() . "'>0</div>\n";
						
						$collapse = "collapse";

						$invalid="";
						
						if ($isFormSubmitted) {
							
							if (($key = array_search($kriterium->getFkKriterium(), $toComment)) !== false) {
								$shouldComment=true;
							}
							
							if ($shouldComment==true) {
								$collapse = "";
							    $invalid = "is-invalid";
							} else {
								$collapse = "collapse";
								$invalid = "";
							}							
						}
						
						echo "<p class='up-down' data-toggle='collapse' data-target='#target" . $kriterium->getFkKriterium() . "' id='chk" . $kriterium->getFkKriterium() . "'><span class='fa fa-caret-right'></span>\n";
						echo "<label class='form-check-label' for='chk" . $kriterium->getFkKriterium() . "'>Kommentar</label></p>\n";
						echo "<textarea class='form-control $collapse $invalid' name='txt" . $kriterium->getFkKriterium() . "' id='target" . $kriterium->getFkKriterium() . "'></textarea>\n";
					}
					?>			
			<div class="form-row">
				<div class="col-md-2">
					<button type="submit" name="senden" class="btn btn-primary form-button">Senden</button>
				</div>
			</div>
		</form>
    </div>	
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
<script src="js/review.js"></script>

