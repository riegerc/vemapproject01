<?php

$navigationItems =
    [
        "sections" => [
            "section" => "",
            "categories" => [
                ["name" => "Ausschreibungen",
                    "links" => [
                        ["name" => "Ihre Ausschreibungen", "url" => "overview_tenders.php", "minUserLevel" => PERM_VIEW_OFFER],
                        ["name" => "Lieferant anlegen", "url" => "create_supplier.php", "minUserLevel" => PERM_CED_SUPPLIER],
                        ["name" => "Ausschreibung erstellen", "url" => "create_tender.php", "minUserLevel" => PERM_CED_SUPPLIER],
                        ["name" => "Erstellte Ausschreibungen", "url" => "ams_response.php", "minUserLevel" => PERM_CED_SUPPLIER],
                    ],
                    "icon" => "<i class='fas fa-file-invoice'></i>",
                    "minUserLevel" => PERM_VIEW_OFFER_MENU
                ],
                ["name" => "Webshop",
                    "links" => [
                        ["name" => "Kunde", "url" => "webshop_kunde.php", "minUserLevel" => PERM_ORDER_FROM_CATALOGUE],
                        ["name" => "Lieferant", "url" => "webshop_lieferant.php", "minUserLevel" => PERM_INSERT_INTO_CATALOGUE],
                    ],
                    "icon" => "<i class='fas fa-store-alt'></i>",
                    "minUserLevel" => PERM_VIEW_WEBSHOP_MENU
                ],
                ["name" => "Bewertungen",
                    "links" => [
                        ["name" => "Übersicht", "url" => "review_uebersichts_tabelle.php", "minUserLevel" => PERM_CED_REVIEW],
                        ["name" => "Bewertung verwalten", "url" => "kriterien.php", "minUserLevel" => PERM_CED_REVIEW],
                        ["name" => "Lieferant bewerten", "url" => "lieferant.php?what=1", "minUserLevel" => PERM_MAKE_REVIEW],
                        ["name" => "Auswertung", "url" => "lieferant.php?what=2", "minUserLevel" => PERM_VIEW_REVIEW],
                    ],
                    "icon" => "<i class='fas fa-edit'></i>",
                    "minUserLevel" => PERM_VIEW_RATING_MENU
                ],
                ["name" => "User",
                    "links" => [
                        ["name" => "Übersicht", "url" => "user.php", "minUserLevel" => PERM_CED_USER],
                        ["name" => "Erstellen", "url" => "create_user.php", "minUserLevel" => PERM_CED_USER],
                    ],
                    "icon" => "<i class='fas fa-users'></i>",
                    "minUserLevel" => PERM_VIEW_CLIENT_MENU
                ],
            ],
            "minUserLevel" => PERM_EDIT_SELF,
        ],
    ];

$standaloneLinks =
    [
        ["name" => "<i class='fas fa-balance-scale'></i> Impressum", "url" => "impressum.php",],
        ["name" => "<i class='fas fa-sitemap'></i> Sitemap", "url" => "sitemap.php",],
    ]

?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="<?php echo PAGE_ICON ?>" id="page-logo" alt="Seiten-Logo"/>
        </div>
    </a>
    <hr class="sidebar-divider my-0">
    <?php
    if (empty($_SESSION) ||
        !isset($_SESSION[USER_ID]) ||
        !isset($_SESSION[USER_NAME]) ||
        !isset($_SESSION[USER_PERMISSION])) {
        echo "
            <li class='nav-item'>
                <div class='nav-link'>
                    <form action='' method='POST'>
                        <div class='form-group'>
                            <label for='email'><small>Email</small></label>
                            <input class='form-control' type='email' name='email' id='email'>
                        </div>
                        <div class='form-group'>
                            <label for='password'><small>Passwort</small></label>
                            <input class='form-control' type='password' name='password' id='password'>
                        </div>
                        <div class='form-group'>
                            <button class='btn btn-secondary float-right' type='submit' name='login' id='submit'>Login</button>
                        </div>
                    </form>
                </div>
            </li>";
    } else {
        echo "
            <li class='nav-item'>
                <a class='nav-link ' href='index.php'>
                    <i class='fa fa-home'></i>
                    <span>Home</span>
                </a>
            </li>";
        // Output Navigation-Sections
        foreach ($navigationItems as $sectionKey => $section) {
            // Check user-permission
            if ($perm->hasPermission($section["minUserLevel"])) {
                echo "<div class='sidebar-heading'>$section[section]</div>";

                // Output Navigation-Categories
                foreach ($section["categories"] as $categoryKey => $category) {
                    // Check user-permission
                    if ($perm->hasPermission($category["minUserLevel"])) {
                        echo "<li class='nav-item'>
                            <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapse$sectionKey$categoryKey'
                               aria-expanded='true' aria-controls='collapse$sectionKey$categoryKey'>
                                <span class='navbar-icon'>$category[icon]</span> 
                                <span>$category[name]</span>
                            </a>
                            <div id='collapse$sectionKey$categoryKey' class='collapse' aria-labelledby='heading$sectionKey$categoryKey' data-parent='#accordionSidebar'>
                              <div class='bg-white py-2 collapse-inner rounded'>";
                        // Output Category-Links
                        foreach ($category["links"] as $linkKey => $link) {
                            // Check user-permission
                            if ($perm->hasPermission($link["minUserLevel"])) {
                                echo "<a class='collapse-item' href='$link[url]'>";
                                echo $link["name"] == "" ? $link["url"] : $link["name"];
                                echo "</a>";
                            }
                        }
                        echo "</div>";
                        echo "</div>";
                        echo "</li>";
                    }
                }
                foreach ($standaloneLinks as $link) {
                    echo "<li class='nav-item'>";
                    echo "<a class='nav-link ' href='index.php'>";
                    echo $link["name"] == "" ? $link["url"] : $link["name"];
                    echo "</a>";
                    echo "</li>";
                }
            } else {
                echo $section["minUserLevel"] . "<br>";
            }
        }
    }
    ?>
</ul>
