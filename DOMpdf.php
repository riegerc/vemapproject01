<?php
session_start();
session_regenerate_id(true);

if ( empty($_SESSION["userID"]) ) {           # wenn Session leer ist d.h. niemand angemeldet
  header("location:DB_0212_logout.php");   # Weiterleitung  zu Logout und weiter zum Login
}

# Verbindung zur Datenbank herstellen
require_once( "include_db.php" );


// include autoloader
require_once 'dompdf/autoload.inc.php';


// reference the Dompdf namespace
use Dompdf\Dompdf;

// # Erstelle ein neues PDF
$pdf = new Dompdf();

//make the content here
//using output buffer
ob_start();
//---------------------------------------------------------------------------
$timestamp = time();
$datum = date("d-m-Y - H:i", $timestamp);
$nur_datum = date("d-m-Y");
# übernimmt die userID von $_GET
$userID = (int)$_GET["userID"];
#

?>
<!--           CSS starts here           -->
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    h1 {
        background-color: #aaa;
        color: #000;
        padding: 10px;
        text-align: left;
        font-size: 20px;
        border: 3px solid #555;
    }
    h1 span {
        font-size: 15px;
        display: block;
        text-align: center;
    }
    main table {
        border-collapse: collapse;
        margin: 20px auto;
        width: 100%;
    }
    table tr:nth-child(2n) {
        background-color: #aaaaaa;
    }
    table th {
        padding: 5px;
        background-color: #006cad;
        color: #fff;
        border: 1px solid #000;
    }
    table td {
        padding: 5px;
    }

</style>
<!--           CSS END           -->



<!-- HERE STARTS THE HTML CONTENT -->

    <p class="left">
        
        <p>Firmenadresse <br>
        ORT PLZ <br>
        Tel: +43 777658688 <br>
        Mail: firma@mail.at</p>
    </p>
    <p class="right">
        <img src="bild.png" alt="FIRMEN LOGO" width="150" height="100">
    </p>


    <h1>Bestellbestätigung für <?php echo $_SESSION['userName']; ?></h1>
    <span><?php echo "Deine Bestellung wurde erfolgreich durchgeführt am $nur_datum!"; ?></span>
  <main>
          <table border="1">
              <tr>
                  <th>Pizza</th>
                  <th>Extras</th>
                  <th>Adresse</th>
                  <th>Preis</th>
              </tr>
          <?php
            $sql = "SELECT *
                FROM pizzabestellung
                INNER JOIN pizza
                ON pizzaID = pbPizzaFID
                WHERE pbUserFID = $userID";
  
  
            $statement = $db->prepare($sql);
            $statement->execute();
            #--------------------------------------------------
  
              $ausgabe = "";
  
            while ( $row = $statement->fetch()) {
    
              $pizzaName = $row["pizzaName"];
              $pizzaPreis = $row["pbPreis"];
              $extra = $row["pbExtra"];
              $adresse = $row["pbAdresse"];
              $uhrzeit = $row["pbUhrzeit"];
  
              
              
              $ausgabe.= "<tr><td>$pizzaName</td><td>$extra</td><td>$adresse</td><td>$pizzaPreis €</td></tr>";
              
//              $ausgabe.= "<p> Die Kosten dafür betragen: ".number_format($pizzaPreis, 2, "," , ".")."EURO. </p></article>";
  
              
              
              echo $ausgabe;
            }
            ?>
            
          </table>
       
           <p>Vielen Dank für Deine Bestellung!</p>
           <p>Dein Pizza Team</p>
       
      
  </main>





<!-- END OF THE HTML CONTENT -->
<?php

$html = ob_get_clean();

$pdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$pdf->setPaper('A4', '');

// Render the HTML as PDF
$pdf->render();

// Output the generated PDF to Browser
$pdf->stream('PDF_Document.pdf', Array('Attachment'=>0));
?>
