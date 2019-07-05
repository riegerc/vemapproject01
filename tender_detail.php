<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = ""; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Übersicht"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

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
                               tenders.end
                                
                        FROM tenders
                        LEFT JOIN user ON tenders.userFID = user.objectID 

                        WHERE tenders.objectID=:tenderGetID  ";
//tenders.amount
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
        <a href="overview_tenders.php" >&#8636 Zurück zu Ihren Ausschreibungen</a>
        <h2><?php echo $row["tender"] ?></h2>
        <a target="_blank" href="pdf.php?id=<?php echo $tenderGetID ?>" class="float-right" ><button type="button" class="btn btn-danger"><i class="fas fa-file-pdf"></i>Ausschreibung als PDF herunterladen</button> </a>

        <!-- <a href="vemapproject01/uploads/anhang01_<?php //echo $row["tender"] ?>.pdf" class="float-right" ><button type="button" class="btn btn-default"><i class="fas fa-file-download"></i>Anhang 1</button> </a> -->

        <a href="uploads/Dsvo%201.doc" class="float-right" ><button type="button" class="btn btn-default"><i class="fas fa-file-download"></i>Anhang 2</button> </a>

         <a href="uploads/agb1.doc" class="float-right" ><button type="button" class="btn btn-default"><i class="fas fa-file-download"></i>Anhang 1</button> </a>
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
                <td><?php
                    echo $row["street"] . " " . $row["houseNumber"] ;

                    if ($row["stairs"] | "" ) {echo "/" . $row["stairs"]; } ;

                    echo "/" . $row["door"] . "<br>" . $row["postCode"] . " " . $row["city"] . "<br>" . $row["country"] ?></td>
            </tr>

            </thead>

        </table>

        <a href="tender_response.php?tenderID=<?php echo $row["DocNumber"]?>"><button class="btn btn-outline-success">Angebot abgeben</button></a>

    </div>
</div>

<?php include "include/page/bottom.php"; ?>

