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

        1.1<br>
        <p>Desktops</p> <p>Langtext:</p> <p>Preis:</p> <input type="number">
          <br>
        1.2<br>
        <p> Monitore</p> <p>Langtext:</p>
        <br>
        1.3<br>
        <p>Mäuse</p> <p>Langtext:</p>
        <br>
        1.4<br>
        <p>Tastatur</p> <p>Langtext:</p>
        <br>
        1.5<br>
        <p>HDMI Kabel</p> <p>Langtext:</p>
       <br>

    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
