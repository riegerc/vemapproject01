<?php
/*
Autoren: Theo Isporidi, Christian Riedler
*/
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = true; // defines if the page is restricted to logged-in Users only
$userLevel = PERM_CED_REVIEW; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Bewertungen verwalten"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

require_once("classes/types/kriterium.inc.php");
require_once("classes/repository.inc.php");
require_once("include/helper.inc.php");


$rep=new Repository();
$summekriterien=0;
$ok=true;
$meldung="";
$name="";
$gewichtung="";
if(isset($_GET["add"])){
	$kid=(int)Helper::sanitize($_GET["add"]);
	$kriterien=$rep->readUnterKriterien($kid);
} elseif (isset($_GET["delete"])) {
	$kid=(int)Helper::sanitize($_GET["delete"]);
	$rep->deleteKriterium($kid, false);
	unset($kid);
	$kriterien=$rep->readKriterien();
} elseif (isset($_GET["deletesub"])) {
	$kid=(int)Helper::sanitize($_GET["deletesub"]);
	$rep->deleteKriterium($kid, true);
	unset($kid);
	$kriterien=$rep->readKriterien();
} else {
	$kriterien=$rep->readKriterien();
}

if(isset($_POST["senden"])){
	$name=Helper::sanitize($_POST["kriterium"]);
	$gewichtung=(int)Helper::sanitize($_POST["gewichtung"]);
	if(isset($_POST["kid"])){
		$kid=(int)Helper::sanitize($_POST["kid"]);
	}
	unset($_POST["senden"]);
	unset($_POST["kriterium"]);
	unset($_POST["gewichtung"]);
	unset($_POST["kid"]);
	$extKriterien=array();

	foreach($_POST as $key=>$val){
		$key=Helper::getId($key,"inp");
		$extKriterien[$key]=(int)Helper::sanitize($val);
	}
	if(isset($kid)){
		if ($name != "") $rep->createUnterKriterium(new Kriterium($name,$gewichtung,0,$kid));
		$rep->update($extKriterien, $kid);
	}else{
		if ($name != "") $rep->create(new Kriterium($name,$gewichtung));
		$rep->update($extKriterien);
	}
	echo '<meta http-equiv="refresh" content="0">';
}

foreach($kriterien as $kriterium){
	$summekriterien+=$kriterium->getGewichtung();
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
	<div class="meldung"><?php echo (strlen($meldung)>0)?$meldung:'' ?></div>
	<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
		<ul id="no-style">
        <?php
		$ausgabe="";
		if(isset($kid)){
			$ausgabe="<input type='hidden' value='$kid' name='kid'>";
		}
			foreach($kriterien as $kriterium){
				$unterkriterien=$rep->readUnterKriterien($kriterium->getId());
				$summeunterkriterien=0;
				foreach($unterkriterien as $unterkriterium){
					$summeunterkriterien+=$unterkriterium->getGewichtung();
				}

				$ausgabe.="<li>
                            <a href='?delete=" . $kriterium->getId() . "'>
                                <div class='fas fa-minus-circle' title='Kategorie löschen' style='color:red'>
                                </div>
                            </a>
                            <span class='criterion'>" . $kriterium->getName(). "</span>
                            <label>Gewichtung:</label>
                            <input class='form-control form-control-critera' type='number'  min='1' max='10' name='inp".$kriterium->getId().
							"' value='".$kriterium->getGewichtung()."' class='cr-gewichtung'> (in Prozent: " .
							number_format(($kriterium->getGewichtung() * 100)/$summekriterien, 2, ",", ".") . ") ";
					if(count($unterkriterien)>0&&!isset($kid)){
						$ausgabe.= "<ul id='no-style'>";
							foreach($unterkriterien as $unterkriterium){
								$ausgabe.="<li>
                                                <a href='?deletesub=". $unterkriterium->getID() . "'>
                                                    <div class='fas fa-minus-circle' title='Unterkategorie löschen' style='color:red'>
                                                    </div>
                                                </a>
											<span class='subcriterion'>" . $unterkriterium->getName() . "</span> (Gewichtung: ". $unterkriterium->getGewichtung() .
											", in Prozent: " . number_format(($unterkriterium->getGewichtung() * 100)/$summeunterkriterien, 2, ",", ".")." %)</li>";
							}
						if(!isset($kid)){
							$ausgabe.="<li>
                                            <a href='?add=".$kriterium->getId()."'>
                                                <div class='fas fa-plus-circle' title='Neue Unterkategorie anlegen' style='color:green'>
                                                </div>
                                            </a>
                                       </li>";
						}
						$ausgabe.="</ul>";
					}
				$ausgabe.="</li>";
			}
			echo $ausgabe;
		?>
		<hr>
        <h4>Neues Kriterium</h4>
		<div class="row">
            <div class="col-md-6">
                <label for="kriterium">Name</label>
                <input class="form-control" type="text" name="kriterium" id="kriterium" placeholder="" value="<?php echo $name; ?>" required>
            </div>
            <div class="col-md-2">
                <label for="kriterium">Gewichtung</label>
                <input type="number" name="gewichtung" id="gewichtung"
                       min="1" max="5" class="form-control" value="<?php echo $gewichtung; ?>" required>
            </div>
            <div class="col-md-4 form-button-wrap">
                <button class="btn btn-primary form-button" type="submit" name="senden">Absenden</button>
            </div>
        </div>
	</form>
    </div>
</div>

<?php include "include/page/bottom.php"; ?>

