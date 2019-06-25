<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = false;

// defines the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 0;

// includes base function like session handling
include "snippets/init.php";

// defines the name of the current page, displayed in the title and as a header on the page
$title = "Willkommen am Beschaffungsportal vom AMS Wien";
include "snippets/top.php";
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

<?php include "snippets/bottom.php"; ?>
