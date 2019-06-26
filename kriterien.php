<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = false;

// defindes the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 1;

// includes base function like session handling
include "snippets/init.php";

// defindes the name of the current page, displayed in the title and as a header on the page
$title = "";
include "snippets/header.php";
include "snippets/top.php";

require_once("classes/types/kriterium.inc.php");
require_once("classes/repository.inc.php");
require_once("include/helper.inc.php");

$rep=new Repository();
$sum=0;
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
		$sum+=$val;
	}
	$sum+=$gewichtung;
	echo "Summe: ".$sum;
	if($sum!==100){
		$meldung="Die Gewichtung der Kriterien muss in Summe 100 ergeben!";
	}else{
		if(isset($kid)){
			$rep->createUnterKriterium(new Kriterium($name,$gewichtung,0,$kid));
			$rep->update($extKriterien, $kid);
		}else{
			$rep->create(new Kriterium($name,$gewichtung));
			$rep->update($extKriterien);
		}
		header("location: ".$_SERVER["PHP_SELF"]);
	}
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
				$ausgabe.="<li><label>Gewichtung in %</label> <input type='text' name='inp".$kriterium->getId()."' value='".$kriterium->getGewichtung()."' class='cr-gewichtung'> <label class='cr-label'>".$kriterium->getName()."</label>";
					if(count($unterkriterien)>0&&!isset($kid)){
						$ausgabe.="<ul>";
							foreach($unterkriterien as $unterkriterium){
								$ausgabe.="<li>Gewichtung in % ".$unterkriterium->getGewichtung()." ".$unterkriterium->getName()."</li>";
							}
						$ausgabe.="</ul>";
					}
				$ausgabe.="</li>";
				if(!isset($kid)){
					$ausgabe.="<a href='?add=".$kriterium->getId()."'><img src='img/add-circle-green-512.png'></a>";
				}
			}
			echo $ausgabe;
		?>
		<hr>
		<li><label>neuesKriterium: </label><br><input type="text" name="kriterium" placeholder="Name des neuen Kriteriums" value="<?php echo $name; ?>" required><br>
		<input type="text" name="gewichtung" id="gewichtung"
				placeholder="Gewichtung des neuen Kriteriums" value="<?php echo $gewichtung; ?>" required></li><button onclick="calcWeight()">Berechnen</button>
		</ul>
		<button type="submit" name="senden">Absenden</button>
	</form>
    </div>
	<script src="js/functions.js"></script>
</div>

<?php include "snippets/bottom.php"; ?>

