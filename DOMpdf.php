<?php
session_start();
session_regenerate_id(true);

if ( empty($_SESSION["userID"]) ) {           # wenn Session leer ist d.h. niemand angemeldet
  header("location:error.php?e=400");   # Weiterleitung  zu Logout und weiter zum Login
}

# Verbindung zur Datenbank herstellen
require_once( "include/database.php" );


// include autoloader
require_once 'classes/DomPDF/dompdf/autoload.inc.php';


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
        font-family: 'Helvetica', sans-serif ;
    }
    body {
        padding: 70px;
    }
    header table {
        width: 100%;
    }
    .header_left {
        padding: 10px;
        width: 50%;
        /*text-indent: 50px;*/
    }
    .header_right {
        width: 30%;
    }
    h1 {
        background-color: #dde2f1;
        color: #000;
        padding: 10px;
        text-align: left;
        font-size: 20px;
        border: 2px solid #555;
        margin: 10px 0;
    }
    .mid_table {
        width: 100%;
    }
    .mid_table_left {
        width: 50%;
    }
    .mid_table_right {
        width: 30%;
    }
    
    main .order_table {
        border-collapse: collapse;
        margin: 20px auto;
        width: 100%;
        text-align: center;
        border: 1px solid #000;
    }
    main .order_table tr:nth-child(2n) {
        background-color: #aaaaaa;
    }
    main .order_table th {
        padding: 5px;
        background-color: #006cad;
        color: #fff;
        border: 1px solid #000;
    }
    main .order_table td {
        padding: 5px;
    }

</style>
<!--           CSS END           -->

<!-- HERE STARTS THE HTML CONTENT -->
<body>
    <header>
      <table>
          <tbody>
          <tr>
              <td class="header_left">
                  <p>Bestellung für: </p>
                  <p>Kundenname <?php echo $_SESSION['userName']; ?></p>
                  <p>KundenAdresse</p>
                  <p>Ort PLZ</p>
                  <br>
                  <p>Tel: +43 2595474</p>
                  <p>Fax: +43 2595474 457</p>
                  <p>Email: kunde@mail.com</p>
              </td>
            
              <td class="header_right">
                  <p>Bestellung bei: </p>
                  <p>Lieferant</p>
                  <p>LieferantAdresse</p>
                  <p>Ort PLZ</p>
                  <br>
                  <p>Tel: +43 0841484</p>
                  <p>Fax: +43 0841484 555</p>
                  <p>Email: lieferant@mail.com</p>
              </td>
          </tr>
          </tbody>
      </table>  
    </header>
    
    <h1>Bestellung Nr.<?php echo "\$Variable_Bestell_Nummer"; ?></h1>
    
    <table class="mid_table">
        <tbody>
        <tr>
            <td class="mid_table_left">
                <p><strong>Bestelldatum: <?php echo $nur_datum ?></strong></p>
                <p><strong>Platzhalter</strong></p>
                <p>Platzhalter</p>
                <p>Platzhalter</p>
                <br>
                <br>
                <br>
            </td>

            <td class="mid_table_right">
                <p><strong>Lieferanschrift:</strong> </p>
                <p>Lieferant</p>
                <p>LieferantAdresse</p>
                <p>Ort PLZ</p>
                <br>
                <p>Tel: +43 0841484</p>
                <p>Email: lieferant@mail.com</p>
            </td>
        </tr>
        </tbody>
    </table>
<!--    <span>--><?php //echo "Die Bestellung wurde erfolgreich durchgeführt am $datum!"; ?><!--</span>-->
  <main>
  
<!--      !!!!!!!!!!!!!!!!!!!!!!!!!! ab hier  GEHÖRT GEÄNDERT                    -->
          <table class="order_table">
              <tr>
                  <th>ArtikelNr/ID</th>
                  <th>ArtikelBezeichnung</th>
                  <th>Menge</th>
                  <th>Je</th>
                  <th>Preis EURO</th>
              </tr>
              
<!--              NUR UM die TABELLE zu FÜHLEN-->
              <?php
              for ($i = 1; $i < 10; $i++) {
                  
                  echo  "<tr>
                        <td>$i</td>
                        <td>Artikel Information/Bezeichnung</td>
                        <td>Menge</td>
                        <td>0,00 €</td>
                        <td>0,00 €</td>
                        </tr>";
              } // TABELLE ENDE
              ?>
              
          <?php
          
          // Datenbankabfrage modifizieren
          
/*            $sql = "SELECT *
                FROM pizzabestellung
                INNER JOIN pizza
                ON pizzaID = pbPizzaFID
                WHERE pbUserFID = $userID";
  
  
            $statement = $db->prepare($sql);
            $statement->execute();*/
             
  
/*              $ausgabe = "";
  
            while ( $row = $statement->fetch()) {
    
              $pizzaName = $row["pizzaName"];
              $pizzaPreis = $row["pbPreis"];
              $extra = $row["pbExtra"];
              $adresse = $row["pbAdresse"];
              $uhrzeit = $row["pbUhrzeit"];
  
              
              
              $ausgabe.= "<tr><td>$pizzaName</td><td>$extra</td><td>$adresse</td><td>$pizzaPreis €</td></tr>";*/
              
//              $ausgabe.= "<p> Die Kosten dafür betragen: ".number_format($pizzaPreis, 2, "," , ".")."EURO. </p></article>";
  
              
              
          /*    echo $ausgabe;
            }*/
          //  !!!  DATENBANKABFRAGE MODIFIKATION ENDE  !!!
            ?>
            
          </table> <!--  ORDER TABELLE ENDE     -->

           <p>Vielen Dank für Ihre Bestellung!</p>
           <p></p>
      
  </main>
</body>



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
