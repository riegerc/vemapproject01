<?php
$pageRestricted = false; // defines if the page is restricted to logged-in Users only
$userLevel = 0; // defines the minimum userRole to access the page, if the userRole is lower than the level, a 403 Error-Page is returned
$title = "Ausschreibung erstellen"; // defines the name of the current page, displayed in the title and as a header on the page

include "include/init.php"; // includes base function like session handling
include "include/page/top.php";





?>
<div class="container-fluid">
   <h1 class="h3 mb-4 text-gray-800"><?php echo $title ?></h1>
   <div class="content">
<?php echo "<h6>". "AmsID : " . $_SESSION[USER_ID] . "<h6>". "<br>"; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            Ausschreibung : <input type="text" name="tender" class="form-control" placeholder="Titel der Ausschreibung...">
            <br>
            Ausschreibungs type :  <br><select name="tenderType" class="form-control">
            <option name="Dienstleistung" value="Dienstleistung">
              Dienstleistung
            </option>
            <option name="Lieferauftrag" value="Lieferauftrag">
              Lieferauftrag
            </option>

</select>
            <br>
            Beginn : <input type="date" name="begin" class="form-control" >
            <br>
            Ende : <input type="date" name="end" class="form-control" >
            <br>
            Menge : <input type="number" name="amount" class="form-control" placeholder="Menge in Zahlen eintragen..." >
            <br>

           <div class="form-group">
               <label for="description">Auftragsbeschreibung :</label>
               <textarea  name="description" class="form-control" placeholder="Beschreibung des Auftrags, inklusive Gruppen, Positionen und Langtexte..." rows="4"  data-error="Please, leave us a message."></textarea>

           </div>
            <br>
            <label>Upload für Ausschreibungs Excel
            </label><br> <input class="btn btn-primary" type="file" name="file"
                                id="file" accept=".xls,.xlsx">
            <br>
            <br>
            <button type="submit" class="btn btn-primary" name="absenden">Ausschreibung erstellen</button>
            <button  type="reset" class="btn btn-danger"  >Formular zurücksetzen</button>
            <br>


        </form>

   </div>
</div>

<?php
if( isset($_POST["absenden"]) ){
            $userFID= $_SESSION[USER_ID];
            $tender=$_POST["tender"];
            $tenderType=$_POST["tenderType"];
            $description=$_POST["description"];
            $begin= $_POST["begin"];
            $end= $_POST["end"];
            $amount=(int)$_POST["amount"];

             $sql="INSERT INTO tenders
                (tender,tenderType,cpvCode,begin,end,description,userFID,amount)
                VALUES
                (?,?,?,?,?,?,?,?)";
             $stmt=connectDB()->prepare($sql);
             $stmt->execute(array($tender,$tenderType, "30000000-9" ,$begin,$end,$description,$userFID, $amount));



}?>




<br>


<?php include "include/page/bottom.php";
?>



