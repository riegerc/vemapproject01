<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = true;

// defindes the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 1;

// includes base function like session handling
include "snippets/init.php";

// defindes the name of the current page, displayed in the title and as a header on the page
$title = "";
include "snippets/header.php";
include "snippets/top.php";
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
    </div>
</div>

<?php include "snippets/bottom.php"; ?>

