<?php
/*
Autor: Theo Isporidi
*/
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = true; // defines if the page is restricted to logged-in Users only
$userLevel = PERM_CED_REVIEW; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Review Übersichts-Tabelle"; // defines the name of the current page, displayed in the title and as a header on the page

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

$reviewedcompanies = [];
$statement = $db->query("SELECT DISTINCT supplierUserFID, branchname FROM reviews
	INNER JOIN user ON user.objectID = supplierUserFID
	ORDER BY branchname");
while ($row = $statement->fetch()) {
	array_push($reviewedcompanies, (int) $row["supplierUserFID"]);
}

echo "<table class='table table-bordered table-striped'>\n<thead class='thead-light'>\n";
echo "<tr><th>Nummer</th><th>Name</th>";
$statement = $db->query("SELECT objectID, name FROM criteria WHERE deleted = 0 ORDER BY objectID");
$rownames = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($rownames as $row) {
	echo "<th>$row[name]</th>";
}
echo "<th>Gesamt</th></tr>\n</thead>\n<tbody>\n";

foreach ($reviewedcompanies as $company) {
	$statement = $db->prepare("SELECT user.objectID AS userID, user.branchname, criteria.objectID AS critID, criteria.name AS critname ,subcriteria.name AS subname,AVG(mark) AS avgmark
	FROM reviewsmark 
	INNER JOIN reviews ON reviewsmark.reviewsFID = reviews.objectID
	INNER JOIN subcriteria ON reviewsmark.undercriteriaFID = subcriteria.objectID
	INNER JOIN criteria ON subcriteria.criteriaFID = criteria.objectID
	INNER JOIN user ON user.objectID = supplierUserFID
	WHERE supplierUserFID=?
	GROUP BY undercriteriaFID
	ORDER BY critID");
	$statement->execute([$company]);

	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$sum = [];
	foreach ($result as $row) {
		if (!isset($sum[$row["critID"]])) {
			$sum[$row["critID"]] = round($row["avgmark"], 2);
		} else {
			$sum[$row["critID"]] += round($row["avgmark"], 2);
		}
	}

	// IMPORTANT !!!
	// Values for good, average and bad are hardcoded at the moment to 0-29, 30-69, 70-100
	echo "<tr><td>$row[userID]</td><td>$row[branchname]</td>";
	$gesamt = 0;
	$anzahl = 0;
	foreach($rownames as $row) {
		if (isset($sum[$row["objectID"]])) {
			if ($sum[$row["objectID"]] < 30) {
				echo "<td class='table-danger'>";
			} else if ($sum[$row["objectID"]] < 70) {
				echo "<td class='table-warning'>";
			} else {
				echo "<td class='table-success'>";
			}
			echo number_format($sum[$row["objectID"]], 2, ",",".") . "</td>";
			$gesamt += $sum[$row["objectID"]];
			$anzahl++;
		} else {
			echo "<td>-</td>";
		}
	}
	if ($anzahl != 0) {
		$gesamt = $gesamt / $anzahl;
		echo "<td>" . number_format($gesamt, 2, ",", ".") . "</td>";
	} else {
		echo "<td>-</td>";
	}
	
	echo "</tr>\n";
}

echo "</tbody>\n</table>\n";

?>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
