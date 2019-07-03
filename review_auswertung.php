<?php
/*
Autor: Theo Isporidi
*/
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = true; // defines if the page is restricted to logged-in Users only
$userLevel = PERM_VIEW_REVIEW; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Reviewauswertung"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
require_once("include/helper.inc.php");
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
		<!-- Content -->
		
<?php
$db = connectDB();

if (isset($_GET["lieferantid"])) {
	$lieferantid = (int) Helper::sanitize($_GET["lieferantid"]);
	$reviewedcompanies = [$lieferantid];
} else {
	$reviewedcompanies = [];
	$statement = $db->query("SELECT DISTINCT supplierUserFID FROM reviews");
	while ($row = $statement->fetch()) {
		array_push($reviewedcompanies, (int) $row["supplierUserFID"]);
	}
}

foreach ($reviewedcompanies as $company) {
	$statement = $db->prepare("SELECT branchName FROM user WHERE objectID=?");
	$statement->execute([$company]);
	$row = $statement->fetch();
	echo "<h4>Durchschnittliche Bewertung der Firma $row[branchName]</h4>";

	$statement = $db->prepare("SELECT criteria.name AS critname ,subcriteria.name AS subname,AVG(mark) AS avgmark
	FROM reviewsmark 
	INNER JOIN reviews ON reviewsmark.reviewsFID = reviews.objectID
	INNER JOIN subcriteria ON reviewsmark.undercriteriaFID = subcriteria.objectID
	INNER JOIN criteria ON subcriteria.criteriaFID = criteria.objectID
	WHERE supplierUserFID=?
	GROUP BY undercriteriaFID");
	$statement->execute([$company]);

	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$sum = [];
	foreach ($result as $row) {
		if (!isset($sum[$row["critname"]])) {
			$sum[$row["critname"]] = round($row["avgmark"], 2);
		} else {
			$sum[$row["critname"]] += round($row["avgmark"], 2);
		}
	}

	$Kriterium = "";

	foreach($result as $row) {
		if ($Kriterium != $row["critname"]) {
			if ($Kriterium != "") echo "</ul>";
			$Kriterium = $row["critname"];
			echo "<span class='criterion'>$Kriterium</span> (Summe: " . number_format($sum[$Kriterium],2,",",".") . ")\n<ul id='nostyle'>\n";
		}
		echo "<li><span class='subcriterion'>$row[subname] : " . number_format($row["avgmark"],2,",",".") . "</span></li>\n";
	}
	echo "</ul>\n";
}


?>
	<a href="bewertung.php?lieferantid=<?= $lieferantid?>"><div class="btn btn-primary" style="margin-bottom:15px">Zur Übersicht</div></a>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
