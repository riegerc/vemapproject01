<?php
$pageTitle = "AMS";
$pageLogo = "img/ams.svg";
$pageDescription = "Beschaffungsportal für das AMS Wien";

$navigationItems =
    [
        [
            "section" => "Allgemein",
            "categories" => [
                ["name" => "Ausschreibungen",
                    "links" => [
                        ["name" => "Dokumente", "url" => "ausschreibungen_dokumente.php", "minUserLevel" => 0],
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
            ],
            "minUserLevel" => 0
        ],
//        [
//            "section" => "Lieferant",
//            "categories" => [
//                ["name" => "Beispiel-Kategorie 2",
//                    "links" => [
//                        ["name" => "Beispiel-Link 3", "url" => "#3", "minUserLevel" => 0],
//                        ["name" => "Beispiel-Link 4", "url" => "#4", "minUserLevel" => 0],
//                    ],
//                    "minUserLevel" => 0
//                ],
//            ],
//            "minUserLevel" => 0
//        ],
    ];
