<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Error <?php $_GET["e"] ?></title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <style>
        .text-center {
            display: flex;
            justify-content: center;
            flex-direction: row;
            align-content: center;
        }
    </style>
    <?php
        $errorCodes = [
            "400" => "Bad request",
            "401" => "Du hast keine Berechtigung um diese Seite zu besuchen",
            "403" => "Du hast keine Berechtigung um diese Seite zu besuchen",
            "404" => "Seite nicht gefunden",
        ]
    ?>
</head>

<body id="page-top">

<div class="container-fluid">
    <br>
    <br>
    <br>
    <br>

    <!-- 404 Error Text -->
    <div class="text-center">
        <div>
        <?php echo "<div class='error mx-auto' data-text='$_GET[e]'>$_GET[e]</div>" ?>
        <p class="lead text-gray-800 mb-5"><?php echo $errorCodes[$_GET["e"]] ?></p>
        <a href="index.php">&larr; Zurück zur Hauptseite</a>
        </div>
    </div>

</div>
</body>
</html>