<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Willkommen am Beschaffungsportal vom AMS Wien"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <p>
            Dieses B2B Portal ist das zentrale Kommunikationsmedium zu unseren Anbietern und<br>
            Auftragnehmern, über das wir Einkaufsprojekte abwickeln und damit Prozesse optimieren.<br>
            <br>
        </p>
        <ul>
            <li>Von uns eingeladene Anbieter können sich hier Ausschreibungsdokumente herunterladen und Angebote
                abgeben.
            </li>
            <li>Mitarbeiter können Standardartikel über den Multilieferantenkatalog abrufen.</li>
            <li>Um die Zusammenarbeit ständig zu verbessern, werden die Auftragnehmer einer regelmäßigen Bewertung
                unterzogen.
            </li>

        </ul>
        <p>
            <br>
            Es werden ausschließlich Technologien verwendet, die einen sicheren Datenaustausch ermöglichen.
        </p>
    </div>
</div>

<?php include "include/page/bottom.php"; ?>
