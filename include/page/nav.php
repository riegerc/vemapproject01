<?php

$navigationItems =
    [
        [
            "section" => "Allgemein",
            "categories" => [
                ["name" => "Ausschreibungen",
                    "links" => [
                        ["name" => "Ihre Ausschreibungen", "url" => "overview_tenders.php", "minUserLevel" => 0],
                        ["name" => "Lieferant anlegen", "url" => "create_supplier.php", "minUserLevel" => 0],
                        ["name" => "Ausschreibung erstellen", "url" => "create_tender.php", "minUserLevel" => 0],
                    ],
                    "icon" => "<i class='fas fa-file-invoice'></i>",
                    "minUserLevel" => 0
                ],
                ["name" => "Webshop",
                    "links" => [
                        ["name" => "Kunde", "url" => "webshop_kunde.php", "minUserLevel" => 0],
                        ["name" => "Lieferant", "url" => "webshop_lieferant.php", "minUserLevel" => 0],
                    ],
                    "icon" => "<i class='fas fa-store-alt'></i>",
                    "minUserLevel" => 0
                ],
                ["name" => "Bewertungen",
                    "links" => [
                        ["name" => "Einkauf", "url" => "#", "minUserLevel" => 0],
                        ["name" => "Lieferant", "url" => "#", "minUserLevel" => 0],
                    ],
                    "icon" => "<i class='fas fa-edit'></i>",
                    "minUserLevel" => 0
                ],["name" => "User",
                    "links" => [
                        ["name" => "User", "url" => "user.php", "minUserLevel" => 0],
                        ["name" => "Update", "url" => "update.php", "minUserLevel" => 0],
                    ],
                    "icon" => "<i class='fas fa-users'></i>",
                    "minUserLevel" => 0
                ],

            ],
            "minUserLevel" => 0
        ],
    ];


?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="<?php echo PAGE_ICON ?>" id="page-logo" alt="Seiten-Logo"/>
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo PAGE_NAME ?></div>
    </a>
    <hr class="sidebar-divider my-0">
    <?php
    if (empty($_SESSION)) {
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
            if ($section["minUserLevel"] <= $_SESSION["userRole"]) {
                echo "<div class='sidebar-heading'>$section[section]</div>";

                // Output Navigation-Categories
                foreach ($section["categories"] as $categoryKey => $category) {
                    // Check user-permission
                    if ($category["minUserLevel"] <= $_SESSION["userRole"]) {
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
                            if ($link["minUserLevel"] <= $_SESSION["userRole"]) {
                                echo "<a class='collapse-item' href='$link[url]'>$link[name]</a>";
                            }
                        }
                        echo "</div>
                  </div>
                </li>";
                    }
                }
            }
        }
    }
    ?>
</ul>
