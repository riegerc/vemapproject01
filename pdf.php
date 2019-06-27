<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once "include/constant.php";

$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = "Übersicht"; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = "Ausschreibungen PDF"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php"; // top-part of html-template (stylesheets, navigation, ..)

$pdfID = (int)$_GET["id"];

if ($pdfID < 1) header("location:error.php?e=400");
$db = connectDB();

$sql = "SELECT *,tenders.objectID AS DocNr
        FROM tenders
            LEFT JOIN user ON tenders.userFID = user.objectID
        WHERE tenders.objectID =:pdfID";

$stmt = $db->prepare($sql);
$stmt->bindParam(":pdfID", $pdfID);
$stmt->execute();

if (!$row = $stmt->fetch()) header("location:error.php?e=400");


//if ($row["objectID"] != $_SESSION["id"]) header("location:error.php?e=400");


$bdate = date_create($row["begin"]);
$edate = date_create($row["end"]);
$adr = "";
if (!empty($row["stairs"])) $adr = $row["stairs"];
if (!empty($row["door"])) $adr = $adr . "/" . $row["door"];

require('classes/FPDF/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage('P', 'A4');
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTopMargin(10);
$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(10);


/* --- Rect --- */
$pdf->Rect(10, 10, 190, 270, 'D');
/* --- Image --- */
$pdf->Image('img/amsPDFlogo.png', 10, 11, 63, 37);
/* --- Cell_DOC.NR --- */
$pdf->SetXY(75, 11);
$pdf->SetFont('', 'B', 12);
$pdf->Cell(0, 4, 'Dokumentennummer: ', 0, 1, 'L', false);
$pdf->SetXY(125, 11);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["DocNr"]), 0, 1, 'L', false);
/* --- Cell_CPV --- */
$pdf->SetXY(75, 18);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'CPV: ', 0, 1, 'L', false);
$pdf->SetXY(125, 18);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["cpvCode"]), 0, 1, 'L', false);
/* --- Cell_amsAddress --- */
$pdf->SetXY(75, 25);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Auftraggeber: ', 0, 1, 'L', false);
$pdf->SetXY(125, 25);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["branchName"]), 0, 1, 'L', false);
/* --- Cell_address --- */
$pdf->SetXY(125, 32);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["street"]) . " " . utf8_decode($row["houseNumber"]) . "/" . $adr, 0, 1, 'L', false);
$pdf->SetXY(125, 39);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["postCode"]) . " " . utf8_decode($row["city"]), 0, 1, 'L', false);
$pdf->SetXY(125, 45);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["country"]) . " " . utf8_decode($row["sectorCode"]), 0, 1, 'L', false);

/* --- Cell_ams_firs&lastName --- */
$pdf->SetXY(75, 59);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Ansprechpartner: ', 0, 1, 'L', false);
$pdf->SetXY(125, 59);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["firstName"]) . " " . utf8_decode($row["lastName"]), 0, 1, 'L', false);
/* --- Cell_amsPhone --- */
$pdf->SetXY(75, 66);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Telefon: ', 0, 1, 'L', false);
$pdf->SetXY(125, 66);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["telNr"]), 0, 1, 'L', false);
/* --- Cell_amsEmail --- */
$pdf->SetXY(75, 73);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'E-Mail: ', 0, 1, 'L', false);
$pdf->SetXY(125, 73);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["email"]), 0, 1, 'L', false);
/* --- Cell_assignment --- */
$pdf->SetXY(10, 93);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Bezeichnung des Auftrags: ', 0, 1, 'L', false);
/* --- MultiCell --- */
$pdf->SetXY(10, 100);
$pdf->SetFont('Courier', '', 12);
$pdf->MultiCell(0, 4, utf8_decode($row["tender"]), 0, 'L', false);
/* --- Cell_assignmentType --- */
$pdf->SetXY(10, 114);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Art des Auftrags: ', 0, 1, 'L', false);
$pdf->SetXY(60, 114);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["tenderType"]), 0, 1, 'L', false);
/* --- Cell_beginDate --- */
$pdf->SetXY(10, 128);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Zeitfenster: ', 0, 1, 'L', false);
$pdf->SetXY(60, 128);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, date_format($bdate, 'd.m.Y') . " - " . date_format($edate, 'd.m.Y'), 0, 1, 'L', false);
/* --- Cell_text --- */
$pdf->SetXY(10, 142);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Gegenstand der Leistung:', 0, 1, 'L', false);
/* --- MultiCell_text --- */
$pdf->SetXY(10, 149);
$pdf->SetFont('Courier', '', 12);
$pdf->MultiCell(0, 4, utf8_decode($row["description"]), 0, 'L', false);

$pdf->Output('auftrag' . $pdfID . '.pdf', 'I');
?>
