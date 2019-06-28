<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
include "classes/repository.inc.php"; // top-part of html-template (stylesheets, navigation, ..)

$rep=new Repository();
$kriterien=$rep->readKriterien();
foreach($kriterien as $kriterium){
	$unterkriterien=$rep->readUnterKriterien($kriterium->getId());
	echo "<pre>";
	print_r($unterkriterien);
	echo "</pre>";
}

?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
