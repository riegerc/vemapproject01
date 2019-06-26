<?php
// defines if the page is restricted to logged-in Users only
$pageRestricted = false;

// defindes the minimum userRole to access the page, if the
// userRole is lower than the level, a 403 Error-Page is returned
$userLevel = 1;

// includes base function like session handling
include "include/init.php";

// defindes the name of the current page, displayed in the title and as a header on the page
$title = "";
include "include/page/top.php";
include_once "include/database.php";

$tenderGetID=(int)$_GET["tenderID"];

$sql = "SELECT tenders.objectID AS DocNumber, 
                               tenders.tender, 
                               tenders.description,
                               tenders.tenderType,
                               user.branchName AS branchName,
                                user.street,
                                user.houseNumber,
                                user.stairs,
                               user.door,
                               user.postCode,
                               user.city,
                               user.country,
                               tenders.begin,
                               tenders.end,
                                tenders.amount
                        FROM tenders
                        LEFT JOIN user ON tenders.userFID = user.objectID 

                        WHERE tenders.objectID=:tenderGetID  ";

$stmt = connectDB()->prepare($sql);
$stmt->bindParam(":tenderGetID", $tenderGetID);
$stmt->execute();

$row=$stmt->fetch();

$dateBegin=date_create($row["begin"]);
$dateEnd=date_create($row["end"]);
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
    <div class="content">
        <a href="overview_tenders.php" >&#8636 Zurück zu ihren Ausschreibungen</a>
        <h2><?php echo $row["tender"] ?></h2>

        <a href="pdf.php?id=<?php $row["$tenderGetID"] ?>" class="float-right" ><button type="button" class="btn btn-danger"><i class="fas fa-file-download"></i> Als PDF herunterladen</button> </a>
        <br>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="row">Art des Auftrags:</th>
                <td><?php echo $row["tenderType"] ?></td>
            </tr>

            <tr>
                <th scope="row">Auftraggeber:</th>
                <td><?php echo $row["branchName"] ?></td>

            </tr>

            <tr>
                <th scope="row">Beginn:</th>
                <td><?php echo date_format($dateBegin,"d.m.Y") ?></td>
            </tr>

            <tr>
                <th scope="row">Ende:</th>
                <td><?php echo date_format($dateEnd,"d.m.Y") ?></td>
            </tr>

            <tr>
                <th scope="row">Beschreibung:</th>
                <td><?php echo $row["description"] ?></td>
            </tr>

            <tr>
                <th scope="row">Erfüllungsort:</th>
                <td><?php echo $row["street"] . $row["houseNumber"] . "/" . $row["stairs"] . "/" . $row["door"] . "<br>" . $row["postCode"] . $row["city"] . "<br>" . $row["country"] ?></td>
            </tr>

            <tr> <!-- If Dienstleistung keine Menge einzeigen -->
                <th scope="row">Menge:</th> <!-- If Dienstleistung keine Menge einzeigen -->
                <td><?php echo $row["amount"] ?></td> <!-- If Dienstleistung keine Menge einzeigen -->
            </tr> <!-- If Dienstleistung keine Menge einzeigen -->



            </thead>
        </table>

    </div>
</div>

<?php include "include/page/bottom.php"; ?>

