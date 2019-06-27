<?php
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
    < class="content">


        <?php //while ($row=$stmt->fetch()) {



        //}; ?>

        <h2>Webdesign Büro</h2>

        1.1.:
        10 Desktops <p>Langtext:  Prozessor: 3,4 GHz Quad-Core Intel Core i5 Prozessor
        Arbeitsspeicher: 8 GB DDR 4 - 2400 RAM
        Speicher: 1 TB Fusion Drive
        Grafik: Radeon Pro 570 mit 4 GB GDDR5 Grafikspeicher </p> Preis: <input name="" type="number">
          <br>
        1.2.:
        10  Monitore <p>Langtext: 27 Zoll (68,58 cm) Retina 5K Display mit 5.120 x 2.880 Pixeln </p> Preis: <input name="" type="number">
        <br>
        1.3.:
        10 Mäuse <p>Langtext: Logitech MX Vertical Ergonomische Maus 910-005448</p> Preis: <input name="" type="number">
        <br>
        1.4.:
        10 Tastatur <p>Langtext: Microsoft Surface Ergonomische Tastatur </p> Preis: <input name="" type="number">
        <br>
        1.5.:
        10 HDMI Kabel <p>Langtext: 5m - Ultra HD 4k HDMI Kabel 2.0b 60Hz 18GBit/s </p> Preis: <input name="" type="number">
       <br>

    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
