<?php
// Author: Oliver Stingl

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
    <hr>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
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
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-landing border-primary">
                    <div class="card-header bg-gradient-primary text-light">
                        <i class="fas fa-piggy-bank"></i> Kosten sparen
                    </div>
                    <div class="card-body">
                        Ein Multilieferentenkatalog ermöglicht Produkte bei Lieferanten zu bestellen, welche die
                        niedrigsten Preise anbieten.
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-landing border-secondary">
                    <div class="card-header bg-gradient-secondary text-light">
                        <i class="fas fa-project-diagram"></i> Einfacher Prozessablauf
                    </div>
                    <div class="card-body">
                        Die Übersichtlichkeit des Portals ermöglicht eine einfache Produktbestellung. Über wenige,
                        einfache Schritte werden Ausschreibungen erstellt, an Lieferanten weitergeleitet und
                        letztlich beim bestmöglichen Lieferant bestellt.
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-landing border-danger">
                    <div class="card-header bg-gradient-danger text-light">
                        <i class="fas fa-clipboard-check"></i> Qualitätssicherung
                    </div>
                    <div class="card-body">
                        Ein Bewertungssystem der Lieferanten soll sicherstellen, dass nur bei den besten Lieferanten
                        bestellt wird. Die Bewertungen fordert die Lieferanten auf, sich an die Förderungen anzupassen.
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <p>
            Es werden ausschließlich Technologien verwendet, die einen sicheren Datenaustausch ermöglichen.
        </p>
    </div>
</div>

<?php include "include/page/bottom.php"; ?>
