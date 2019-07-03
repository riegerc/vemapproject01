<?php
// Author: Frederik Gschaider

$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Sitemap"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <!-- Content -->
        <p>Eine Übersicht über die Web Site: </p>
        <?php
        echo "<ul class='no-style'>";
        echo "<li><a href='index.php'><i class='fa fa-home'></i><span>Home</span></a></li>";
        // Output Navigation-Sections
        foreach ($navigationItems as $sectionKey => $section) {
            // Check user-permission
            if ($perm->hasPermission($section["minUserLevel"])) {
                echo "<h5>$section[section]</h5>";
                echo "<ul class='no-style'>";

                // Output Navigation-Categories
                foreach ($section["categories"] as $categoryKey => $category) {
                    if ($category["name"] !== "Sitemap") {
                        // Check user-permission
                        if ($perm->hasPermission($category["minUserLevel"])) {
                            echo "<li>$category[icon] $category[name]</li>";
                            echo "<ul class='no-style'>";
                            foreach ($category["links"] as $linkKey => $link) {
                                // Check user-permission
                                if ($perm->hasPermission($link["minUserLevel"])) {
                                    echo "<li>";
                                    echo "<a href='$link[url]'>";
                                    echo $link["name"] == "" ? $link["url"] : $link["name"];
                                    echo "</a>";
                                    echo "</li>";
                                }
                            }
                            echo "</ul>";
                        }
                    }
                }
                echo "</ul>";
            }
        }
        echo "</ul>";
        ?>
    </div>
</div>

<?php include "include/page/bottom.php"; // bottom-part of html-template (footer, scripts, .. ) ?>
