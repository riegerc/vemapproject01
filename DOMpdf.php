<?php
$checkme = "a30ee472364c50735ad1d43cc09be0a1";
require_once( "include/constant.php" );
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = PERM_EDIT_SELF; // uses a PERM_ const now and hasPermission($userLevel) now if fails a 403 Error-Page is returned
$title = ""; // defines the name of the current page, displayed in the title and as a header on the page


# Verbindung zur Datenbank herstellen
#require_once( "include/database.php" );

include( "include/init.php" );
if ( empty($_SESSION[USER_ID]) ) {           # wenn Session leer ist d.h. niemand angemeldet
  header("location:error.php?e=400");   # Weiterleitung  zu Logout und weiter zum Login
}
// include autoloader
require_once( "classes/DomPDF/dompdf/autoload.inc.php" );

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
$orderNr = 1; # zum TESTEN!

# übernimmt die userID von $_GET
//$userID = (int)$_GET["objectID"];
#

?>
<!--           CSS starts here           -->
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Helvetica', sans-serif;
        /*font-family: 'monospace', sans-serif;*/
    }

    body {
        padding: 70px;
        font-size: 14px;
    }

    header table {
        width: 100%;
    }

    .header_left {
        padding: 10px;
        width: 50%;
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
                <p>Kundenname <?php echo $_SESSION[USER_NAME]; ?></p>
              <?php //tabelle user Spalten street, houseNumber, door, postCode, city, country,teNr, email ?>
                <p>KundenAdresse</p>

                <p>Ort PLZ</p>
                <br>
                <p>Tel: +43 2595474</p>
                <p>Fax: +43 2595474 457</p>
                <p>Email: kunde@mail.com</p>
            </td>

            <td class="header_right">
              <?php //tabelle user Spalten street, houseNumber, door, postCode, city, country,teNr, email ?>
                <p>Lieferziel: </p>
                <p>Name</p>
                <p>Lieferadresse</p>
                <p>Ort PLZ</p>
                <br>
                <p>Tel: +43 0841484</p>
                <p>Fax: +43 0841484 555</p>
                <p>Email: lieferziel@mail.com</p>
            </td>
        </tr>
        </tbody>
    </table>
</header>

<h1>Bestellung Nr.<?php echo "$orderNr"; ?></h1>


<?php //$nurdatum= Tabelle order Spalte dateTime?>
<p><strong>Bestelldatum: <?php echo $nur_datum ?></strong></p>

<main>

    <!--       TABELLE für die Artikelbestellungen                    -->
    <table class="order_table">
      <?php
      $db = connectDB();


      //Lieferantennamen auslesen
      $sql = "SELECT user.branchName FROM `order` LEFT JOIN user ON order.supplierUserFID=user.objectID WHERE order.objectID=:orderNr";
      $statement = $db->prepare($sql);
      $statement->bindParam(":orderNr", $orderNr);
      $statement->execute();
      
      $row = $statement->fetch();
          
          $lieferant = $row['branchName'];
          
      
      
      
      //tabelle orderitems spalten atrticleFID count price
      //tabelle order spalten supplierUserFID
      //tabelle article spalten name price=je
      //tabelle user spalte branchName
      //sql abfrage
      $sql = "SELECT orderitems.articleFID AS 'Artikel-Nr',
                        orderitems.count AS Menge,
                        orderitems.price AS EUR,
                        article.name AS Artikel,
                        article.price AS je
                        FROM orderitems 
                        LEFT JOIN article ON  article.objectID=orderitems.articleFID
                        WHERE orderitems.orderFID=:orderNr";
      
      $statement = $db->prepare($sql);
      $statement->bindParam(":orderNr", $orderNr);
      $statement->execute();
      
      
      echo   "<tr>
                  <th>Artikel-Nr</th>
                  <th>Artikel</th>
                  <th>Menge</th>
                  <th>je</th>
                  <th>EUR</th>
                  <th>Lieferant</th>
             </tr>";
      
      // Befüllung der Tabelle Bestellungen
      while ( $row = $statement->fetch() ) {
        
        echo "<tr>
                  <td>{$row['Artikel-Nr']}</td>
                  <td>{$row['Artikel']}</td>
                  <td>{$row['Menge']}</td>
                  <td>{$row['je']}</td>
                  <td>{$row['EUR']}</td>
                  <td>$lieferant</td>
              </tr>";
      }  // while ENDE
      
      
      
      ?>

    </table> <!--  ORDER TABELLE ENDE     -->

    <p>Vielen Dank für Ihre Bestellung!</p>

</main>
<footer>

</footer>
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
$pdf->stream('PDF_Document.pdf', Array( 'Attachment' => 0 ));
?>
