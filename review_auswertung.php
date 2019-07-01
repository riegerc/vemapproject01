<?php
/*
Autor: Theo Isporidi
*/
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Reviewauswertung"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
		<!-- Content -->
		
<?php
$db = connectDB();

$reviewedcompanies = [];
$statement = $db->query("SELECT DISTINCT supplierUserFID FROM reviews");
while ($row = $statement->fetch()) {
	array_push($reviewedcompanies, (int) $row["supplierUserFID"]);
}

$Kriterium = "";
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
	
	while($row = $statement->fetch()) {
		if ($Kriterium != $row["critname"]) {
			if ($Kriterium != "") echo "</ul>";
			$Kriterium = $row["critname"];
			echo "<span class='criterion'>$Kriterium</span>\n<ul id='nostyle'>\n";
		}
		echo "<li><span class='subcriterion'>$row[subname] : $row[avgmark]</span></li>\n";
	}
	echo "</ul>\n";
}


?>
	<a href="bewertung.php">Zur Übersicht</a>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
