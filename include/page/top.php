<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
    <title><?php echo "$title |" . PAGE_NAME ?></title>
</head>
<body id="page-top">
<div id="wrapper">
    <?php include "nav.php"; ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <?php
                if (isset($_SESSION[USER_NAME])) {
                    echo "
                        <ul class='navbar-nav ml-auto'>
                            <div class='topbar-divider d-none d-sm-block'></div>
                            <li class='nav-item dropdown no-arrow'>
                                <a class='nav-link dropdown-toggle' href='#' id='userDropdown' role='button'
                                   data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                    <span class='mr-2 d-none d-lg-inline text-gray-600 small'>" .
                                        $_SESSION[USER_NAME]
                        . "</span>
                                </a>
                                <div class='dropdown-menu dropdown-menu-right shadow animated--grow-in'
                                     aria-labelledby='userDropdown'>
                                    <a class='dropdown-item' href='#' data-toggle='modal' data-target='#logoutModal'>
                                        <i class='fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400'></i>
                                        Ausloggen
                                    </a>
                                </div>
                            </li>
                        </ul>";
                }
                ?>
            </nav>
