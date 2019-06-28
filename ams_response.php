<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)



$sql="SELECT userFID FROM user "
// TODO Abfrage das einem nur die Ausschreibungen angezeigt werden zu denen man eingeladen ist
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">

<h2>Erstellte Ausschreibungen</h2>


       <?php
       while ($row = $stmt->fetch()){ echo "<table>
            <thead>
            
            </thead>
        </table>";
} ?>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
