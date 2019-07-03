<?php
// Author: Frederik Gschaider

$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <ul>
            <li><a href="index.php">Home</a> </li>
            <li><a href="#">Ausschreibungen</a>
                <ul>
                    <li><a href="overview_tenders.php">Ihre Ausschreibungen</a></li>
                    <li><a href="create_supplier.php">Lieferant anlegen</a></li>
                    <li><a href="create_tender.php">Ausschreibung erstellen</a></li>
                </ul>
            </li>
            <li><a href="#">Webshop</a>
                <ul>
                    <li><a href="webshop_kunde.php">Kunde</a></li>
                    <li><a href="webshop_lieferant.php">Lieferant</a></li>
                </ul></li>
            <li><a href="#">Bewertungen</a>
                <ul>
                    <li><a href="review_uebersichts_tabelle.php">Übersicht</a></li>
                    <li><a href="kriterien.php">Bewertung verwalten</a></li>
                    <li><a href="lieferant.php?what=1">Lieferant bewerten</a></li>
                    <li><a href="lieferant.php?what=2">Auswertung</a></li>
                </ul></li>
            <li><a href="#">User</a>
                <ul>
                    <li><a href="user.php">Übersicht</a></li>
                    <li><a href="create_user.php">Erstellen</a></li>
                </ul></li>
        </ul>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
