<?php
session_start();
?>
<html>
<head>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <style>
        .card-body {
            max-height: 600px;
            overflow-y: scroll;
        }
    </style>
</head>
<body>
<br>
<div class="container">
    <h1>Debug</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h1>$_SESSION</h1>
                </div>
                <div class="card-body">
                    <pre>
                    <?php var_dump($_SESSION); ?>
                    </pre>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h1>$_POST</h1>
                </div>
                <div class="card-body">
                    <pre>
                    <?php var_dump($_POST); ?>
                    </pre>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h1>$_GET</h1>
                </div>
                <div class="card-body">
                    <pre>
                    <?php var_dump($_GET); ?>
                    </pre>
                </div>
            </div>

        </div>
        <div class="col-md-12">
            <?php phpinfo(); ?>
        </div>
    </div>
</body>
</html>
