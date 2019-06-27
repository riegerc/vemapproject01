<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = false;

// defines the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 1;

// includes base function like session handling
include "include/init.php";

// defines the name of the current page, displayed in the title and as a header on the page
$title = "";
include "include/page/top.php";

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
}else{
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
		$key=Helper::getId($key);
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
		<ul class="cr-list">
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
								
				$ausgabe.="<li><span class='criterion'>" . $kriterium->getName(). "</span> <label>Gewichtung: <input type='number' min='1' max='10' name='inp".$kriterium->getId().
							"' value='".$kriterium->getGewichtung()."' class='cr-gewichtung'> (in Prozent: " .
							number_format(($kriterium->getGewichtung() * 100)/$summekriterien, 2, ",", ".") . ")</label> ";
					if(count($unterkriterien)>0&&!isset($kid)){
						$ausgabe.="<ul>";
							foreach($unterkriterien as $unterkriterium){
								$ausgabe.="<li><span class='subcriterion'>" . $unterkriterium->getName() . "</span> (Gewichtung: ". $unterkriterium->getGewichtung() .
											", in Prozent: " . number_format(($unterkriterium->getGewichtung() * 100)/$summeunterkriterien, 2, ",", ".")." %)</li>";
							}
						$ausgabe.="</ul>";
					}
				$ausgabe.="</li>";
				if(!isset($kid)){
					$ausgabe.="<a href='?add=".$kriterium->getId()."'><div class='fas fa-plus-circle' title='Neue Unterkategorie anlegen' style='color:green'></div></a>";
				}
			}
			echo $ausgabe;
		?>
		<hr>
		<li><label for="kriterium">neues Kriterium: </label><br><input type="text" name="kriterium" id="kriterium" placeholder="Name des neuen Kriteriums" value="<?php echo $name; ?>"><br>
		<input type="text" name="gewichtung" id="gewichtung"
				placeholder="Gewichtung" value="<?php echo $gewichtung; ?>"></li>
		</ul>
		<button type="submit" name="senden">Absenden</button>
	</form>
    </div>
	<script src="js/functions.js"></script>
</div>

<?php include "include/page/bottom.php"; ?>

