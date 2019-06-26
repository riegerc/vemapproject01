<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 0; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = "Ausschreibungen-PDF"; // defines the name of the current page, displayed in the title and as a header on the page

$pdfID = (int)$_GET["id"];

if ($pdfID < 1) header("location:error.php?e=400");
include ("include/init.php");
$db=connectDB();

$sql = "SELECT *,tenders.objectID AS DocNr
        FROM tenders
            LEFT JOIN user ON tenders.userFID = user.objectID
        WHERE tenders.objectID =:pdfID";

$stmt = $db->prepare($sql);
$stmt->bindParam(":pdfID", $pdfID);
$stmt->execute();

if (!$row = $stmt->fetch()) header("location:error.php?e=400");


//if ($row["objectID"] != $_SESSION["id"]) header("location:error.php?e=400");


$bdate= date_create($row["begin"]);
$edate= date_create($row["end"]);

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
$pdf->SetXY(130, 11);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["DocNr"]), 0, 1, 'L', false);
/* --- Cell_DOC.NR --- */
$pdf->SetXY(75, 16);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'CPV: ', 0, 1, 'L', false);
$pdf->SetXY(130, 16);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["cpvCode"]), 0, 1, 'L', false);
/* --- Cell_amsAdress --- */
$pdf->SetXY(75, 23);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Auftraggeber: ', 0, 1, 'L', false);
$pdf->SetXY(130, 23);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["branchName"]), 0, 1, 'L', false);
/* --- Cell_ams_firs&lastName --- */
$pdf->SetXY(75, 33);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Ansprechpartner: ', 0, 1, 'L', false);
$pdf->SetXY(130, 33);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, utf8_decode($row["firstName"]) ." ".utf8_decode($row["lastName"]), 0, 1, 'L', false);
/* --- Cell_amsPhone --- */
$pdf->SetXY(75, 38);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Telefon: ', 0, 1, 'L', false);
$pdf->SetXY(130, 38);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4,utf8_decode($row["telNr"]), 0, 1, 'L', false);
/* --- Cell_amsEmail --- */
$pdf->SetXY(75, 43);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'E-Mail: ', 0, 1, 'L', false);
$pdf->SetXY(130, 43);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, 'E-Mail: '. utf8_decode($row["email"]), 0, 1, 'L', false);
/* --- Cell_assignment --- */
$pdf->SetXY(10, 72);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Bezeichnung des Auftrags: ', 0, 1, 'L', false);
/* --- MultiCell --- */
$pdf->SetXY(10, 79);
$pdf->SetFont('Courier', '', 12);
$pdf->MultiCell(0, 4, utf8_decode($row["tender"]), 0, 'L', false);
/* --- Cell_assignmentType --- */
$pdf->SetXY(10, 100);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Art des Auftrags: ', 0, 1, 'L', false);
$pdf->SetXY(60, 100);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4,  utf8_decode($row["tenderType"]), 0, 1, 'L', false);
/* --- Cell_beginDate --- */
$pdf->SetXY(10, 114);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Zeitfenster: ', 0, 1, 'L', false);
$pdf->SetXY(60, 114);
$pdf->SetFont('Courier', '', 12);
$pdf->Cell(0, 4, date_format($bdate,'d.m.Y') ." - " .date_format($edate,'d.m.Y'), 0, 1, 'L', false);
/* --- Cell_text --- */
$pdf->SetXY(10, 128);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 4, 'Gegenstand der Leistung:', 0, 1, 'L', false);
/* --- MultiCell_text --- */
$pdf->SetXY(10, 135);
$pdf->SetFont('Courier', '', 12);
$pdf->MultiCell(0, 4, utf8_decode($row["description"]), 0, 'L', false);

$pdf->Output('auftrag'.$pdfID.'.pdf', 'I');
?>
