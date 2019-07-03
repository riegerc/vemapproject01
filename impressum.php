<?php
// Author: Frederik Gschaider

$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Impressum"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <p><b>Arbeitsmarktservice</b><br>
            Dienstleistungsunternehmen des öffentlichen Rechts<br>
            Treustraße 35-43<br>
            1200 Wien<br>
            Telefon: +43 1 33178-0<br>
            Telefax: +43 1 33178-121<br>
            E-Mail: <a title="E-Mail AMS" href="mailto:ams.oesterreich@ams.at" style="display: inline-block;" tabindex="0">ams.oesterreich@ams.at <br>
            </a></p>
        <p>UID: ATU 38908009<br>
        </p>
        <p><b>Bankverbindung:</b></p>
        <p>BAWAG P.S.K.</p>
        <p>IBAN AT39 6000 0000 0600 0839</p>
        <p>BIC/SWIFT BAWAATWW</p>
        <p><a title="Organisation" href="https://www.ams.at/organisation/ueber-ams/organisation" tabindex="0">Organe</a></p>
        <p><a title="Bankverbindungen" href="https://www.ams.at/organisation/ueber-ams/bankverbindungen" tabindex="0">Alle Bankverbindungen des Arbeitsmarktservice</a></p>


    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
